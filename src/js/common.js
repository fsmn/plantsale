
$(document).on("change", "select#category_id", function () {
	my_parent = $(this).val();

	form_data = {
		parent: my_parent,
		category: "subcategory",
		field: "subcategory_id",
		value: ""
	};

	$.ajax({
		type: "get",
		url: "/menu/get_dropdown",
		data: form_data,
		success: function (data) {
			$("#subcategory-envelope").html(data);
		},
		error: function (data) {
			console.log(data);
		}
	});
});

// $(document).on('keyup', '#common-search-body', function (event) {
// 	common_search = this.value;
// 	if (common_search.length > 2 && common_search != "Find Common Names") {
// 		search_words = common_search.split(' ');
// 		my_name = search_words.join('%') + "%";
// 		form_data = {
// 			ajax: 1,
// 			name: my_name,
// 			type: 'inline'
// 		};
// 		$.ajax({
// 			url: base_url + "common/search_by_name",
// 			type: 'GET',
// 			data: form_data,
// 			success: function (data) {
// 				//remove the search_list because we don't want to have a ton of them. 

// 				$("#search_list").css({ "z-index": 1000 }).html(data).position({
// 					my: "left top",
// 					at: "left bottom",
// 					of: $("#common-search-body"),
// 					collision: "fit"
// 				}).show();
// 			}
// 		});
// 	} else {
// 		$("#search_list").hide();
// 		$("#search_list").css({ "left": 0, "top": 0 });
// 	}
// });// end stuSearch.keyup

// $(document).on('focus', '#common-search-body', function (event) {
// 	$('#common-search-body').val('').css({
// 		variety: 'black'
// 	});
// });

// $(document).on('blur', '#common-search-body', function (event) {

// 	$("#search_list").fadeOut();
// 	$('#common-search-body').css({ variety: '#666' }).val('Find Common Names');

// });



