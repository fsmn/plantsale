$(document).ready(function () {


	$(document).on("change", "#order-edit input[name='flat_size'],#order-edit input[name='flat_cost'],#order-edit input[name='plant_cost']", function () {
		flat_size = $("input[name='flat_size']").val();
		flat_cost = $("input[name='flat_cost']").val();
		plant_cost = $("input[name='plant_cost']").val();
		my_name = $(this).attr("name");
		if (my_name == "flat_size") {
			$("#order-edit input[name='flat_cost']").val(parseFloat(flat_size) * parseFloat(plant_cost));
			$("#order-edit input[name='plant_cost']").val(parseFloat(flat_cost) / parseFloat(flat_size));

		} else if (my_name == "plant_cost") {
			$("#order-edit input[name='flat_cost']").val(parseFloat(flat_size) * parseFloat(plant_cost));

		} else if (my_name == "flat_cost") {
			$("#order-edit input[name='plant_cost']").val(parseFloat(flat_cost) / parseFloat(flat_size));
		}
	});

//crop failures should not include a year in the search. This messes up the results. 
	$(document).on("change", "#output_format", function () {
		if ($(this).val() == "crop-failure") {
			$("#year").val("");
		} else {
			$("#year").attr("readonly", false);
		}
	});

	$(document).on("click", ".edit-cost", function () {
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
			success: function (data) {
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

	$(document).on("click", "#order-edit .hide", function () {
		$("#search_list").hide().css({"top": 0, "left": 0});
	})

	$(document).on("click", ".show-order-totals", function () {
		$("#order-totals").html("Loading...");
		$(".front-page-widget").fadeOut();

		$.ajax({
			type: "get",
			url: base_url + "index/get_order_totals",
			success: function (data) {
				$("#order-totals").html(data).fadeIn();
			}
		});
	});

	$(document).on("click", ".add-order-sort", function () {
		form_data = {
			basic_sort: 1
		};
		$.ajax({
			type: "get",
			url: base_url + "order/show_sort",
			data: form_data,
			success: function (data) {
				$("#sort-block").append(data);
				console.log(data);
			}
		});
		$(this).addClass("disabled");

	});

	$(document).on("click", ".delete-order", function () {
		question = confirm("Are you sure you want to delete this order? This cannot be undone!");
		if (question) {
			again = confirm("Are you really sure you want to delete this? Click cancel if you aren't sure.");
			if (again) {
				my_id = this.id.split("_")[1];

				form_data = {
					id: my_id,
					ajax: 1
				};
				$.ajax({
					type: "post",
					url: base_url + "order/delete",
					data: form_data,
					success: function (data) {
						document.location = base_url + "variety/view/" + data;
					}
				});
			}
		}
	});

	$(document).on("click", "input#pot_size", function () {
		$.ajax({
			type: "get",
			dataType: "json",
			url: base_url + "order/get_pot_sizes",
			success: function (data) {
				$("input#pot_size").autocomplete({source: data});
			}
		});
	});

	$(document).on("click", ".pot-size-menu.edit-field", function () {
		my_parent = $(this).parent(".field-envelope").attr("id");
		$.ajax({
			dataType: "json",
			type: "get",
			url: base_url + "order/get_pot_sizes",
			success: function (data) {
				$("#" + my_parent + " input").autocomplete({source: data});
			}
		});

	});

	$(document).on("click", ".batch-update-orders", function () {
		batch_update_orders();
	});

	$(document).on("change", "#pot-size-menu", function () {
		let pot_size = $(this).val();
		if (pot_size === "other") {
			my_parent = $(this).parent();
			$(this).remove();
			my_parent.append("<input name='pot_size' required value=''/>");
			my_parent.children("input").focus();
		}
		// check if the pot-size should be excluded from flat totals
		let form_data = {
			pot_size: pot_size,
			ajax: true
		};
		$.ajax({
			type: "get",
			url: base_url + "order/flat_total_exclude",
			data: form_data,
			success: function (data) {
				if (data) {
					$("select#flat_exclude").val("1");
				} else {
					$("select#flat_exclude").val("0");
				}
			},
			failure: function (data) {
				console.log(data);
			}
		})
	})
});

function batch_update_orders() {
	var id_array = $.map($(".edit-order"), function (n, i) {
		return n.id.split("_")[1];
	});
	form_data = {
		ids: id_array,
		action: "edit"
	};
	console.log(id_array);

	$.ajax({
		type: "post",
		data: form_data,
		url: base_url + "order/batch_update",
		success: function (data) {
			show_popup("Batch Updater", data, "auto");
		}

	});
}

function batch_update_warning() {

}

function sellouts() {
	my_table = "table.list";
	my_list = [0, 3, 4, 5, 6, 7];
	for (i = 0; i < my_list.length; i++) {
		hide_column(my_table, my_list[i]);
	}

}

function hide_column(my_table, my_index) {
	my_index = Number(my_index);
	$(my_table + ".top-row").hide();
	my_column = my_table + ' td:nth-child(' + my_index + ')';
	console.log(my_column);
	$(my_column).hide();
	my_column = my_table + ' th:nth-child(' + my_index + ')';

	$(my_column).hide();

}
