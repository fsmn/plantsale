$(document).ready(function(){
	
	$(".edit-field").live("click",function() {
		me = $(this);
		my_field = me.parents("p").attr("class");
		my_value = me.html();
		if(me.hasClass("dropdown")){
			my_category = me.attr("menu");
			form_data = {
					field: my_field,
					category: my_category,
					value: my_value
			};
			$.ajax({
				type: "get",
				url: base_url + "menu/get_dropdown",
				data: form_data,
				success: function(output){
					me.html(output).removeClass("edit-field");
				}
			
			});
			
		}else if(me.hasClass("textarea")){
			me.html("<br/><textarea name='" + my_field + "'class='save-field'>" + my_value + "</textarea>").removeClass("edit-field");
			
		 
			
		}else{
			if(me.attr("format")){
				my_format = me.attr("format");
				if(my_format == "currency"){
					my_value = my_value.split("$")[1];
				}
			}
		me.html(
				"<input type='text' name='" + my_field
						+ "' class='save-field' value='"
						+ my_value + "'/>").removeClass("edit-field");
		$(".save-field").focus();
		}
	});

	$(".save-field").live("blur", function() {
		save_field($(this));
	});
	
	$(".dropdown .save-field").live("change", function(){
		save_field($(this));
	});
	
});

function show_popup(my_title,data,popup_width,x,y){
	if(!popup_width){
		popup_width=300;
	}
	var myDialog=$('<div id="popup">').html(data).dialog({
		autoOpen:false,
		title: my_title,
		modal: true,
		width: popup_width
	});
	
	if(x) {
		myDialog.dialog({position:x});
	}


	myDialog.fadeIn().dialog('open',{width: popup_width});

	return false;
}

function create_dropdown(my_field, my_category, my_value)
{
	form_data = {
			field: my_field,
			category: my_category,
			value: my_value
	};
	$.ajax({
		type: "get",
		url: base_url + "menu/get_dropdown",
		data: form_data,
		success: function(output){
			return output;
		}
	
	});
}

function save_field(me)
{
	table = $(me).parents("fieldset").attr("id");
	my_parent = $(me).parents("span");
	my_id = $("#id").val();
	if(table == "order"){
		my_id = $("#order_id").val();
	}
	my_value = $(me).val();
	my_field = $(me).attr("name");
	my_format = $(me).parents("span").attr("format");
	form_data = {
		field: my_field,
		value: my_value,
		format: my_format,
		id: my_id
	};
	my_url =  base_url +  table + "/update_value";
	$.ajax({
		type: "post",
		url: my_url,
		data: form_data,
		success: function(output){
			my_parent.addClass("edit-field").html(output);
			
		}
	});
	
}