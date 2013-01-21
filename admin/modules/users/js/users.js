/* js users */

$j(document).ready(function(){


	$j("button.edit").click(function(){
		window.location = sess+"section="+"users&action=edit&id="+$j(this).parent().parent().parent().find("[name=id_user]").val();
	});

	$j("#user-password-change").bind("click", function () {

		$j("#layer-password-change").slideToggle("fast");
	});

	/* добавление */
	$j("#action-users-submit").click(function () {

		bodyContent = $j.ajax({
			url: "/admin/modules/users/handler/UsersCreate.handler.php",
			type: "POST",
			data: ({

				active 	: $j("#user-active:checked").val(),
				name 	: $j("#user-name").val(),
				login 	: $j("#user-login").val(),
				pwd		: $j("#user-password").val(),
				pwd_re 	: $j("#user-password-re").val(),
				photo 	: $j("#user-photo").val(),
				mail 	: $j("#user-mail").val(),
				phone 	: $j("#user-phone").val(),
				icq 	: $j("#user-icq").val(),
				comment	: $j("#user-comment").val()

			}),
			success: function(msg){

			}
		}
		).responseText;
	});

	/* редактирование */
	$j("#action-users-update").click(function () {

		bodyContent = $j.ajax({
			url: "/admin/modules/users/handler/UsersUpdate.handler.php",
			type: "POST",
			data: ({

				uid		: $j("#action-users-update").parent().find("[name=id_user]").val(),
				active 	: $j("#user-active:checked").val(),
				name 	: $j("#user-name").val(),
				login 	: $j("#user-login").val(),
				pwd		: $j("#user-password").val(),
				pwd_re 	: $j("#user-password-re").val(),
				photo 	: $j("#user-photo").val(),
				mail 	: $j("#user-mail").val(),
				phone 	: $j("#user-phone").val(),
				icq 	: $j("#user-icq").val(),
				comment	: $j("#user-comment").val(),
				report	: $j("#report-mail:checked").val()
			}),
			success: function(msg){

			}
		}
		).responseText;
	});

	/* удаление */
	$j("button.drop").click(function(){

		var btn = this;
		
		if (confirm("Вы действительно хотите удалить пользователя?")) {

			$j.ajax({
				url: "/admin/modules/users/handler/UsersDelete.handler.php",
				type: "POST",
				data: ({
					id_user	: $j(btn).parent().parent().parent().find("[name=id_user]").val()
				}),
				success: function(msg){
					
					if (msg!=0)
						$j(btn).parent().parent().parent().remove();
				}
			});

		}
	});
	

	
	
});