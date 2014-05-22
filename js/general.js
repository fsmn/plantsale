$(document).ready(function(){
	$("#utility").on("click",".set-current-year", function(){
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

	$(".field-envelope").on("click",".edit-field",function(){

		my_parent = $(this).parent().attr("id");
		my_attr = my_parent.split("__");
		my_type = "text";
		my_category = $(this).attr('menu');
		my_name = $(this).attr("name");
			if($(this).hasClass("dropdown")){
				my_type = "dropdown";
			}else if($(this).hasClass("checkbox")){
				my_type = "checkbox";
			}else if($(this).hasClass("multiselect")){
				my_type = "multiselect";
			}else if($(this).hasClass("textarea")){
				my_type = "textarea";
			}
			console.log(my_type);
			form_data = {
					table: my_attr[0],
					field: my_name,
					id: my_attr[2],
					type: my_type,
					category: my_category,
					value: $(this).html()
			};
			$.ajax({
				type:"get",
				url: base_url + my_attr[0] + "/edit_value",
				data: form_data,
				success: function(data){
					$("#" + my_parent + " .edit-field").html(data);
					$("#" + my_parent + " .edit-field").removeClass("edit-field").removeClass("field").addClass("live-field").addClass("text");
					$("#" + my_parent + " .live-field input").focus();
				}
			});
	});
	
	$(".field-envelope").on("blur",".live-field.text",function(){
		//id, field, value {post}
		update_field(this);
	
	});
	
	$(".field-envelope").on("click", ".save-multiselect",function(){
		
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

function update_field(me){
	my_parent = $(me).parent().attr("id");
	my_attr = my_parent.split("__");
	my_value = $(me).children().val();
	form_data = {
			table: my_attr[0],
			field: my_attr[1],
			id: my_attr[2],
			value: my_value
	};
	$.ajax({
		type:"post",
		url: base_url + my_attr[0] + "/update_value",
		data: form_data,
		success: function(data){
			$("#" + my_parent + " .live-field").html(data);
			$("#" + my_parent + " .live-field").addClass("edit-field field").removeClass("live-field text");
		}
	});
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
		},
		error: function(output){
			return output;
		}
	
	});
}


$(window).scroll(function(){
	var top=$('.float');
	if($(window).scrollTop()>250){
		if(top.css('position')!='fixed'){
			top.css('position','fixed');
			top.css('top', 15);
			top.css('left','45%');
			//top.css('background-color','#000');
		}
	}else{
		if(top.css('position')!='static'){
			top.css('position','static');
			top.css('top','inherit');
			top.css('background-color','inherit');
		}
	}
});