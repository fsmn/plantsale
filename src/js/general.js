(function ($) {


	$(document).ready(function () {


		$("#navigation .menu-button").click(function (e) {
			e.preventDefault();
			$("#navigation .button-box").toggle();
		});


		$(".message").click(function (e) {
			$(this).fadeOut();
		});

		$("#footer").css({ "top": $(document).height() - 25 + "px" });

		$("#utility").on("click", ".set-current-year", function () {
			my_uri = $(location).attr("href");

			form_data = {
				uri: my_uri
			};

			$.ajax({
				type: "get",
				data: form_data,
				url: base_url + "index/show_set_year",
				success: function (data) {
					show_popup("Set Sale Year", data, "auto");
				}
			});
		});

		$(document).on("click", ".search.dialog", function (e) {
			e.preventDefault();
			refine = 0;
			if ($(this).hasClass("refine")) {
				refine = 1;
			}
			url = $(this).attr("href");
			form_data = {
				refine: refine,
				ajax: 1

			};
			$.ajax({
				type: "get",
				data: form_data,
				url: url,
				success: function (data) {
					show_popup("Search", data, "auto");
				}
			});
		});
		$(document).on("click", "ul.filters li.filter-item a", function (e) {
			e.preventDefault();
			let my_target = $(this).data('target');
			$("table.log-list tr").hide();
			$("table.log-list tr." + my_target).show();
			console.log(my_target);
		});
		$(document).on("click", ".create.dialog, .edit.dialog, .delete.dialog", function (e) {
			e.preventDefault();
			let redirect_url = $(location).attr("href");
			let url = $(this).attr("href");
			let form_data = {
				ajax: 1
			};
			$.ajax({
				type: "get",
				data: form_data,
				url: url,
				success: function (data) {
					show_popup("*", data, "auto");
					$("#redirect_url").val(redirect_url);
				},
				failure: function(data) {
					console.log(data);
				}
			});
		});


		$("table.list.hideable-columns").on("click", "th", function () {
			$("table.list.hideable-columns .top-row").remove();

			id = $("table.list.hideable-columns th").index(this);
			id = Number(id) + 1;
			target = '.hideable-columns td:nth-child(' + id + ')';
			console.log(target);

			$(target).hide();
			$(this).hide();
		});

		$(".column-instructions").on("click", ".reset-columns", function () {
			$("table.list.hideable-columns th").show();
			$("table.list.hideable-columns td").show();
		});


		$(".search-fieldset").on("click", "legend", function () {
			$(".search-parameters").toggle(400);
			$(".search-fieldset").toggleClass("hidden");
			if ($(".search-fieldset").hasClass("hidden")) {
				$(".search-fieldset legend").html("Show Search Parameters");
			} else {
				$(".search-fieldset legend").html("Search Parameters");
			}
		});
		$('table.list').stickytable();

	});

	$(document).on("blur", "#grower-id", function () {
		my_id = $("#grower-id").val();
		$.ajax({
			type: "get",
			url: base_url + "grower/is_unique/" + my_id,
			success: function (data) {
				if (data === false) {
					$("#unique-id").html("This ID is not unique!");
					$("#grower-id").addClass("notice");

				} else {
					$("#unique-id").html("OK");
					$("#grower-id").removeClass("notice");
				}
			}
		});
	});

	$(document).on("click", ".field-envelope .edit-field", function (e) {

		let me;
		let my_parent;
		let my_attr;
		let my_type;
		let my_category;
		let my_name;
		let form_data;
		if ($("body").hasClass("editor")) {
			me = $(this);
			my_parent = me.parent();
			my_type = "text";
			my_category = me.attr('menu');

			my_name = me.attr("name");
			if (me.hasClass("dropdown")) {
				my_type = "dropdown";
			} else if (me.hasClass("checkbox")) {
				my_type = "checkbox";
			} else if (me.hasClass("multiselect")) {
				my_type = "multiselect";
			} else if (me.hasClass("textarea")) {
				my_type = "textarea";
			} else if (me.hasClass("autocomplete")) {
				my_type = "autocomplete";
			} else if (me.hasClass("category-dropdown")) {
				my_type = "category-dropdown";
				my_category = "category";
			} else if (me.hasClass("subcategory-dropdown")) {
				my_type = "subcategory-dropdown";
				my_category = "subcategory";
			} else if (me.hasClass("user-dropdown")) {
				my_type = "user-dropdown";
				my_category = "user";
			} else if (me.hasClass("pot-size")) {
				my_type = "pot-size";
			}
			form_data = {
				table: $(this).data('table'),
				field: $(this).data('field'),
				id: $(this).data('id'),
				type: my_type,
				category: my_category,
				value: me.html()
			};
			$.ajax({
				type: "get",
				url: base_url + "menu/edit_value",
				data: form_data,
				success: function (data) {
					my_parent.children(".edit-field").html(data).removeClass("edit-field").removeClass("field").addClass("live-field").addClass("text");
					//$("#" + my_parent + " .live-field input").focus();
				}
			});
		}
	});

	$(document).on("click", ".set-catalog-numbers", function (event) {
		event.preventDefault();
		href = $(this).attr("href");
		first_question = confirm("Are you sure you want to update catalog numbers? This cannot be easily undone without some saddness.");
		if (first_question) {
			second_question = confirm("Are you absolutely sure? Make sure you note the time you did this in case you need to revert to an earlier state.");
			if (second_question) {
				location.href = href;
			}
		}
	});

	$(document).on("click", ".autocomplete.edit-field", function () {
		let my_parent = $(this).parent(".field-envelope").attr("id");
		let my_attr = my_parent.split("__");
		let my_table = my_attr[0];
		let my_category = $(this).attr("menu");
		let my_value = $(this).val();
		let form_data = {
			category: my_category,
			value: my_value,
			id: my_parent
		};
		$.ajax({
			dataType: "json",
			type: "get",
			data: form_data,
			url: base_url + "menu/get_autocomplete",
			success: function (data) {
				$("#" + my_parent + " input").autocomplete({ source: data });
			}
		});

	});

	$(document).on("blur", ".field-envelope .live-field.text input[type='text']", function () {
		if ($(this).hasClass("ui-autocomplete-input")) {
			update_field(this, "autocomplete");

		} else {
			update_field(this, "text");
		}
		return false;
	});
	$(document).on("change", ".field-envelope .live-field input[type='checkbox']", function (e) {
		let my_type = $(this).data('type');
		let has_type = $(this).data().hasOwnProperty("type");
		if (!has_type) {
			my_type = 'checkbox';
		}
		update_field(this, my_type);
	});

	$(document).on("blur", ".field-envelope .live-field textarea", function () {
		update_field(this, "textarea");
	});
	$(document).on("blur", ".field-envelope .live-field.category-dropdown select", function () {
		console.log("here");
		update_field(this, "category-dropdown");
	});

	$(document).on("blur", ".field-envelope .live-field.subcategory-dropdown select", function () {
		update_field(this, "subcategory-dropdown");
	});


	$(document).on("blur", ".field-envelope .live-field select", function () {
		if ($(this).val() === "other") {
			my_name = $(this).parents('.field-envelope').attr("id").split("_")[1];
			$(this).parents(".live-field").html("<input type='text' name='" + my_name + "' value='' id=''/>");
		} else {
			update_field(this, "select");
		}
	});

	//*/

	$(document).on("click", ".field-envelope .save-multiselect", function () {
		console.log(this);
		update_field(this, "multiselect");

	});


	$(document).on("click", ".autocomplete-live", function () {
		let my_category = $(this).attr("category");
		let my_id = this.id;
		let my_value = $(this).val();
		let my_parent = false;
		if (my_id === "subcategory") {
			my_parent = $("#category").val();
		}
		let form_data = {
			category: my_category,
			id: my_id,
			value: my_value,
			parent: my_parent,
			is_live: 1
		};
		console.log(form_data);
		$.ajax({
			dataType: "json",
			type: "get",
			url: base_url + "menu/get_autocomplete",
			data: form_data,
			success: function (data) {
				$("#" + my_id).autocomplete({ source: data });
			}
		});
	});

	$(document).on("click", ".autocomplete-off", function () {
		$("input").attr("autocomplete", "off");
		$(this).html("Turn Autocomplete On").removeClass("autocomplete-off").addClass("autocomplete-on");
	});

	$(document).on("click", ".autocomplete-on", function () {
		$("input").attr("autocomplete", "On");
		$(this).html("Turn Autocomplete Off").removeClass("autocomplete-on").addClass("autocomplete-off");
	});


	//download the quark files show a progress bar for entertainment purposes.
	$(document).on("click", "#category-selector a.export", function (event) {
		// event.preventDefault();
		// show_popup("Downloading","Please wait <div id='progressbar'></div>","auto");
		// var progressbar = $( "#progressbar" )
		// progressbar.progressbar({
		//       value: 0,
		//       max: 100
		//     });
		//
		// function progress(){
		// 	var val = progressbar.progressbar("value") || 0;
		// 	progressbar.progressbar("value", val + .1);
		// 	if(val < 99){
		// 		setTimeout(progress, 100);
		// 	}
		// }
		// setTimeout(progress,3000);
		//
		// url = $(this).attr("href");
		// console.log(url);
		// $.ajax({
		// 	type: "get",
		// 	url: url,
		// 	success: function(data){
		// 		$(".ui-dialog-content").html(data);
		// 		$("#progressbar").remove();
		// 	}
		// });
	});

	$(document).on("click", ".export-for-web", function (event) {
		event.preventDefault();
		me = $(this);
		if ($(this).hasClass("active")) {
			$("#category-selector").fadeOut();
			$(this).removeClass("active").addClass("ready");
		} else {
			$(this).addClass("active").removeClass("ready");
			$.ajax({
				type: "get",
				url: base_url + "index/web_selector",
				success: function (data) {
					$("#category-selector").fadeIn().html(data).position({
						my: "left top",
						at: "left bottom",
						of: me,
						collision: "fit"
					}).show();
				}
			});
		}
	});

	$(document).on("click", ".show-catalog-updater", function (event) {
		event.preventDefault();
		let me = $(this);
		if ($(this).hasClass("active")) {
			$("#category-selector").fadeOut();
			$(this).removeClass("active").addClass("ready");
		} else {
			$(this).addClass("active").removeClass("ready");
			$.ajax({
				type: "get",
				url: base_url + "order/catalog_update_selector",
				success: function (data) {
					$("#category-selector").fadeIn().html(data).position({
						my: "left top",
						at: "left bottom",
						of: me,
						collision: "fit"
					}).show();
				}
			});
		}
	});

	$(document).on("click", ".help", function (event) {
		let keys = this.id.split("_");//expect the id to be in the format "helpTopic_helpSubtopic"
		let my_topic = keys[0];
		let my_subtopic = keys[1];
		let form_data = {
			topic: my_topic,
			subtopic: my_subtopic,
			ajax: '1'
		};
		$.ajax({
			type: "get",
			url: base_url + "help/get",
			data: form_data,
			success: function (data) {
				var title = "Help with " + my_topic + "->" + my_subtopic;
				show_popup(title, data, "300px");
			}
		});
	});//end function(event)


	$(document).ready(function () {
		$(".mr-shmallow").bind("click", function () {
			$(".mr-shmallow-image").fadeIn();
			if (!$("#page").hasClass("on")) {

				$(".mr-shmallow-image img").toggle({ effect: "puff", percent: 200 });
				$.ajax({
					type: 'post',
					url: base_url + "index/user_test",
					success: function (data) {
						console.log(data);
					}
				});

			} else {
				$("#page").removeClass("on").effect("bounce");
			}

		});

	});
	$(document).on('click', ".mr-shmallow-image", function () {
		$(".mr-shmallow-image img").toggle({ effect: "puff", percent: 200 });


	});

	$(document).on('click', '.toggle-boolean', function (e) {
		e.preventDefault();
		let wrapper = $(this).data('wrapper');
		let me = $(this);
		let form_data = {
			id: $(this).data('id'),
			field: $(this).data('field'),
			value: $(this).data('value'),
		}
		$.ajax(
			{
				'dataType': 'json',
				'type': 'post',
				'url': $(this).attr('href'),
				'data': form_data,
				success: function (data) {
					me.html(data['text']);
					me.prop('title', data['title']);
					me.data('value', data['value']);
				}
			}
		);
	});
})(jQuery);


function show_popup(my_title, data, popup_width, x, y) {
	if (!popup_width) {
		popup_width = 300;
	}
	let myDialog = $('<div id="popup">').html(data).dialog({
		autoOpen: false,
		title: my_title,
		modal: true,
		width: popup_width
	});

	if (x) {
		myDialog.dialog({ position: x });
	}


	myDialog.fadeIn().dialog('open', { width: popup_width });

	return false;
}

function update_field(me, my_type) {
	let my_parent = $(me).parent();
	let my_value = $(me).val();
	if( $(me).hasClass("persistent")){
		my_parent = $(me);
	}
	let is_persistent = my_parent.hasClass("persistent");

	let my_category = false;

	switch (my_type) {
		case ("category-dropdown"):
			my_category = "category";
			break;
		case ("subcategory-dropdown"):
			my_category = "subcategory";
			break;
		case ("checkbox"):
			my_category = "checkbox";
			if ($(me).attr("checked") === true) {
				my_value = 1;
			} else {
				my_value = 0;
			}
			break;
		case ("boolean"):
			if ($(me).attr("checked") === true) {
				my_value = 'yes';
			} else {
				my_value = 'no';
			}
			break;
		default:
			break;
	}



	//don't do anything if the value is empty and it is a persistent field 
	if (is_persistent && my_value === "") {
		return false;
	}

	let override = my_parent.hasClass("override");
	let form_data = {
		table: my_parent.data('table'),
		field: my_parent.data('field'),
		id: my_parent.data('id'),
		value: my_value,
		override: override,
		category: my_category,
		type: my_type,
	};
	console.log(my_parent.data('table'));

	$.ajax({
		type: "post",
		url: base_url + my_parent.data('table') + "/update_value",
		data: form_data,
		success: function (data) {
			// console.log(data);
			if (!is_persistent) {
				me.focus();
				$(my_parent).html(data)
				$(my_parent).removeClass("live-field text");
				//$(my_parent).addClass("edit-field field");
			}
		}
	});
}

// let my_parent = $(me).parents(".field-envelope").attr("id");
// let my_value = $("#" + my_parent).children(".live-field").children("input" | "textarea").val();
// let my_category = false;
// if (my_type === "autocomplete") {
// 	my_value = $("#" + my_parent).children(".live-field").children("input").val();
// } else if (my_type === "multiselect") {
// 	my_value = $("#" + my_parent).children(".multiselect").children("select").val();
// } else if (my_type === "category-dropdown") {
// 	my_category = "category";
// } else if (my_type === "subcategory-dropdown") {
// 	my_category = "subcategory";
// } else if (my_type === "checkbox") {
// 	my_category = "checkbox";
// 	if ($(me).attr("checked") === true) {
// 		my_value = 1;
// 	} else {
// 		my_value = 0;
// 	}
// } else if(my_type === 'boolean'){
// 	if ($(me).attr("checked") === true) {
// 		my_value = 'yes';
// 	} else {
// 		my_value = 'no';
// 	}
// }
// let is_persistent = $(me).hasClass("persistent");

// //don't do anything if the value is empty and it is a persistent field 
// if (is_persistent && my_value === "") {
// 	return false;
// }

// let override = $(me).hasClass("override");
// let form_data = {
// 	table: $(me).data('table'),
// 	field: $(me).data('field'),
// 	id: $(me).data('id'),
// 	value: my_value,
// 	override: override,
// 	category: my_category,
// 	type: my_type,
// };

// $.ajax({
// 	type: "post",
// 	url: base_url + $(me).data('table') + "/update_value",
// 	data: form_data,
// 	success: function (data) {
// 		console.log(data);
// 		if (!is_persistent) {
// 			$("#" + my_parent + " .live-field").html(data);
// 			$("#" + my_parent + " .live-field").addClass("edit-field field").removeClass("live-field text");
// 		}
// 	}
// });


function create_dropdown(my_field, my_category, my_value) {

	let form_data = {
		field: my_field,
		category: my_category,
		value: my_value
	};
	$.ajax({
		type: "get",
		url: base_url + "menu/get_dropdown",
		data: form_data,
		success: function (output) {
			return output;
		},
		error: function (output) {
			return output;
		}

	});
}

$(document).ready(function () {
	$("table.list").on("click", ".omit-row", function () {
		if ($(this).hasClass("plant-info")) {
			if ($(this).attr("checked")) {
				omit_row(this, "#plant-info_");
			}

			//}else if($(this).hasClass("order-info")){
		} else {
			omit_row(this, "#order_");
		}
	});
});


function omit_row(me, target) {
	let my_id = me.id.split("_")[1];
	console.log(target + my_id);
	$(target + my_id).remove();

}

$(window).scroll(function () {
	let top = $('.float');
	if ($(window).scrollTop() > 250) {
		if (top.css('position') != 'fixed') {
			top.css('position', 'fixed');
			top.css('top', 15);
			top.css('left', '45%');
			//top.css('background-color','#000');
		}
	} else {
		if (top.css('position') != 'static') {
			top.css('position', 'static');
			top.css('top', 'inherit');
			top.css('background-color', 'inherit');
		}
	}
});
