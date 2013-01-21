//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события готовности документа
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$j(document).ready(function(){
	
	$j("#item-button-submit").hide();
	$j("#item-button-delete").hide();
			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Подсветка фона
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("div.cat-list-item").live("mouseover", function () {
  		$j(this).css({
    		backgroundColor: "#E1D7C0"
  		});
	});
			
	$j("div.cat-list-item").live("mouseout", function () {
  		$j(this).css({
    		backgroundColor: "#FFFFFF"
  			});	
  	});
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Всплывающее меню
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("div.icon").live("mouseover", function () {
  		$j(this).find("div.block").show();
	});
			
	$j("div.icon").live("mouseout", function () {
  		$j(this).find("div.block").hide();
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
		
		if (name!="")
		
			$j.ajax({
				url: "/admin/modules/module/block/menu/handler/cat-create.handler.php",
				type: "POST",
				dataType : "json",
				data: ({
					sess_id	: sess_id,
					name 	: 	name,
					pid 	: 	0
				}),
				
				beforeSend: function(){
					//Loading(true);
				},
				
				success: function(response){
					
					//Loading(false);
					
					if (response.result=="success") {
						
						$j(".cat-list-item:first").clone(true).insertAfter(".cat-list-item:last");
						
						$j(".cat-list-item:last [name=id_cat]").val(response.text);
						$j(".cat-list-item:last .cat-name").text(name);
						href = $j(".cat-list-item:last .cat-name").attr("href") + response.text;
						$j(".cat-list-item:last .cat-name").attr("href", href);
						$j(".cat-list-item:last").show();
					}
					else
						if (response.result=="error")
							alert(response.text);
						else
							alert(response);
				},
				
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					
					//Loading(false);					
					alert(textStatus);
				}
			});		
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Удаление категории
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".drop-menu-delete-cat").live("click", function () {
		
		var div = $j(this).parent().parent().parent().parent().parent().parent();
		var id_cat = $j(div).find("[name=id_cat]").val();
		var name = $j(div).find(".cat-name").text();
		
		if (id_cat!=0)
		
			if (confirm("Вы действительной хотите удалить категорию \""+name+"\"?"))
			
				$j.ajax({
					url: "/admin/modules/module/block/menu/handler/cat-delete.handler.php",
					type: "POST",
					dataType : "json",
					data: ({
						sess_id	: sess_id,
						id_cat 	: id_cat
					}),
					
					success: function(response) {
					
						if (response.result=="success") {
							
							$j(div).slideUp(300);
							
							setTimeout(function(){
									$j(div).remove();
								}, 300);
						}
						else
							if (response.result=="error")
								alert(response.text);
							else
								alert(response);
					},
				
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						
						//Loading(false);					
						alert(textStatus);
					}
				});
		
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Переход к редактированию категории
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".drop-menu-edit-cat").live("click", function () {
		
		var div = $j(this).parent().parent().parent().parent().parent().parent();
		var id_cat = $j(div).find("[name=id_cat]").val();
		
		if (id_cat!=0)
		
			document.location = document.location+"&edit="+id_cat;		
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик клика по ссылке "добавить подкатегорию"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#add-subcat").click(function(){			
		$j(".subcat-div:first").clone(true).insertAfter(".subcat-div:last").slideDown(300);	
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Подсветка фона под "карандашом", "крестиком", "дискетой" и т.п.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("div.subcat-button-delete,div.subcat-button-save").live("mouseover", function () {
  		$j(this).css({
    		backgroundColor: "#FCAD81"
  		});
	});
			
	$j("div.subcat-button-delete,div.subcat-button-save").live("mouseout", function () {
  		$j(this).css({
    		backgroundColor: "#FFFFFF"
  		});	
  	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки "Удалить" в списке подкатегорий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".subcat-button-delete").click(function() {
		
			var btn = this;
			var id_cat = $j(btn).parent().parent().find("input:hidden[name=id_cat]").val();
			
			if (id_cat==0) {
				$j(btn).parent().parent().slideUp(300);
				setTimeout(function(){
						$j(btn).parent().parent().remove();
					}, 300);
			}
			else {
				
				if (confirm("Вы действительно хотите удалить выбранную подкатегорию и все элементы в ней?")) 
					
					$j.ajax({
					
						url: "/admin/modules/module/block/menu/handler/cat-delete.handler.php",
						type: "POST",
						dataType: "json",
						data: ({
							sess_id	: sess_id,
							id_cat 	: id_cat
						}),
						
						success: function(response) {
					
							if (response.result=="success") {
								$j(btn).parent().parent().slideUp(300);
								setTimeout(function(){
									$j(btn).parent().parent().remove();
								}, 300);
							}
							else
								if (response.result=="error")
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
//	Обработчик события нажатия кнопки "Сохранить" в списке подкатегорий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".subcat-button-save").click(function(){
		
			var id_cat 	= $j(this).parent().parent().find("input:hidden[name=id_cat]").val();
			var name 	= $j(this).parent().parent().find("input:text[name=name]").val();
			
			var pid 	= $j("#cat-id").val();
			var btn = this;
			
			if (id_cat==0) {
				
				$j.ajax({
					
					url: "/admin/modules/module/block/menu/handler/cat-create.handler.php",
					type: "POST",
					dataType: "json",
					data: ({
						sess_id	: sess_id,
						pid		: pid,
						name 	: name
					}),
					
					success: function(response){
					
						if (response.result=="success") {
							$j(btn).parent().parent().find("input:hidden[name=id_cat]").val(response.text);	
						}
						else
							if (response.result=="error")
								alert(response.text);
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
					
					url: "/admin/modules/module/block/menu/handler/cat-update.handler.php",
					type: "POST",
					dataType: "json",
					data: ({
						sess_id	: sess_id,
						id_cat	: id_cat,
						name 	: name
					}),
					success: function(response){
						if (response.result=="error")
							alert(response.text);
						else
							if (response.result=="success");
							else
								alert(response)
					},
					
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						
						alert(textStatus);
					}
				});
			}		
				
		});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события сохранения категории
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $j("#cat-button-submit").click(function(){
    		
    	var name = $j("#cat-name").val();
		
		if (name!="") {
		
			$j.ajax({
				url: "/admin/modules/module/block/menu/handler/cat-update.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					sess_id	: sess_id,
					id_cat	: $j("#cat-id").val(),
					name 	: name					
				}),
				
				success: function(response){
					
					if (response.result=="success") {
						$j("#cat-head").text(name);
						alert("Сохранено.");
					}					
					else
						if (response.result=="error")
							alert(response.text);
						else
							alert(response);
							
					$j(".subcat-button-save").not(":first").click();
				},
				
				error: function(XMLHttpRequest, textStatus, errorThrown) {
						
					alert(textStatus);
				}
			});
    	}
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Подключаем форматирование
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  	
	$j('.form-textarea').each(function(){
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
			$j(div).find("textarea").hide();
			
			var width = parseInt($j(div).find("textarea").css("width"));
			$j(div).find("div.wysiwyg").css("width", (width-10)+"px");
			$j(div).find("div.wysiwyg iframe").css("width", "100%");
			
			var height = parseInt($j(div).find("textarea").css("height"));
			$j(div).find("div.wysiwyg").css("height", (height-10)+"px");
			$j(div).find("div.wysiwyg iframe").css("min-height", (height-50) + "px");
			
			var content = $j(div).find("textarea").val();
			$j(div).find("textarea").wysiwyg('setContent', content);
			
			$j(div).find("div.wysiwyg").show();
		}
		else {
			$j(div).find("div.wysiwyg").hide();
			$j(div).find("textarea").show();
		}
			
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события клика по флагу "добавить рецепт"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j("#item-recipe").click(function(){
		if (this.checked) {
			$j("#item-recipe-div").slideDown(500);
		}
		else {
			$j("#item-recipe-div").slideUp(500);
		}
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события выбора элемента из списка
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#item-list").change(function(){                                           
 			
   		var id_item = $j(this).val();
   			
		if (id_item > 0){
   				
   			EmptyForm();
   			$j("#item-button-create").hide();
			$j("#item-button-submit").show();
			$j("#item-button-delete").show();
			
   			$j.ajax({
				url: "/admin/modules/module/block/menu/handler/item-get-details.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					sess_id	: sess_id,
					id_item : id_item
				}),
					
				success: function(response){
						
					if (response.result=="success") {
							
						$j("#item-id").val(response.text.id_item);
						$j("#item-cat").val(response.text.id_cat);
						$j("#item-name").val(response.text.name);
						$j("#item-portion").val(response.text.portion);
						$j("#item-price").val(response.text.price);
						
						if (response.text.recipe > 0) {
							$j("#item-recipe")[0].checked = true;
							$j("#item-recipe-div").show();
						}
						else {
							$j("#item-recipe")[0].checked = false;
							$j("#item-recipe-div").hide();
						}
						
						$j("#item-annot").wysiwyg('setContent', response.text.annot);
						$j("#item-description").wysiwyg('setContent', response.text.description);
						$j("#item-picture").val(response.text.picture);
						$j("#item-image").attr("src", response.text.image);
												
						LoadPhotos(response.text.photos);
					}					
					else
						if (response.result=="error")
							alert(response.text);
						else
							alert(response);								
				},
					
				error: function(XMLHttpRequest, textStatus, errorThrown) {
							
					alert(textStatus);
				}
			});            	
		}
		else {
            
			$j("#item-picture").val("");
			$j("#item-image").attr("src", "");
			$j("#item-button-create").show();
			$j("#item-button-submit").hide();
			$j("#item-button-delete").hide();
			ClearPhotos();
			//EmptyForm();            	
		}
	})
	.change();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события добавления элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $j("#item-button-create").click(function(){
    		
    	var id_cat 		= $j("#item-cat").val();
		var name 		= $j("#item-name").val();
		var annot 		= $j("#item-annot").val();
		var portion 	= $j("#item-portion").val();
		var price 		= $j("#item-price").val();
		var recipe 		= ($j("#item-recipe")[0].checked) ? 1 : 0; 
		var description	= $j("#item-description").val();
		var picture 	= $j("#item-picture").val();
		
		$j("#item-list").val(0);
		$j("[name=id_price]").val(0);
		
		if ( (id_cat!="") && (name!="") && (portion!="") && (price!="") &&
			(((recipe>0)&&(description!="")&&(picture!="")) || (recipe==0)) ) {
		
			$j.ajax({
				url: "/admin/modules/module/block/menu/handler/item-create.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					sess_id		: sess_id,
					pid			: $j("#cat-id").val(),
					id_cat		: id_cat,
					name		: name,
					annot		: annot,
					portion		: portion,
					price		: price,
					recipe		: recipe,
					description	: description,
					picture 	: picture					
				}),
				
				success: function(response){
														
					if (response.result=="success") {
					
						$j("#item-id").val(response.text);
						
						$j("#item-list").loadSelect(response.items);
						$j("#item-list").val(response.text);
						$j("#item-list").change();
						
						alert("Сохранено.");
					}					
					else {
						if (response.result=="error")
							alert(response.text);
						else
							alert(response);												
					}
				},
				
				error: function(XMLHttpRequest, textStatus, errorThrown) {
						
					alert(textStatus);
				}
			});
    	}
	});
      	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки сохранения элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#item-button-submit").click(function(){
		
		var id_item 	= $j("#item-list").val();
		var id_cat 		= $j("#item-cat").val();
		var name 		= $j("#item-name").val();
		var annot 		= $j("#item-annot").val();
		var portion 	= $j("#item-portion").val();
		var price 		= $j("#item-price").val();
		var recipe 		= ($j("#item-recipe")[0].checked) ? 1 : 0; 
		var description	= $j("#item-description").val();
		var picture 	= $j("#item-picture").val();
		
		if ( (id_item!="") && (id_item>0) && (id_cat!="") && (name!="") && (portion!="") && (price!="") &&
			(((recipe>0)&&(description!="")&&(picture!="")) || (recipe==0)) ) {
		
			$j.ajax({
				url: "/admin/modules/module/block/menu/handler/item-update.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					sess_id		: sess_id,
					pid			: $j("#cat-id").val(),
					id_item		: id_item,
					id_cat		: id_cat,
					name		: name,
					annot		: annot,
					portion		: portion,
					price		: price,
					recipe		: recipe,
					description	: description,
					picture 	: picture					
				}),
				
				success: function(response){
				
					if (response.result=="success") {
						
						$j("#item-list").loadSelect(response.items);
						$j("#item-list").val(id_item);
						$j("#item-list").change();
						
						alert("Сохранено.");
					}					
					else {
						if (response.result=="error")
							alert(response.text);
						else
							alert(response);
					}					
				},
				
				error: function(XMLHttpRequest, textStatus, errorThrown) {
						
					alert(textStatus);
				}
			});
    	}
		else
			if ((id_item=="") || (id_item==0))
				alert("Выберите редактируемый элемент.");
			else
				alert("Все обязательные поля должны быть заполнены.");
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки удаления элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#item-button-delete").click(function(){
		
		var id_item = $j("#item-list").val();
			
		if (id_item > 0) {
		
			if (confirm("Вы действительно хотите удалить выбранный элемент?")) {
			
				$j.ajax({
					
					url: "/admin/modules/module/block/menu/handler/item-delete.handler.php",
					type: "POST",
					dataType: "json",
					data: {
						sess_id	: sess_id,
						id_item	: id_item,
						pid		: $j("#cat-id").val()
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
							$j("#item-list").loadSelect(response.items);
							$j("#item-list").val(0);
							EmptyForm();
						}
						else
							if (response.result=="error")
								alert(response.text);
							else
								alert(response);		
					}
				});
			}
		}
		else
			alert("Выберите удаляемый элемент.");
	});
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки добавления фотографии для элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if ($j("#item-photo-button-browse").length) {
		
		var upload = new AjaxUpload("#item-photo-button-browse", {
 		
			action: "/admin/modules/module/block/menu/handler/photo-upload.handler.php",
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
				
					$j(".item-photo-div:first").clone(true).insertAfter(".item-photo-div:last");
					$j(".item-photo-div:last").find("[name=id_photo]").val(response.text.id_photo);
					$j(".item-photo-div:last").find("img").attr("src", response.text.photo);
					$j(".item-photo-div:last").fadeIn(500);
				}
				else
					if (response.result=="error")
						alert(response.text);
					else
						alert(response);
			}
		});
	}
	
	$j("#item-photo-button-add").click(function(){		
	
		var id_item = $j("#item-id").val();
			
		upload.setData({
			"sess_id"	: sess_id,
			"id_item" 	: id_item
		});	
		
		upload.submit();
		
		$j("#item-photo-new-file").val("");
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки "Удалить" в списке фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".item-photo-button-delete").click(function(){
		
		var btn = this;
		var id_photo = $j(btn).parent().parent().find("input:hidden").val();
			
		if (confirm("Вы действительно хотите удалить выбранную фотографию?")) 
			
			$j.ajax({
					
				url: "/admin/modules/module/block/menu/handler/photo-delete.handler.php",
				dataType: "json",
				type: "POST",
				data: ({
					sess_id		: sess_id,
					id_photo 	: id_photo
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
//	Обработчик события нажатия кнопки добавления картинки для объекта
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if ($j("#item-picture-button-browse").length) {
		
		var _upload = new AjaxUpload("#item-picture-button-browse", {
 		
			action: "/admin/modules/module/block/menu/handler/item-upload-photo.handler.php",
  			name: "newfile",
  			responseType: "json",
  			autoSubmit: false,
  			onChange: function(file, ext) {
  				$j("#item-picture-new-file").val(file);
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
					$j("#item-img-div").find("input:hidden").val(response.text.name);
					$j("#item-img-div").find("img").attr("src", response.text.src);
				}
				else
					if (response.result=="error")
						alert(response.text);
					else
						alert(response);
			}
		});
	}
	
	$j("#item-picture-button-add").click(function(){		
		
		_upload.setData({
			"sess_id" : sess_id
		});
		
		_upload.submit();
		
		$j("#item-picture-new-file").val("");
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Очистка полей формы и фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j("#item-fields-empty").click(function(){
		$j("#item-list").val(0);
		EmptyForm();
	});
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
});

function Loading(is_loading) {
	(is_loading) ? $j("#loading").show() : $j("#loading").hide();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Процедура очистки полей формы
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function EmptyForm() {
	
	$j("#item-id").val(0);
	$j("#item-name").val("");
	$j("#item-portion").val("");
	$j("#item-price").val("");
	$j("#item-recipe")[0].checked = false;;
	$j("#item-picture").val("");
	$j("#item-image").attr("src", "");
	$j("#item-annot").wysiwyg('setContent', "");
	$j("#item-description").wysiwyg('setContent', "");
	$j("#item-picture-new-file").val("");
	
	$j("#item-button-create").show();
	$j("#item-button-submit").hide();
	$j("#item-button-delete").hide();
	
	ClearPhotos();
	
	return true;
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, загружающая список фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function LoadPhotos(data) {
	
	$j.each(data, function(index, item){		
		$j(".item-photo-div:first").clone(true).insertAfter(".item-photo-div:last");
		$j(".item-photo-div:last").show().find("[name=id_photo]").val(item.id_photo);
		$j(".item-photo-div:last").find("img").attr("src", item.photo);
	});
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, очищающая список фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ClearPhotos() {
	
	$j(".item-photo-div").not(":first").remove();	
};
