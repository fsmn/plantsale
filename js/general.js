$(document).ready(function(){
	$("#footer").css({"top":$(document).height()-25 + "px"});
	
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
	
	$("table.list.hideable-columns").on("click","th", function(){
		$("table.list.hideable-columns .top-row").remove();

		id = $("table.list.hideable-columns th").index(this);
		id = Number(id) + 1;
		target = '.hideable-columns td:nth-child(' + id  + ')';
		console.log(target);

		$(target).hide();
		$(this).hide();
	});
	
	$(".column-instructions").on("click",".reset-columns",function(){
		$("table.list.hideable-columns th").show();
		$("table.list.hideable-columns td").show();
	});
	
	
	$(".search-fieldset").on("click","legend",function(){
		$(".search-parameters").toggle(400);
		$(".search-fieldset").toggleClass("hidden");
		if($(".search-fieldset").hasClass("hidden")){
			$(".search-fieldset legend").html("Show Search Parameters");
		}else{
			$(".search-fieldset legend").html("Search Parameters");
		}
	});
	$('table.list').stickytable();

});

	$(document).on("blur","#grower-id", function(){
		my_id = $("#grower-id").val();
		$.ajax({
			type:"get",
			url: base_url + "grower/is_unique/" + my_id,
			success: function(data){
				if(data == false){
					$("#unique-id").html("This ID is not unique!");
					$("#grower-id").addClass("notice");

				}else{
					$("#unique-id").html("OK");
					$("#grower-id").removeClass("notice");
				}
			}
		});
	});

$(document).on("click",".field-envelope .edit-field",function(){
if($("body").hasClass("editor")){
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
		}else if($(this).hasClass("autocomplete")){
			my_type = "autocomplete";
		}else if($(this).hasClass("category-dropdown")){
			my_type = "category-dropdown";
			my_category = "category";
		}else if($(this).hasClass("subcategory-dropdown")){
			my_type = "subcategory-dropdown";
			my_category = "subcategory";
		}
		form_data = {
				table: my_attr[0],
				field: my_name,
				id: my_attr[2],
				type: my_type,
				category: my_category,
				value: $(this).html()
		};
console.log(form_data);
		$.ajax({
			type:"get",
			url: base_url +  "menu/edit_value",
			data: form_data,
			success: function(data){
				
				$("#" + my_parent + " .edit-field").html(data);
				$("#" + my_parent + " .edit-field").removeClass("edit-field").removeClass("field").addClass("live-field").addClass("text");
				$("#" + my_parent + " .live-field input").focus();
			}
		});
}
});

$(document).on("click",".autocomplete.edit-field",function(){
	my_parent = $(this).parent(".field-envelope").attr("id");
	my_attr = my_parent.split("__");
	my_table = my_attr[0];
	my_category = $(this).attr("menu");
	my_value = $(this).val();
	form_data = {
			category: my_category,
			value: my_value,
			id:my_parent
	};
	$.ajax({
		dataType: "json",
		type:"get",
		data: form_data,
		url: base_url + "menu/get_autocomplete",
		success: function(data){
			$("#" + my_parent + " input").autocomplete({source:data});
		}
	});
	
});

$(document).on("blur",".field-envelope .live-field.text input",function(){
	if($(this).hasClass("ui-autocomplete-input")){
		update_field(this, "autocomplete");
	
	}else{
		update_field(this, "text");
	}
	return false;
});
$(document).on("blur",".field-envelope .live-field textarea",function(){
	update_field(this, "textarea");
});
$(document).on("blur",".field-envelope .live-field.category-dropdown select",function(){
	console.log("here");
	update_field(this, "category-dropdown");
});

$(document).on("blur",".field-envelope .live-field.subcategory-dropdown select",function(){
	update_field(this, "subcategory-dropdown");
});


$(document).on("blur",".field-envelope .live-field select",function(){
	update_field(this, "select");
});

//*/

$(document).on("click", ".field-envelope .save-multiselect",function(){
	console.log(this);
	update_field(this, "multiselect");
	
});


$(document).on("click",".autocomplete-live",function(){
	my_category = $(this).attr("category");
	my_id = this.id;
	my_value = $(this).val();
	my_parent = false;
	if(my_id == "subcategory"){
		my_parent = $("#category").val();
	}
	form_data = {
		category: my_category,
		id: my_id,
		value: my_value,
		parent: my_parent,
		is_live: 1
	};
	console.log(form_data);
	$.ajax({
		dataType: "json",
		type: "get",
		url: base_url + "menu/get_autocomplete",
		data: form_data,
		success: function(data){
			$("#" + my_id).autocomplete({source:data});
		}
	});
});

$(document).on("click",".autocomplete-off",function(){
	$("input").attr("autocomplete","off");
	$(this).html("Turn Autocomplete On").removeClass("autocomplete-off").addClass("autocomplete-on");
});

$(document).on("click",".autocomplete-on",function(){
	$("input").attr("autocomplete","On");
	$(this).html("Turn Autocomplete Off").removeClass("autocomplete-on").addClass("autocomplete-off");
});

$(document).ready(function(){
$(".mr-shmallow").bind("click",function(){
	//$(".mr-shmallow-image").fadeIn();
	if(!$("#page").hasClass("on")){
		$("#page").addClass("on").effect("bounce");
		$(this).html("Oh Ick! Change it back!");

		//$("#page").animate({backgroundColor: "#aa000"},1000);
		//$(".mr-shmallow-image img").toggle({effect: "puff",percent:200});
		$.ajax({
			type:'post',
			url: base_url + "index/user_test",
			success: function(data){
				console.log(data);
			}
		});

	}else{
		$("#page").removeClass("on").effect("bounce");
		$(this).html("Try This Out!");
	}

});

});

//download the quark files show a progress bar for entertainment purposes. 
$(document).on("click","#quark-export a.export",function(event){
	event.preventDefault();
	show_popup("Downloading","Please wait <div id='progressbar'></div>","auto");
	var progressbar = $( "#progressbar" )
	progressbar.progressbar({
	      value: 0,
	      max: 100
	    });
	
	function progress(){
		var val = progressbar.progressbar("value") || 0;
		progressbar.progressbar("value", val + .1);
		if(val < 99){
			setTimeout(progress, 100);
		}
	}
	setTimeout(progress,3000);
	
	url = $(this).attr("href");
	console.log(url);
	$.ajax({
		type: "get",
		url: url,
		success: function(data){
			$(".ui-dialog-content").html(data);
			$("#progressbar").remove();
		}
	});
});

$(document).on("click",".help",function(event){
			var keys=this.id.split("_");//expect the id to be in the format "helpTopic_helpSubtopic"
			var my_topic=keys[0];
			var my_subtopic=keys[1];
			 form_data = {
					topic: my_topic,
					subtopic: my_subtopic,
					ajax: '1'
			};
			$.ajax({
				type: "get",
				url: base_url + "help/get",
				data: form_data,
				success: function(data){
					var title="Help with "+ my_topic + "->"+ my_subtopic;
					show_popup(title, data, "300px");
				}
			});
	});//end function(event)

$(document).on('click',".mr-shmallow-image",function(){
	//$(".mr-shmallow-image img").toggle({effect: "puff",percent:200});
	
	
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

function update_field(me,my_type){
	my_parent = $(me).parents(".field-envelope").attr("id");
	my_attr = my_parent.split("__");
	my_value = $("#" + my_parent).children(".live-field").children("input"|"textarea").val();
	my_category = false;
	if(my_type == "autocomplete"){
		my_value = $("#" + my_parent).children(".live-field").children("input").val();

	}else if(my_type == "multiselect"){
		my_value = $("#" + my_parent).children(".multiselect").children("select").val();
	}else if(my_type == "category-dropdown"){
		my_category = "category";
	}else if(my_type == "subcategory-dropdown"){
		my_category = "subcategory";
	}
	
	form_data = {
			table: my_attr[0],
			field: my_attr[1],
			id: my_attr[2],
			value: my_value,
			category: my_category
	};
	console.log(form_data);

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