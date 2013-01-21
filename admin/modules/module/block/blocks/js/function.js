//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события готовности документа
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$j(document).ready(function(){
	
	$j("#module-blocks-submit").hide();
	$j("#module-blocks-delete").hide();
				
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Подключаем календарь
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j.datepicker.setDefaults(
        $j.extend($j.datepicker.regional["ru"])
  	);
  	
  	$j("#module-blocks-datepicker").datepicker({
  		changeMonth: true,
		changeYear: true,
		dateFormat: "dd.mm.yy",
		yearRange: "1920:2020"
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
//	Обработчик клика по ссылке "Добавить новый тип"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#module-blocks-newtypetoggle").click(function(){
			
			$j("#module-blocks-newtypediv").slideToggle("slow");
		});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик клика по ссылке "Добавить изображение"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#module-blocks-image-new-toggle").click(function(){
			
			$j("#module-blocks-image-new-div").slideToggle("slow");
		});
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик клика по ссылке "Список фотографий:"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#module-blocks-image-list-toggle").click(function(){
			
			$j("#module-blocks-image-list").slideToggle("slow");
		});
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик клика по ссылке "Список полей:"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#module-blocks-showtypefields").click(function(){
			
			$j("#module-blocks-type-fields-div").slideToggle(500);
		});
			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик клика по ссылке "Очистить"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#module-blocks-emptyform").click(function(){
			
			$j("#module-blocks-block-list").val(0);
			EmptyBlockForm();
		});
			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик клика по ссылке "Добавить поле"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#module-blocks-addnewfield").click(function(){
			
			$j(".module-blocks-field:first").clone(true).css({
					display: "none"
				}).insertAfter(".module-blocks-field:last").slideDown(500);
			
		});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Подсветка фона под "карандашом", "крестиком", "дискетой" и т.п.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("div.delete,a.edit,div.module-blocks-fields-button-delete,div.module-blocks-fields-button-save").live("mouseover",
		function () {
  			$j(this).css({
    			backgroundColor: "#FCAD81"
  				});
			});
			
	$j("div.delete,a.edit,div.module-blocks-fields-button-delete,div.module-blocks-fields-button-save").live("mouseout", 
		function () {
  			$j(this).css({
    			backgroundColor: "#FFFFFF"
  				});	
  		});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события добавления нового блока
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $j("#module-blocks-addnewtype").click(function(){
    		
    		var name = $j("#module-blocks-new-type-name").val();
    		var title = $j("#module-blocks-new-type-title").val();
    		
    		$j.ajax({
				url: "/admin/modules/module/block/blocks/handler/block-create.handler.php",
				type: "POST",
				data: ({

					name 	: 	name,
					title 	: 	title

				}),
				success: function(data){
					
					if (data!=0)
						AddBlock(data, title);	
				}
			});
    	
    	});
    	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки "Удалить" в списке полей
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".module-blocks-fields-button-delete").click(function(){
		
			var btn = this;
			var id_field = $j(btn).parent().parent().find("input:hidden").val();
			
			if (id_field==0) {
				$j(btn).parent().parent().slideUp(300)
				setTimeout(function(){
						$j(btn).parent().parent().remove();
					}, 300);
			}
			else {
				
				if (confirm("Вы действительно хотите удалить выбранное поле?")) 
					$j.ajax({
					
						url: "/admin/modules/module/block/blocks/handler/field-delete.handler.php",
						type: "POST",
						data: ({

							id_field : id_field
						}),
						success: function(data){
					
							if (data) {
								$j(btn).parent().parent().slideUp(300)
								setTimeout(function(){
									$j(btn).parent().parent().remove();
								}, 300);
							}	
						}
					});	
			}		
				
		});
    	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки "Сохранить" в списке полей
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".module-blocks-fields-button-save").click(function(){
		
			var id_field 	= $j(this).parent().parent().find("input:hidden[name=id_field]").val();
			var id_type 	= $j(this).parent().parent().find("[name=id_input]").val();			
			var name 		= $j(this).parent().parent().find("input:text[name=name]").val();
			var title 		= $j(this).parent().parent().find("input:text[name=title]").val();
			var empty 		= $j(this).parent().parent().find("input:checkbox[name=empty]").filter(":checked").val();
			
			var id_block = $j("#module-blocks-type-id").val();
			var btn = this;
			
			if (id_field==0) {
				
				$j.ajax({
					
					url: "/admin/modules/module/block/blocks/handler/field-create.handler.php",
					type: "POST",
					data: ({

						id_block	: 	id_block,
						name 		: 	name,
						title		:	title,
						empty		:	empty,
						id_type 	: 	id_type
					}),
					success: function(data){
					
						if (data)
							$j(btn).parent().parent().find("input:hidden").val(data);	
					}
				});
			}
			else {
				
				$j.ajax({
					
					url: "/admin/modules/module/block/blocks/handler/field-update.handler.php",
					type: "POST",
					data: ({

						id_field 	: 	id_field,
						id_block	: 	id_block,
						name 		: 	name,
						title		:	title,
						empty		:	empty,
						id_type 	: 	id_type
					}),
					success: function(data){
						
					}
				});
			}		
				
		});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события сохранения блока
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $j("#module-blocks-type-submit").click(function(){
    		
    		var name = $j("#module-blocks-type-name").val();
    		var title = $j("#module-blocks-type-title").val();
    		var photo = $j("#module-blocks-type-photo:checked").val();
    		
			$j.ajax({
				url: "/admin/modules/module/block/blocks/handler/block-update.handler.php",
				type: "POST",
				data: ({

					id_block	:	$j("#module-blocks-type-id").val(),
					name 		: 	name,
					title 		: 	title,
					photo		:	photo

				}),
				success: function(data){
					
					if (data)
						$j("#module-blocks-type-head").text(title);
					
					$j(".module-blocks-fields-button-save").click();
				}
			});
    	
    	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события выбора элемента в списке блоков
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#module-blocks-type-list").change(function(){                                           
 			
   			var block_id = $j(this).val();
   			if (block_id > 0){
   				
   				EmptyBlockForm();
   				
   				$j.getJSON("/admin/modules/module/block/blocks/handler/content-get-list.handler.php", {id: block_id},
            		function(data){
            			
            				$j("#module-blocks-block-list").loadSelect(data);
							$j("#module-blocks-block-list").val(0);
							$j("#module-blocks-type-id").val(block_id);
            		});
            		
            	$j.getJSON("/admin/modules/module/block/blocks/handler/block-get-fields.handler.php", {id: type_id},
            		function(data){
            			
            				GenerateBlockForm(data);
            		});
            }
            else {
            	
            	EmptyBlockForm();
            	$j("#module-blocks-block-list").emptySelect();
            	$j("#module-blocks-content-form").empty();
            }
      	})
      	.change();
      	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события выбора элемента блока из списка
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#module-blocks-block-list").change(function(){                                           
 			
   			var content_id = $j(this).val();
   			if (content_id > 0){
   				
   				EmptyBlockForm();
   				ClearPhotos();
				
				$j("#module-blocks-create").hide();
				$j("#module-blocks-submit").show();
				$j("#module-blocks-delete").show();
				
   				$j("#module-blocks-image-form").slideDown(300);
   				
   				var text = $j("#module-blocks-block-list option:selected").text();
   				$j("#module-blocks-block-name").val(text);
   				$j("#module-blocks-block-id").val(content_id);
   				$j("#module-blocks-image-new-block-id").val(content_id);
   				
   				$j.ajax({
					url: "/admin/modules/module/block/blocks/handler/content-get-details.handler.php",
					type: "GET",
					dataType: "json",
					data: ({
						id: content_id
					}),
					
            		success: function(response){
						
						$j.each(response, function (index, item){
            				if (item.type=="checkbox")
          						$j("#module-blocks-content-form").find("[name="+item.name+"]")[0].checked = (item.content=="Y");
          					else
          						if (item.type=="textarea") {
          							$j("#module-blocks-content-form").find("[name="+item.name+"]").wysiwyg('setContent', item.content);
								}
          						else
          							$j("#module-blocks-content-form").find("[name="+item.name+"]").val(item.content);
        				});
					},
					
					error: function(XMLHttpRequest, textStatus, errorThrown) {
								
						//alert(textStatus);
					}
					
				});
            		
            	$j.getJSON("/admin/modules/module/block/blocks/handler/photo-get-list.handler.php", {id: content_id},
            		function(data){
            			LoadPhotos(data);
            		});
            	
            }
            else {
            	
				$j("#module-blocks-create").show();
				$j("#module-blocks-submit").hide();
				$j("#module-blocks-delete").hide();
            	//EmptyBlockForm();
            	
            }
      	})
      	.change();
      	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки сохранения элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#module-blocks-submit").click(function(){
		
			var input_array = new Object();
			
			input_array["id_content"] = $j("#module-blocks-block-list").val();
			input_array["content_name"] = $j("#module-blocks-block-name").val();
			
			$j("#module-blocks-content-form").find("input,textarea,select").each(function(){
					input_array[$j(this).attr("name")] = $j(this).val();
				});
			
			$j.ajax({
					
					url: "/admin/modules/module/block/blocks/handler/content-update.handler.php",
					type: "POST",
					dataType: "json",
					data: input_array,
					success: function(data){
						
						$j("#module-blocks-block-list").loadSelect(data);
						$j("#module-blocks-block-list").val(input_array.id_content);	
					}
				});		
				
		});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки добавления элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#module-blocks-create").click(function(){
		
			var input_array = new Object();
			
			input_array["id_block"] = $j("#module-blocks-type-id").val();
			input_array["content_name"] = $j("#module-blocks-block-name").val();
			
			$j("#module-blocks-content-form").find("input,textarea,select").each(function(){
					input_array[$j(this).attr("name")] = $j(this).val();
				});
			
			$j.ajax({
					
				url: "/admin/modules/module/block/blocks/handler/content-create.handler.php",
				type: "POST",
				dataType: "json",
				data: (input_array),
				
				error: function(xhr, status) {
   	 					var errinfo = { errcode: status }
        				if (xhr.status != 200) {
            				// может быть статус 200, а ошибка
            				// из-за некорректного JSON
            				errinfo.message = xhr.statusText
        				} else {
            				errinfo.message = 'Некорректные данные с сервера'
        				}
        				var msg = "Ошибка "+errinfo.errcode
        				if (errinfo.message)
        					msg = msg + ' :'+errinfo.message
        				alert(msg)

  					},
  					
				success: function(data){
					
					$j("#module-blocks-block-list").loadSelect(data);
					$j("#module-blocks-block-list").val(0);
					ClearPhotos();
				}
			});		
				
		});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки удаления элемента
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#module-blocks-delete").click(function(){
		
			var id_content = $j("#module-blocks-block-list").val();
			var id_block = $j("#module-blocks-type-id").val();
			
			if (id_content > 0)
				$j.ajax({
					
					url: "/admin/modules/module/block/blocks/handler/content-delete.handler.php",
					type: "POST",
					dataType: "json",
					data: {
						id_content	: id_content,
						id_block	: id_block
						},
						
					error: function(xhr, status) {
   	 					var errinfo = { errcode: status }
        				if (xhr.status != 200) {
            				// может быть статус 200, а ошибка
            				// из-за некорректного JSON
            				errinfo.message = xhr.statusText
        				} else {
            				errinfo.message = 'Некорректные данные с сервера'
        				}
        				
        				var msg = "Ошибка "+errinfo.errcode
        				if (errinfo.message)
        					msg = msg + ' :'+errinfo.message
        				alert(msg)
  					},	
  					
					success: function(data){
						
						$j("#module-blocks-block-list").loadSelect(data);
						$j("#module-blocks-block-list").val(0);
						EmptyBlockForm();
						ClearPhotos();		
					}
				});		
				
		});
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки добавления фотографии
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if ($j("#module-blocks-image-button-browse").length) {
		
		var upload = new AjaxUpload("#module-blocks-image-button-browse", {
 		
			action: "/admin/modules/module/block/blocks/handler/photo-upload.handler.php",
  			name: "newfile",
  			responseType: "json",
  			autoSubmit: false,
  			onChange: function(file, ext){
  				$j("#module-blocks-image-new-file").val(file);
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
				if (response) {
					AddNewPhoto();
					$j(".module-blocks-photo-div:last").find("[name=id_image]").val(response.id_photo);
					$j(".module-blocks-photo-div:last").find("img").attr("src", response.image);
					$j(".module-blocks-photo-div:last").fadeIn(500);
				}
			}
		});
	}
	
	$j("#module-blocks-image-button-add").click(function(){
		
		var id = $j("#module-blocks-image-new-block-id").val();
			
		if (id!=0) {
			
			upload.setData({
				"id" 	: id
			});	
			upload.submit();	
		}
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки "Удалить" в списке фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".module-blocks-image-button-delete").click(function(){
		
			var btn = this;
			var id_photo = $j(btn).parent().parent().find("input:hidden").val();
			
			if (confirm("Вы действительно хотите удалить выбранную фотографию?")) 
				$j.ajax({
					
					url: "/admin/modules/module/block/blocks/handler/photo-delete.handler.php",
					type: "POST",
					data: ({

						id : id_photo
					}),
					success: function(data){
					
						if (data) {
							$j(btn).parent().parent().fadeOut(300)
							setTimeout(function(){
								$j(btn).parent().parent().remove();
							}, 300);
						}	
					}
				});

			return false;			
		});
    	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
});


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Процедура очистки полей формы
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function EmptyBlockForm() {
	
	$j("#module-blocks-create").show();
	$j("#module-blocks-submit").hide();
	$j("#module-blocks-delete").hide();
				
	$j("#module-blocks-block-name").val("");
	$j("#module-blocks-block-id").val("");
	
	$j("#module-blocks-content-form").find("input:text").each(function(){
			$j(this).val("");
		});
	$j("#module-blocks-content-form").find("input:checkbox").each(function(){
			if ($j(this).attr("name")!="redactor_toggle")
				this.checked = false;
		});
		
	$j("#module-blocks-content-form").find("textarea").each(function(){
			$j(this).wysiwyg('setContent', "");
		});
	$j("#module-blocks-content-form").find("select").each(function(){
			$j(this).val("");
		});
	
	return true;
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, преобразующая дату из формата DATETIME в формат "dd.mm.yyyy"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ConvertDate(str) {
	
	var year = str.substr(0, 4);
	var month = str.substr(5, 2);
	var day = str.substr(8, 2);
	
	return day+"."+month+"."+year;	
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, добавляющая в таблицу новый блок
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function AddBlock(data, name) {
	
	var sess = $j("#session").val();
	var module = $j("#module-type").val();
	
	var part1 = "<tr id=\"tr"+data+"\"><td><a href=\""+sess+"section=module&type="+module+"&content="+data+"\">";
	var part2 = "</a></td><td><div class=\"action-menu\">";
	var part3 = "<a class=\"edit\" href=\""+sess+"section=module&type="+module+"&block="+data+"\"></a>"
	var part4 = "<div class=\"delete\" onclick=\"deleteBlock("+data+", '"+name+"')\"></div></div></td></tr>" 
	
	$j("#module-blocks-typetbody").append(part1+name+part2+part3+part4);
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, удаляющая блок
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function deleteBlock(id_block, name) {
	
	if (confirm("Вы действительно хотите удалить \""+name+"\"?"))
		$j.ajax({
				url: "/admin/modules/module/block/blocks/handler/block-delete.handler.php",
				type: "POST",
				data: ({

					id_block 	: 	id_block

				}),
				success: function(data){
					
					if (data)
						$j("#tr"+id_block).remove();		
				}
			});	
	else
		return false;
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, генерирующая форму для определенного типа статьи
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function GenerateBlockForm(fields) {
	
	$j("#module-blocks-datepicker").remove();
	$j("#module-blocks-content-form").empty();
	
	$j.each(fields, function(index, item){
	
		var title = "<br><div class=\"span\">"+item.title+":</div>";
		var field = "";
		
		switch (item.type) {
		
			case "textarea":
				field = "<textarea class=\"form-textarea\" style=\"width: 500px; height: 200px;\" name=\""+item.name+"\"></textarea>";
				break;
				
			case "text":
				field = "<input class=\"form-text\" style=\"width: 490px;\" type=\""+item.type+"\" name=\""+item.name+"\" />";
				break;
				
			case "date":
				field = "<input type=\"text\" class=\"form-text\" id=\"module-blocks-datepicker\" name=\""+item.name+"\" />";
				break;
				
			default:
				field = "<input type=\""+item.type+"\" name=\""+item.name+"\" />";
				break;
		}		
		$j("#module-blocks-content-form").append(title+"<div>"+field+"</div>");
	});
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, добавляющая в список фотографий новый элемент
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function AddNewPhoto() {
	
	$j(".module-blocks-photo-div:first").clone(true).insertAfter(".module-blocks-photo-div:last");
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, загружающая список фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function LoadPhotos(data) {
	
	$j.each(data, function(index, item){
		
		AddNewPhoto();
		$j(".module-blocks-photo-div:last").css({display: "block"}).find("[name=id_image]").val(item.id_photo);
		$j(".module-blocks-photo-div:last").find("img").attr("src", item.image);
		$j(".module-blocks-photo-div:last").find("[name=link]").val(item.image);
		$j(".module-blocks-photo-div:last").find("[name=thumb]").val(item.thumb);
	});
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, очищающая список фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ClearPhotos() {
	
	$j(".module-blocks-photo-div:not(:first)").remove();	
};
