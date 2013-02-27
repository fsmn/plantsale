$(document).ready(function(){
	$(".color-create").live("click",function(){
		my_id = this.id.split("_")[1];
		form_data = {
				common_id: my_id,
				ajax: 1
		};
		$.ajax({
			type: "get",
			url: base_url + "color/create",
			data: form_data,
			success: function(data){
				show_popup("Add a new color", data, "auto");
			}
		});
	});
	
	
});