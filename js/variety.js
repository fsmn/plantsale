$(document).ready(function() {
			$(".variety-create").live("click", function() {
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
			
			$(".variety-insert").live("click",function(){
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

		$(".flag-add").live("click", function() {
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
		
		$(".flag-insert").live("change",function(){
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
		
		$(".flag-delete").live("click",function(){
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
		
		$('#variety-search-body').live('keyup', function(event) {
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
		

		$('#variety-search-body').live('focus', function(event) {
			$('#variety-search-body').val('').css( {
				color : 'black'
			});
		});
		
		
		$('#variety-search-body').live('blur', function(event) {
			
			$("#search_list").fadeOut();
			$('#variety-search-body').css({variety:'#666'}).val('Find Plants');
			//$("#search_list").remove();
			
			
		});
		
		$(".plant-row").live("hover | focus",function(){
			if(! $(this).hasClass("active") ){
				my_id = this.id.split("_")[1];
				$(this).addClass("active");
				console.log(my_id);
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
		
		$(".plant-row").live("blur", function(){
			$(this).removeClass("active");
		});
		
		$(".search-varieties").live("click",function(event){
			$.ajax({
				type: "get",
				url: base_url + "variety/search",
				success: function(data){
					show_popup("Search Plants",data,"auto");
				}
			});
		});
		
		$(".variety-delete").live("click",function(){
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
		
		$(".show-category-totals").live("click",function(){
			$.ajax({
				type:"get",
				url: base_url + "index/get_categories",
				success: function(data){
					$("#category-totals").html(data);
				}
			});
		});
		
		$(".show-flat-totals").live("click",function(){
			console.log("yes");
			$.ajax({
				type:"get",
				url: base_url + "index/get_flats",
				success: function(data){
					$("#flat-totals").html(data);
				}
			});
		});
});