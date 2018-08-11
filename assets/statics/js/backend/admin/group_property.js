var close_with = [];

function table_render() {
    var detail = site + 'group_property/';
    var table = $('.table1').DataTable({
        responsive: true,
        ajax: detail + 'json',
        columns: [{
            data: null
        }, {
            data: 'name'
        }, {
            data: 'address'
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
    var desc = CKEDITOR.instances['desc'].getData();
    var address = $('#address').val();
    var video = $('#video').val();
    var map = $('#map').val();
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
    var sketchs = [];
    $(".sketch_data").each(function() {
        var img_name = $(this).attr("value");
        var img_title = $(this).next('.image_title').val();
        var my_img = {
            "name": img_name,
            "title": img_title
        };
        sketchs.push(my_img);
    })
    var input = new FormData();
    input.append('name', name);
    input.append('video', video);
    input.append('address', address);
    input.append('map', map);
    input.append('close_with_data', JSON.stringify(close_with));
    input.append('images_data', JSON.stringify(images));
    input.append('sketchs_data', JSON.stringify(sketchs));
    input.append('close_with_data', JSON.stringify(close_with));
    input.append('include_property', JSON.stringify(FixIncludeProperty));
    input.append('image_thumbnail', thumbnail);
    var post_url = 'group_property/post';
    ServerPost(post_url, input, true);
}

function update() {
  var name = $('#name').val();
  empty_validate(name, 'Name');
  var desc = CKEDITOR.instances['desc'].getData();
  var address = $('#address').val();
  var video = $('#video').val();
  var map = $('#map').val();
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
  var sketchs = [];
  $(".sketch_data").each(function() {
    var img_name = $(this).attr("value");
    var img_title = $(this).next('.image_title').val();
    var my_img = {
        "name": img_name,
        "title": img_title
    };
    sketchs.push(my_img);
})
  var input = new FormData();
  input.append('name', name);
  input.append('video', video);
  input.append('address', address);
  input.append('desc', desc);
  input.append('map', map);
  input.append('close_with_data', JSON.stringify(close_with));
  input.append('images_data', JSON.stringify(images));
  input.append('sketchs_data', JSON.stringify(sketchs));
  input.append('close_with_data', JSON.stringify(close_with));
  input.append('include_property', JSON.stringify(FixIncludeProperty));
  input.append('deleted_images_data', JSON.stringify(deleted_image));
  input.append('image_thumbnail', thumbnail);
  var post_url = 'group_property/update';
  ServerPost(post_url, input, true);
}

function Delete(row) {
    var input = new FormData();
    input.append('id', $('#del_id').val());
    var delete_url = 'group_property/delete';
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

function NewCloseWith() {
    $('#NewCloseWithModal').modal({
        backdrop: false
    });
}

function AddProperty() {
    $('#addPropertyModal').modal({
        backdrop: false
    });
    getNewestProperty();   
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

function DeletePlaceConfirmation() {
    $('#DeleteConfirmationModal').modal({
        backdrop: false
    });
}

function DeletePropertyEditModal(e,id_item,id_property) {
    $('#DeletePropertiConfirmationModal').modal({
        backdrop: false
    });
    $("#hidden_id_item").val(id_item);
    $('#yesDeleteProperti').on('click', function() {
        var delete_id = $("#hidden_id_item").val();        
        deleteProperty(delete_id);        
        FixIncludeProperty = FixIncludeProperty.filter(data => data.id != id_property );
        // console.log(FixIncludeProperty)
        $(e).closest('tr').remove();
        
    })
}

function deleteProperty(id) {
    var input = new FormData();
    input.append('id', id);
    var delete_url = 'group_property/property/delete';
    ServerPost(delete_url, input);
}

function UpdateAttributeConfirmation() {
    $('#PostConfirmationModal').modal({
        backdrop: false
    });
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

function filemanagerModalClose() {
    $('#filemanagerModal').modal('hide');
}

function DeletePlaceEditModal(e, id, action) {
    $('#DeleteConfirmationModal').modal({
        backdrop: false
    });
    $("#hidden_id").val(id);
    $('#yesDelete').on('click', function() {
        var delete_id = $("#hidden_id").val();
        deletePlace(delete_id);
        if (action == 'list') {
            $(e).closest('tr').remove();
        }
    })
}

function deletePlace(id) {
    var input = new FormData();
    input.append('id', id);
    var delete_url = 'group_property/place/delete';
    ServerPost(delete_url, input);
}

function setToThumbnail(image_name) {
    thumbnail = image_name;
}

function setDirectionAs(e) {
    var value = $(e).attr("value");
    var label = $(e).text();
    $("#directionAs").text(label);
    $("#directionAs").attr("value", value);
}

function pushToTable() {
    var new_location = $("#new_location").val();
    var new_direction_text = $("#new_direction option:selected").text();
    var new_direction = $("#new_direction").val();
    var new_distance = $("#new_distance").val();
    var new_distance_as = $("#directionAs").attr("value");
    var new_distance_as_text = $("#directionAs").text();
    var key = Math.random().toString(36).substring(7);
    var new_row = "<tr>";
    var set_new_close_with = {
        "key": key,
        "location": new_location,
        "direction": new_direction,
        "distance": new_distance,
        "distance_as": new_distance_as
    };
    close_with.push(set_new_close_with);
    var delete_btn = "<button class='btn btn-sm btn-danger btn-flat' onclick='delThisCloseWith(this)'><i class='fa fa-close'></i></button>";
    new_row += "<td>" + new_location + "</td>";
    new_row += "<td>" + new_direction_text + "</td>";
    new_row += "<td>" + new_distance + "&nbsp;" + new_distance_as_text + "</td>";
    new_row += "<td><input type='hidden' class='hidden_key' value=" + key + ">" + delete_btn + "<div style='display:none' class='new_attribute_data'></div></td>";
    new_row += "</tr>";
    $("#CloswWithTable").append(new_row);
}

function delThisCloseWith(e) {
    var key = $(e).closest($('tr')).find('.hidden_key').val();
    close_with = close_with.filter(data => data.key != key);
    $(e).closest('tr').remove();
}
// custom function 

// IN NEW PAGE
function findByName() {
    var word = $('#keyword').val();    
    var post_url = 'property/find_name';
    var csrf_token = $.cookie("csrf_cookie_iklamedia");
    var html = '';
    $('#loading').empty();
    $('#loading').append('<center><i class="fa fa-circle-o-notch fa-spin"></i><center>');
    setTimeout(function ()
    {
      $.post(post_url, {'keyword' : word,'csrf_iklamedia' : csrf_token},function(reply) {                 
       if (reply.data != '') {            
        $.each(reply.data, function() {
            var filter_id = FixIncludeProperty.filter(data => data.id == this.id);
            if(filter_id == ''){        
                var output = generatePropertyPanel(this);
                html += output;
            }

        });                                
    } else {
        html += '<div class="col-md-12"> <h4><i class="fa fa-exclamation-triangle"></i> Hasil tidak ditemukan </h4></div>';
    }
    $('#loading').empty();
    $("#newestPropertyDiv").hide();
    $('#loading').append('<center><i class="fa fa-check"></i><center>');        
    $("#FindResultPropertyDiv").empty();
    $("#FindResultPropertyDiv").show();
    $("#FindResultPropertyDiv").append(html);  

}, "json");
  }, 1000);
    
}

function getNewestProperty() {
    var url = site + 'group_property/property/latest';
    var html = '';
    $.getJSON(url, function(reply) {

        if (reply.data != '') {
            $.each(reply.data, function() {
                var filter_id = FixIncludeProperty.filter(data => data.id == this.id);
                if(filter_id == ''){        
                    var output = generatePropertyPanel(this);
                    html += output;
                }
                
            })
        }
        $("#FindResultPropertyDiv").hide();
        $("#newestPropertyDiv").show();
        $("#newestPropertyDiv").html(html);
    });
}

function generatePropertyPanel(data) {
    var output = '';
    if (data != '') {
        output += '<div class="col-md-4">';
        output += '<div class="panel panel-default">';
        output += '<div class="panel-heading"><input type="checkbox" data-cost="'+data.cost+'" data-name="'+data.name+'" data-category="'+data.category_name+'" value="' + data.id + '" onchange="checkedMe(this)" >&nbspTandai properti ini</div>';
        output += '<div class="panel-body" style="height:280px;"><label>' + data.name + ' ('+data.category_name+')'+ '</label>';
        var desc = data.description;
        var cut = desc.substring('0', '100') + '... ';
        output += '<img src="' + data.thumbnail + '" class="img img-responsive"><br>' + cut + '<br>';
        output += '</div>';
        output += '</div>';
        output += '</div>';
    }
    return output;
}

function checkedMe(me){
    if ($(me).is(':checked')) {
        var key = Math.random().toString(36).substring(7);
        var data = { key: key, id : $(me).val(), name : $(me).attr('data-name'), category_name : $(me).attr('data-category'), cost : $(me).attr('data-cost')}
        NewIncludeProperty.push(data);
    }  
    else {
        NewIncludeProperty = NewIncludeProperty.filter(data => data.id != $(me).val());        
    }    
    
}

function pushToPropertyTable() {
    var new_row = '';

    $.each(NewIncludeProperty, function(){   

        var existing_id = FixIncludeProperty.filter(data => data.id == this.id);             
        if(existing_id == ''){
            var delete_btn = "<button class='btn btn-sm btn-danger btn-flat' data-id='"+this.id+"' data-key='"+this.key+"' onclick='delThisPropertyInclude(this)'><i class='fa fa-close'></i></button>";
            var property_link = "<a target='_blank' href=" + main_property_detail_url + this.id + ">"+this.name+"</a>";
            new_row += "<tr><td>" + property_link + "</td>";
            new_row += "<td>" + this.category_name + "</td>";       
            new_row += "<td >Rp. " + $.number(this.cost) + "</td>";  
            new_row += "<td>" + delete_btn + "</td>";
            new_row += "</tr>";
            FixIncludeProperty.push(this);     
        }        
    })   

    tdnumberformat(); 
    
    NewIncludeProperty = [];    
    $("#propertyIncludeData").append(new_row);    
}

function tdnumberformat(){
    $('.td_number').number(true);
}
function delThisPropertyInclude(me){
   var key = $(me).attr('data-key');
   FixIncludeProperty = FixIncludeProperty.filter(data => data.key != key);
   $(me).closest('tr').remove();   
}

function deleteThisImageInEdit(e) {
    var img_id = $(e).attr('image-id');
    deleted_image.push(img_id);
    $(e).closest('.image_container').remove();
}

function deleteThisImage(e) {
    $(e).closest('.image_container').remove();
}

function setMap() {
    var map_script = $("#map").val();
    $(".map_result_area").show();
    $("#map_result").html(map_script);
    $("iframe").css("width", "100%");
    $("iframe").css("height", "50%");
}

function initiliaze_property_include(){
    $(".hidden_id_properti_data").each(function() {
        var hidden_id = {id: $(this).val()};
        FixIncludeProperty.push(hidden_id);
    })

    console.log(FixIncludeProperty);
}