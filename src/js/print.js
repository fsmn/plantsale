$(document).ready(function(){
	
	$(".button-box").on("click",".change-font",function(){
		my_font = this.id;
		reset_fonts();
		$(this).addClass("active");
		$("body").addClass(my_font);
	});
	
});

function reset_fonts(){
	$("body").removeClass("lato").removeClass("ubuntu").removeClass("merriweather").removeClass("merriweather-sans");
	$(".button-box>.button-list>li>a.active").removeClass("active");
}