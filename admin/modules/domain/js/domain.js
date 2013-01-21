/*--------------------------------------------------------------*/
/* domain */
$j(document).ready(function(){

	$j("#action-domain-submit").click(function () {
		bodyContent = $j.ajax({
			url: "/admin/modules/domain/handler/DomainUpdate.handler.php",
			type: "POST",
			data: ({

				active	: $j('#active:checked').val(),
				name	: $j('#name_').val(),
				url		: $j('#url').val(),
				p403	: $j('#select-403').val(),
				p404	: $j('#select-404').val(),
				charset	: $j('#charset').val()

			}),
			success: function(msg){

			}
		}
		).responseText;
	});
});