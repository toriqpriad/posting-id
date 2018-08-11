//CRUD OPERATION
function post() {
	var name = $('#name').val();
	var desc = $('#description').val();
	var attribute_data = [];
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
	var input = new FormData();
	input.append('name', name);
	input.append('desc', desc);
	input.append('attribute_data', JSON.stringify(attribute_data));
	var post_url = 'subcategory/post';
	ServerPost(post_url, input);
}

function update() {
	var name = $('#name').val();
	var desc = $('#desc').val();
	var new_category_id = $('#category_property').val();
	var last_category_id = $('#category_property_last').val();
	var use_category_attribute = $('#use_category_attribute').attr('use');
	var attribute_data = [];
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
	var input = new FormData();
	input.append('name', name);
	input.append('desc', desc);
	input.append('category', new_category_id);
	input.append('category_old', last_category_id);
	input.append('category_attr', use_category_attribute);
	input.append('attribute_data', JSON.stringify(attribute_data));
	var post_url = 'subcategory/update';
	ServerPost(post_url, input);
}

//MODAL
function PostConfirmation() {
	$('#PostConfirmationModal').modal({
		backdrop: false
	});
}

function UpdateConfirmation() {
	$('#UpdateConfirmationModal').modal({
		backdrop: false
	});
}



//custom
function setParentAttribute(e) {
	if ($(e).is(':checked')) {
		$('.specification').attr('use', 'yes');
		$('.specification').show();
		$(e).attr('use','yes')
	} else {
		$(e).attr('use','')
		$('.specification').attr('use', '');
		$('.specification').hide();
	}
}

function setCategory(e) {
	var selected = $('option:selected', e).val();
	var category_last_id = $("#category_property_last").val();
	if($("#use_category_attribute").is(':checked')){
		var use_category_attribute = 'yes';
	} else {
		var use_category_attribute = '';
	}
	if(use_category_attribute == 'yes'){
		if (selected != category_last_id) {
			$(".specification_old").css('display', 'none');
			var get_category_attribute_url = site + 'category/json/' + selected;
			$.getJSON(get_category_attribute_url, function(data) {
				if (data.response == "OK") {
					$(".specification_row").empty();				
					$(".specification_row").attr('use','yes');
					$(".specification_old").attr('use','');
					$(".specification_old").hide();				
					var set_html = setAttributeHtml(data);
					$(".specification_row").append(set_html);
				}
			});
		} else {
			$(".specification_row").empty();
			$(".specification_row").attr('use','');
			$(".specification_old").css('display', '');
		}
	}
}

function setAttributeHtml(response) {
	var html = '';
	var attr_div = '';
	$.each(response.data.attributes, function(i,attr){		
		attr_div += '<div class="col-md-6"><div class="form-group"> <label>'+attr.name+'</label><br>';		
		if(attr.type == 'TXT'){
			if(attr.count_as != ""){
				attr_div += '<div class="input-group"><input type="text" class="form-control this_attribute" attribute-id="'+attr.id+'" ><span class="input-group-addon" id="basic-addon2">'+attr.count_as+'</span></div>';
			} else {
				attr_div += '<input type="text" class="form-control this_attribute"  attribute-id="" >';
			}
		} else if(attr.type == 'TXA'){
			attr_div += ' <textarea cols="30" rows="2" class="form-control this_attribute" attribute-id="'+attr.id+'"></textarea>'
		} else if(attr.type == 'RDB'){
			attr_div += "<div class='this_attribute_with_options' attribute-id='"+attr.id+"'>";
			if(attr.options != undefined){
				$.each(attr.options, function(i,attr_opts){
					attr_div += "<label class='radio-inline'><input type='radio' checked='' name='radio_"+attr.id+"' class='this_attribute_option' attribute-id='' attribute-id-option='"+attr_opts.id+"' value='"+attr_opts.id+"' onchange='setActive(this)'>"+attr_opts.label+"</label>";					
				})
			}
			attr_div += "</div>";		
		} else if(attr.type == 'CBX'){
			attr_div += "<div class='this_attribute_with_options' attribute-id='"+attr.id+"'>";
			if(attr.options != undefined){
				$.each(attr.options, function(i,attr_opts){
					attr_div += "<div class='checkbox'><label><input type='checkbox' class='this_attribute_option' attribute-id-option='"+attr_opts.id+"' attribute-id='' value='' onchange='setActive(this)'>"+attr_opts.label+"</label></div>";					
				})
			}
			attr_div += "</div>";
		}
		attr_div +='</div></div>';
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

