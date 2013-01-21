
$j(document).ready(function(){

	$j("#feedback-template").text (''+$j("#feedback-template-temp").html()+'');

	$j("#module-feedback-submit").click(function () {

		bodyContent = $j.ajax({
			url: "/admin/modules/module/block/feedback/handler/feedback-update.handler.php",
			type: "POST",
			data: ({

				allow	: $j('#feedback-allow:checked').val(),
				mails	: $j('#feedback-mails').val(),
				subject	: $j('#feedback-subject').val(),
				mail	: $j('#feedback-mail-template').val(),
				captcha	: $j('#feedback-captcha:checked').val(),
				template: $j('#feedback-template').val(),
				access	: $j('#feedback-access').val(),
				error	: $j('#feedback-error').val()

			}),
			success: function(msg){

				alert('Сохранено!');
			}
		}
		).responseText;
		
		return false;
	});


	$j("#feedback-send").click(function () {
		
		if ($j(this).hasClass("blocked"))
			return false;
		
		$j(this).addClass("blocked");
		
		var name 	= $j("#feedback-name").val();
		var phone 	= $j("#feedback-phone").val();
		var email	= $j("#feedback-email").val();
		var message = $j("#feedback-message").val();
		
		if (name=="") {
			alert("Пожалуйста, укажите ваше имя.");
			$j("#feedback-send").removeClass("blocked");
			return false;
		}
		
		if (email=="") {
			alert("Пожалуйста, укажите ваш email.");
			$j("#feedback-send").removeClass("blocked");
			return false;
		}
		
		email = trim(email); 
		
		if (!check_email(email)) {
			alert("Введенный email неверный. Пожалуйста, попробуйте снова.");
			$j("#feedback-send").removeClass("blocked");
			return false;
		}
		
		if (message=="") {
			alert("Пожалуйста, введите текст сообщения.");
			$j("#feedback-send").removeClass("blocked");
			return false;
		}
		
		$j.ajax({
			url: "/admin/modules/module/block/feedback/handler/feedback-submit.handler.php",
			type: "POST",
			data: ({					
				name 	: name,
				phone 	: phone,
				email 	: email,
				message	: message
			}),
			success: function(msg){
				
				if (msg!=0) {
						
					alert("Спасибо, ваше сообщение успешно отправлено.");
						
					setTimeout(function(){
						$j("#feedback input:text").val("");
						$j("#feedback textarea").val("");
						$j("#feedback-send").removeClass("blocked");
					}, 500);						
				}
				else {
					alert("Ошибка. Сообщение не может быть отправлено.");
					$j("#feedback-send").removeClass("blocked");
				}
			}
		});
			
		return false;
	});

});

function trim(str) {
	
	var newstr = str.replace(/^\s*(.+?)\s*$/, "$1");
	
    if (newstr == " ") {
        return "";
    }
	
    return newstr;
}

function check_email(email) {
    
	var pattern = /^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z])+$/;
    
    if (pattern.test(email)) {
        return true;
    }
	
    return false; 
}