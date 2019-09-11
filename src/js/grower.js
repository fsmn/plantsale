$(document).ready(function(){
	
	$(".edit-contact,.create-contact").click(function(e){
		e.preventDefault();
		href = $(this).attr("href");
		form_data = {
			"ajax": 1
		};
		$.ajax({
			type:"get",
			data: form_data,
			url: href,
			success: function(data){
				show_popup("Grower Contact",data,"auto");
			}
			
			
		});
	});
	
	$(document).on("click",".delete-contact",function(e){
		e.preventDefault();
		my_id = this.id.split("_")[1];
		if(confirm("Are you sure you want to delete this contact? This cannot be undone!")){
		$(this).parents("form").attr("action",base_url + "contact/delete");
		$(this).parents("form").submit();
		}
	});
	
	
});