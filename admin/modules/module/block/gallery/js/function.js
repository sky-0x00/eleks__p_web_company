//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события готовности документа
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$j(document).ready(function(){
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Подключаем календарь
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if ($j("#module-gallery-datepicker").length) {
		
		$j.datepicker.setDefaults(
        	$j.extend($j.datepicker.regional["ru"])
  		);
  	
  		$j("#module-gallery-datepicker").datepicker();
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик клика по ссылке "Добавить новый альбом"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#module-gallery-album-new-toggle").click(function(){
			
			$j("#module-gallery-album-new-div").slideToggle("slow");
		});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик клика по ссылке "Добавить новый альбом"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#module-gallery-photo-new-toggle").click(function(){
			
			$j("#module-gallery-photo-new-div").slideToggle("slow");
		});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Подсветка фона под "карандашом", "крестиком", "дискетой" и т.п.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("div.delete,a.edit,div.module-articles-fields-button-delete,div.module-articles-fields-button-save").live("mouseover",
		function () {
  			$j(this).css({
    			backgroundColor: "#FCAD81"
  				});
			});
			
	$j("div.delete,a.edit,div.module-articles-fields-button-delete,div.module-articles-fields-button-save").live("mouseout", 
		function () {
  			$j(this).css({
    			backgroundColor: "#FFFFFF"
  				});	
  		});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события добавления нового альбома
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $j("#module-gallery-album-button-add").click(function(){
    		
    	var name = $j("#module-gallery-album-new-name").val();
    		
    	if (name!="") {
    		
			$j.ajax({
				url: "/admin/modules/module/block/gallery/handler/album-create.handler.php",
				type: "POST",
				dataType: "json",
				
				data: ({
					name : name
				}),
					
				success: function(response){
					
					if (response.result=="success") {							
						AddAlbum(response.text, name)				
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
//	Обработчик события нажатия кнопки "Удалить" в списке альбомов
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".delete").live("click", function(){
		
		var btn = this;
		var id_album = $j(btn).parent().parent().parent().find("input:hidden").val();
			
		if (confirm("Вы действительно хотите удалить выбранный альбом?")) {
			
			$j.ajax({
					
				url: "/admin/modules/module/block/gallery/handler/album-delete.handler.php",
				type: "POST",
				dataType: "json",
				
				data: ({
					id_album : id_album
				}),
					
				success: function(response){
					
					if (response.result=="success") {							
						
						$j(btn).parent().parent().parent().slideUp(300)
						
						setTimeout(function(){
							$j(btn).parent().parent().parent().remove();
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
//	Обработчик события сохранения альбома
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $j("#module-gallery-album-button-submit").click(function(){
    		
    	var name = $j("#module-gallery-album-edit-name").val();
    		
		if (name!="") {
    			
			$j.ajax({
				url: "/admin/modules/module/block/gallery/handler/album-update.handler.php",
				type: "POST",
				dataType: "json",
				
				data: ({
					id_album	:	$j("#module-gallery-album-edit-id").val(),
					alias		:	$j("#module-gallery-album-edit-alias").val(),
					descr		:	$j("#module-gallery-album-edit-descr").val(),
					name 		: 	name
				}),
				
				success: function(response){
					
					if (response.result=="success") {						
						$j("#module-gallery-album-edit-head").text(name);
						alert(response.text);
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
//	Обработчик события нажатия кнопки добавления фотографии
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if ($j("#module-gallery-photo-button-browse").length) {
		
		var upload = new AjaxUpload("#module-gallery-photo-button-browse", {
 		
			action: "/admin/modules/module/block/gallery/handler/photo-upload.handler.php",
  			name: "newfile",
  			responseType: "json",
  			autoSubmit: false,
  			onChange: function(file, ext){
  				$j("#module-gallery-photo-new-file").val(file);
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
					AddPhoto(response.text.id_photo, response.text.photo);					
				}
				else if (response.result=="error")
					alert(response.text);
				else
					alert(response);
					
				$j("#module-gallery-photo-new-file").val("");
			}
		});
	}
	
	$j("#module-gallery-photo-button-add").click(function(){
		
		var id_album = $j("#module-gallery-album-id").val();
			
		if (id_album!=0) {
			
			upload.setData({
				"id_album" 	: id_album,
			});	
			upload.submit();	
		}
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки "Удалить" в списке фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".module-gallery-photo-button-delete").click(function(){
		
		var btn = this;
		var id_photo = $j(btn).parent().parent().find("input:hidden[name=id_photo]").val();
			
		if (confirm("Вы действительно хотите удалить выбранную фотографию?")) {
			
			$j.ajax({
					
				url: "/admin/modules/module/block/gallery/handler/photo-delete.handler.php",
				type: "POST",
				dataType: "json",
				
				data: ({
					id_photo : id_photo
				}),
					
				success: function(response){
					
					if (response.result=="success") {						
						
						$j(btn).parent().parent().slideUp(300)
						
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
		
		return false;
	});
    	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Обработчик события нажатия кнопки "Сохранить" в списке фотографий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".module-gallery-photo-button-save").click(function(){
		
		var id_photo = $j(this).parent().parent().find("input:hidden[name=id_photo]").val();
		var name = $j(this).parent().parent().find("input:text[name=name]").val();
		var descr = $j(this).parent().parent().find("textarea[name=descr]").val();
			
		$j.ajax({
					
			url: "/admin/modules/module/block/gallery/handler/photo-update.handler.php",
			type: "POST",
			dataType: "json",
			
			data: ({
				id_photo	: id_photo,
				name		: name,
				descr		: descr
			}),
				
			success: function(response){
					
				if (response.result=="success") {						
					alert(response.text);
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
			
		return false;		
				
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
});


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, добавляющая в список новый альбом
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function AddAlbum(id, name) {
	
	$j(".module-gallery-album-list-item:first").clone(true).insertAfter(".module-gallery-album-list-item:last");
	
	var href1 = $j(".module-gallery-album-list-item:last .left-auto a").attr("href");
	var href2 = $j(".module-gallery-album-list-item:last .right a.edit").attr("href");
	
	$j(".module-gallery-album-list-item:last .left-auto a").attr("href", href1+id).text(name);
	$j(".module-gallery-album-list-item:last .right a.edit").attr("href", href2+id);
	$j(".module-gallery-album-list-item:last [name=id_album]").val(id);
	
	$j(".module-gallery-album-list-item:last").show();
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Функция, добавляющая в список фотографий новый блок
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function AddPhoto(id_photo, photo) {	
	$j(".module-gallery-photo-div:first").clone(true).insertAfter(".module-gallery-photo-div:last");

	$j(".module-gallery-photo-div:last [name=id_photo]").val(id_photo);
	$j(".module-gallery-photo-div:last img").attr("src", photo);
	$j(".module-gallery-photo-div:last").slideDown(500);
}
