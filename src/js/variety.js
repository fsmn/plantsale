$(document).ready(function(){
	
	$(".plant-info").on("click","input[type='checkbox']",function(){
		my_id = this.id.split("_")[1];
		if($(this).attr("checked")){
			checked = $(this).val();
			$(this).parents(".plant-info").addClass("omitted").removeClass("print");
		}else{
			checked = 0;
			$(this).parents(".plant-info").removeClass("omitted").addClass("print");
		}
		form_data = {
				id: my_id,
				value: checked,
				field: "omit"
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
				$("#edit-common-id #submit").fadeIn();
				$("#edit-common-id #revert").fadeOut();

			$("#edit-common-id #common-name").html(data).removeClass("alert");
			}else{
				$("#edit-common-id #common-name").html("No such common ID!").addClass("alert");
				$("#edit-common-id #submit").fadeOut();
				$("#edit-common-id #revert").fadeIn();
				$("#common_id").focus();
			}
		}
	});
	
});

$(document).on("keyup","#edit-common-id #common_id",function(){
	if($(this).val() != $("#original_id").val()){
		$("#change-button").fadeIn();
	}else{
		$("#change-button").fadeOut();
	}
});

$(document).on("click","#edit-common-id #revert",function(){
	original_id = $("#original_id").val();
	$("#edit-common-id #revert").fadeOut();
	$("#common_id").focus().val(original_id);
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
			});
				
				

		$(document).on("click",".flag-add", function() {
			my_id = this.id.split("_")[1];
			form_data = {
					id: my_id,
					ajax: 1
			};
			$.ajax({
				type: "get",
				url: base_url + "variety/add_flag",
				data: form_data,
				success: function(data){
					$("#flag-list_" + my_id).append(data);
				}
			});
		});
		
		$(document).on("change",".flag-insert",function(){
			my_id = $(this).parents(".flag-list").attr("id").split("_")[1];
			console.log(my_id);
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
					$("#flag-list_" + my_id ).html(data);
				}
			});
		});
		
		$(document).on("click",".flag-delete",function(){
			my_id = $(this).parent().attr("id").split("_")[1];
			my_variety = $(this).parents(".flag-list").attr("id").split("_")[1];
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
					$("#flag-list_"+ my_variety).html(data);
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
			$('#variety-search-body').css({color:'#666'}).val($('#variety-search-body').attr('placeholder'));
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
						$("#plant-details").css({display: "inline-block"});
					}
				});
			}else{
				$(this).removeClass("active");
			}
			
		});
		
		
			
	
		
		$(document).on("blur",".plant-row", function(){
			$(this).removeClass("active");
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
					$("#category-totals").html(data).fadeIn();
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
					$("#flat-totals").html(data).fadeIn();
					document.location.href = "#flat-totals-end";
					return false;
				}
			});
		});
		
		$(document).on("click",".show-quark-export",function(){
			if($(this).hasClass("active")){
				$("#category-selector").removeClass("scroll").fadeOut();
				$(this).removeClass("active").addClass("ready");
				
			}else{
				$(this).addClass("active").removeClass("ready");
				$("#category-selector").addClass("scroll");
			$.ajax({
				type:"get",
				url: base_url + "index/show_quark_export",
				success: function(data){
					$("#category-selector").fadeIn().html(data).position({
						my: "left top",
						at: "left bottom",
						of: $(".show-quark-export"), 
						collision: "fit"
					}).show();
				}
			});
			}
			
			
		});
		
		$(document).on("click",".show-quark-export.active",function(){
			$("#category-selector").hide();
			$(this).removeClass("active").addClass("ready");
			return false;
			
		});
		
		$(document).on("click",".hide-quark-export",function(){
			$("#category-selector").hide();
			$(".show-quark-export.active").removeClass("active").addClass("ready");
		});

		$(document).on("click",".delete-image",function(){
			let question = confirm("Are you sure you want to delete this image? This cannot be undone!");
			if(question){
					let my_id = $(this).data('id');
					console.log(my_id);
					let form_data = {
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
							console.log(data);
						}
					});
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
		
		$(document).on("click",".print-poster-batch",function(event){
			event.preventDefault();
			print_poster_selector();
			
		});
		
		$(document).on("click",".variety-print-tabloid", function(event){
			event.preventDefault();
			
			batch_print_varieties(this,"tabloid");
		});
		
		$(document).on("click",".variety-print-statement",function(event){
			event.preventDefault();
			
			batch_print_varieties(this,"statement");
		});
		$(document).on("click",".variety-print-letter",function(event){
			event.preventDefault();
			
			batch_print_varieties(this,"letter");
		});
		
		function print_poster_selector(){
			var id_array = $.map($("tr.plant-row.plant-info.print"),function(n,i){
				return n.id.split("_")[1];
			});
			form_data = {
					ids: id_array,
					format: "select"
			};

			$.ajax({
				type: "post",
				data: form_data,
				url: base_url + "variety/print_result",
				success: function(data){
					show_popup("Select Format",data,"auto");
				},
			error: function(data){
				console.log(data);
			}
			});
		}
		
		function batch_print_varieties(me,format){
		
			url = $(me).attr('href');
			show_popup("Preparing","Preparing Printout. Please wait <div id='progressbar'></div>","auto");
			var progressbar = $( "#progressbar" )
			progressbar.progressbar({
			      value: 0,
			      max: 100
			    });
		
			function progress(){
				var val = progressbar.progressbar("value") || 0;
				progressbar.progressbar("value", val + .25);
				if(val < 99){
					setTimeout(progress, 100);
				}
			}
			setTimeout(progress,3000);
			var id_array = $.map($("tr.plant-row.plant-info.print"),function(n,i){
				return n.id.split("_")[1];
			});
			form_data = {
					ids: id_array,
			};
			console.log(id_array);
			$.ajax({
				type:"post",
				data: form_data,
				url: base_url + "variety/print_result/" + format,
				success: function(data){
					
					var win=window.open('about:blank');
			        with(win.document)
			        {
			            open();
			            write(data);
			            close();
			            $(".ui-dialog, .ui-widget-overlay").hide();
			        }
				}
				
			});
		}
		
		$(document).on("click",".batch-update-flags",function(e){
			me = $(this);
			e.preventDefault();
			batch_update_flags(me);
		});
		
		function batch_update_flags(me){
			var id_array = $.map($(".plant-info"),function(n,i){
				return n.id.split("_")[1];
			});
			href = me.attr('href');
			form_data = {
					ids: id_array,
					action: "edit",
					target: href
			};
			
			console.log(form_data);
			$.ajax({
				type:"post",
				data: form_data,
				url: base_url + "variety/batch_update_flags",
				success: function(data){
					show_popup("Batch Updater",data,"auto");
				}
				
			});
		}
		
