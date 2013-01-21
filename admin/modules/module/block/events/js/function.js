//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события готовности документа
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$j(document).ready(function(){
	
	$j("#event-button-submit").hide();
	$j("#event-button-delete").hide();
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Подключаем календарь
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j.datepicker.setDefaults(
        $j.extend($j.datepicker.regional["ru"])
  	);
  	
  	$j("#event-date").datepicker({
  		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd",
		yearRange: "1920:2030"
  	});
	
	$j("#ui-datepicker-div").css("z-index", "1000");
	
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
//	Обработчик события выбора года из списка
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#year-list").change(function(){                                           
 			
   		var year = $j(this).val();
   		$j("#event-list").emptySelect();
		EmptyForm();
		
		if (year > 0){ 				
   				
   			$j.ajax({
				url: "/admin/modules/module/block/events/handler/event-get-items.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					sess_id	: sess_id,
					year 	: year
				}),
					
				success: function(response){
						
					if (response.result=="success") {
							
						$j("#event-list").loadSelect(response.text);
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
            $j("#event-button-create").show();
			$j("#event-button-submit").hide();
			$j("#event-button-delete").hide();
			//EmptyForm();            	
		}
	})
	.change();
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события выбора мероприятия из списка
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#event-list").change(function(){                                           
 			
   		var id_event = $j(this).val();
   			
		if (id_event > 0){
   				
   			EmptyForm();
			$j("#event-button-create").hide();
			$j("#event-button-submit").show();
			$j("#event-button-delete").show();
   				
   			$j.ajax({
				url: "/admin/modules/module/block/events/handler/event-get-details.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					sess_id		: sess_id,
					id_event 	: id_event
				}),
					
				success: function(response){
						
					if (response.result=="success") {
							
						$j("#event-id").val(response.text.id_event);
						$j("#event-title").val(response.text.title);
						$j("#event-annot").wysiwyg('setContent', response.text.annot);
						$j("#event-text").wysiwyg('setContent', response.text.text);
						$j("#event-date").val(response.text.date);

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
            $j("#event-button-create").show();
			$j("#event-button-submit").hide();
			$j("#event-button-delete").hide();
			ClearPhotos();			
			//EmptyForm();            	
		}
	})
	.change();
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки сохранения мероприятия
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#event-button-submit").click(function(){
		
		var id_event = $j("#event-id").val();
		var title = $j("#event-title").val();
		var annot = $j("#event-annot").val();
		var text = $j("#event-text").val();
		var date = $j("#event-date").val();
			
		var year = date.substr(0, 4);
			
		if ( (id_event!="") && (id_event>0) && (title!="") && (text!="") && (date!="") ) {
			
			$j.ajax({
					
				url: "/admin/modules/module/block/events/handler/event-update.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					sess_id		: sess_id,
					id_event	: id_event,
					title		: title,
					annot		: annot,
					text		: text,
					date		: date
				}),
					
				success: function(response){
						
					if (response.result=="success") {
							
						$j("#year-list").loadSelect(response.years).val(year).change();
						alert(response.text);
						setTimeout(function(){$j("#event-list").val(id_event).change();}, 100);
					}
					else
						if (response.result=="error")
							alert(response.text);
						else
							alert(response);	
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
  				}
			});				
		}
		else
			if ((id_event!="") && (id_event>0))
				alert("все поля должны быть заполнены.");
			else
				alert("Редактируемый элемент не выбран.");
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки добавления мероприятия
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#event-button-create").click(function(){
		
		var title = $j("#event-title").val();
		var annot = $j("#event-annot").val();
		var text = $j("#event-text").val();
		var date = $j("#event-date").val();
			
		var year = date.substr(0, 4);
			
		if ( (title!="") && (text!="") && (date!="") ) {
				
			$j.ajax({
						
				url: "/admin/modules/module/block/events/handler/event-create.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					sess_id	: sess_id,
					title	: title,
					annot	: annot,
					text	: text,
					date	: date
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
							
						var id_event = parseInt(response.text);
							
						$j("#year-list").loadSelect(response.years).val(year).change();
						alert("Добавлено.");
						setTimeout(function(){$j("#event-list").val(id_event).change();}, 100);
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
			alert("Все поля должны быть заполнены.");
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки удаления мероприятия
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#event-button-delete").click(function(){
		
		var id_event = $j("#event-list").val();
		var year = $j("#year-list").val();
		
		if ((id_event != "")&&(id_event > 0)) {
				
			if (confirm("Вы действительно хотите удалить выбранное мероприятие?")) {
				
				$j.ajax({
						
					url: "/admin/modules/module/block/events/handler/event-delete.handler.php",
					type: "POST",
					dataType: "json",
					data: {
						sess_id		: sess_id,
						id_event 	: id_event
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
												
							$j("#year-list").loadSelect(response.years).val(year).change();
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
			alert("Выберите удаляемое мероприятие.");
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки добавления фотографии для элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if ($j("#event-photo-button-browse").length) {
		
		var upload = new AjaxUpload("#event-photo-button-browse", {
			
		action: "/admin/modules/module/block/events/handler/photo-upload.handler.php",
		name: "newfile",
		responseType: "json",
		autoSubmit: false,
		onChange: function(file, ext) {
			$j("#event-photo-new-file").val(file);
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
				
				$j(".event-photo-div:first").clone(true).insertAfter(".event-photo-div:last");
				$j(".event-photo-div:last").find("[name=id_photo]").val(response.text.id_photo);
				$j(".event-photo-div:last").find("img").attr("src", response.text.photo);
				$j(".event-photo-div:last").fadeIn(500);
			}
			else
				if (response.result=="error")
					alert(response.text);
				else
					alert(response);
			}
		});		
	}	
	
	$j("#event-photo-button-add").click(function(){		
	
		var id_event = $j("#event-id").val();
		
		if (id_event > 0) {		
		
			upload.setData({
				"sess_id"	: sess_id,
				"id_event" 	: id_event
			});						
			
			upload.submit();
		}
		else {
			alert("Сначала выберите или создайте элемент.");
		}
		
		$j("#event-photo-new-file").val("");
	});
			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки "Удалить" в списке фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".event-photo-button-delete").click(function(){
		
		var btn = this;
		var id_photo = $j(btn).parent().parent().find("input:hidden").val();
			
		if (confirm("Вы действительно хотите удалить выбранную фотографию?")) 
			
			$j.ajax({
					
				url: "/admin/modules/module/block/events/handler/photo-delete.handler.php",
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
//	Очистка полей формы
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j("#event-fields-empty").click(function(){
		$j("#year-list").val(0).change();
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
	
	$j("#event-id").val(0);
	$j("#event-title").val("");
	$j("#event-annot").wysiwyg('setContent', "");
	$j("#event-text").wysiwyg('setContent', "");
	$j("#event-date").val("");
	
	ClearPhotos();
	
	return true;
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, загружающая список фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function LoadPhotos(data) {
	
	$j.each(data, function(index, item){		
		$j(".event-photo-div:first").clone(true).insertAfter(".event-photo-div:last");
		$j(".event-photo-div:last").show().find("[name=id_photo]").val(item.id_photo);
		$j(".event-photo-div:last").find("img").attr("src", item.photo);
	});
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, очищающая список фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ClearPhotos() {
	
	$j(".event-photo-div").not(":first").remove();	
};
