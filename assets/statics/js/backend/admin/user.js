function table_render() {
  var detail = site + 'user/';
  var table = $('.table1').DataTable({
    responsive: true,
    ajax: site + 'user/json',
    columns: [{
      data: null
    }, {
      data: 'name'
    }, {
      data: 'email'
    }, {
      data: 'role'
    }, {
      data: 'status'
    }, {
      data: 'update_at'
    }, {
      data: 'id'
    }],
    dom: 'Bfrtip',
    buttons: [],
    columnDefs: [{
      "render": function(data, type, row) {
        if (data == 'F') {
          return '<span class="text-warning">Free</span>';
        } {
          return '<span class="text-primary">Premium</span>';
        }
      },
      "targets": 3
    }, {
      "render": function(data, type, row) {
        if (data == 'A') {
          return '<span class="label label-success">Aktif</span>';
        } else {
          return '<span class="label label-danger">Nonaktif</span>';
        }
      },
      "targets": 4
    }, {
      "render": function(data, type, row) {
        return '<a href="' + detail + data + '"  class="btn btn-fill btn-sm btn-warning btn-flat" title="Edit"><i class="fa fa-pencil"></i></a>&nbsp<button   class="btn btn-fill btn-flat btn-sm btn-danger" title="Hapus" onclick="DeleteConfirmationInIndexTable(\'' + data + '\',this)"><i class="fa fa-trash"></i></button>';
      },
      "targets": 6
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

function update() {
  var name = $('#name').val();
  var email = $('#email').val();
  empty_validate(name, 'Name');
  empty_validate(email, 'Email');
  var contact = $('#contact').val();
  var role = $('#role').val();
  var status = $('#status').val();
  var address = $('#address').val();
  var new_password = $('#new_password').val();
  var input = new FormData();
  input.append('name', name);
  input.append('email', email);
  input.append('contact', contact);
  input.append('role', role);
  input.append('status', status);
  input.append('address', address);
  input.append('new_password', new_password);
  var post_url = 'user/update';
  ServerPost(post_url, input, true);
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

function ChangePasswordModal() {
  $('#ChangePasswordModal').modal({
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

function changePassword(){
  $("#new_password").val('y');
}