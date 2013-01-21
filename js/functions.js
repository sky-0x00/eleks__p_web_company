/*****************************************************************************************************************
 *	HighSlide
 *****************************************************************************************************************/
 
hs.registerOverlay({
	thumbnailId: null,
	position: 'top right',
	hideOnMouseOut: true
});

hs.graphicsDir = '/admin/lib/highslide/graphics/';
hs.outlineType = 'rounded-white';

/*****************************************************************************************************************/

$j = jQuery.noConflict();

/*****************************************************************************************************************/

$j(document).ready(function(){
		
/*****************************************************************************************************************
 *	Переключение страниц новостей
 *****************************************************************************************************************/
 
	$j(".nav-pages a").live("click", function(){
		
		var text = $j(".nav-pages li.current").text();
		var href = "";		
		
		if ($j(this).hasClass("left")) {			
			
			if ($j(".nav-pages li.current").prev().find("a").hasClass("left"))
				return false;
			
			if (href = $j(".nav-pages li.current").prev().find("a").attr("href"))
				document.location = href;			
			else
				$j(".nav-pages li.current").prev().find("a").click();
		}
		else if ($j(this).hasClass("right")) {
		
			if ($j(".nav-pages li.current").next().find("a").hasClass("right"))
				return false;
			
			if (href = $j(".nav-pages li.current").next().find("a").attr("href"))
				document.location = href;
			else
				$j(".nav-pages li.current").next().find("a").click();
		}
		else {		
			
			$j(".nav-pages li.current").html("<a>"+text+"</a>").removeClass("current");
			
			var n = $j(this).text();
			
			$j(this).parent().html(n).addClass("current");
			
			$j(".news-page").hide().filter(":eq("+(n-1)+")").show();
		}
	});
	
/*****************************************************************************************************************
 *	Наведение на фото в разделе "Услуги"
 *****************************************************************************************************************/
	
	var above_timeout = 400;
	
	$j(".object-photo").bind("mouseover", function(){
			
		var above = $j(this).find(".above");
			
		/*.stop().css("top", "").css("left", "").css("position", "")*/
			
		/*$j(".left", above).stop().css("top", "").css("left", "").show("slide", { direction: "left" }, above_timeout);
		$j(".right", above).stop().css("top", "").css("left", "").show("slide", { direction: "right" }, above_timeout);
		$j(".comment", above).stop().css("top", "").css("left", "").show("slide", { direction: "down" }, above_timeout);*/
		
		$j(".left", above).show();
		$j(".right", above).show();
		$j(".comment", above).show();
	});
	
	$j(".object-photo").bind("mouseout", function(){
		
		var above = $j(this).find(".above");
			
		/*$j(".left", above).stop().css("top", "").css("left", "").hide("slide", { direction: "left" }, above_timeout);
		$j(".right", above).stop().css("top", "").css("left", "").hide("slide", { direction: "right" }, above_timeout);
		$j(".comment", above).stop().css("top", "").css("left", "").hide("slide", { direction: "down" }, above_timeout);*/
		
		$j(".left", above).hide();
		$j(".right", above).hide();
		$j(".comment", above).hide();
	});

/*****************************************************************************************************************
 *	Переключение объектов влево-вправо
 *****************************************************************************************************************/
	
	var objects_timeout = 1000;
	
	$j(".above .left").click(function(){
		
		if ($j(this).hasClass("blocked"))
			return false;
		
		$j(".above .right").addClass("blocked");
		$j(".above .left").addClass("blocked");
		
		var n = ($j(".object-photo img").length>0) ? ($j(".object-photo img").length - 1) : 0;
		
		if (n>0) {	
		
			var img = $j(".object-photo img").not(":hidden");
			var div = $j(".comment .desc").not(":hidden");
			
			if (img.prev("img").length>0) {
				img.prev("img").show("slide", { direction: "left" }, objects_timeout);
				img.hide("slide", { direction: "right" }, objects_timeout);
				div.prev(".desc").show();
				div.hide();
			}
			else {
				$j(".object-photo img:eq("+n+")").show("slide", { direction: "left" }, objects_timeout);
				img.hide("slide", { direction: "right" }, objects_timeout);
				$j(".comment .desc:eq("+n+")").show();
				div.hide();
			}
		}
		
		setTimeout(function(){$j(".above .blocked").removeClass("blocked");}, objects_timeout);
	});
	
	$j(".above .right").click(function(){
		
		if ($j(this).hasClass("blocked"))
			return false;
		
		$j(".above .right").addClass("blocked");
		$j(".above .left").addClass("blocked");
		
		var n = ($j(".object-photo img").length>0) ? ($j(".object-photo img").length - 1) : 0;
		
		if (n>0) {			
			var img = $j(".object-photo img").not(":hidden");
			var div = $j(".comment .desc").not(":hidden");
			
			if (img.next("img").length>0) {
				img.next("img").show("slide", { direction: "right" }, objects_timeout);
				img.hide("slide", { direction: "left" }, objects_timeout);
				div.next(".desc").show();
				div.hide();
			}
			else {
				$j(".object-photo img:eq(0)").show("slide", { direction: "right" }, objects_timeout);
				img.hide("slide", { direction: "left" }, objects_timeout);
				$j(".comment .desc:eq(0)").show();
				div.hide();
			}
		}
		
		setTimeout(function(){$j(".above .blocked").removeClass("blocked");}, objects_timeout);
	});
	
/*****************************************************************************************************************
 *	Клик по ссылке продукта
 *****************************************************************************************************************/

	$j(".product-name a").click(function(){
		
		var src 	= $j(this).prev().prev().val();
		var title 	= $j(this).text()
		
		$j(".product-photo:first").clone(true).insertAfter(".product-photo:last");
		
		$j(".product-photo:last .title").text(title);
		$j(".product-photo:last .desc").html($j(this).prev().text());
		$j(".product-photo:last .big-image").empty();
		
		var img = new Image();
		
		$j(".product-photo:last .big-image").append(img);
		
		$j(img).load(function () {

			var im = this;

			setTimeout(function(){				
				$j(im).fadeIn(300);
			}, 100);

		}).error(function (){}).attr("alt", title).attr("src", src).hide();
							
		$j(".product-photo:last").show().draggable({ containment: 'body' }).css("cursor", "move");
	});
	
/*****************************************************************************************************************
 *	Закрытие окна
 *****************************************************************************************************************/
	
	$j(".product-photo .cross").live("click", function(){
		$j(this).parent().remove();		
	});

/*****************************************************************************************************************
 *	Переключение сертификатов
 *****************************************************************************************************************/
 
	$j(".certificates .to-left").click(function(){
		
		if ($j(this).hasClass("blocked"))
			return false;

		$j(".certificates .to-left").addClass("blocked");
		$j(".certificates .to-right").addClass("blocked");

		var li_count = $j(".certificates ul li").length;
		var ul_inner_width = parseInt($j(".certificates").width())-100;
		//var ul_inner_width = parseInt($j(".certificates").css("width"))-100;

		var li_width = 89;
		var li_inner_count = parseInt((ul_inner_width+10)/li_width);

		var ul_left = parseInt($j(".certificates ul").css("left"));
		var ul_width = li_count*li_width;

		var ul_offset = ((-ul_left) >= ul_inner_width) ? ul_inner_width : -ul_left;
		
		if (ul_offset>0) {
			$j(".certificates ul").stop().animate({ "left": "+="+ul_offset }, 1000, function(){$j(".blocked").removeClass("blocked");});
		}
		else {
			$j(".blocked").removeClass("blocked");
		}
	});
	
	$j(".certificates .to-right").click(function(){
		
		if ($j(this).hasClass("blocked"))
			return false;

		$j(".certificates .to-left").addClass("blocked");
		$j(".certificates .to-right").addClass("blocked");

		var li_count = $j(".certificates ul li").length;
		var ul_inner_width = parseInt($j(".certificates").width())-100;
		//var ul_inner_width = parseInt($j(".certificates").css("width"))-100;

		var li_width = 89;
		var li_inner_count = parseInt((ul_inner_width+10)/li_width);

		var ul_left = parseInt($j(".certificates ul").css("left"));
		var ul_width = li_count*li_width;

		var ul_offset = ((ul_width-ul_inner_width+ul_left) >= ul_inner_width) ? ul_inner_width : (ul_width-ul_inner_width+ul_left);

		if (ul_offset>0) {
			$j(".certificates ul").stop().animate({ "left": "-="+ul_offset }, 1000, function(){$j(".blocked").removeClass("blocked");});
		}
		else {
			$j(".blocked").removeClass("blocked");
		}
	});

/*****************************************************************************************************************
 *	Просмотр отзывов
 *****************************************************************************************************************/

	$j(".comments a").click(function(){		
		
		$j(".comments-form").show();
		
		var container = $j(".comment-nav");
		
		SliderInit(container, ".slider-wrap", 63);		
	});
	
	$j(".comments-form .cross").click(function(){
		
		$j(this).parent().hide();
	});
	
/*****************************************************************************************************************
 *	Просмотр отзыва
 *****************************************************************************************************************/

	$j(".comment-nav li img").click(function(){
		
		var src = $j(this).siblings("[name=photo]").val();
		var descr = $j(this).siblings("[name=descr]").val();
		
		var img = new Image();
		
		$j(".comments-form .full-size").empty().append(img);
		$j(".comments-form .comment-text").html(descr);
		
		$j(img).load(function () {

			var im = this;

			setTimeout(function(){				
				$j(im).fadeIn(300);
			}, 100);

		}).error(function (){}).attr("alt", "").attr("src", src).hide();
	});

/*****************************************************************************************************************
 *	Прокрутка отзывов
 *****************************************************************************************************************/
 
	$j(".comment-nav").mousewheel(function(event, delta) {
		
		if ($j(this).hasClass("blocked"))
			return false;
			
		$j(this).addClass("blocked");
		
		var value = $j(".slider-wrap").slider('option', 'value');										
		var max = $j(".slider-wrap").slider('option', 'max');
		
		if (delta > 0) {
			if (value < 63)
				$j(".slider-wrap").slider('value', 0);
			else
				$j(".slider-wrap").slider('value', value - 63);
		}
		else {
			if (value+63 > max)
				$j(".slider-wrap").slider('value', max);
			else
				$j(".slider-wrap").slider('value', value + 63);
		}
		
		setTimeout(function(){$j(".comment-nav").removeClass("blocked")}, 100);
		
		return false;
	});

/*****************************************************************************************************************
 *	Прокрутка галереи проекта
 *****************************************************************************************************************/
 
	if ($j(".project-gallery").length>0) {
		
		var container = $j(".slider");
		
		SliderInit(container, ".slider-wrap", 103);
		
		$j(".slider").mousewheel(function(event, delta) {
		
			if ($j(this).hasClass("blocked"))
				return false;
				
			$j(this).addClass("blocked");
			
			var value = $j(".slider-wrap").slider('option', 'value');										
			var max = $j(".slider-wrap").slider('option', 'max');
			
			if (delta > 0) {
				if (value < 103)
					$j(".slider-wrap").slider('value', 0);
				else
					$j(".slider-wrap").slider('value', value - 103);
			}
			else {
				if (value+103 > max)
					$j(".slider-wrap").slider('value', max);
				else
					$j(".slider-wrap").slider('value', value + 103);
			}
			
			setTimeout(function(){$j(".slider").removeClass("blocked")}, 100);
			
			return false;
		});
	}
	
/*****************************************************************************************************************
 *	Просмотр фото проекта
 *****************************************************************************************************************/

	$j(".project-gallery li img").click(function(){
		
		var src = $j(this).prev().val();
		var name = $j("h2.product").text();
		
		var img = new Image();
		
		$j(".photo-number span").text( $j(this).prev().prev().val());
		$j(".project-gallery .full-image").empty().append(img);
		
		$j(img).load(function () {

			var im = this;

			setTimeout(function(){				
				$j(im).fadeIn(300);
			}, 100);

		}).error(function (){}).attr("alt", name).attr("src", src).hide();
	});
	
/*****************************************************************************************************************/
});

/*****************************************************************************************************************
 *	Слайдер
 *****************************************************************************************************************/
 
function SliderInit(container, slider, li_width) {
	
	var ul = $j("ul", container);
			
	var items_count = $j("li", ul).length;
	$j(ul).css("width", li_width*items_count+"px");
	var itemsWidth = ul.innerWidth() - container.outerWidth();
		
	if (itemsWidth > 0) {
		
		$j(slider).slider({
			min: 0,
			max: itemsWidth,
			handle: ".handle",
			stop: function (event, ui) {
				ul.animate({"left" : ui.value * -1}, 100);
			},
			change: function (event, ui) {
				ul.animate({"left" : ui.value * -1}, 100);
			},
			slide: function (event, ui) {
				ul.css("left", ui.value * -1);
			}
		});
	}	
}
