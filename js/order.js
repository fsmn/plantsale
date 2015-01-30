$(document).ready(function(){

});

$(document).on("click",".order-create",function(){
		my_id = this.id.split("_")[1];
		redirect_url = $(location).attr("href");
		form_data = {
				variety_id: my_id,
				
		};
		$.ajax({
			type: "get",
			data: form_data,
			url: base_url + "order/create",
			success: function(data){
				show_popup("New Order",data, "auto");
				$("#redirect_url").val(redirect_url);
			}
		});
		
	});
	
	$(document).on("change","#order-edit input[name='flat_size'],#order-edit input[name='flat_cost'],#order-edit input[name='plant_cost']",function(){
		flat_size = $("input[name='flat_size']").val();
		flat_cost = $("input[name='flat_cost']").val();
		plant_cost = $("input[name='plant_cost']").val();
		my_name = $(this).attr("name");
		if( my_name =="flat_size"){
			$("#order-edit input[name='flat_cost']").val(parseFloat(flat_size) * parseFloat(plant_cost));
			$("#order-edit input[name='plant_cost']").val( parseFloat(flat_cost) / parseFloat(flat_size) );

		}else if(my_name == "plant_cost"){
			$("#order-edit input[name='flat_cost']").val(parseFloat(flat_size) * parseFloat(plant_cost));

		}else if(my_name == "flat_cost"){
			$("#order-edit input[name='plant_cost']").val( parseFloat(flat_cost) / parseFloat(flat_size) );

		}
	});
	
	$(document).on("click",".edit-cost",function(){
		console.log("line 39 order.js");
		my_id = this.id.split("_")[1];
		my_field = $(this).parent(".field").attr("id");
		
		form_data = {
				id: my_id
		}
		
		$.ajax({
			type: "post",
			data: form_data,
			url: base_url + "order/edit_cost",
			success: function(data){
				$("#search_list").css({"z-index": 1000}).html(data).position({
					my: "left top",
					at: "left bottom",
					of: $("#edit-flat-size_" + my_id), 
					collision: "fit"
				}).show();
				$("input[name='" + my_field + "'").select();
			}
		
		});
	});
	
	$(document).on("click","#order-edit .hide",function(){
		$("#search_list").hide().css({"top":0,"left":0});
	})
	
	$(document).on("click",".search-orders",function(){
		refine = 0;
		if($(this).hasClass("refine")){
			refine = 1;
		}
		form_data = {
				refine: refine,
				find: 1
		};
		$.ajax({
			type: "get",
			data: form_data,
			url: base_url + "order/search",
			success: function(data){
				show_popup("Search Orders",data, "auto");
			}
		});
	});
	
	$(document).on("click",".edit-order",function(){
		my_id = this.id.split("_")[1];
		redirect_url = $(location).attr("href");
		console.log(redirect_url);
		form_data = {
				id: my_id,
				ajax: 1
		};
		$.ajax({
			type:"get",
			data: form_data,
			url: base_url + "order/edit/" + my_id,
			success: function(data){
				show_popup("Editing an Order",data,"auto");
				
				$("#redirect_url").val(redirect_url);
			}
		});
	});
	
	
	$(document).on("click",".show-order-totals",function(){
		$("#order-totals").html("Loading...");
			
		$.ajax({
			type: "get",
			url: base_url + "index/get_order_totals",
			success: function(data){
				$("#order-totals").html(data);
			}
		});
	});
	
	$(document).on("click",".add-order-sort", function(){
		form_data = {
				basic_sort: 1
		};
		$.ajax({
			type:"get",
			url: base_url + "order/show_sort",
			data: form_data,
			success: function(data){
				$("#sort-block").append(data);
				console.log(data);
			}
		});
		$(this).addClass("disabled");
		
	});
	
	$(document).on("click",".delete-order",function(){
		question = confirm("Are you sure you want to delete this order? This cannot be undone!");
		if(question){
			again = confirm("Are you really sure you want to delete this? Click cancel if you aren't sure.");
			if(again){
				my_id = this.id.split("_")[1];
			
				form_data = {
						id: my_id,
						ajax: 1
				};
				$.ajax({
					type:"post",
					url: base_url + "order/delete",
					data: form_data,
					success: function(data){
						document.location = base_url + "variety/view/" + data;
					}
				});
			}
		}
	});
	
	
	$(document).on("click","input#pot_size",function(){
		$.ajax({
			type:"get",
			dataType: "json",
			url: base_url + "order/get_pot_sizes",
			success:function(data){
				$("input#pot_size").autocomplete({source:data});
			}
		});
	});
	
	$(document).on("click",".pot-size-menu.edit-field",function(){
		my_parent = $(this).parent(".field-envelope").attr("id");
		$.ajax({
			dataType: "json",
			type:"get",
			url: base_url + "order/get_pot_sizes",
			success: function(data){
				$("#" + my_parent + " input").autocomplete({source:data});
			}
		});
		
	});
	

	$(document).on("click",".batch-update-orders",function(){
		batch_update_orders();
	});
	
	$(document).on("change","#pot-size-menu",function(){
		console.log($(this).val());
		if($(this).val()== "other"){
			my_parent = $(this).parent();
			$(this).remove();
			my_parent.append("<input name='pot_size' required value=''/>");
			my_parent.children("input").focus();
		}
	})
    
	$(document).ready(function(){
		$("table.list").on("click",".omit-row",function(){
			omit_row(this);
		});
	});
	
	
	function omit_row(me){
		var my_id = me.id.split("_")[1];
		console.log(my_id);
		$("#order_" + my_id).remove();
	}
	
	function batch_update_orders(){
		var id_array = $.map($(".edit-order"),function(n,i){
			return n.id.split("_")[1];
		});
		form_data = {
				ids: id_array,
				action: "edit"
		};
		console.log(id_array);
		
		$.ajax({
			type:"post",
			data: form_data,
			url: base_url + "order/batch_update",
			success: function(data){
				show_popup("Batch Updater",data,"auto");
			}
			
		});
	}
	
	function batch_update_warning(){
		
	}
 