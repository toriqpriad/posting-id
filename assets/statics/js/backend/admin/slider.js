var attribute_data = [];
var options_to_delete = [];

function table_render() {
  var detail = site + 'slider/';
  var table = $('.table1').DataTable({
    responsive: true,
    ajax: site + 'slider/json',
    columns: [{
      data: null
    }, {
      data: 'name'
    }, {
      data: 'link'
    }, {
      data: 'update_at'
    }, {
      data: 'id'
    }],
    dom: 'Bfrtip',
    buttons: [],
    columnDefs: [{
      "render": function(data, type, row) {
        return '<a href="' + detail + data + '"  class="btn btn-fill btn-sm btn-warning btn-flat" title="Edit"><i class="fa fa-pencil"></i></a>&nbsp<button   class="btn btn-fill btn-flat btn-sm btn-danger" title="Hapus" onclick="DeleteConfirmationInIndexTable(\'' + data + '\',this)"><i class="fa fa-trash"></i></button>';
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

function post() {  
  var name = $('#name').val();
  empty_validate(name, 'Name');
  var desc = $('#desc').val();
  var link = $('#link').val();
  var img = $('#img').prop('files')[0];
  var input = new FormData();
  input.append('name', name);
  input.append('desc', desc);
  input.append('link', link);
  input.append('img', img);
  var post_url = 'slider/post';
  ServerPost(post_url, input, true);
}

function update() {
  var name = $('#name').val();
  empty_validate(name, 'Name');
  var desc = $('#desc').val();
  var link = $('#link').val();
  var old_img = $('#img_old').val();
  var new_img = $('#img_new').val();
  if (new_img != undefined) {
    var img = $('#img').prop('files')[0];
  } else {
    var img = 'old';
  }
  var input = new FormData();
  input.append('name', name);
  input.append('desc', desc);
  input.append('link', link);
  input.append('img', img);
  input.append('old_img', old_img);
  var post_url = 'slider/update';
  ServerPost(post_url, input, true);
}

function Delete(row) {
  var input = new FormData();
  input.append('id', $('#del_id').val());
  var delete_url = 'slider/delete';
  ServerPost(delete_url, input);
  $(row).closest('tr').remove();
}
// MODAL TRIGGER
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

function DeleteConfirmationInIndexTable(link, row) {
    $('#DeleteConfirmationModal').modal({
        backdrop: false
    });
    $('#del_id').val(link);
    $('#yes').click(function() {
        Delete(row);
    })
}