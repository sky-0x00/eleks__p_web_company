$j(document).ready(function(){

	$j("#action-structure-update").click(function () {

		var module = '';
		if ($j('#module-count').val() > 0) {
			for (i = 0; i < $j('#module-count').val(); i++) {
				if ($j('#module_'+i+':checked').val()) {
					module += $j('#module_'+i+'').val() +'|';
				}
			}
		}

		bodyContent = $j.ajax({
			url: "/admin/modules/structure/handler/PageUpdate.handler.php",
			type: "POST",
			data: ({

				id_page		: $j('#id_page').val(),
				active		: $j('#active:checked').val(),
				type_id		: $j('#type_id:checked').val(),
				title_upply : $j('#title_upply:checked').val(),
				name		: $j('#name_').val(),
				priority	: $j('#priority').val(),
				template_id : $j('#template_id').val(),
				url			: $j('#url').val(),
				title		: $j('#title').val(),
				description : $j('#description').val(),
				keywords 	: $j('#keywords').val(),
				module		: module

			}),
			success: function(msg){

			}
		}
		).responseText;
	});

	$j('#action-structure-submit').click(function () {

		var module = '';
		if ($j('#module-count').val() > 0) {
			for (i = 0; i < $j('#module-count').val(); i++) {
				if ($j('#module_'+i+':checked').val()) {
					module += $j('#module_'+i+'').val() +'|';
				}
			}
		}
		
		var args = getArgs();
		
		bodyContent = $j.ajax({
			url: "/admin/modules/structure/handler/PageCreate.handler.php",
			type: "POST",
			data: ({

				parentid	: $j('#parentid').val(),
				active		: $j('#active:checked').val(),
				type_id		: $j('#type_id:checked').val(),
				title_upply : $j('#title_upply:checked').val(),
				name		: $j('#name_').val(),
				priority	: $j('#priority').val(),
				template_id : $j('#template_id').val(),
				url			: $j('#url').val(),
				title		: $j('#title').val(),
				description : $j('#description').val(),
				keywords 	: $j('#keywords').val(),
				module		: module

			}),
			success: function(msg){
				
				if (msg!=0)
					document.location = "/admin/index.php?sess_id="+args.sess_id+"&section=structure";
				else
					alert("При добавлении страницы возникла ошибка.");
				
			}
		}
		).responseText;

	});
	
	$j("a.structure-page-delete").live("click", function(){
		
		var btn = this;
		
		if (confirm("Вы действительно хотите удалить страницу?")) {

			$j.ajax({
			
				url: "/admin/modules/structure/handler/PageDelete.handler.php",
				type: "post",					
				
				data: ({
					id_page	: $j(this).parent().find("[name=id_page]").val() 
				}),
				
				success: function(req){
					if (req!=0) {
						$j(btn).parent().parent().parent().remove();
					}
				}
			});
		}
		
	});
	
	$j("div.list-menu a.under").live("click", function(){
		OpenPageContent ($j(this).parent().find("[name=id_page]").val());
	});
});
