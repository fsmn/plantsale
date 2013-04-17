$(document).ready(function(){
	$(".order-create").live("click",function(){
		my_id = this.id.split("_")[1];
		form_data = {
				color_id: my_id
		};
		$.ajax({
			type: "get",
			data: form_data,
			url: base_url + "order/create",
			success: function(data){
				show_popup("New Order",data, "auto");
				//$(".all-orders").append(data);
				//$(".order-create").fadeOut();
			}
		});
		
	});
});