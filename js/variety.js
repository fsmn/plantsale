$(document).ready(function(){
	$(".plant-info").on("click","input[type='checkbox']",function(){
		my_id = this.id.split("_")[1];
		if($(this).attr("checked")){
			checked = $(this).val();
			$(this).parents(".plant-info").addClass("omitted");
		}else{
			checked = 0;
			$(this).parents(".plant-info").removeClass("omitted");
		}
		form_data = {
				id: my_id,
				value: checked,
				field: "print_omit"
		};
		$.ajax({
			type: "post",
			url: base_url + "order/update_value",
			data: form_data,
			success: function(data){
				console.log(data);
			}
			
		});
	});
	$(".common-info").on("click",".change-common",function(){
		my_id = this.id.split("_")[1];
		question = true;
		//question = confirm("Are you sure you want to change the common id for this variety? This cannot be undone!");
		if(question){
			form_data = {
					id: my_id,
					edit: 1
			};
			$.ajax({
				type:"get",
				data: form_data,
				url: base_url + "variety/edit_common_id",
				success: function(data){
					show_popup("Change Common ID", data, "auto");
				}
			});
		}
	});
	
	
});
$(document).on("change","#edit-common-id #common_id",function(){
	$.ajax({
		type:"get",
		url: base_url + "common/get_name/" + $(this).val(),
		success: function(data){
			if(data){
			$("#edit-common-id #common-name").html(data).removeClass("alert");
			}else{
				$("#edit-common-id #common-name").html("No such common ID!").addClass("alert");
				original_id = $("#original_id").val();
				$("#common_id").val(original_id).focus();
			}
		}
	});
	
});

	$(document).on("click",".variety-create", function() {
				my_id = this.id.split("_")[1];
				form_data = {
					common_id : my_id,
					ajax : 1
				};
				$.ajax({
					type : "get",
					url : base_url + "variety/create",
					data : form_data,
					success : function(data) {
						show_popup("Add a new variety", data, "auto");
					}
				});
			});
			
			$(document).on("click",".variety-insert",function(){
				if($("#add_order").attr("checked")){
					$.ajax({
						type: "post",
						url: base_url + "variety/insert",
						data: $("#variety-editor").serializeArray(),
						success: function(data) {
							$("#ui-dialog-title-popup").html("New Order");
							$("#popup").html(data);
						}
					});
					return false;
				}
			
			});
			
			$(document).ready(function(){
				$(".button-box").on("click",".variety-edit",function(){
					return false;
				});
				
				$(".button-box").on("click",".variety-print-options",function(){
//					my_id = this.id.split("_")[1];
//					form_data = {
//							ajax: 1,
//					};
//					$.ajax({
//						type:"get",
//						url: base_url + "variety/print_options/" + my_id,
//						data: form_data,
//						success: function(data){
//							show_popup("Print Options",data,"auto");
//						}
//					});
//					
//					return false;
				});
			});

		$(document).on("click",".flag-add", function() {
			my_id = $("#id").val();
			form_data = {
					id: my_id,
					ajax: 1
			};
			$.ajax({
				type: "get",
				url: base_url + "variety/add_flag",
				data: form_data,
				success: function(data){
					$("#flag-list").append(data);
				}
			});
		});
		
		$(document).on("change",".flag-insert",function(){
			my_id = $("#id").val();
			my_flag = $(this).val();
			form_data = {
					variety_id: my_id,
					name: my_flag,
					ajax: 1
			};
			$.ajax({
				type: "post",
				url: base_url + "variety/insert_flag",
				data: form_data,
				success: function(data){
					$("#flag-list").html(data);
				}
			});
		});
		
		$(document).on("click",".flag-delete",function(){
			my_id = $(this).parent().attr("id").split("_")[1];
			my_variety = $("#id").val();
			form_data = {
					id: my_id,
					variety_id: my_variety,
					ajax: 1
			};
			$.ajax({
				type: "post",
				url: base_url + "variety/delete_flag",
				data: form_data,
				success: function(data){
					$("#flag-list").html(data);
				}
			});
			
		});
		
		$(document).on('keyup','#variety-search-body', function(event) {
			common_search = this.value;
			if (common_search.length > 2 && common_search != "Find Common Names") {
				search_words = common_search.split(' ');
				my_name = search_words.join('%') + "%";
				form_data = {
					ajax: 1,
					name: my_name,
					type: 'inline'
				};
				$.ajax({
					url: base_url + "variety/search_by_name",
					type: 'GET',
					data: form_data,
					success: function(data){
						//remove the search_list because we don't want to have a ton of them. 

						$("#search_list").css({"z-index": 1000}).html(data).position({
							my: "left top",
							at: "left bottom",
							of: $("#variety-search-body"), 
							collision: "fit"
						}).show();
				}
				});
			}else{
				$("#search_list").hide();
	        	$("#search_list").css({"left": 0, "top": 0});


			}
		});// end stuSearch.keyup
		

		$(document).on('focus','#variety-search-body', function(event) {
			$('#variety-search-body').val('').css( {
				color : 'black'
			});
		});
		
		
		$(document).on('blur','#variety-search-body', function(event) {
			
			$("#search_list").fadeOut();
			$('#variety-search-body').css({color:'#666'}).val('Find Plants');
			//$("#search_list").remove();
			
			
		});
		
		$(document).on("click | focus",".plant-row",function(){
			if(! $(this).hasClass("active") ){
				my_id = this.id.split("_")[1];
				$(this).addClass("active");
				form_data = {
						ajax: "1"
				};
				$.ajax({
					type: "get",
					data: form_data,
					url: base_url + "variety/view/" + my_id,
					success: function(data){
						$("#plant-details").html(data).slideDown(500);
					}
				});
			}else{
				$(this).removeClass("active");
			}
			
		});
		
		
			
	
		
		$(document).on("blur",".plant-row", function(){
			$(this).removeClass("active");
		});
		
		$(document).on("click",".search-varieties", function(event){
			form_data = false;
			if(($(this).hasClass("refine"))){
				form_data = {
						refine: 1
				};
			}
			$.ajax({
				type: "get",
				url: base_url + "variety/search",
				data: form_data,
				success: function(data){
					show_popup("Search Plants",data,"500px");
				}
			});
		});
		
		$(document).on("click",".variety-delete", function(){
			form_data = {
					id: $("#id").val(),
					ajax: 1
			};
			question = confirm("Are you sure you want to delete this variety? This is permanent and will delete all related orders and flags!");
			if(question){
				query = confirm("Are you absolutely sure? This is quite permanent and undoable!");
				if(query){
					$.ajax({
						type: "post",
						url: base_url + "variety/delete",
						data: form_data,
						success: function(data){
							document.location.href = base_url + "common/view/" + data;
						}
					});
				}
			}
		});
		
		$(document).on("click",".show-category-totals", function(){
			$.ajax({
				type:"get",
				url: base_url + "index/get_categories",
				success: function(data){
					$("#category-totals").html(data);
					document.location.href = "#category-totals-end";
					return false;
				}
			});
		});
		
		$(document).on("click",".show-flat-totals", function(){
			$.ajax({
				type:"get",
				url: base_url + "index/get_flats",
				success: function(data){
					$("#flat-totals").html(data);
					document.location.href = "#flat-totals-end";
					return false;
				}
			});
		});

		$(document).on("click",".delete-image",function(){
			question = confirm("Are you sure you want to delete this image? This cannot be undone!");
			if(question){
				query = confirm("Really, it cannot be undone in a special undoable way! Go ahead?");
				if(query){
					my_id = this.id.split("_")[1];
					form_data = {
							ajax: 1,
							id: my_id
					};
					$.ajax({
						type:"post",
						url: base_url + "variety/delete_image/",
						data: form_data,
						success:function(data){
							$("#image").html(data);
						},
						error: function(data){
							$("#image").html(data);
						}
					});
				}
			}
		});
		
		$(document).on("click",".add-image",function(){
			my_id = this.id.split("_")[1];
			form_data = {
					ajax: 1,
					variety_id: my_id
			};
			$.ajax({
				type: "get",
				url: base_url + "variety/new_image",
				data: form_data,
				success: function(data){
					show_popup("Add an Image",data, "auto");
				}
			});
			return false;
		});