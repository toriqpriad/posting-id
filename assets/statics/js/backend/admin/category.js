var attribute_data = [];
var options_to_delete = [];

function table_render() {
  var detail = site + 'category/';
  var sub_detail = site + 'subcategory/';
  var table = $('.table1').DataTable({
    responsive: true,
    ajax: site + 'category/json',
    columns: [{
      data: null
    }, {
      data: 'name'
    },{
      data: 'type'
    }, {
      data: 'update_at'
    }, {
      data: 'url'
    }],
    dom: 'Bfrtip',
    buttons: [],
    columnDefs: [{
      "render": function(data, type, row) {
        var id = row.id;
        return '<a href="' + data + '"  class="btn btn-fill btn-sm btn-warning btn-flat" title="Edit"><i class="fa fa-pencil"></i></a>&nbsp<button   class="btn btn-fill btn-flat btn-sm btn-danger" title="Hapus" onclick="DeleteConfirmationInIndexTable(\'' + id + '\',this)"><i class="fa fa-trash"></i></button>';
      },
      "targets": 4
    }, ]
  });
  table.on('order.dt search.dt', function() {
    table.column(0, {
      search: 'applied',
      order: 'applied'
    }).nodes().each(function(cell, i) {
      cell.innerHTML = i + 1;
    });
  }).draw();
}

function table_attribute_render() {
  $.ajax({
    url: site + 'category/attribute/latest',
    method: 'GET',
    dataType: 'json',
    contentType: 'application/json',
    cache: false,
    contentType: false,
    processData: false,
    success: function(response) {
      if (response.response == 'OK') {
        var item = response.data;
        var options_data = [];
        $.each(item.options, function(i, opt) {
          options_data += opt.label + "<br>";
        })
        var type_label = '';
        if (item.type === "TXT") {
          type_label = 'Input Text';
        } else if (item.type === "CBX") {
          type_label = 'Checkbox';
        } else if (item.type === "RDB") {
          type_label = 'Radiobutton';
        } else {
          type_label = 'Textarea';
        }
        var action_btn = '';
        var edit_link = site + 'category/attribute/' + item.id;
        action_btn += '<a href="' + edit_link + '" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;';
        action_btn += '<button class="btn btn-sm btn-danger btn-flat" onclick="DeleteAttributeModal(this,&quot;' + item.id + '&quot;)" title="Hapus"><i class="fa fa-close"></i></button>';
        $('#attribute_table').append("<tr>" + "<td>" + item.name + "</td>" + "<td>" + type_label + "</td>" + "<td>" + options_data + "</td>" + "<td>" + item.count_as + "</td>" + "<td>" + action_btn + "</td>" + "</tr>");
      }
    }
  });
}

function post() {
  var name = $('#name').val();
  empty_validate(name, 'Name');
  var desc = $('#desc').val();
  var input = new FormData();
  input.append('name', name);
  input.append('desc', desc);
  console.log(attribute_data);
  input.append('attribute_data', JSON.stringify(attribute_data));
  var post_url = 'category/post';
  ServerPost(post_url, input, true);
}

function postNewAttribute() {
  var name = $('#new_name').val();
  empty_validate(name, 'Nama');
  var type = $('#new_type').val();
  empty_validate(type, 'Tipe');
  var count_as = $('#new_count_as').val();
  var options_new = [];
  $(".new_options").each(function() {
    var new_option_value = $(this).val();
    options_new.push(new_option_value);
  });
  var input = new FormData();
  input.append('name', name);
  input.append('type', type);
  input.append('count_as', count_as);
  input.append('options', JSON.stringify(options_new));
  var post_url = 'category/attribute/post';
  ServerPost(post_url, input);
    // table_attribute_render();  
  }

  function update() {
    var name = $('#name').val();
    empty_validate(name, 'Name');
    var desc = $('#desc').val();
    var input = new FormData();
    input.append('name', name);
    input.append('desc', desc);
    var post_url = 'category/update';
    ServerPost(post_url, input, true);
  }

  function updateAttribute() {
    var name = $('#name').val();
    empty_validate(name, 'Name');
    var type = $('#type').val();
    empty_validate(type, 'Tipe')
    var count_as = $('#count_as').val();
    var options = [];
    $(".option").each(function() {
      var option_id = $(this).attr("data-id");
      var option_value = $(this).val();
      if (type === 'RDB' || type === 'CBX') {
        var option_data = {
          "id": option_id,
          "value": option_value
        };
        options.push(option_data);
      } else {
        options_to_delete.push(option_id);
      }
    });
    var options_new = [];
    $(".new_options").each(function() {
      var new_option_value = $(this).val();
      options_new.push(new_option_value);
    });
    var input = new FormData();
    input.append('name', name);
    input.append('type', type);
    input.append('count_as', count_as);
    input.append('options', JSON.stringify(options));
    input.append('options_new', JSON.stringify(options_new));
    input.append('options_delete', JSON.stringify(options_to_delete));
    var post_url = 'category/attribute/update';
    ServerPost(post_url, input, true);
  }

  function setType(e) {
    var selected = $('option:selected', e).val();
    if (selected === 'RDB' || selected === "CBX") {
      $('#add_value_btn').css('display', '');
      $('#type_value').show();
      $(".new_options").each(function() {
        $(this).removeAttr("disable");
      });
    } else {
      $('#add_value_btn').css('display', 'none');
      $('#type_value').hide();
      $(".new_options").each(function() {
        $(this).attr("disable", "disabled");
      });
    }
  }

  function addOptions() {
    var input = "<div class='col-md-6' style='margin-bottom:4px;'> <div class='input-group ' >";
    input += '<input type="text" class="form-control input-sm new_options" placeholder="" value="">';
    input += '<span class="input-group-btn">';
    input += '<button class="btn btn-danger btn-md" type="button" style="padding:7px;" onclick="delThisOptions(this)"><i class="fa fa-close"></i></button>';
    input += '</span></div></div>';
    $('#type_value').append(input);
  }

  function delThisOptions(e) {
    $(e).closest('.col-md-6').remove();
  }

  function delThisOptionsOnEdit(e, id_option) {
    options_to_delete.push(id_option);
    $(e).closest('.col-md-6').remove();
  }

  function delThisAttribute(e) {
    var key = $(e).closest($('tr')).find('.hidden_key').val();
    attribute_data = attribute_data.filter(data => data.key != key);
    $(e).closest('tr').remove();
  }

  function pushToTable() {
    var new_attribute_label = $("#new_label").val();
    empty_validate(new_attribute_label, 'Label');
    var new_attribute_type = $("#new_type").val();
    empty_validate(new_attribute_type, 'Tipe');
    var new_attribute_type_label = $("#new_type option:selected").text();
    var new_count_as = $("#new_count_as").val();
    var new_attribute_options = [];
    $(".new_options").each(function() {
      new_attribute_options.push($(this).val());
    });
    $('#NewAttributeModal').modal('hide');
    var key = Math.random().toString(36).substring(7);
    var new_row = "<tr>";
    var set_new_attribute_data = {
      "key": key,
      "label": new_attribute_label,
      "type": new_attribute_type,
      "count_as": new_count_as,
      "options": new_attribute_options,
      "status": "new"
    };
    attribute_data.push(set_new_attribute_data);
    console.log(attribute_data);
    var delete_btn = "<button class='btn btn-sm btn-danger btn-flat' onclick='delThisAttribute(this)'><i class='fa fa-close'></i></button>";
    new_row += "<td>" + new_attribute_label + "</td>";
    new_row += "<td>" + new_attribute_type_label + "</td>";
    new_row += "<td>" + new_attribute_options + "</td>";
    new_row += "<td>" + new_count_as + "</td>";
    new_row += "<td><input type='hidden' class='hidden_key' value=" + key + ">" + delete_btn + "<div style='display:none' class='new_attribute_data'></div></td>";
    new_row += "</tr>";
    $("#attribute_table").append(new_row);
  }

  function Delete(row) {
    var input = new FormData();
    input.append('id', $('#del_id').val());
    var delete_url = 'category/delete';
    ServerPost(delete_url, input);
    $(row).closest('tr').remove();
  }
// MODAL TRIGGER
function DeleteConfirmationInIndexTable(link, row) {
  $('#DeleteConfirmationModal').modal({
    backdrop: false
  });
  $('#del_id').val(link);
  $('#yes').click(function() {
    Delete(row);
  })
}

function NewAttribute() {
  $('#NewAttributeModal').modal({
    backdrop: false
  });
}

function NewAttributeInEdit() {
  $('#NewAttributeModal').modal({
    backdrop: false
  });
  $('#yes').click(function() {
    postNewAttribute(this);
  })
}

function UpdateConfirmation() {
  $('#UpdateConfirmationModal').modal({
    backdrop: false
  });
}

function PostConfirmation() {
  $('#PostConfirmationModal').modal({
    backdrop: false
  });
}

function UpdateAttributeConfirmation() {
  $('#PostConfirmationModal').modal({
    backdrop: false
  });
}

function DeleteAttributeModal(e, id) {
  $('#DeleteConfirmationModal').modal({
    backdrop: false
  });
  $('#yesDelete').on('click', function() {
    var input = new FormData();
    input.append('id', id);
    var delete_url = 'category/attribute/delete';
    ServerPost(delete_url, input);
    $(e).closest('tr').remove();
    $("#DeleteConfirmationModal").removeData();
  })
}

function DeleteSubCategoryModal(e, id) {
  $('#DeleteSubCategoryConfirmationModal').modal({
    backdrop: false
  });
  $('#yesDeleteSubCategory').on('click', function() {
    var input = new FormData();
    input.append('id', id);
    var delete_url = 'subcategory/delete';
    ServerPost(delete_url, input);
    $(e).closest('tr').remove();
    $("#DeleteSubCategoryConfirmationModal").removeData();
  })
}