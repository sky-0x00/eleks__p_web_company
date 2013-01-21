//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события готовности документа
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$j(document).ready(function(){
	
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
//	Обработчик события выбора объекта из списка
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#object-list").change(function(){                                           
 			
   		var id_object = $j(this).val();
   			
		if (id_object > 0){
   				
   			EmptyForm();
   				
   			$j.ajax({
				url: "/admin/modules/module/block/objects/handler/object-get-details.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					id_object : id_object
				}),
					
				success: function(response){
						
					if (response) {
							
						$j("#object-id").val(response.id_object);
						$j("#object-type").val(response.id_type);
						$j("#object-name").val(response.name);
						$j("#object-town").val(response.town);
						$j("#object-primary")[0].checked = (response.primary>0);
						$j("#object-short_description").wysiwyg('setContent', response.short_description);
						$j("#object-description").wysiwyg('setContent', response.description);
						$j("#object-picture").val(response.picture);
						$j("#object-image").attr("src", response.image);						
												
						LoadPhotos(response.photos);
					}					
				},
					
				error: function(XMLHttpRequest, textStatus, errorThrown) {
							
					alert(textStatus);
				}
			});            	
		}
		else {
            
			$j("#object-picture").val("");
			$j("#object-image").attr("src", "");
			ClearPhotos();
			//EmptyItemForm();            	
		}
	}).change();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события добавления объекта
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $j("#object-button-create").click(function(){
    		
    	var id_type 			= $j("#object-type").val();
		var name 				= $j("#object-name").val();
		var town 				= $j("#object-town").val();
		var primary 			= ($j("#object-primary:checked").length>0) ? 1 : 0;
		var short_description	= $j("#object-short_description").val();
		var description			= $j("#object-description").val();
		var picture 			= $j("#object-picture").val();
		
		$j("#object-list").val(0);
		$j("[name=id_price]").val(0);
		
		if ((id_type!="") && (name!="") && (description!="") && (short_description!="")) {
		
			$j.ajax({
				url: "/admin/modules/module/block/objects/handler/object-create.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					id_type				: id_type,
					name				: name,
					town				: town,
					short_description	: short_description,
					description			: description,
					primary				: primary,
					picture 			: picture					
				}),
				
				success: function(response){
														
					if (response.result=="success") {
					
						$j("#object-id").val(response.text);
						
						$j("#object-list").loadSelect(response.objects);
						$j("#object-list").val(response.text);
						$j("#object-list").change();
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
		else {
			alert("Заполните все поля, отмеченные звездочкой.");
		}
		
	});
      	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки сохранения элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#object-button-submit").click(function(){
		
		var id_object 			= $j("#object-list").val();
		var id_type 			= $j("#object-type").val();
		var name 				= $j("#object-name").val();
		var town 				= $j("#object-town").val();
		var primary 			= ($j("#object-primary:checked").length>0) ? 1 : 0;
		var short_description	= $j("#object-short_description").val();
		var description			= $j("#object-description").val();
		var picture 			= $j("#object-picture").val();
		
		if ((id_object!="") && (id_object>0) && (id_type!="") && (name!="") && (description!="") && (short_description!="")) {
		
			$j.ajax({
				url: "/admin/modules/module/block/objects/handler/object-update.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					id_object			: id_object,
					id_type				: id_type,
					name				: name,
					town				: town,
					short_description	: short_description,
					description			: description,
					primary				: primary,
					picture 			: picture					
				}),
				
				success: function(response){
				
					if (response.result=="success") {
						$j("#object-list").loadSelect(response.objects);
						$j("#object-list").val(id_object);
						$j("#object-list").change();
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
		else {
			if ((id_object=="") || (id_object==0))
				alert("Выберите редактируемый элемент.");
			else
				alert("Заполните все поля, отмеченные звездочкой.");
		}
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки удаления элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#object-button-delete").click(function(){
		
		var id_object = $j("#object-list").val();
			
		if (id_object > 0) {
		
			if (confirm("Вы действительно хотите удалить выбранный объект?")) {
			
				$j.ajax({
					
					url: "/admin/modules/module/block/objects/handler/object-delete.handler.php",
					type: "POST",
					dataType: "json",
					data: {
						id_object : id_object
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
							$j("#object-list").loadSelect(response.objects);
							$j("#object-list").val(0);
							EmptyForm();
						}
						else if (response.result=="error")
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

	if ($j("#object-photo-button-browse").length) {
		
		var upload = new AjaxUpload("#object-photo-button-browse", {
 		
			action: "/admin/modules/module/block/objects/handler/photo-upload.handler.php",
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
				else
					if (response.result=="error")
						alert(response.text);
					else
						alert(response);
			}
		});
	}
	
	$j("#object-photo-button-add").click(function(){		
	
		var id_object = $j("#object-id").val();
			
		upload.setData({
			"id_object" : id_object
		});	
		
		upload.submit();
		
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
					
				url: "/admin/modules/module/block/objects/handler/photo-delete.handler.php",
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
//	Обработчик события нажатия кнопки добавления картинки для объекта
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if ($j("#object-picture-button-browse").length) {
		
		var _upload = new AjaxUpload("#object-picture-button-browse", {
 		
			action: "/admin/modules/module/block/objects/handler/object-upload-photo.handler.php",
  			name: "newfile",
  			responseType: "json",
  			autoSubmit: false,
  			onChange: function(file, ext) {
  				$j("#object-picture-new-file").val(file);
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
					$j("#object-img-div:last").find("input:hidden").val(response.text.name);
					$j("#object-img-div:last").find("img").attr("src", response.text.src);
				}
				else
					if (response.result=="error")
						alert(response.text);
					else
						alert(response);
			}
		});
	}
	
	$j("#object-picture-button-add").click(function(){		
			
		_upload.submit();
		
		$j("#object-picture-new-file").val("");
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
	
	$j("#object-id").val(0);
	$j("#object-name").val("");
	$j("#object-town").val("");
	$j("#object-primary")[0].checked = false;
	$j("#object-picture").val("");
	$j("#object-image").attr("src", "");
	$j("#object-type").val("");
	$j("#object-short_description").wysiwyg('setContent', "");
	$j("#object-description").wysiwyg('setContent', "");
	$j("#object-picture-new-file").val("");
	
	ClearPhotos();
	
	return true;
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, загружающая список фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function LoadPhotos(data) {
	
	$j.each(data, function(index, item){		
		$j(".object-photo-div:first").clone(true).insertAfter(".object-photo-div:last");
		$j(".object-photo-div:last").show().find("[name=id_photo]").val(item.id_photo);
		$j(".object-photo-div:last").find("img").attr("src", item.photo);
	});
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, очищающая список фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ClearPhotos() {
	
	$j(".object-photo-div").not(":first").remove();	
};
