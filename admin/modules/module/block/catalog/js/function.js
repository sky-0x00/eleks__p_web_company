//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события готовности документа
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$j(document).ready(function(){
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Подключаем форматирование
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  	
	$j(".form-textarea").each(function(){
		
		$j(this).wysiwyg({
    			controls : {
         			bold          : { visible : true, tags : ['b', 'strong'], css : { fontWeight : 'bold' } },
            		italic        : { visible : true, tags : ['i', 'em'], css : { fontStyle : 'italic' } },
            		strikeThrough : { visible :  true },
            		underline     : { visible :  true },

            		separator00 : { visible :  true },

            		justifyLeft   : { visible :  true },
            		justifyCenter : { visible :  true },
            		justifyRight  : { visible :  true},
            		justifyFull   : { visible :  true },

            		separator01 : { visible :  true},

            		indent  : { visible :  true },
            		outdent : { visible :  true },

            		separator02 : { visible :  true },

            		subscript   : { visible :  true },
            		superscript : { visible :  true},
	
            		separator03 : { visible :  true },

            		undo : { visible :  true },
            		redo : { visible :  true },

            		separator04 : { visible :  true },

            		insertOrderedList    : { visible :  true },
            		insertUnorderedList  : { visible :  true },
            		insertHorizontalRule : { visible :  true },
            	
            		separator06 : { separator : true },
            	
            		createLink :	{ visible :  true },
					insertImage :	{ visible :  true },
				
            		separator07 : { visible : true},
            	
            		cut   : { visible : true },
            		copy  : { visible : true},
            		paste : { visible : true },
            		html : {visible : false}
    			}
			});
			
		$j(this).parent().find("div.wysiwyg").hide();		
		$j(this).show();
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Переключение между обычным режимом и режимом редактора
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j("[name=redactor_toggle]").live("click", function(){
		
		var div = $j(this).parent();
		
		if ($j(this).filter(":checked").length > 0) {
			$j("textarea", div).hide();
			
			var width = parseInt($j("textarea", div).css("width"));
			$j("div.wysiwyg", div).css("width", (width-10)+"px");
			$j("div.wysiwyg iframe", div).css("width", "100%");
			
			var height = parseInt($j("textarea", div).css("height"));
			$j("div.wysiwyg", div).css("height", (height-10)+"px");
			$j("div.wysiwyg iframe", div).css("min-height", (height-50) + "px");
			
			var content = $j("textarea", div).val();
			$j("textarea", div).wysiwyg('setContent', content);
			
			$j("div.wysiwyg", div).show();
		}
		else {
			$j("div.wysiwyg", div).hide();
			$j("textarea", div).show();
		}
			
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Добавление новой родительской категории
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#add-new-parent-cat").click(function(){
		$j("#catalog-new-parent-div").slideToggle(300);
	});
	
	$j("#parent-cat-button-cancel").click(function(){
		$j("#catalog-new-parent-div").slideUp(300);
	});
	
	$j("#parent-cat-button-submit").click(function(){
		
		var name = $j(this).parent().parent().find("[name=cat_name]").val();
		
		if (name!="") {
		
			$j.ajax({
				url: "/admin/modules/module/block/catalog/handler/cat-create.handler.php",
				type: "POST",
				dataType : "json",
				data: ({
					name 	: 	name,
					pid 	: 	0
				}),
				
				beforeSend: function(){
					//Loading(true);
				},
				
				success: function(response){
					
					//Loading(false);
					
					if (response.result=="success") {
						
						var li = $j("li.cat-list-item:first").clone(true);
						
						var href = $j(li).find("> .cat-item-div a").attr("href") + response.text;
						
						$j(li).appendTo("#cat-list > ul");
						
						$j(li).find("> .cat-item-div a").text(name).attr("href", href);
						$j(li).find("> .cat-item-div [name=cat_id]").val(response.text);
						$j(li).show();
						$j(li).find("> .cat-item-div").show();
					}
					else if (response.result=="error")
						alert(response.text);
					else
						alert(response);
				},
				
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					
					//Loading(false);					
					alert(textStatus);
				}
			});
		}
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Добавление новой категории
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".cat-button-create").live("click", function(){
		var li_insert = $j("li.cat-list-item:first").clone(true);
		var li_parent = $j(this).parent().parent().parent();

		if ($j(li_parent).find("> ul").length == 0)
			$j(li_parent).append("<ul></ul>");
			
		if ($j(li_parent).find("> ul").length > 0) {
			$j(li_parent).find("> ul").append(li_insert);
			$j(li_insert).show();
			$j(li_insert).find(".cat-edit-div").show();
		}
		else
			$j(li_insert).remove();
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Сохранение новой категории
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".cat-button-apply").live("click", function(){
	
		var li = $j(this).parent().parent().parent();
		var name = $j(this).parent().parent().find("[name=cat_name]").val();
		var pid = $j(li).parent().parent().find("> div > [name=cat_id]").val();
		
		if ((name!="")&&(pid!="")&&(pid>0)) {
		
			$j.ajax({
				url: "/admin/modules/module/block/catalog/handler/cat-create.handler.php",
				type: "POST",
				dataType : "json",
				data: ({
					name 	: 	name,
					pid 	: 	pid
				}),
				
				beforeSend: function(){
					//Loading(true);
				},
				
				success: function(response){
					
					//Loading(false);
					
					if (response.result=="success") {
						
						var href = $j(li).find("> .cat-item-div a").attr("href") + response.text;						
							
						$j(li).find("> .cat-item-div a").text(name).attr("href", href);
						$j(li).find("> .cat-item-div [name=cat_id]").val(response.text);
						$j(li).find("> .cat-edit-div").hide();
						$j(li).find("> .cat-item-div").show();						
					}
					else if (response.result=="error")
						alert(response.text);
					else
						alert(response);
				},
				
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					
					//Loading(false);					
					alert(textStatus);
				}
			});
		}
		else {
			alert("Empty name or pid.");
		}
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Отмена добавления новой категории
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".cat-button-cancel").live("click", function(){
		
		$j(this).parent().parent().parent().remove();
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Переход к редактированию категории
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".cat-button-edit").live("click", function(){
	
		var id = $j(this).parent().parent().find("> [name=cat_id]").val();
		
		if ((id!="")&&(id>0)) {
		
			var args = getArgs();
						
			document.location = sess + "section=module&type="+args.type+"&action=category&id="+id;
		}
	});
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Удаление категории
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".cat-button-delete").live("click", function(){
		
		var li = $j(this).parent().parent().parent();
		var id = $j(this).parent().parent().find("> [name=cat_id]").val();
		var name = $j(this).parent().parent().find("> div > a").text();
		
		if ((id!="")&&(id>0)) {
		
			if (confirm("Вы действительно хотите удалить категорию \""+name+"\" и все содержащиеся в ней подкатегории и элементы?" )) {
			
				$j.ajax({
					url: "/admin/modules/module/block/catalog/handler/cat-delete.handler.php",
					type: "POST",
					dataType : "json",
					data: ({
						id : id
					}),
					
					success: function(response){
					
						if (response.result=="success") {
							
							var ul = $j(li).parent();
							$j(li).remove();							
						}
						else if (response.result=="error")
							alert(response.text);
						else
							alert(response);
					},
					
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						
						alert(textStatus);
					}
				});
			}
		}
		else {
			alert("Empty id.");
		}
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик клика по ссылке "Добавить поле"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#cat-add-field").click(function(){
			
		$j(".cat-field:first").clone(true).insertAfter(".cat-field:last").slideDown(300);	
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Подсветка фона под "карандашом", "крестиком", "дискетой" и т.п.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("div.input-fields-button-delete,div.input-fields-button-save").live("mouseover",
		function () {
  			$j(this).css({
    			backgroundColor: "#FFFFFF"
  				});
			});
			
	$j("div.input-fields-button-delete,div.input-fields-button-save").live("mouseout", 
		function () {
  			$j(this).css({
    			backgroundColor: ""
  				});	
  		});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Изменение полей
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	/*$j(".cat-field input,.cat-field textarea,.cat-field select").live("change", function(){
		
		var div = $j(this).parent().parent();
		
		if (!div.hasClass("changed")) {		
			div.css("background-color", "#ebc2af").addClass("changed");
		}
	});*/
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки "Удалить" в списке полей
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".input-fields-button-delete").click(function() {
		
		var btn = this;
		var id_field = $j(btn).parent().parent().find("input:hidden").val();
			
		if (id_field==0) {
			$j(btn).parent().parent().slideUp(300);
			setTimeout(function(){
					$j(btn).parent().parent().remove();
				}, 300);
		}
		else {
				
			if (confirm("Вы действительно хотите удалить выбранное поле?")) 
				$j.ajax({
					
					url: "/admin/modules/module/block/catalog/handler/field-delete.handler.php",
					type: "POST",
					dataType: "json",
					data: ({
						id_field : id_field
					}),
						
					success: function(response) {
				
						if (response.result=="success") {
							$j(btn).parent().parent().slideUp(300);
							setTimeout(function(){
								$j(btn).parent().parent().remove();
							}, 300);
						}
						else if (response.result=="error")
							alert(response.text);
						else
							alert(response);
					},
					
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						
						alert(textStatus);
					}
				});	
		}		
				
	});
    	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки "Сохранить" в списке полей
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".input-fields-button-save").click(function(){
		
		//if ($j(this).parent().parent().hasClass("changed")) {
		
			var id_field 	= $j(this).parent().parent().find("input:hidden[name=id_field]").val();
			var type 		= $j(this).parent().parent().find("[name=id_input]").val();			
			var name 		= $j(this).parent().parent().find("input:text[name=name]").val();
			var title 		= $j(this).parent().parent().find("input:text[name=title]").val();
			var options 	= $j(this).parent().parent().find("textarea[name=options]").val();
			var empty 		= ($j(this).parent().parent().find("input:checkbox[name=empty]:checked").length>0) ? 0 : 1;
			
			var id_cat = $j("#cat-id").val();
			var btn = this;
			
			if (id_field==0) {
				
				$j.ajax({
					
					url: "/admin/modules/module/block/catalog/handler/field-create.handler.php",
					type: "POST",
					dataType: "json",
					data: ({

						id_cat	: id_cat,
						name 	: name,
						title	: title,
						type 	: type,
						options	: options,
						empty	: empty
					}),
					
					success: function(response){
					
						if (response.result=="success") {
							//$j(btn).parent().parent().css("background-color", "#c9ecb1").removeClass("changed");
							$j(btn).parent().parent().find("input:hidden").val(response.text);
						}
						else if (response.result=="error") {
							//alert(response.text);
						}
						else
							alert(response);
					},
					
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						
						alert(textStatus);
					}
				});
			}
			else {
				
				$j.ajax({
					
					url: "/admin/modules/module/block/catalog/handler/field-update.handler.php",
					type: "POST",
					dataType: "json",
					data: ({

						id_field 	: id_field,
						id_cat		: id_cat,
						name 		: name,
						title		: title,
						type 		: type,
						options		: options,
						empty		: empty
					}),
					success: function(response){
					
						if (response.result=="success") {
							//$j(btn).parent().parent().css("background-color", "#c9ecb1").removeClass("changed");
						}
						else if (response.result=="error") {
							//alert(response.text);
						}
						else
							alert(response)
					},
					
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						
						alert(textStatus);
					}
				});
			}		
		//}	
	
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события сохранения категории
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $j("#cat-button-submit").click(function(){
    	
		var id_cat 	= $j("#cat-id").val();
    	var name 	= $j("#cat-name").val();		
    	var sort 	= $j("#cat-sort").val();		
    	var active 	= ($j("#cat-active:checked").length > 0) ? 1 : 0;		
		
		if (name!="") {
		
			$j.ajax({
				url: "/admin/modules/module/block/catalog/handler/cat-update.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					id_cat	: id_cat,
					name 	: name,					
					sort 	: sort,					
					active 	: active					
				}),
				
				success: function(response){
					
					$j(".input-fields-button-save").not(":first").click();
					
					if (response.result=="success") {
						$j("#cat-head").text(name);
						alert("Сохранено.");
					}					
					else if (response.result=="error")
						alert(response.text);
					else
						alert(response);										
				},
				
				error: function(XMLHttpRequest, textStatus, errorThrown) {
						
					alert(textStatus);
				}
			});
    	}
	});
      
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки добавления фотографии пользователя
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if ($j("#item-photo-button-browse").length) {
		
		var upload = new AjaxUpload("#item-photo-button-browse", {
 		
			action: "/admin/modules/module/block/catalog/handler/item-upload-image.handler.php",
  			name: "newfile",
  			responseType: "json",
  			autoSubmit: false,
			
  			onChange: function(file, ext) {
  				$j("#item-photo-new-file").val(file);
  			},
			
  			onSubmit: function(file, ext){
				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
					// extension is not allowed
                    alert('Error: invalid file extension');
                    // cancel upload
                    return false;
				}
			},
			
			onComplete: function(file, response) {
				
				if (response.result=="success") {
					$j("#item-img-div input:hidden").val(response.text.name);
					$j("#item-img-div img").attr("src", response.text.src);
				}
				else if (response.result=="error")
					alert(response.text);
				else
					alert(response);
			}
		});
		
		$j("#item-photo-button-add").click(function(){		
			
			upload.submit();
			
			$j("#item-photo-new-file").val("");
			
			return false;
		});
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки добавления элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#item-button-create").click(function(){
					
		var id_cat 		= $j("#item-cat").val();
		var name 		= $j("#item-name").val();
		var active 		= ($j("#item-active:checked").length>0) ? 1 : 0;
		var description	= $j("#item-description").val();
		var image		= $j("#item-photo").val();
		
		if ((id_cat!="") && (id_cat>0) && (name!="")) {
				
			$j.ajax({
						
				url: "/admin/modules/module/block/catalog/handler/item-create.handler.php",
				type: "POST",
				dataType: "json",
					
				data: ({
					id_cat		: id_cat,
					name		: name,
					active		: active,
					description	: description,
					image		: image
				}),
					
				error: function(xhr, status) {
					
   	 				var errinfo = { errcode: status };
        				
					if (xhr.status != 200) {
            			// может быть статус 200, а ошибка
            			// из-за некорректного JSON
            			errinfo.message = xhr.statusText;
        			} 
					else {
            			errinfo.message = 'Некорректные данные с сервера';
        			}
        			
					var msg = "Ошибка "+errinfo.errcode;
        				
					if (errinfo.message)
        				msg = msg + ' :'+errinfo.message;
        			
					alert(msg);
  				},
  					
				success: function(response){
						
					if (response.result=="success") {							
							
						var args = getArgs();
						
						alert("Элемент успешно добавлен. Можете перейти к редактированию.");
						
						document.location = sess + "section=module&type="+args.type+"&action=edit&id="+response.text;
					}
					else
						if (response.result=="error")
							alert(response.text);
						else
							alert(response);
				}
			});		
		}
		else
			alert("Поля \"Название\" и \"Артикул\" должны быть заполнены.");
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Переход к редактированию элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j(".item-edit").click(function(){
		
		var args = getArgs();
						
		document.location = sess + "section=module&type="+args.type+"&action=edit&id="+$j(this).parent().parent().find("[name=id_item]").val();
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки сохранения элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#item-button-submit").click(function(){
		
		var input_array = new Object();
			
		input_array['id_item'] 		= $j("#item-id").val();
		input_array['id_cat'] 		= $j("#item-cat").val();
		input_array['name'] 		= $j("#item-name").val();
		input_array['active'] 		= ($j("#item-active:checked").length>0) ? 1 : 0;
		input_array['description']	= $j("#item-description").val();
		input_array['image']		= $j("#item-photo").val();
					
		if ((input_array.id_item!="") && (input_array.id_item>0) && (input_array.name!="")) {
			
			$j("#item-properties").find("input,textarea,select").each(function(){
				input_array["property_"+$j(this).attr("name")] = $j(this).val();
			});
			
			$j.ajax({
					
				url: "/admin/modules/module/block/catalog/handler/item-update.handler.php",
				type: "POST",
				dataType: "json",
				data: input_array,
					
				success: function(response){
						
					if (response.result=="success") {
						alert("Сохранено.");
					}
					else if (response.result=="error")
						alert(response.text);
					else
						alert(response);	
				},
					
				error: function(XMLHttpRequest, textStatus, errorThrown) {
							
					alert(textStatus);
				}
			});				
		}
		else 
			alert("Поля \"Название\" и \"Артикул\" должны быть заполнены.");
		
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки удаления элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".item-delete").click(function(){
		
		var tr = $j(this).parent().parent().parent();		
		var id_item = $j("[name=id_item]", tr).val();
			
		if (confirm("Вы действительно хотите удалить выбранный элемент?")) {
			
			$j.ajax({
					
				url: "/admin/modules/module/block/catalog/handler/item-delete.handler.php",
				type: "POST",
				dataType: "json",
				data: {
					id_item	: id_item
				},
						
				error: function(xhr, status) {
					
   	 				var errinfo = { errcode: status };
						
        			if (xhr.status != 200) {
           				// может быть статус 200, а ошибка
           				// из-за некорректного JSON
           				errinfo.message = xhr.statusText;
        			} 
					else {
           				errinfo.message = 'Некорректные данные с сервера';
        			}
        				
        			var msg = "Ошибка "+errinfo.errcode;
						
        			if (errinfo.message)
        				msg = msg + ' :'+errinfo.message;
							
        			alert(msg);
  				},	
  				
				success: function(response){
						
					if (response.result=="success") {
						tr.remove();
					}
					else if (response.result=="error")
						alert(response.text);
					else
						alert(response);		
				}
			});
		}		
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Сохранение параметров
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#settings-submit").click(function(){
		
		var per_page = $j("#per-page").val();
		
		if ((per_page!="")&&(per_page>0)) {
			
			$j.ajax({
				
				url: "/admin/modules/module/block/catalog/handler/settings-update.handler.php",
				type: "POST",
				dataType: "json",
				data: {
					per_page : per_page
				},
						
				error: function(xhr, status) {
					
   	 				var errinfo = { errcode: status };
						
        			if (xhr.status != 200) {
           				// может быть статус 200, а ошибка
           				// из-за некорректного JSON
           				errinfo.message = xhr.statusText;
        			} 
					else {
           				errinfo.message = 'Некорректные данные с сервера';
        			}
        				
        			var msg = "Ошибка "+errinfo.errcode;
						
        			if (errinfo.message)
        				msg = msg + ' :'+errinfo.message;
							
        			alert(msg);
  				},	
  				
				success: function(response){
						
					if (response.result=="success") {
						alert(response.text);
					}
					else if (response.result=="error")
						alert(response.text);
					else
						alert(response);		
				}
			});
		}
		else {
			alert("Количество элементов на странице должно быть больше 0.");
		}
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки добавления фотографии для элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if ($j("#object-photo-button-browse").length) {
		
		var upload1 = new AjaxUpload("#object-photo-button-browse", {
 		
			action: "/admin/modules/module/block/catalog/handler/photo-upload.handler.php",
  			name: "newfile",
  			responseType: "json",
  			autoSubmit: false,
  			onChange: function(file, ext) {
  				$j("#object-photo-new-file").val(file);
  			},
  			onSubmit: function(file, ext){
				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
					// extension is not allowed
                    alert('Error: invalid file extension');
                    // cancel upload
                    return false;
				}
			},
			onComplete: function(file, response) {
				
				if (response.result=="success") {
				
					$j(".object-photo-div:first").clone(true).insertAfter(".object-photo-div:last");
					$j(".object-photo-div:last").find("[name=id_photo]").val(response.text.id_photo);
					$j(".object-photo-div:last").find("img").attr("src", response.text.photo);
					$j(".object-photo-div:last").fadeIn(500);
				}
				else if (response.result=="error")
					alert(response.text);
				else
					alert(response);
					
				$j("#object-photo-new-file").val("");
			}
		});
	}
	
	$j("#object-photo-button-add").click(function(){		
	
		var id_item = $j("#item-id").val();
			
		upload1.setData({
			"id_item" : id_item
		});	
		
		upload1.submit();
		
		$j("#object-photo-new-file").val("");
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки "Удалить" в списке фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".object-photo-button-delete").click(function(){
		
		var btn = this;
		var id_photo = $j(btn).parent().parent().find("input:hidden").val();
			
		if (confirm("Вы действительно хотите удалить выбранную фотографию?")) 
			
			$j.ajax({
					
				url: "/admin/modules/module/block/catalog/handler/photo-delete.handler.php",
				dataType: "json",
				type: "POST",
				data: ({

					id_photo : id_photo
				}),
					
				error: function(xhr, status) {
					
   	 				var errinfo = { errcode: status };
						
        			if (xhr.status != 200) {
            			// может быть статус 200, а ошибка
            			// из-за некорректного JSON
            			errinfo.message = xhr.statusText;
        			} 
					else {
            			errinfo.message = 'Некорректные данные с сервера';
        			}
        				
        			var msg = "Ошибка "+errinfo.errcode;
						
        			if (errinfo.message)
        				msg = msg + ' :'+errinfo.message;
							
					alert(msg);
  				},	
					
				success: function(response){
					
					if (response.result=="success") {
						
						$j(btn).parent().parent().fadeOut(500)
						setTimeout(function(){
							$j(btn).parent().parent().remove();
						}, 500);
							
					}
					else
						if (response.result=="error")
							alert(response.text);
						else
							alert(response);
				}
			});

		return false;			
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Очистка полей формы и фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j("#item-fields-empty").click(function(){
		EmptyItemForm();
	});
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
});

function Loading(is_loading) {
	(is_loading) ? $j("#loading").show() : $j("#loading").hide();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Процедура очистки полей формы
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function EmptyItemForm() {
	
	$j("#item-name,#item-photo-new-file,#item-photo").val("");
	
	$j("#item-image").attr("src", "");
	$j("#item-description").wysiwyg('setContent', "");
	
	$j("#item-active")[0].checked = false;
	$j("#item-new")[0].checked = false;
	$j("#item-leader")[0].checked = false;
			
	return true;
};