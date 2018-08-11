
function table_render() {
  var detail = site + 'order/';
  var table = $('.table1').DataTable({
    responsive: true,
    ajax: site + 'order/json',
    columns: [{
      data: null
    }, {
      data: 'name'
    }, {
      data: 'email'
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
      "targets": 5
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
  
  var post_url = 'slider/post';
  ServerPost(post_url, input, true);
}

function update() {
  var name = $('#name').val();
  empty_validate(name, 'Name');
  var desc = $('#desc').val();
  var link = $('#link').val();
  var email = $('#email').val();
  var input = new FormData();
  input.append('name', name);
  input.append('desc', desc);
  input.append('link', link);
  input.append('email', email);  
  var post_url = 'order/update';
  ServerPost(post_url, input, true);
}

function Delete(row) {
  var input = new FormData();
  input.append('id', $('#del_id').val());
  var delete_url = 'order/delete';
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