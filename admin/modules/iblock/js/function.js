$j(document).ready(function(){
	
	$j("a.iblock-quick-edit").live("click", function(){
		var id_block = $j(this).prev().val();
		OpenBlockContent (id_block);
	});
	
	$j("#action-iblock-update").click(function () {

		bodyContent = $j.ajax({
			url: "/admin/modules/iblock/handler/iblock-update.handler.php",
			type: "POST",
			data: ({
				id			: $j("#iblock-id").val(),
				active		: $j("#iblock-active:checked").val(),
				name		: $j("#iblock-name").val(),
				description	: $j("#iblock-description").val(),
				content		: $j("#iblock-content").val()

			}),
			success: function(msg){
				alert(msg);
			}
		}
		).responseText;
	});


	$j("#action-iblock-submit").click(function () {

		bodyContent = $j.ajax({
			url: "/admin/modules/iblock/handler/iblock-submit.handler.php",
			type: "POST",
			data: ({
				active		: $j("#iblock-active:checked").val(),
				name		: $j("#iblock-name").val(),
				description	: $j("#iblock-description").val(),
				content		: $j("#iblock-content").val()

			}),
			success: function(msg){
				alert(msg);
			}
		}
		).responseText;
	});
	
});