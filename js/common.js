$(document).ready(function(){
	
	$(".common-edit").live("click",function(){
		my_id = this.id.split("_")[1];
		form_data = {
				id: my_id,
				ajax: 1
		};
		my_url = base_url + "common/edit/" + my_id;
		$.ajax({
			type:"get",
			url: my_url,
			data: form_data,
			success: function(data){
				show_popup("Edit Common Name",data,"auto");
			}
		});
	});
	
	$(".common-create").live("click",function(){
		$.ajax({
			type: "get",
			url: base_url + "common/create",
			success: function(data){
				show_popup("Create Common Name",data, "auto");
			}
		});
		
	});
	
});