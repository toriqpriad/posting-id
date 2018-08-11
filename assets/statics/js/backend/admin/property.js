var close_with = [];

function table_render() {
    var detail = site + 'product/';
    var table = $('.table1').DataTable({
        responsive: true,
        ajax: detail + 'json',
        columns: [{
            data: null
        }, {
            data: 'name'
        }, {
            data: 'brand_name'
        }, {
            data: 'category_name'
        }, {
            data: 'cost'
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
                return 'Rp. ' + $.number(data);
            },
            "targets": 4
        }, {
            "render": function(data, type, row) {
                if (data == 'A') {
                    return '<span class="label label-success">Tersedia</span>';
                } else {
                    return '<span class="label label-danger">Habis</span>';
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
    var brand = $('#brand').val();
    empty_validate(type, 'Tipe');
    var category = $('#category_property').val();
    if (category == "0") {
        category = "";
        empty_validate(category, 'Kategori');
    }
    var sub_category = $('#sub_category').val();
    var desc = CKEDITOR.instances['desc'].getData();
    var address = $('#address').val();
    var video = $('#video').val();
    var map = $('#map').val();
    var use_sub_category_attr = 'N';
    var cost = $('#cost_value').val();
    var dp = $('#dp_value').val();
    var attribute_data = [];
    var sub_category = $('#sub_category').val();
    if (sub_category == undefined) {
        category = $('#category_property').val();
    } else if (sub_category == '0') {
        category = $('#category_property').val();
    } else {
        category = sub_category;
    }
    $("input[name='useAttr']").each(function() {
        if ($(this).is(':checked')) {
            selectedAttr = $(this).val();
        }
    })
    if (selectedAttr == 'parent') {
        use_sub_category_attr = 'N';
        $(".attr_parent").each(function() {
            var used = $(this).attr('use');
            if (used == 'yes') {
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
                        if ($(this).is(":checked")) {
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
    } else {
        use_sub_category_attr = 'Y';
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
    input.append('category', category);
    input.append('use_sub_category_attr', use_sub_category_attr);
    input.append('cost', cost);
    input.append('brand', brand);
    input.append('attribute_data', JSON.stringify(attribute_data));
    input.append('close_with_data', JSON.stringify(close_with));
    input.append('images_data', JSON.stringify(images));
    input.append('sketchs_data', JSON.stringify(sketchs));
    input.append('image_thumbnail', thumbnail);
    var post_url = 'product/post';
    ServerPost(post_url, input, true);
}

function update() {
    var name = $('#name').val();
    empty_validate(name, 'Name');
    var type = $('#type').val();
    empty_validate(type, 'Tipe');
    var category = $('#category_property').val();
    empty_validate(category, 'Kategori');
    var category_old = $('#category_property_last').val();
    var brand_new = $('#brand').val();
    var brand_old = $('#brand_id_last').val();
    var attribute_data = [];    
    var desc = CKEDITOR.instances['desc'].getData();
    var additional_description = CKEDITOR.instances['additional_description'].getData();    
    var address = $('#address').val();
    var map = $('#map').val();
    var cost = $('#cost_value').val();
    var dp = $('#dp_value').val();
    var video = $('#video').val();
    var useAttr = $("input[name='useAttr']").val();
    var selectedAttr = '';
    var use_sub_category = '';
    var sub_category = $('#sub_category').val();
    if (sub_category == undefined) {
        category = $('#category_property').val();
    } else if (sub_category == '0') {
        category = $('#category_property').val();
    } else {
        category = sub_category;
    }
    $("input[name='useAttr']").each(function() {
        if ($(this).is(':checked')) {
            selectedAttr = $(this).val();
        }
    })
    if (selectedAttr == 'parent') {
        use_sub_category = 'N';
        $(".attr_parent").each(function() {
            var used = $(this).attr('use');
            if (used == 'yes') {
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
                        if ($(this).is(":checked")) {
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
    } else {
        use_sub_category = 'Y';
    }
    // console.log(attribute_data);
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
    input.append('additional_description', additional_description);
    input.append('address', address);
    input.append('map', map);
    input.append('cost', cost);
    input.append('dp', dp);
    input.append('brand_old', brand_old);
    input.append('brand_new', brand_new);
    input.append('category', category);
    input.append('category_old', category_old);
    input.append('use_sub_category', use_sub_category);
    input.append('parent_type', use_parent_type);
    input.append('attribute_data', JSON.stringify(attribute_data));
    input.append('close_with_data', JSON.stringify(close_with));
    input.append('images_data', JSON.stringify(images));
    input.append('image_thumbnail', thumbnail);
    input.append('deleted_images_data', JSON.stringify(deleted_image));
    input.append('sketchs_data', JSON.stringify(sketchs));
    input.append('city_property', JSON.stringify(selected_city));
    var post_url = 'product/update';
    ServerPost(post_url, input, true);
}

function Delete(row) {
    var input = new FormData();
    input.append('id', $('#del_id').val());
    var delete_url = 'product/delete';
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

function ShowPromotionModal() {
    $('#PromotionModal').modal({
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

function DeletePromotionEditModal(id) {
    $('#DeletePromotionModal').modal({
        backdrop: false
    });
    $("#promotion_id").val(id);
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

function filemanagerPromotionModalShow(action) {
    $('#framefmpromotion').show()
    // var active_action = "promotion";
    console.log(action);
    $(".active_action_promotion").val(action)
    var frame_url = $('#filemanager_url').val();
    $('#filemanager_promotion_frame').attr('src', frame_url);
    $('#filemanager_promotion_frame').addClass('thumbnail');
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

function ShowDatasetModal() {
    $('#datasetModal').modal({
        backdrop: false
    });
    $('#datasetDiv').empty();
    var html = '';
    $.getJSON(site + 'product/dataset', function(reply) {
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

            $.getJSON(site + 'product/dataset/' + city_val, function(data) {
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
        url : site + 'product/dataset/' + target,
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
    var delete_url = 'product/dataset/delete';
    ServerPost(delete_url, input, false);
}

function deletePlace(id) {
    var input = new FormData();
    input.append('id', id);
    var delete_url = 'property/place/delete';
    ServerPost(delete_url, input);
}
// custom function 
function checkParent() {
    if (use_subcategory_check == 'yes') {
        $(".parent_attribute_recorded_row").attr('use', 'yes');
    }
}

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
            $(".specification_parent").attr('use', 'yes');
            $(".specification_row").attr('use', 'no');
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

function setParentCategoryEdit() {
    var selected = $('#category_property').val();
    var category_last = $("#category_property_last").val();
    var get_category_attribute_url = site + 'category/json/' + selected;
    var get_sub_category = site + 'category/subcategory/json/' + selected;
    $.getJSON(get_sub_category, function(reply) {
        var sub_category = setSubCategoryEditOptions(reply);
        $("#select_sub_cat").empty();
        $("#select_sub_cat").append(sub_category);
        $(".subcategory_attribute_recorded").hide();
        $(".subcategory_attribute_new").hide();
        $(".row_subcategory_attribute_new").empty();
    });
    $("#radio_sub_category").removeAttr('checked');
    if (selected == category_last) {
        $(".parent_attribute_recorded").show();
        $(".parent_attribute_new_row").attr('use', '');
        $(".parent_attribute_recorded_row").attr('use', 'yes');
        $(".parent_attribute_new").hide();
        use_parent_type = 'old';
    } else {
        $.getJSON(get_category_attribute_url, function(data) {
            use_parent_type = 'new';
            if (data.response == "OK") {
                var set_html = setParentAttributeHtml(data);
                $(".parent_attribute_recorded_row").removeAttr('use', '');
                $(".parent_attribute_new_row").attr('use', 'yes');
                $(".parent_attribute_new_row").empty();
                $(".parent_attribute_recorded").hide();
                $(".parent_attribute_new").show();
                if (set_html === '') {
                    set_html = 'Tidak ada spesifkasi khusus';
                }
                $(".parent_attribute_new_row").append(set_html);
                // $(".specification_parent").hide();
            }
        });
    }
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
    var html = '';
    if (response.data != "") {
        html += '<select class="form-control" id="sub_category" onchange="setSubCategoryAttrEdit(this)">';
        html += '<option value="0">Pilih</option>';
        $.each(response.data, function(i, sub) {
            html += '<option value="' + sub.id + '">' + sub.name + '</option>';
        })
        html += '</select>';
    } else {
        html += '<select class="form-control" id="sub_category" onchange="setSubCategoryAttr(this)">';
        html += '<option value="0">Pilih</option>';
        html += '</select>';
    }
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
                attr_div += '<input type="text" class="form-control this_attribute"  attribute-id="' + attr.id + '" >';
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

function setParentAttributeHtml(response) {
    var html = '';
    var attr_div = '';
    $.each(response.data.attributes, function(i, attr) {
        attr_div += '<div class="col-md-12"><div class="form-group"> <label>' + attr.name + '</label><br>';
        if (attr.type == 'TXT') {
            if (attr.count_as != "") {
                attr_div += '<div class="input-group"><input type="text" class="form-control this_attribute" attribute-id="' + attr.id + '" ><span class="input-group-addon" id="basic-addon2">' + attr.count_as + '</span></div>';
            } else {
                attr_div += '<input type="text" class="form-control this_attribute"  attribute-id="' + attr.id + '" >';
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
            $(".specification_row").empty();
            $(".specification_row").append(set_html);
        }
    });
}

function setSubCategoryAttrEdit(e) {
    var selected = $('option:selected', e).val();
    var url = site + 'subcategory/attribute/json/' + selected;
    $.getJSON(url, function(data) {
        if (data.response == "OK") {
            var set_html = setAttributeSubCategoryEditHtml(data);
            $(".subcategory_attribute_new").show();
            $(".subcategory_attribute_recorded").hide();
            $(".row_subcategory_attribute_new").empty();
            if (set_html === '') {
                set_html = '<center>Tidak ada spesifkasi khusus</center>';
            }
            $(".row_subcategory_attribute_new").append(set_html);
        }
    });
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

function setAttributeSubCategoryEditHtml(response) {
    var html = '';
    var attr_div = '';
    $.each(response.data.attributes, function(i, attr) {
        attr_div += '<div class="col-md-12"><div class="form-group"> <label>' + attr.attribute_name + '</label><br>';
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
                    attr_div += "<label class='radio-inline'><input disabled type='radio'  use='new' checked='' name='radio_" + attr.attribute_category_property_id + "' class='this_attribute_option' attribute-id='' attribute-id-option='" + attr_opts.value_attribute_category_property_id + "' value='" + attr_opts.value_attribute_category_property_id + "' onchange='setActive(this)'>" + attr_opts.label_of_value_attribute_category_property + "</label>";
                })
            }
            attr_div += "</div>";
        } else if (attr.type == 'CBX') {
            attr_div += "<div class='this_attribute_with_options' attribute-id='" + attr.id + "'>";
            if (attr.attribute_value_property != undefined) {
                $.each(attr.attribute_value_property, function(i, attr_opts) {
                    attr_div += "<div class='checkbox'><label><input disabled checked type='checkbox'  use='new' class='this_attribute_option' attribute-id-option='" + attr_opts.id + "' attribute-id='' value='' onchange='setActive(this)'>" + attr_opts.label_of_value_attribute_category_property + "</label></div>";
                })
            }
            attr_div += "</div>";
        }
        attr_div += '</div></div>';
    })
    html += attr_div;
    return html;
}

function showSubCategoryAttribute() {
    var sub_cat_id = $("#sub_category").val();
    var url = site + 'subcategory/attribute/json/' + sub_cat_id;
    $.getJSON(url, function(data) {
        if (data.response == "OK") {
            var set_html = setAttributeSubCategoryEditHtml(data);
            $(".specification_row").empty();
            $(".row_subcategory_attribute_recorded").append(set_html);
        }
    });
}

function setAttributeSubCategoryEditHtml(response) {
    var html = '';
    var attr_div = '';
    $.each(response.data.attributes, function(i, attr) {
        attr_div += '<div class="col-md-12"><div class="form-group"> <label>' + attr.attribute_name + '</label><br>';
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

function init_map() {
    var latitude_val = $("#lat").val();
    var longtitude_val = $("#long").val();
    //   new GMaps({
    //     div: '#latlongmap',
    //     lat: latitude_val,
    //     lng: longtitude_val
    // });    
    // $("#latlongmap").googleMap();
    // $("#latlongmap").addMarker({
    //     coords: [48.895651, 2.290569], // GPS coords
    //     url: 'http://www.tiloweb.com', // Link to redirect onclick (optional)
    //     id: 'marker1' // Unique ID for your marker
    // });    
    var uluru = {
        lat: 48.895651,
        lng: 2.290569
    };
    var map = new google.maps.Map(document.getElementById('latlongmap'), {
        zoom: 4,
        center: uluru
    });
    var marker = new google.maps.Marker({
        position: uluru,
        map: map
    });
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
    var post_url = 'product/place/update';
    ServerPost(post_url, input, true);
}

function setToThumbnail(image_name) {
    thumbnail = image_name;
}

function load_image_promotion(event) {
    var img_url = URL.createObjectURL(event.target.files[0]);
    $("#promotion_image_result").attr('src', img_url);
    $("#new_promotion_image_name").val(event.target.files[0].name);
    $("#promotion_image_result").show();
}

function saveNewPromotion() {
    var name = $("#new_promotion_name").val();
    var desc = $("#new_promotion_desc").val();
    var image_name = $("#new_promotion_image_name").val();
    var image_file = $('#promotion_image').prop('files')[0];
    var input = new FormData();
    input.append('name', name);
    input.append('desc', desc);
    input.append('image_name', image_name);
    input.append('image_file', image_file);
    var post_url = 'product/promotion/post';
    ServerPost(post_url, input);
    setTimeout(function() {
        promotionTableRefresh();
    }, 1000);
}

function promotionTableRefresh() {
    var url = site + 'property/promotion/json';
    $.getJSON(url, function(reply) {
        $("#promotionTableBody").empty();
        if (reply.data != "") {
            var html = '';
            $.each(reply.data, function(i, each) {
                html += "<tr>";
                html += "<td>" + each.name + "</td>";
                html += "<td>" + each.description + "</td>";
                var image_tag = '<img src="' + each.img_url + '" style="width:40%">'
                html += "<td>" + image_tag + "</td>";
                var edit_btn = '<button class="btn btn-sm btn-warning btn-flat" title="Edit"><i class="fa fa-pencil"></i></button>&nbsp;';
                var del_btn = "<button class='btn btn-sm btn-danger btn-flat'  title='Hapus' onclick='DeletePromotionEditModal(&quot;" + each.id + "&quot;)'><i class='fa fa-close'></i></button>";
                html += "<td>" + edit_btn + del_btn + "</td>";
                html += "</tr>";
            })
            $("#promotionTableBody").append(html);
        }
    });
}

function DeletePromotion() {
    var id = $("#promotion_id").val();
    var input = new FormData();
    input.append('id', id);
    var post_url = 'product/promotion/delete';
    ServerPost(post_url, input);
    setTimeout(function() {
        promotionTableRefresh();
    }, 1000);
}