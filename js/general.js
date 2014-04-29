$(document).ready(function(){

	

	
	$(".set-current-year").live("click", function(){
		my_uri = $(location).attr("href");
		
		form_data = {
				uri:my_uri
		};
		
		$.ajax({
			type:"get",
			data: form_data,
			url:base_url + "index/show_set_year",
			success:function(data){
				show_popup("Set Sale Year",data,"auto");
			}
		});
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


	