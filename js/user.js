
	$(document).on("click",".edit-user",function(){
		my_id = this.id.split("_")[1];
		form_data = {
				ajax: '1'
		};
		$.ajax({
			type: "get",
			data: form_data,
			url: baseUrl + "auth/edit_user/" + my_id,
			success: function(data){
				showPopup("Edit User", data, "auto");
			}
		});
		
		return false;
	});


	$(document).on("click",".new-user",function(){

		form_data = {
				ajax: '1'
		};
		
		$.ajax({
			type: "get",
			data: form_data,
			url: baseUrl + "auth/create_user",
			success: function(data){
				showPopup("Create User",data, "auto");
			}
		});
		
		return false;

	});
	
	$(document).on("click",".new-group", function(){
		
		form_data = {
				ajax: '1'
		};
		
		$.ajax({
			type: "get",
			data: form_data,
			url: baseUrl + "auth/create_group",
			success: function(data){
				showPopup("Create Group",data, "auto");
			}
		});
		
		return false;

	});
	
	$(document).on("click",".deactivate-user",function(){
		
		my_id = this.id.split("_")[1];
	
		form_data = {
				ajax: "1"
		};
		
		$.ajax({
			type: "get",
			url: baseUrl + "auth/deactivate/" + my_id,
			data: form_data,
			success: function(data){
				showPopup("Deactivate User",data, "auto");
			},
			error: function(data){
				console.log(data);
				return false;
			}
		});
		return false;
		
	});
