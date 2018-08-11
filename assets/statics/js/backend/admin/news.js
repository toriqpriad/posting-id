var attribute_data = [];
var options_to_delete = []; 
var thumbnail = '';
function post() {
  var title = $('#title').val();
  var category_id = $('#category').val();
  empty_validate(title, 'Judul');
  var desc = CKEDITOR.instances['desc'].getData();
  var images = [];
  $(".image_data").each(function() {
    var img_name = $(this).attr("value");
    var img_title = $(this).next('.image_title').val();
    var my_img = {
      "name": img_name,
      "title": img_title
    };
    images.push(my_img);
  })

  var input = new FormData();
  input.append('title', title);
  input.append('category', category_id);  
  input.append('desc', desc);  
  input.append('images_data', JSON.stringify(images));
  input.append('image_thumbnail', thumbnail);
  var post_url = 'news/post';
  ServerPost(post_url, input, true);
}


function update() {
 var title = $('#title').val();
 var title_old = $('#title_old').val();
 var category_id = $('#category').val();
 empty_validate(title, 'Judul');
 var desc = CKEDITOR.instances['desc'].getData();
 var images = [];
 $(".image_data").each(function() {
  var img_name = $(this).attr("value");
  var img_title = $(this).next('.image_title').val();
  var my_img = {
    "name": img_name,
    "title": img_title
  };
  images.push(my_img);
})

 var input = new FormData();
 input.append('title', title);
 input.append('title_old', title_old);
 input.append('category', category_id);  
 input.append('desc', desc);  
 input.append('images_data', JSON.stringify(images));
 input.append('image_thumbnail', thumbnail);
 input.append('deleted_images_data', JSON.stringify(deleted_image));
 input.append('city_news', JSON.stringify(selected_city));
 var post_url = 'news/update';
 ServerPost(post_url, input, true);
}

function Delete(row) {
  var input = new FormData();
  input.append('id', $('#del_id').val());
  var delete_url = 'news/delete';
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

function filemanagerModalClose() {
  $('#filemanagerModal').modal('hide');
}

function setToThumbnail(image_name) {
  thumbnail = image_name;
}



function filemanagerModalShow(action) {
  $('#filemanagerModal').modal('show');
  $('#filemanagerModal').modal({
    backdrop: false
  });
  if (action == "image") {
    var active_action = "image";
  } else {
    var active_action = "sketch";
  }
  $("#active_action").val(active_action)
  var frame_url = $('#filemanager_url').val();
  $('#filemanager_frame').attr('src', frame_url);
}

function deleteThisImage(e) {
  $(e).closest('.image_container').remove();
}

function deleteThisImageInEdit(e) {
  var img_id = $(e).attr('image-id');
  deleted_image.push(img_id);
  $(e).closest('.image_container').remove();
}

function ShowDatasetModal() {
  $('#datasetModal').modal({
    backdrop: false
  });
  $('#datasetDiv').empty();
  var html = '';
  $.getJSON(site + 'news/dataset', function(reply) {
    $.each(reply.data, function(i, sub) {
      if (selected_city.length > 0) {
        $.each(selected_city, function(i, city) {
          if (city.name == sub) {
            reply.data = reply.data.filter(data => data != sub);
          }
        })
      }
    })
    $.each(reply.data, function(i, sub) {
      html += '<input type="checkbox" name="city_select" data-name="' + sub + '" value="' + sub + '.txt"/>&nbsp;' + sub + "<br>";
    })
    $('#datasetDiv').append(html);
  })
}


function setSelectedCity() {
  $("input[name='city_select']").each(function() {
    if ($(this).is(':checked')) {
      var city_val = $(this).val();
      var city_name = $(this).attr('data-name');            

      $.getJSON(site + 'news/dataset/' + city_val, function(data) {
        var city_html = '';
        var cities = [];                
        var choose_city = selected_city.filter(data => data.name != city_name);
        console.log(choose_city);
        var city_data = { "txt": city_val, "name": city_name,"cities": cities,"cities_total" : cities.length,"status" : "N" }
        selected_city.push(city_data); 

        $.each(data.data, function(i, city) {
         city_html += city+", ";
         cities.push(city);
       })
        $("#datasetrecord").append("<tr><td><small>"+city_val+"</small><br><br><button onclick='deleteCity(this)' data-name='"+city_name+"' class='text-center btn btn-danger btn-center btn-flat btn-xs'><i class='fa fa-trash'></i>&nbsp;Hapus</button></td><td><div class='row'><div class='col-md-12'><small>"+city_html+"</small></div></div></td></tr>");                
      })
    }
  })

  console.log(selected_city);
}

function LoadCity(){    
  $(".city_div").each(function() {    
    var city_html = '';
    var target = $(this).attr('data-name') +'.txt';
    $.ajax({
      url : site + 'news/dataset/' + target,
      method: 'GET',
      dataType : 'json',
      context : this,
      success : function (data) {

        $.each(data.data, function(i, city) {
         city_html += city+", ";             
       });        
        console.log(data);
        $(this).append("<small>"+city_html+"</small>");
      }
    });

  })
}

function deleteCity(me,action){

  var city_name = $(me).attr('data-name');    
  if(action == "live_delete"){
    $('#DeleteDatasetModal').modal({
      backdrop: false
    });        
    $("#pgp_name_to_delete").val(city_name);        
    $('#DeleteDatasetLive').click(function(){
     DeleteDatasetLive()
     $(me).closest('tr').remove();    
   })
  } else {
    selected_city = selected_city.filter(data => data.name != city_name);    
    $(me).closest('tr').remove();    
  }

}

function DeleteDatasetLive(){
  var input = new FormData();
  input.append('pgp_name',  $("#pgp_name_to_delete").val());
  var delete_url = 'news/dataset/delete';
  ServerPost(delete_url, input, false);
}

