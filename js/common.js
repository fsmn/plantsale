(function($){
	$.fn.stickytable = function(options){
		
		var settings = $.extend({},$.fn.stickytable.defaults, options);
		
		return this.each(function(index){
			var table = $(this);
			var fixedheader = $('<div class="header-fixed"></div>');
			var tableOffset = table.offset().top;
			var tableleft = table.offset().left;
			var tablewidth = table.width();
			var tableheight = table.height();

			if($('thead',table).length < 1) {
				if($('th',table).length > 0){
					$('th',table).eq(0).parent().wrap('<thead class="theader"></thead>');
					$('.theader',table).prependTo(table);
				} 
				
				else $('tr',table).eq(0).wrap('<thead></thead>');
			}

			var $header = $("thead", table).clone();
			var newTable = $('<table class="'+table.attr('class')+'"></table>');
			$header.appendTo(newTable);
			newTable.css('margin','0');

			fixedheader.css({
				'position':'fixed',
				'top':'0px',
				'display':'none',
				'left':tableleft+'px',
				'width':tablewidth+2+'px',
				'z-index': '103'
			});
			var $fixedHeader = fixedheader.append(newTable);

			table.find('th').each(function(index, valuee){
				//console.log($(this).width()+'px');
				$header.find('th').eq(index).css('width',$(this).width()+'px');
			});
			
			$(window).on("scroll", function() {
				var offset = $(this).scrollTop();
				tableOffset = table.offset().top;
				tablewidth = table.width();
				tableheight = table.height();
				if (offset >= tableOffset && $fixedHeader.is(":hidden") && offset < tableOffset+tableheight) {
					fixedheader.appendTo('body');
					$fixedHeader.fadeIn(100);
					table.addClass('stuck');
				}
				else if (offset < tableOffset || offset > tableOffset+tableheight-30) {
					$fixedHeader.fadeOut(150);
					table.removeClass('stuck');
				}
			});

		});
	}
	

	$.fn.stickytable.defaults = {
		
	}

})(jQuery);

$(document).ready(function(){
	$('table.list').stickytable();
});
	
	$(document).on("click",".common-edit",function(){
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
	
	$(document).on("click",".common-create",function(){
		$.ajax({
			type: "get",
			url: base_url + "common/create",
			success: function(data){
				show_popup("Create Common Name",data, "auto");
			}
		});
		
	});
	
	$(document).on("click",".search-common-names", function(event){
		$.ajax({
			type: "get",
			url: base_url + "common/search",
			success: function(data){
				show_popup("Search Plants",data,"auto");
			}
		});
	});
	
	
	$(document).on('keyup','#common-search-body', function(event) {
		common_search = this.value;
		if (common_search.length > 2 && common_search != "Find Common Names") {
			search_words = common_search.split(' ');
			my_name = search_words.join('%') + "%";
			form_data = {
				ajax: 1,
				name: my_name,
				type: 'inline'
			};
			$.ajax({
				url: base_url + "common/search_by_name",
				type: 'GET',
				data: form_data,
				success: function(data){
					//remove the search_list because we don't want to have a ton of them. 

					$("#search_list").css({"z-index": 1000}).html(data).position({
						my: "left top",
						at: "left bottom",
						of: $("#common-search-body"), 
						collision: "fit"
					}).show();
			}
			});
		}else{
			$("#search_list").hide();
        	$("#search_list").css({"left": 0, "top": 0});


		}
	});// end stuSearch.keyup
	

	$(document).on('focus','#common-search-body', function(event) {
		$('#common-search-body').val('').css( {
			variety : 'black'
		});
	});
	
	
	$(document).on('blur','#common-search-body', function(event) {
		
		$("#search_list").fadeOut();
		$('#common-search-body').css({variety:'#666'}).val('Find Common Names');
		//$("#search_list").remove();
		
		
	});
	
