var close_with = [];

function table_render() {
    var detail = site + 'property/';
    var table = $('.table1').DataTable({
        responsive: true,
        ajax: detail + 'json',
        columns: [{
            data: null
        }, {
            data: 'name'
        }, {
            data: 'category_name'
        }, {
            data: 'type'
        }, {
            data: 'price'
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
                if (data == 'P') {
                    return '<span class="text-success">Baru</span>';
                } else {
                    return '<span class="text-warning">Bekas</span>';
                }
            },
            "targets": 3
        }, {
            "render": function(data, type, row) {
                if (data == 'A') {
                    return '<span class="text-success">Tersedia</span>';
                } else if (data == 'I') {
                    return '<span class="text-warning">Indent</span>';
                } else {
                    return '<span class="text-primary">Terjual</span>';
                }
            },
            "targets": 5
        }, {
            "render": function(data, type, row) {
                return '<a href="' + detail + data + '"  class="btn btn-fill btn-sm btn-warning btn-flat" title="Edit"><i class="fa fa-pencil"></i></a>&nbsp<button   class="btn btn-fill btn-flat btn-sm btn-danger" title="Hapus" onclick="DeleteConfirmationInIndexTable(\'' + data + '\',this)"><i class="fa fa-trash"></i></button>';
            },
            "targets": 7
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
        url: site + 'category_property/attribute/latest',
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
                var edit_link = site + 'category_property/attribute/' + item.id;
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
    var type = $('#type').val();
    empty_validate(type, 'Tipe');
    var category = $('#category_property').val();
    var sub_category = $('#sub_category').val();
    var desc = CKEDITOR.instances['desc'].getData();
    var address = $('#address').val();
    var video = $('#video').val();
    var map = $('#map').val();
    var use_sub_category_attr = 'N';
    var attribute_data = [];
    if(sub_category == '0'){
        category = category;
    } else {
        category = sub_category;
    }

    if ($(".specification_row").attr('use') == 'yes') {
        use_sub_category_attr = 'Y';
    } else {
        $(".specification").each(function() {
            var $parent_this = $(this);
            if ($(this).attr('use') === 'yes') {
                var this_attributes_array = [];
                var this_attributes_options_array = [];
                $(".this_attribute", this).each(function() {
                    if ($(this).val() != "") {
                        var data = {
                            "id": $(this).attr('attribute-id'),
                            "value": $(this).val()
                        }
                        attribute_data.push(data);
                    }
                });
                $(".this_attribute_with_options", this).each(function() {
                    var me = {
                        "id": $(this).attr('attribute-id'),
                        "options": ""
                    };
                    var me_data = [];
                    $(".this_attribute_option", this).each(function() {
                        if ($(this).val() != "") {
                            var attribute_data = {
                                "id": $(this).val()
                            };
                            me_data.push(attribute_data);
                        }
                    })
                    me.options = me_data;
                    attribute_data.push(me);
                });
            }
        })
    }
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
    input.append('type', type);
    input.append('desc', desc);
    input.append('video', video);
    input.append('address', address);
    input.append('map', map);
    // input.append('sub_category', sub_category);
    input.append('category', category);
    input.append('use_sub_category_attr', use_sub_category_attr);
    input.append('attribute_data', JSON.stringify(attribute_data));
    input.append('close_with_data', JSON.stringify(close_with));
    input.append('images_data', JSON.stringify(images));
    input.append('sketchs_data', JSON.stringify(sketchs));
    input.append('image_thumbnail', thumbnail);
    var post_url = 'property/post';
    ServerPost(post_url, input, true);
}

function update() {
    var name = $('#name').val();
    empty_validate(name, 'Name');
    var type = $('#type').val();
    empty_validate(type, 'Tipe');
    var category = $('#category_property').val();
    var category_old = $('#category_property_last').val();
    var attribute_data = [];
    var desc = CKEDITOR.instances['desc'].getData();
    var address = $('#address').val();
    var map = $('#map').val();
    var video = $('#video').val();
    $(".specification").each(function() {
        var $parent_this = $(this);
        if ($(this).attr('use') === 'yes') {
            var this_attributes_array = [];
            var this_attributes_options_array = [];
            $(".this_attribute", this).each(function() {
                if ($(this).val() != "") {
                    var data = {
                        "id": $(this).attr('attribute-id'),
                        "value": $(this).val()
                    }
                    attribute_data.push(data);
                }
            });
            $(".this_attribute_with_options", this).each(function() {
                var me = {
                    "id": $(this).attr('attribute-id'),
                    "options": ""
                };
                var me_data = [];
                $(".this_attribute_option", this).each(function() {
                    if ($(this).is(':checked')) {
                        var attribute_data = {
                            "id": $(this).val()
                        };
                        me_data.push(attribute_data);
                    }
                })
                me.options = me_data;
                attribute_data.push(me);
            });
        }
    })
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
    input.append('type', type);
    input.append('video', video);
    input.append('desc', desc);
    input.append('address', address);
    input.append('map', map);
    input.append('category', category);
    input.append('category_old', category_old);
    input.append('attribute_data', JSON.stringify(attribute_data));
    input.append('close_with_data', JSON.stringify(close_with));
    input.append('images_data', JSON.stringify(images));
    input.append('image_thumbnail', thumbnail);
    input.append('deleted_images_data', JSON.stringify(deleted_image));
    input.append('sketchs_data', JSON.stringify(sketchs));
    var post_url = 'property/update';
    ServerPost(post_url, input, );
}

function Delete(row) {
    var input = new FormData();
    input.append('id', $('#del_id').val());
    var delete_url = 'category_property/delete';
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
    var delete_url = 'property/place/delete';
    ServerPost(delete_url, input);
}
// custom function 
function setCategory() {
    var selected = $('#category_property').val();    
    var get_category_attribute_url = site + 'category/json/' + selected;
    var get_sub_category = site + 'category/subcategory/json/' + selected;
    $.getJSON(get_sub_category, function(reply) {
        $("#new_sub_category").remove();
        if (reply.data != "") {
            var sub_category = setSubCategoryOptions(reply);
            $(".specification_parent").show();
            $("#useAttrFrom").show();
            $("#category_opt").removeClass('col-md-12');
            $("#category_opt").addClass('col-md-6');
            $("#category_row").append(sub_category);
        } else {
            $("#useAttrFrom").hide();
            $("#category_opt").removeClass('col-md-6');
            $("#category_opt").addClass('col-md-12');
            $(".specification_parent").show();
        }
    });
    $.getJSON(get_category_attribute_url, function(data) {
        if (data.response == "OK") {
            var set_html = setAttributeHtml(data);
            $(".specification_row").empty();
            $(".specification_parent").empty();
            $(".specification_parent").append(set_html);
            // $(".specification_parent").hide();
        }
    });
}

function setCategoryEdit() {   
    $("#last_sub_category").hide(); 
    var selected = $('#category_property').val();      
    var get_category_attribute_url = site + 'category/json/' + selected;
    var get_sub_category = site + 'category/subcategory/json/' + selected;
    $.getJSON(get_sub_category, function(reply) {
        $("#new_sub_category").remove();
        if (reply.data != "") {            
            var sub_category = setSubCategoryEditOptions(reply);            
            $(".specification_parent").show();
            $("#useAttrFrom").show();
            $("#category_opt").removeClass('col-md-12');
            $("#category_opt").addClass('col-md-6');
            $("#category_row").append(sub_category);
        } else {
            $("#useAttrFrom").hide();
            $("#category_opt").removeClass('col-md-6');
            $("#category_opt").addClass('col-md-12');
            $(".specification_parent").show();
        }
    });
    $.getJSON(get_category_attribute_url, function(data) {
        if (data.response == "OK") {
            var set_html = setAttributeHtml(data);
            $(".specification_row").empty();
            $(".specification_parent").empty();
            $(".specification_parent").append(set_html);    
            // $(".specification_parent").hide();
        }
    });
}



function setUseAttr(e) {
    if ($(e).is(':checked')) {
        var UseAttr = $(e).val();
        if (UseAttr == '1') {
            $(".specification_parent").show();
            $(".specification_parent").attr('use', 'yes');
            $(".specification_row").attr('use', 'no');
            $(".specification_row").hide();
        } else {
            $(".specification_parent").hide();
            $(".specification_parent").attr('use', 'no');
            $(".specification_row").attr('use', 'yes');
            $(".specification_row").show();
        }
    }
}

function setSubCategoryOptions(response) {
    var html = '<div id="new_sub_category" class="col-md-6">';
    if (response.data != "") {
        html += '<label>Sub Kategori</label><br>';
        html += '<select class="form-control" id="sub_category" onchange="setSubCategoryAttr(this)">';
        html += '<option value="0">Pilih</option>';
        $.each(response.data, function(i, sub) {
            html += '<option value="' + sub.id + '">' + sub.name + '</option>';
        })
        html += '</select>';
    }
    html += '</div>';
    return html;
}

function setSubCategoryEditOptions(response) {
    var html = '<div id="new_sub_category" class="col-md-6">';
    if (response.data != "") {
        html += '<label>Sub Kategori</label><br>';
        html += '<select class="form-control" id="sub_category" onchange="setSubCategoryAttrEdit(this)">';
        html += '<option value="0">Pilih</option>';
        $.each(response.data, function(i, sub) {
            html += '<option value="' + sub.id + '">' + sub.name + '</option>';
        })
        html += '</select>';
    }
    html += '</div>';
    return html;
}

function setAttributeHtml(response) {
    var html = '';
    var attr_div = '';
    $.each(response.data.attributes, function(i, attr) {
        attr_div += '<div class="col-md-6"><div class="form-group"> <label>' + attr.name + '</label><br>';
        if (attr.type == 'TXT') {
            if (attr.count_as != "") {
                attr_div += '<div class="input-group"><input type="text" class="form-control this_attribute" attribute-id="' + attr.id + '" ><span class="input-group-addon" id="basic-addon2">' + attr.count_as + '</span></div>';
            } else {
                attr_div += '<input type="text" class="form-control this_attribute"  attribute-id="" >';
            }
        } else if (attr.type == 'TXA') {
            attr_div += ' <textarea cols="30" rows="2" class="form-control this_attribute" attribute-id="' + attr.id + '"></textarea>'
        } else if (attr.type == 'RDB') {
            attr_div += "<div class='this_attribute_with_options' attribute-id='" + attr.id + "'>";
            if (attr.options != undefined) {
                $.each(attr.options, function(i, attr_opts) {
                    attr_div += "<label class='radio-inline'><input type='radio' checked='' name='radio_" + attr.id + "' class='this_attribute_option' attribute-id='' attribute-id-option='" + attr_opts.id + "' value='" + attr_opts.id + "' onchange='setActive(this)'>" + attr_opts.label + "</label>";
                })
            }
            attr_div += "</div>";
        } else if (attr.type == 'CBX') {
            attr_div += "<div class='this_attribute_with_options' attribute-id='" + attr.id + "'>";
            if (attr.options != undefined) {
                $.each(attr.options, function(i, attr_opts) {
                    attr_div += "<div class='checkbox'><label><input type='checkbox' class='this_attribute_option' attribute-id-option='" + attr_opts.id + "' attribute-id='' value='' onchange='setActive(this)'>" + attr_opts.label + "</label></div>";
                })
            }
            attr_div += "</div>";
        }
        attr_div += '</div></div>';
    })
    html += attr_div;
    return html;
}

function setSubCategoryAttr(e) {
    var selected = $('option:selected', e).val();
    var url = site + 'subcategory/attribute/json/' + selected;
    $.getJSON(url, function(data) {
        if (data.response == "OK") {
            var set_html = setAttributeSubCategoryHtml(data);
            console.log(set_html);
            $(".specification_row").empty();
            $(".specification_row").append(set_html);
        }
    });
}

function setSubCategoryAttrEdit(e) {
    var selected = $('option:selected', e).val();
    var last_sub_cat_id = $('#last_sub_category').attr('sub-category-id'); 
    if(selected == last_sub_cat_id){
        $('.specification_sub_cat').show();
    } else {
        $('.specification_sub_cat').hide();
        var url = site + 'subcategory/attribute/json/' + selected;
        $.getJSON(url, function(data) {
            if (data.response == "OK") {
                var set_html = setAttributeSubCategoryHtml(data);
                console.log(set_html);
                $(".specification_row").empty();
                $(".specification_row").append(set_html);
            }
        });
    }
}



function setAttributeSubCategoryHtml(response) {
    var html = '';
    var attr_div = '';
    $.each(response.data.attributes, function(i, attr) {
        attr_div += '<div class="col-md-6"><div class="form-group"> <label>' + attr.attribute_name + '</label><br>';
        if (attr.type == 'TXT') {
            if (attr.count_as != "") {
                attr_div += '<div class="input-group"><input type="text" class="form-control this_attribute" disabled attribute-id="' + attr.attribute_category_property_id + '" value="' + attr.value + '" ><span class="input-group-addon" id="basic-addon2">' + attr.attribute_count_as + '</span></div>';
            } else {
                attr_div += '<input type="text" class="form-control this_attribute"  disabled attribute-id="' + attr.attribute_category_property_id + '" value="' + attr.value + '" >';
            }
        } else if (attr.type == 'TXA') {
            attr_div += ' <textarea cols="30" rows="2" class="form-control this_attribute" disabled attribute-id="' + attr.attribute_category_property_id + '">' + attr.value + '</textarea>'
        } else if (attr.type == 'RDB') {
            attr_div += "<div class='this_attribute_with_options' attribute-id='" + attr.attribute_category_property_id + "'>";
            if (attr.attribute_value_property != '') {
                $.each(attr.attribute_value_property, function(i, attr_opts) {
                    attr_div += "<label class='radio-inline'><input disabled type='radio' checked='' name='radio_" + attr.attribute_category_property_id + "' class='this_attribute_option' attribute-id='' attribute-id-option='" + attr_opts.value_attribute_category_property_id + "' value='" + attr_opts.value_attribute_category_property_id + "' onchange='setActive(this)'>" + attr_opts.label_of_value_attribute_category_property + "</label>";
                })
            }
            attr_div += "</div>";
        } else if (attr.type == 'CBX') {
            attr_div += "<div class='this_attribute_with_options' attribute-id='" + attr.id + "'>";
            if (attr.attribute_value_property != undefined) {
                $.each(attr.attribute_value_property, function(i, attr_opts) {
                    attr_div += "<div class='checkbox'><label><input disabled checked type='checkbox' class='this_attribute_option' attribute-id-option='" + attr_opts.id + "' attribute-id='' value='' onchange='setActive(this)'>" + attr_opts.label_of_value_attribute_category_property + "</label></div>";
                })
            }
            attr_div += "</div>";
        }
        attr_div += '</div></div>';
    })
    html += attr_div;
    return html;
}

function showSubCategoryAttribute(){
    var sub_cat_id = $("#sub_category").val();
    var url = site + 'subcategory/attribute/json/' + sub_cat_id;
    $.getJSON(url, function(data) {
        if (data.response == "OK") {
            var set_html = setAttributeSubCategoryHtml(data);            
            $(".specification_row").empty();
            $(".specification_sub_cat").append(set_html);
            console.log(set_html);
        }
    });   
}


function setActive(e) {
    if ($(e).is(':checked') || $(e).is(':selected')) {
        var attribute_id_backup = $(e).attr('attribute-id-option');
        $(e).attr('attribute-id', attribute_id_backup);
        $(e).val(attribute_id_backup);
    } else {
        $(e).attr('attribute-id', '');
        $(e).val('');
    }
}

function setMap() {
    var map_script = $("#map").val();
    $(".map_result_area").show();
    $("#map_result").html(map_script);
    $("iframe").css("width", "100%");
    $("iframe").css("height", "50%");
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

function deleteThisImage(e) {
    $(e).closest('.image_container').remove();
}

function deleteThisImageInEdit(e) {
    var img_id = $(e).attr('image-id');
    deleted_image.push(img_id);
    $(e).closest('.image_container').remove();
}

function updatePlace() {
    var name = $("#name").val();
    var direction = $("#direction").val();
    var distance = $("#distance").val();
    var distance_as = $("#distance_as").val();
    var input = new FormData();
    input.append('name', name);
    input.append('direction', direction);
    input.append('distance', distance);
    input.append('distance_as', distance_as);
    var post_url = 'property/place/update';
    ServerPost(post_url, input, true);
}

function setToThumbnail(image_name) {
    thumbnail = image_name;
    console.log(thumbnail);
}