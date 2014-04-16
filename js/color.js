$(document).ready(function() {
			$(".color-create").live("click", function() {
				my_id = this.id.split("_")[1];
				form_data = {
					common_id : my_id,
					ajax : 1
				};
				$.ajax({
					type : "get",
					url : base_url + "color/create",
					data : form_data,
					success : function(data) {
						show_popup("Add a new color", data, "auto");
					}
				});
			});
			
			$(".color-insert").live("click",function(){
				if($("#add_order").attr("checked")){
					$.ajax({
						type: "post",
						url: base_url + "color/insert",
						data: $("#color-editor").serializeArray(),
						success: function(data) {
							$("#ui-dialog-title-popup").html("New Order");
							$("#popup").html(data);
						}
					});
					return false;
				}
			
			});

		$(".flag-add").live("click", function() {
			my_id = $("#id").val();
			form_data = {
					id: my_id,
					ajax: 1
			};
			$.ajax({
				type: "get",
				url: base_url + "color/add_flag",
				data: form_data,
				success: function(data){
					$("#flag-list").append(data);
				}
			});
		});
		
		$(".flag-insert").live("change",function(){
			my_id = $("#id").val();
			my_flag = $(this).val();
			form_data = {
					color_id: my_id,
					name: my_flag,
					ajax: 1
			};
			$.ajax({
				type: "post",
				url: base_url + "color/insert_flag",
				data: form_data,
				success: function(data){
					$("#flag-list").html(data);
				}
			});
		});
		
		$(".flag-delete").live("click",function(){
			my_id = $(this).parent().attr("id").split("_")[1];
			my_color = $("#id").val();
			form_data = {
					id: my_id,
					color_id: my_color,
					ajax: 1
			};
			$.ajax({
				type: "post",
				url: base_url + "color/delete_flag",
				data: form_data,
				success: function(data){
					$("#flag-list").html(data);
				}
			});
			
		});
		
		$('#color-search-body').live('keyup', function(event) {
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
					url: base_url + "color/search_by_name",
					type: 'GET',
					data: form_data,
					success: function(data){
						//remove the search_list because we don't want to have a ton of them. 

						$("#search_list").css({"z-index": 1000}).html(data).position({
							my: "left top",
							at: "left bottom",
							of: $("#color-search-body"), 
							collision: "fit"
						}).show();
				}
				});
			}else{
				$("#search_list").hide();
	        	$("#search_list").css({"left": 0, "top": 0});


			}
		});// end stuSearch.keyup
		

		$('#color-search-body').live('focus', function(event) {
			$('#color-search-body').val('').css( {
				color : 'black'
			});
		});
		
		
		$('#color-search-body').live('blur', function(event) {
			
			$("#search_list").fadeOut();
			$('#color-search-body').css({color:'#666'}).val('Find Colors');
			//$("#search_list").remove();
			
			
		});
		
		$(".color-delete").live("click",function(){
			form_data = {
					id: $("#id").val(),
					ajax: 1
			};
			question = confirm("Are you sure you want to delete this color? This is permanent and will delete all related orders and flags!");
			if(question){
				query = confirm("Are you absolutely sure? This is quite permanent and undoable!");
				if(query){
					$.ajax({
						type: "post",
						url: base_url + "color/delete",
						data: form_data,
						success: function(data){
							document.location.href = base_url + "common/view/" + data;
						}
					});
				}
			}
		});
});