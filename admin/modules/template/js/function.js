$j(document).ready(function(){

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Редактирование файла
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("div.template-list-file-name a").live("click", function(){
		var filename = "/templates/" + $j(this).text() + ".tpl.php";
		OpenFileContent (filename);
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Подсветка фона
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("div.module-template-list-item").live("mouseover",
		function () {
  			$j(this).css({
    			backgroundColor: "#E1D7C0"
  				});
		});
			
	$j("div.module-template-list-item").live("mouseout", 
		function () {
  			$j(this).css({
    			backgroundColor: "#FFFFFF"
  				});	
  		});
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Всплывающее меню
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("div.icon").live("mouseover",
		function () {
  			$j(this).find("div.block").show();
		});
			
	$j("div.icon").live("mouseout", 
		function () {
  			$j(this).find("div.block").hide();
  		});
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Раскрытие формы добавления группы
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j("#template-group-create-link").live("click", function(){
		$j("#template-group-create-div").slideToggle(300);
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Раскрытие группы шаблонов
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j("div.tree_arrow_close").click(function(){
		$j(this).parent().parent().parent().find("div.group-template-list").toggle();
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Добавление шаблона
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#template-button-create").click(function () {
		
		var name 		= $j("#template-name").val();
		var filename 	= $j("#template-filename").val();
		var group 		= $j("#template-group").val();
		var css 		= $j("#template-css").val();
		var description = $j("#template-description").val();
		
		if ((name!="")&&(filename!="")&&(group!=""))
			$j.ajax({
				url: "/admin/modules/template/handler/template-create.handler.php",
				type: "POST",
				data: ({				
					
					name		:	name,
					filename	:	filename,
					group		:	group,
					css			:	css,
					description	:	description
				}),
				success: function(msg) {
					
					msg = parseInt(msg);
					
					if (msg>0) {
						alert("Шаблон успешно добавлен.");
						document.location = sess+"section=template";
					}
					else {
						alert("При добавлении шаблона возникла ошибка. Возможно, файл с таким именем уже существует.");
					}
				
				}
			});
		else
			alert("Все поля, отмеченные звездочками, должны быть заполнены.");
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Добавление группы шаблонов
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#template-group-button-create").click(function () {
		
		var name = $j("#template-group-name").val();
		
		if (name!="")
			$j.ajax({
				url: "/admin/modules/template/handler/group-create.handler.php",
				type: "POST",
				data: ({				
					
					name : name
				}),
				success: function(msg) {
				
					if (msg!=0) {
						var div = $j(".template-group-list-item:first").clone(true).insertAfter(".template-group-list-item:last");
						$j(div).find("[name=id_group]").val(msg);
						$j(div).find("a.under").text(name);
						$j(div).find(".template-group-name").val(name);
						$j(div).slideDown(300);
					}
					else
						alert("Ошибка. Невозможно добавить группу.");
				
				}
			});
		else
			alert("Пожалуйста, введите название группы.");
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Удаление группы шаблонов
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".drop-menu-delete-group").live("click", function () {
		
		var div = $j(this).parent().parent().parent().parent().parent().parent().parent();
		var id_group = $j(div).find("[name=id_group]").val();
		var name = $j(div).find("a.under:first").text();
		
		if (id_group!=0)
		
			if (confirm("Вы действительной хотите удалить группу \""+name+"\" и все содержащиеся в ней шаблоны?"))
			
				$j.ajax({
					url: "/admin/modules/template/handler/group-delete.handler.php",
					type: "POST",
					data: ({				
						
						id_group : id_group
					}),
					success: function(msg) {
					
						if (msg==1) {
							$j(div).slideUp(300)
							setTimeout(function(){
								$j(div).remove();
							}, 300);
						}
						else
							alert("Ошибка. Невозможно удалить группу.");
					
					}
				});
		
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Переход к переименованию группы шаблонов
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".drop-menu-rename-group").live("click", function () {
		
		var div = $j(this).parent().parent().parent().parent().parent().parent().parent();
		
		$j(div).find("div.tree_arrow_close").hide();
		$j(div).find("div.template-group-rename-div").show();
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Отмена переименования группы шаблонов
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("button.template-group-button-cancel").live("click", function () {
		
		var div = $j(this).parent().parent().parent();
		
		$j(div).find("div.template-group-rename-div").hide();
		$j(div).find("div.tree_arrow_close").show();
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Отмена переименования группы шаблонов
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("button.template-group-button-rename").live("click", function () {
		
		var div = $j(this).parent().parent().parent().parent().parent();
		
		var id_group = $j(div).find("[name=id_group]").val();
		var name = $j(div).find("[name=group_name]").val();
		
		if (name!="") {
		
			$j.ajax({
				url: "/admin/modules/template/handler/group-update.handler.php",
				type: "POST",
				data: ({				
					
					id_group 	:	id_group,
					name		:	name
				}),
					success: function(msg) {
					
						if (msg==1) {
							
							alert("Группа успешно была переименована.");
							$j(div).find("a.under:first").text(name);
							$j(div).find("div.template-group-rename-div").hide();
							$j(div).find("div.tree_arrow_close").show();
						}
						else
							alert("Ошибка. Невозможно переименовать группу.");					
					}
				});
		}		
		else
			alert("Пожалуйста, введите название группы.");
				
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Удаление шаблона
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".drop-menu-delete-template").live("click", function () {
		
		var div = $j(this).parent().parent().parent().parent().parent().parent();
		var id_template = $j(div).find("[name=id_template]").val();
		var name = $j(div).find(".template-list-item-name").text();
		
		if (id_template!=0)
		
			if (confirm("Вы действительной хотите удалить шаблон \""+name+"\"?"))
			
				$j.ajax({
					url: "/admin/modules/template/handler/template-delete.handler.php",
					type: "POST",
					data: ({				
						
						id_template : id_template
					}),
					success: function(msg) {
					
						if (msg==1) {
							$j(div).slideUp(300)
							setTimeout(function(){
								$j(div).remove();
							}, 300);
						}
						else
							alert("Ошибка. Невозможно удалить шаблон.");
					
					}
				});
		
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Переход к редактированию шаблона
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".drop-menu-edit-template").live("click", function () {
		
		var div = $j(this).parent().parent().parent().parent().parent().parent();
		var id_template = $j(div).find("[name=id_template]").val();
		
		if (id_template!=0)
		
			document.location = sess+"section=template&action=edit&id="+id_template;		
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Сохранение шаблона
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#template-button-update").click(function () {
		
		var id_template	= $j("#template-id").val();
		var name 		= $j("#template-name").val();
		var filename 	= $j("#template-filename").val();
		var group 		= $j("#template-group").val();
		var css 		= $j("#template-css").val();
		var description = $j("#template-description").val();
		
		if ((id_template!=0)&&(id_template!="")&&(name!="")&&(filename!="")&&(group!=""))
			$j.ajax({
				url: "/admin/modules/template/handler/template-update.handler.php",
				type: "POST",
				data: ({				
					
					id_template	:	id_template,
					name		:	name,
					filename	:	filename,
					group		:	group,
					css			:	css,
					description	:	description
				}),
				success: function(msg) {
				
					if (msg==1) {
						alert("Шаблон успешно сохранен.");
						//document.location = sess+"section=template";
					}
					else
						alert("При сохранении шаблона возникла ошибка.");
				
				}
			});
		else
			alert("Все поля, отмеченные звездочками, должны быть заполнены.");
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			
});