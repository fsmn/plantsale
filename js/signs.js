$(document).on("click",".price, .pot-size", function(){
var my_field = this;
var my_id = my_field.id;
var my_class = $(my_field).attr("class");
var my_value = $(my_field).html();

$(my_field).removeClass(my_class);
$(my_field).addClass(my_class + "_field");

$(my_field).html("<input type='text' value='" + my_value + "'/>");
$(my_field).children("input").focus();
});

$(document).on("blur",".price_field, .pot-size_field", function(){
	var my_field = this;
	var my_child = $(this).children("input");
var my_value = my_child.val();
var my_class = $(my_field).attr("class");
console.log(my_value);
$(my_field).removeClass(my_class);
var new_class = my_class.split("_")[0];
$(my_field).addClass(new_class);
$(my_field).html(my_value);
});

