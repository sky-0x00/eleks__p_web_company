/*****************************************************************************************************************/

$j = jQuery.noConflict();

/*****************************************************************************************************************
 *	Global variables
 *****************************************************************************************************************/

var x_c = 610;
var y_c = 135;
var R1 = 240;
var R2 = 135;
var offset = 50;
var phi = 0;
var speed = 1000;				
		
var alpha = 0.0;

var params = new Object();

/*****************************************************************************************************************/

$j(document).ready(function(){

/*****************************************************************************************************************
 *	Поиск
 *****************************************************************************************************************/
 
	$j(".search .text").focus(function(){
		$j(this).val("");
	});
	
	$j(".search form").submit(function(){
		
		var text = trim($j(".text", this).val());
		
		if ((text!="")&&(text!="введите текст")) {
			$j(".text", this).val(text)
		}
		else {
			return false;
		}
		
		return true;
	});
	
/*****************************************************************************************************************/
	
	if (!$j.browser.msie || (parseFloat($j.browser.version)>=7)) {
	
		$j(".automation").css("z-index", "10").css("width", "100px").css("height", "100px");
		$j(".montage").css("z-index", "10").css("width", "100px").css("height", "100px");
		$j(".safety").css("z-index", "10").css("width", "100px").css("height", "100px");
		$j(".construction").css("z-index", "10").css("width", "100px").css("height", "100px");
		
		SetPosition($j(".construction"), 2*Math.PI);
		SetPosition($j(".automation"), (3*Math.PI)/2);
		SetPosition($j(".montage"), Math.PI);
		SetPosition($j(".safety"), Math.PI/2);
	}
	else {
		
		/*$j(".automation").css("cursor", "pointer").css("z-index", "100").css("top", "100px").css("left", "100px").find(".desc").show().css("top", "100px");
		$j(".montage").css("cursor", "pointer").css("z-index", "100").css("top", "100px").css("left", "700px").find(".desc").show().css("top", "100px");
		$j(".safety").css("cursor", "pointer").css("z-index", "100").css("top", "400px").css("left", "100px").find(".desc").show().css("top", "100px");
		$j(".construction").css("cursor", "pointer").css("z-index", "100").css("top", "400px").css("left", "700px").find(".desc").show().css("top", "100px");*/
	}

/*****************************************************************************************************************
 *	Автономная карусель
 *****************************************************************************************************************/
		
	if (!$j.browser.msie || (parseFloat($j.browser.version)>=7)) {
		
		$j("#earth").everyTime(50, "timer1", function(i) {
			alpha += Math.PI/180;
			
			if (alpha > (2*Math.PI))
				alpha -= 2*Math.PI;
			
			SetPosition($j(".construction"), 2*Math.PI - alpha);
			SetPosition($j(".automation"), (3*Math.PI)/2 - alpha);
			SetPosition($j(".montage"), Math.PI - alpha);
			SetPosition($j(".safety"), Math.PI/2 - alpha);
			
		});
	}
	
/*****************************************************************************************************************
 *	Мануальная карусель
 *****************************************************************************************************************/
	
	if (!$j.browser.msie || (parseFloat($j.browser.version)>=7)) {
	
		$j("#earth").mousewheel(function(event, delta) {
			
			if ($j("#visual img.static").length>0)
				return false;
			
			if ($j(this).hasClass("blocked"))
				return false;
			
			$j("#earth").stopTime("timer1");
			
			$j("#earth").everyTime(50, "timer2", function(i) {
			
				if (delta > 0) {
					alpha -= Math.PI/90;
				}
				else {
					alpha += Math.PI/90;
				}
				
				if (alpha > (2*Math.PI))
				alpha -= 2*Math.PI;
			
				SetPosition($j(".construction"), 2*Math.PI - alpha);
				SetPosition($j(".automation"), (3*Math.PI)/2 - alpha);
				SetPosition($j(".montage"), Math.PI - alpha);
				SetPosition($j(".safety"), Math.PI/2 - alpha);
				
			}, 4);
			
			return false;
		});
		
		$j("#earth").css("z-index", "50");
		
		$j("#stop").click(function(){
			$j("#earth").stopTime("timer1");
		});
	}
	
/*****************************************************************************************************************
 *	Наведение на блоки
 *****************************************************************************************************************/
	
	if (!$j.browser.msie || (parseFloat($j.browser.version)>=7)) {
	
		$j(".construction, .automation, .montage, .safety").hover(
			function(){
			
				if ($j(".desc-left-active", this).length>0)
					return false;
					
				$j("img.hidden", this).css("top", 0);
			},
			function(){
				
				if ($j(".desc-left-active", this).length>0)
					return false;
					
				$j("img.hidden", this).css("top", "-200000px");
			}
		);
	}
	
/*****************************************************************************************************************
 *	Клик на вращающийся блок
 *****************************************************************************************************************/
	
	if (!$j.browser.msie || (parseFloat($j.browser.version)>=7)) {	
		
		$j("img.clickable").live("click", function(){			
			MoveObjects(this);		
		});		
	}
	else {	
		
		$j("#visual .text").click(function(){
			MoveObjects($j(this).find("img.hidden"));
		});
	}
	
/*****************************************************************************************************************
 *	Всплывающее окно
 *****************************************************************************************************************/

	$j("img.static").live("click", function(){
		
		if ($j(this).siblings(".desc-left-active").length>0)
			return false;
		
		$j(".info").hide();
		$j(".popup").hide();
		
		$j(".construction img, .automation img, .montage img, .safety img").not(this)
			.css("cursor", "pointer")
			.css("top", "")
			.addClass("static")
			.siblings(".desc-left-active")
			.removeClass("desc-left-active")
			.addClass("desc-left");
			
		$j(this).css("cursor", "default").removeClass("static").parent().find(".desc-left").addClass("desc-left-active").removeClass("desc-left");
		
		var cls = $j(this).parent().parent().attr("class");
		
		var type = "";
			
		switch (cls) {
				
			case "automation":
				type = "asu";
				break;
					
			case "montage":
				type = "montage";
				break;
					
			case "safety":
				type = "safety";
				break;
					
			case "construction":
				type = "construction";
				break;
		}
			
		$j(".lines").show();
			
		if ($j.browser.msie)
			$j("#info-"+type).show();
		else
			$j("#info-"+type).fadeIn(500);
				
		$j("#info-"+type).css("z-index", 100);
	});
	
/*****************************************************************************************************************
 *	Всплывающее окно
 *****************************************************************************************************************/

	$j(".text .further").click(function(){
		
		if ($j.browser.msie)
			$j(this).closest(".info").next(".popup").show()
		else
			$j(this).closest(".info").next(".popup").fadeIn(500);
			
		return false;
	});
	
	$j(".popup").draggable({ containment: 'body' }).css("cursor", "move");
	
	$j(".popup .cross").click(function(){
		$j(this).parent().hide();
	});

/*****************************************************************************************************************
 *	Возврат к вращению
 *****************************************************************************************************************/
 
	$j(".info .close").click(function(){
		
		$j(".info, .popup, .lines").hide();
		
		$j(".text .desc-left, .text .desc-left-active").removeClass("desc-left").removeClass("desc-left-active").addClass("desc");
		 
		if ($j.browser.msie && (parseFloat($j.browser.version)<7)) {
			$j("desc").css("top", "100px");			
		}
		else {
			$j("desc").hide();
		}
		
		$j("#earth").show();
		
		$j(".construction").animate({
			left: params.construction.left,
			top: params.construction.top
		}, speed, function(){
		}).css("z-index", 100);
		
		
		$j(".automation").animate({
			left: params.asu.left,
			top: params.asu.top
		}, speed, function(){
		}).css("z-index", 100);
		
		
		$j(".montage").animate({
			left: params.montage.left,
			top: params.montage.top
		}, speed, function(){
		}).css("z-index", 100).css("top", "");
		
		
		$j(".safety").animate({
			left: params.safety.left,
			top: params.safety.top
		}, speed, function(){				
		}).css("z-index", 100).css("top", "");
		
		$j(".safety img").animate({
			width: params.safety.size,
			height: params.safety.size
		}, speed, function(){
		
			if (params.safety.size<=100)
				$j(this).parent().parent().css("z-index", 10);
				
		}).removeClass("static").css("top", "");
		
		$j(".montage img").animate({
			width: params.montage.size,
			height: params.montage.size
		}, speed, function(){
		
			if (params.montage.size<=100)
				$j(this).parent().parent().css("z-index", 10);
				
		}).removeClass("static").css("top", "");
		
		$j(".construction img").animate({
			width: params.construction.size,
			height: params.construction.size
		}, speed, function(){
		
			if (params.construction.size<=100)
				$j(this).parent().parent().css("z-index", 10);
				
		}).removeClass("static").css("top", "");
		
		$j(".automation img").animate({
			width: params.asu.size,
			height: params.asu.size
		}, speed, function(){
			
			if (params.asu.size<=100)
				$j(this).parent().parent().css("z-index", 10);
				
		}).removeClass("static").css("top", "");
		
		if (!$j.browser.msie || (parseFloat($j.browser.version)>=7)) {	
		
			setTimeout(function(){
			
				$j("#earth").removeClass("blocked");
				
				$j("#earth").everyTime(50, "timer1", function(i) {
					alpha += Math.PI/180;
					
					if (alpha > (2*Math.PI))
						alpha -= 2*Math.PI;
					
					SetPosition($j(".construction"), 2*Math.PI - alpha);
					SetPosition($j(".automation"), (3*Math.PI)/2 - alpha);
					SetPosition($j(".montage"), Math.PI - alpha);
					SetPosition($j(".safety"), Math.PI/2 - alpha);
					
				});
			}, speed);
		}
		
	});
	
/*****************************************************************************************************************/
});


/*****************************************************************************************************************
 *	Установка элемента на позицию
 *****************************************************************************************************************/

function SetPosition(obj, a) {

	var x = x_c + R1*Math.cos(a)*Math.cos(phi) - R2*Math.sin(a)*Math.sin(phi) - offset;
	var y = y_c + R1*Math.cos(a)*Math.sin(phi) + R2*Math.sin(a)*Math.cos(phi) - offset;	
	
	var local_offset = 0;
	var size = 100;
	
	size = 100 + 63*Math.sin(a);
	
	/*if (size>100) {
	
		$j(".desc", obj).css("top", size+"px");
		
		var opacity = (size-100)/63;	
		
		$j(".desc", obj).animate({
			opacity: opacity
		}, 10, function(){
			if ($j(this).css("display")=="none")
				$j(this).show();
		});	
	}
	else if ($j(".desc", obj).css("display")!="none") {
		$j(".desc", obj).hide();
	}*/
	
	if (size>100) {
		
		$j(".desc", obj).css("top", size+"px");
		
		if ($j(".desc", obj).css("display")=="none")
			$j(".desc", obj).fadeIn(500);
	}
	else if ($j(".desc", obj).css("display")!="none") {
		$j(".desc", obj).fadeOut(500);
	}
	
	if ((size > 100) && !$j("img", obj).hasClass("clickable")) {
		obj.css("z-index", 100);
		$j("img", obj).css("cursor", "pointer").addClass("clickable");			
	}
	if ((size <= 100) && $j("img", obj).hasClass("clickable")) {
		obj.css("z-index", 10);
		$j("img", obj).css("cursor", "default").removeClass("clickable");
	}
	
	if (a > (2*Math.PI))
		a -= 2*Math.PI;
		
	if (a < 0)
		a += 2*Math.PI;
	
	a = Math.round(a*180/Math.PI);
	
	if (a<=210)
		obj.css("z-index", 100);
	else if (a<=30)
		obj.css("z-index", 10);
		
	$j("img", obj).css("width", size+"px").css("height", size+"px").attr("width", size).attr("height", size);
	
	obj.css("left", x+"px").css("top", y+"px");
}

function trim(str) {
	
	var newstr = str.replace(/^\s*(.+?)\s*$/, "$1");
	
    if (newstr == " ") {
        return "";
    }
	
    return newstr;
}

function MoveObjects(obj) {
	
	params.asu = new Object();
			
	params.asu.size 	= parseInt($j(".automation img").css("width"));
	params.asu.left 	= parseInt($j(".automation").css("left"));
	params.asu.top 		= parseInt($j(".automation").css("top"));
			
	params.montage = new Object();
			
	params.montage.size 	= parseInt($j(".montage img").css("width"));
	params.montage.left 	= parseInt($j(".montage").css("left"));
	params.montage.top 		= parseInt($j(".montage").css("top"));
			
	params.safety = new Object();
			
	params.safety.size 	= parseInt($j(".safety img").css("width"));
	params.safety.left 	= parseInt($j(".safety").css("left"));
	params.safety.top 	= parseInt($j(".safety").css("top"));
			
	params.construction = new Object();
			
	params.construction.size 	= parseInt($j(".construction img").css("width"));
	params.construction.left 	= parseInt($j(".construction").css("left"));
	params.construction.top 	= parseInt($j(".construction").css("top"));
			
	var cls = $j(obj).parent().parent().attr("class");
			
	$j(".info").hide();
	$j(".popup").hide();
			
	$j(".construction img, .automation img, .montage img, .safety img").removeClass("clickable").css("cursor", "pointer").addClass("static");
	$j(".construction .desc, .automation .desc, .montage .desc, .safety .desc").animate({opacity: 0}, 0).hide().addClass("desc-left").removeClass("desc").css("top", "");
			
	$j(obj).removeClass("static").css("cursor", "default").parent().find(".desc-left").hide().addClass("desc-left-active").removeClass("desc-left");
		
	if (!$j.browser.msie || (parseFloat($j.browser.version)>=7)) {	
		$j("#earth").stopTime("timer1").stopTime("timer2").addClass("blocked");		
	}	
		
	$j(".construction").animate({
		left: "55",
		top: "410"
	}, speed, function(){
	}).css("z-index", 100);
			
			
	$j(".automation").animate({
		left: "60",
		top: "70"
	}, speed, function(){
	}).css("z-index", 100);
			
			
	$j(".montage").animate({
		left: "120",
		top: "185"
	}, speed, function(){
	}).css("z-index", 100);
			
			
	$j(".safety").animate({
		left: "110",
		top: "300"
	}, speed, function(){				
	}).css("z-index", 100);
			
			
	$j(".safety img, .montage img, .construction img, .automation img").animate({
		width: "100",
		height: "100"
	}, speed, function(){
				
		$j(this).parent().parent().css("z-index", 10);
				
		if ($j.browser.msie)
			$j(this).siblings(".desc-left, .desc-left-active").animate({opacity: 1}, 0).show();
		else
			$j(this).siblings(".desc-left, .desc-left-active").animate({opacity: 1}, 0).fadeIn(500);
		
		$j("#earth").hide();
				
		var type = "";
				
		switch (cls) {
					
			case "automation":
				type = "asu";
				break;
						
			case "montage":
				type = "montage";
				break;
						
			case "safety":
				type = "safety";
				break;
						
			case "construction":
				type = "construction";
				break;
		}
				
		$j(".lines").show();
				
		if ($j.browser.msie)
			$j("#info-"+type).show();
		else
			$j("#info-"+type).fadeIn(500);
					
		$j("#info-"+type).css("z-index", 100);
				
	});	
}
