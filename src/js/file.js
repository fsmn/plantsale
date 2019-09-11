	$(document).live('click', ".file_edit",function(event) {
		var myFile = this.id.split("_")[1];
		var formData = {
				ajax: '1',
				kFile: myFile
		};
		var myUrl = baseUrl + "file/edit_file/";
		$.ajax({
			url: myUrl,
			type: 'POST',
			data: formData,
			success: function(data) {
			$('#fileline_' + myFile).html(data);
//				showPopup('Edit File', data, 'auto');
			}
		}); //end ajax
	}); // end insert	
	
	$(document).live('click',".file_cancel", function(event){
		var myFile = $("#kFile").val();
		var formData = {
				ajax: '1',
				kFile: myFile
		};
		var myUrl = baseUrl + "file/view_file/";
		$.ajax({
			url: myUrl,
			type: 'POST',
			data: formData,
			success: function(data) {
			$("#fileline_" + myFile).html(data);
			}
			
		});
	});
	
	$(".file_delete").live('click', function(event){
		var myFile = $("#kFile").val();
		var formData = {
				ajax: 1,
				kFile: myFile
		};
		var myUrl = baseUrl + "file/delete_file";
		$.ajax({
			url: myUrl,
			type: 'POST',
			data: formData,
			success: function(data) {
				$("#fileline_" + myFile).html(data);
			}
		});
	});
	

