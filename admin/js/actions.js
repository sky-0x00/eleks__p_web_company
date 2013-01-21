$j = jQuery.noConflict();

$j(document).ready(function(){
		
	$j("#header-hide").click(function () {
		($j("#header").slideToggle(500))
	});

	/*--------------------------------------------------------------*/
	/* global */

	$j("#cms-logout").click(function () {
		bodyContent = $j.ajax({
			url: "/admin/modules/cms/handler/logout.handler.php",
			type: "POST",
			data: ({
				sessid : sess
			}),
			success: function(msg){
				location.href = '/admin/';
			}
		}
		).responseText;
	});


	/*--------------------------------------------------------------*/
	/* обработчики структура */

	$j("#action-module-list").click(function () {
		$j("#module-list").slideToggle(500);
	});

	/*
	url 		- скрипт обработки
	result_id 	- слой, который содержит контейнер обработки скрипта
	text_id 	- поле, которое содержит результат ввиде строки
	temp_id 	- поле, которое содержит ID строки
	*/
	function AjaxSelect (url, result_id, text_id, temp_id) {

		if (url != "") {

			bodyContent = $j.ajax({
				url: url,
				type: "POST",
				data: ({
					sessid : sess
				}),
				success: function(msg){
					$j("#"+result_id+"")
					.html(msg)
					.slideToggle(0);

					$j("#"+result_id+":div input").bind("click", function (){

						$j("#"+text_id+"").val($j(this).val());
						$j("#"+temp_id+"").val($j(this).attr("tid"));
						$j("#"+result_id+"").hide();

					});
				}
			}
			).responseText;

		} else {

			$j("#"+result_id+"")
			.slideToggle(0);
			$j("#"+result_id+":div input").bind("click", function (){

				$j("#"+text_id+"").val($j(this).val());
				$j("#"+temp_id+"").val($j(this).attr("tid"));
				$j("#"+result_id+"").hide();

			});
		}
	}



	$j("#input-drop").click (function () {

		AjaxSelect("/admin/modules/structure/handler/getTemplateList.handler.php", "input-drop-result-t", "input-text-result-t", "template_id");
	});

	$j("#input-structure").click (function () {

		AjaxSelect("/admin/modules/structure/handler/getStructureList.handler.php", "input-drop-result-s", "input-text-result-s", "parentid");
	});

	$j("#input-error-e403").click (function () {

		AjaxSelect("/admin/modules/page_error/handler/getErrorList.handler.php", "input-drop-result-e403", "input-text-result-e403", "select-403");
	});

	$j("#input-error-e404").click (function () {

		AjaxSelect("/admin/modules/page_error/handler/getErrorList.handler.php", "input-drop-result-e404", "input-text-result-e404", "select-404");
	});

	$j("#input-charset").click (function () {

		AjaxSelect("", "input-drop-result", "input-text-result", "charset");

	});


	

	/*----------------------------------------------------------------*/
});

function MessageWindow (message) {
	
	meerkat({
		animation: 'slide',
		animationSpeed: 500,
		dontShowExpire: 0,
		meerkatPosition: 'bottom',
		background: '#2e2a22 url(admin/images/meerkat-bg.png) repeat-x 0 0',
		height: '100px'
	});
	
	$j("#meerkat-wrap").css("z-index", "100").css("display", "none");
	//$j("#meerkat").slideDown();
}
