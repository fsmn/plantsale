$(document).ready(
		function() {
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

			$(".edit-field").live("click",function() {
						field_name = $(this).parent("p").attr("class");
						value = $(this).html();
						$(this).html(
								"<input type='text' name='" + field_name
										+ "' class='save-field' value='"
										+ value + "'/>").removeClass("edit-field");
			});

			$(".save-field").live("blur", function() {
				table = $(this).parent("span").parent("p").parent("fieldset").attr("id");
				my_parent = $(this).parent("span");
				my_id = $("#id").val();
				if(table == "order"){
					my_id = $("#order_id").val();
				}
				my_value = $(this).val();
				my_field = $(this).attr("name"),
				form_data = {
					field: my_field,
					value: my_value,
					id: my_id
				};
				$(this).parent("span").addClass("edit-field");
				my_url =  base_url +  table + "/update_value",
				$.ajax({
					type: "post",
					url: my_url,
					data: form_data,
					success: function(data){
						my_parent.addClass("edit-field").html(data);
						
					}
				});
				

			});

		});