function category_list_refresh() {
  var loading = '<a  class="list-group-item list-group-item-action" id="spin_load"><center><i class="fa fa-circle-o-notch fa-spin fa-2x"></i></center></a>';
  $('#category_list_div').html(loading);
  setTimeout(function() {
    $.getJSON(site + 'category/json/', function(data) {
      if (data.response == "OK") {
        var link = '';
        $.each(data.data, function(i, dt) {
          link += '<a onclick="setCategory(this)" href="javascript:void(0)" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-id="' + dt.id + '" ><b>' + dt.name + '</b><span ><i title="Edit" onclick="editMe(\'' + dt.id + '\')" class="fa fa-pencil-square-o"></i>&nbsp;<i title="Hapus" onclick="delMe(\'' + dt.id + '\')" class="fa fa-trash-o"></i></span></span></a> ';
        })
        $('#spin_load').remove();
        $('#category_list_div').html(link);
      }
    });
  }, 2000);
}

function news_refresh() {
  var loading = '<div class="text-center col-md-12" id="spin_news_load"><center><i class="fa fa-circle-o-notch fa-spin fa-2x"></i></center></div>';
  $('#news_div').html(loading);
  setTimeout(function() {
    $.getJSON(site + 'news/json/', function(data) {
      if (data.response == "OK") {
        var link = '';
        if(data.data != ""){
          $.each(data.data, function(i, dt) {
            link += '<div class="col-md-4" style="margin-bottom:20px;">';
            link += '<div class="card">';
            link += '<img class="card-img-top" src="' + dt.thumb_url + '" alt="Card image cap" style="height:150px;">';
            link += '<div class="card-body"><h5 class="card-title " style="align:justify">' + dt.title + '</h5><strong><small><i class="fa fa-calendar"></i>&nbsp;' + dt.created_at + '<br> <i class="fa fa-bookmark-o"></i>&nbsp;' + dt.category_name + ' </small></strong></p>';
            link += '<a href="' + dt.link + '" class="btn btn-primary btn-sm">Lihat</a>&nbsp;<a href="' + dt.edit_link + '" class="btn btn-success btn-sm">Edit</a>&nbsp; <button class="btn btn-danger btn-sm" onclick="delNews(\'' + dt.id + '\')">Hapus</button></div></div></div>';
          })            
        } else {
          link += '<div class="col-md-4" style="margin-bottom:20px;">';
          link += "Tidak ada";
          link += '</div>';
        }
        $('#spin_news_load').remove();
        $('#news_div').html(link);
      }
    });
  }, 2000);
}

function post() {
  var name = $('#category_name').val();
  empty_validate(name, 'Nama Kategori');
  var input = new FormData();
  input.append('name', name);
  var post_url = 'category/post';
  ServerPost(post_url, input, false);
  setTimeout(function() {
    if ($('#success_param').val() == 'yes') {
      category_list_refresh();
    }
  }, 1000);
}

function update() {
  var name = $('#category_edit_name').val();
  var id = $('#category_edit_id').val();
  empty_validate(name, 'Nama Kategori');
  var input = new FormData();
  input.append('name', name);
  input.append('id', id);
  var post_url = 'category/update';
  ServerPost(post_url, input, false);
  setTimeout(function() {
    if ($('#success_param').val() == 'yes') {
      category_list_refresh();
    }
  }, 1000);
}

function setCategory(me) {
  var category_id = $(me).attr('data-id');
}

function editMe(id) {
  $.getJSON(site + 'category/' + id, function(data) {
    if (data.response == "OK") {
      EditCategoryModal();
      $('#category_edit_id').val(id);
      $('#category_edit_name').val(data.data.name);
    }
  });
}

function delMe(id) {
  DelCategoryModal();
  $('#category_del_id').val(id);
}

function delNews(id) {
  DelNewsModal();
  $('#news_del_id').val(id);
}

function removeDuplicateUsingFilter(arr) {
  let unique_array = arr.filter(function(elem, index, self) {
    return index == self.indexOf(elem);
  });
  return unique_array
}
// MODAL TRIGGER
function NewCategoryModal() {
  $('#NewCategoryShowModal').modal();
}

function EditCategoryModal() {
  $('#EditCategoryShowModal').modal();
}

function DelCategoryModal() {
  $('#DelCategoryShowModal').modal();
}

function DelNewsModal() {
  $('#DelNewsModal').modal();
}

function del() {
  var input = new FormData();
  input.append('id', $('#category_del_id').val());
  var delete_url = 'category/delete';
  ServerPost(delete_url, input);
  setTimeout(function() {
    if ($('#success_param').val() == 'yes') {
      category_list_refresh();
    }
  }, 1000);
}

function delNewsNow() {
  var input = new FormData();
  input.append('id', $('#news_del_id').val());
  var delete_url = 'news/delete';
  ServerPost(delete_url, input);
  setTimeout(function() {
    if ($('#success_param').val() == 'yes') {
      news_refresh();
    }
  }, 1000);
}

function searchNews() {
  var input = new FormData();
  var keyword = $('#keyword').val();  
  var csrf_token = $.cookie("csrf_cookie_pid");  
  input.append('csrf_pid',csrf_token);
  input.append('keyword', keyword);
  var post_url = 'news/search';
  if(keyword != ""){
    $.ajax({
      url: site + post_url,
      method: 'POST',
      data: input,
      dataType: 'json',
      contentType: 'application/json',
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data.response == "OK") {
          var link = '';
          if(data.data != ""){
            $.each(data.data, function(i, dt) {
              link += '<div class="col-md-4" style="margin-bottom:10px;">';
              link += '<div class="card">';
              link += '<img class="card-img-top" src="' + dt.thumb_url + '" alt="Card image cap" style="height:150px;">';
              link += '<div class="card-body"><h5 class="card-title " style="align:justify">' + dt.title + '</h5><strong><small><i class="fa fa-calendar"></i>&nbsp;' + dt.created_at + '<br> <i class="fa fa-bookmark-o"></i>&nbsp;' + dt.category_name + ' </small></strong></p>';
              link += '<a href="' + dt.link + '" class="btn btn-primary btn-sm">Lihat</a>&nbsp;<a href="' + dt.link + '" class="btn btn-success btn-sm">Edit</a>&nbsp; <button class="btn btn-danger btn-sm" onclick="delNews(\'' + dt.id + '\')">Hapus</button></div></div></div>';
            })
          }
          $('#spin_news_load').remove();
          $('#news_div').html(link);
        }

      }
    });
  } else {
    news_refresh();
  }
}