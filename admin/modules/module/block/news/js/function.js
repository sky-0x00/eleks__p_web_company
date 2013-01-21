//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события готовности документа
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$j(document).ready(function(){

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Подключаем календарь
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j.datepicker.setDefaults(
        $j.extend($j.datepicker.regional["ru"])
  	);
  	
  	$j("#article-date").datepicker({
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
   		$j("#article-list").emptySelect();
		EmptyForm();
		
		if (year > 0){ 				
   				
   			$j.ajax({
				url: "/admin/modules/module/block/news/handler/article-get-items.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					year : year
				}),
					
				success: function(response){
						
					if (response.result=="success") {
							
						$j("#article-list").loadSelect(response.text);
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
            
			//EmptyForm();            	
		}
	}).change();
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события выбора статьи из списка
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#article-list").change(function(){                                           
 			
   		var id_article = $j(this).val();
   			
		if (id_article > 0){
   				
   			EmptyForm();
   				
   			$j.ajax({
				url: "/admin/modules/module/block/news/handler/article-get-details.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					id_article : id_article
				}),
					
				success: function(response){
						
					if (response.result=="success") {
							
						$j("#article-id").val(response.text.id_article);
						$j("#article-title").val(response.text.title);
						$j("#article-annot").wysiwyg('setContent', response.text.annot);
						$j("#article-text").wysiwyg('setContent', response.text.text);
						$j("#article-date").val(response.text.date);														
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
            	
			//EmptyForm();            	
		}
	})
	.change();
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки сохранения статьи
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#article-button-submit").click(function(){
		
		var id_article = $j("#article-id").val();
		var title = $j("#article-title").val();
		var annot = $j("#article-annot").val();
		var text = $j("#article-text").val();
		var date = $j("#article-date").val();
			
		var year = date.substr(0, 4);
			
		if ((id_article!="") && (id_article>0) && (title!="") && (annot!="") && (text!="") && (date!="")) {
			
			$j.ajax({
					
				url: "/admin/modules/module/block/news/handler/article-update.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					id_article	: id_article,
					title		: title,
					annot		: annot,
					text		: text,
					date		: date
				}),
					
				success: function(response){
						
					if (response.result=="success") {
							
						$j("#year-list").loadSelect(response.years).val(year).change();
						alert(response.text);
						setTimeout(function(){$j("#article-list").val(id_article).change();}, 100);
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
			if ((id_article!="") && (id_article>0))
				alert("все поля должны быть заполнены.");
			else
				alert("Редактируемый элемент не выбран.");
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки добавления статьи
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#article-button-create").click(function(){
		
		var title = $j("#article-title").val();
		var annot = $j("#article-annot").val();
		var text = $j("#article-text").val();
		var date = $j("#article-date").val();
			
		var year = date.substr(0, 4);
			
		if ((title!="") && (annot!="") && (text!="") && (date!="")) {
				
			$j.ajax({
						
				url: "/admin/modules/module/block/news/handler/article-create.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
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
							
						var id_article = parseInt(response.text);
							
						$j("#year-list").loadSelect(response.years).val(year).change();
						alert("Добавлено.");
						setTimeout(function(){$j("#article-list").val(id_article).change();}, 100);
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
//	Обработчик события нажатия кнопки удаления статьи
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#article-button-delete").click(function(){
		
		var id_article = $j("#article-list").val();
		var year = $j("#year-list").val();
		
		if ((id_article != "")&&(id_article > 0)) {
				
			if (confirm("Вы действительно хотите удалить выбранную статью?")) {
				
				$j.ajax({
						
					url: "/admin/modules/module/block/news/handler/article-delete.handler.php",
					type: "POST",
					dataType: "json",
					data: {
						id_article : id_article
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
			alert("Выберите удаляемую статью.");
	});
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Очистка полей формы
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j("#article-fields-empty").click(function(){
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
	
	$j("#article-id").val(0);
	$j("#article-title").val("");
	$j("#article-annot").wysiwyg('setContent', "");
	$j("#article-text").wysiwyg('setContent', "");
	$j("#article-date").val("");
		
	return true;
};
