$j(document).ready(function(){

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Операции с окном
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j("div.hdwscloser").live("click", function(){
		$j(this).parent().parent().hide().remove();
	});
	
	$j("div.hdwslayer div.hdwssweeper").live("click", function(){
		$j(this).parent().parent().removeClass("hdwslayer").addClass("hdwslayer_sweeped");
		
		var div = $j(this).parent().parent();
		var hdiv = parseInt($j(div).css("height"));
		
		$j(div).find("textarea").css("height", (hdiv-90) + "px");
		$j(div).find("div.wysiwyg").css("height", (hdiv-90) + "px");
		$j(div).find("div.wysiwyg iframe").css("min-height", (hdiv-120) + "px");
		
		var width = parseInt($j(div).find("textarea").css("width"));
		$j(div).find("div.wysiwyg").css("width", (width-1)+"%");
		$j(div).find("div.wysiwyg iframe").css("width", "100%");
		
		$j(this).parent().parent().attr("style", "display: block;");
	});
	
	$j("div.hdwslayer div.hdwsfurler").live("click", function(){
		$j(this).parent().parent().removeClass("hdwslayer").addClass("hdwslayer_furled");
		
		$j(this).parent().parent().attr("style", "display: block;");
	});
	
	$j("div.hdwslayer_sweeped div.hdwssweeper").live("click", function(){
		$j(this).parent().parent().removeClass("hdwslayer_sweeped").addClass("hdwslayer");
		
		var div = $j(this).parent().parent();
		var hdiv = parseInt($j(div).css("height"));
		
		$j(div).find("textarea").css("height", (hdiv-90) + "px");
		$j(div).find("div.wysiwyg").css("height", (hdiv-90) + "px");
		$j(div).find("div.wysiwyg iframe").css("min-height", (hdiv-120) + "px");
		
		var width = parseInt($j(div).find("textarea").css("width"));
		$j(div).find("div.wysiwyg").css("width", (width-1)+"%");
		$j(div).find("div.wysiwyg iframe").css("width", "100%");
		
		$j(this).parent().parent().attr("style", "display: block;");
	});
	
	$j("div.hdwslayer_sweeped div.hdwsfurler").live("click", function(){
		$j(this).parent().parent().removeClass("hdwslayer_sweeped").addClass("hdwslayer_furled");
		
		$j(this).parent().parent().attr("style", "display: block;");
	});	
	
	$j("div.hdwslayer_furled div.hdwsfurler").live("click", function(){
		$j(this).parent().parent().removeClass("hdwslayer_furled").addClass("hdwslayer");
		
		$j(this).parent().parent().attr("style", "display: block;");
	});
	
	$j("div.hdwslayer_furled div.hdwssweeper").live("click", function(){	
		$j(this).parent().parent().removeClass("hdwslayer_furled").addClass("hdwslayer_sweeped");
	
		$j(this).parent().parent().attr("style", "display: block;");
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Нажатие на кнопку "Сохранить"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j(".filemanager-button-file-save-content").live("click", function(){
		
		var filename = $j(this).parent().parent().parent().find("input:hidden").val();
		var filecontent = $j(this).parent().parent().parent().find("textarea").val();
			
		$j.ajax({
			url: "/admin/modules/filemanager/handler/file-save-content.handler.php",
			type: "POST",
			data: ({							
				filename : filename,
				filecontent : filecontent
			}),
			success: function(response) {			
				alert(response);
				refreshlist();
			}
		});
	});
	
	$j(".structure-button-page-save-content").live("click", function(){
		
		var id_page = $j(this).parent().parent().parent().find("input:hidden").val();
		var content = $j(this).parent().parent().parent().find("textarea").val();
			
		$j.ajax({
			url: "/admin/modules/structure/handler/page-save-content.handler.php",
			type: "POST",
			data: ({							
				id_page : id_page,
				content : content
			}),
			success: function(response) {			
				alert(response);
			}
		});
	});
	
	$j(".iblock-save-content").live("click", function(){
		
		var id_block 	= $j(this).closest(".hdwslayer").find("input:hidden").val();
		var content 	= $j(this).closest(".hdwslayer").find("textarea").val();
		
		$j.ajax({
			url: "/admin/modules/iblock/handler/save-content.handler.php",
			type: "POST",
			data: ({							
				id_block 	: id_block,
				content 	: content
			}),
			success: function(response) {			
				alert(response);
			}
		});
	});
	
	$j("div.redactor-toggle input:checkbox").live("click", function(){
		var div = $j(this).parent().parent().parent();
		
		if ($j(this).filter(":checked").length > 0) {
			$j(div).find("textarea").hide();
			
			var width = parseInt($j(div).find("textarea").css("width"));
			$j(div).find("div.wysiwyg").css("width", (width-1)+"%");
			$j(div).find("div.wysiwyg iframe").css("width", "100%");
			
			var height = parseInt($j(div).find("textarea").css("height"));
			$j(div).find("div.wysiwyg").css("height", (height)+"px");
			$j(div).find("div.wysiwyg iframe").css("min-height", (height-30) + "px");
			
			var content = $j(div).find("textarea").val();
			$j(div).find("textarea").wysiwyg('setContent', content);
			
			$j(div).find("div.wysiwyg").show();
		}
		else {
			var str = $j(div).find("textarea").val();
			
			while (strpos(str, "%7B")) {
				str = str.replace ("%7B", "{");
			}
			
			while (strpos(str, "%7D")) {
				str = str.replace ("%7D", "}");
			}
			
			while (strpos(str, "%20")) {
				str = str.replace ("%20", " ");
			}
			
			$j(div).find("textarea").val(str);
			
			$j(div).find("div.wysiwyg").hide();
			$j(div).find("textarea").show();
		}
			
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Загрузка окна с содержимым файла
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function OpenFileContent (filename) {

	$j("div.hdwslayer:first").clone(true).insertAfter("div.hdwslayer:last").show().draggable();
	
	$j("div.hdwslayer:last textarea").wysiwyg({
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
	$j("div.hdwslayer:last div.wysiwyg").hide();
	$j("div.hdwslayer:last textarea").show();
	
	$j("div.hdwslayer:last span.file-name-header").text(filename);
	$j("div.hdwslayer:last input:hidden").val(filename);
	
	$j.ajax({
		url: "/admin/modules/filemanager/handler/file-get-content.handler.php",
		type: "POST",
		data: ({							
			filename : filename
		}),
		success: function(response) {			
			if (response) {	
				//$j("div.hdwslayer:last textarea").wysiwyg('setContent', response);
				$j("div.hdwslayer:last textarea").val(response);
			}
		}
	});
}

function OpenPageContent (id_page) {

	$j("div.hdwslayer:first").clone(true).insertAfter("div.hdwslayer:last").show().draggable();
	
	$j("div.hdwslayer:last textarea").wysiwyg({
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
	$j("div.hdwslayer:last div.wysiwyg").hide();
	$j("div.hdwslayer:last textarea").show();
	
	$j("div.hdwslayer:last .filemanager-button-file-save-content")
		.removeClass("filemanager-button-file-save-content")
		.addClass("structure-button-page-save-content");
	
	$j("div.hdwslayer:last input:hidden").val(id_page);
	
	$j.ajax({
		url: "/admin/modules/structure/handler/page-get-content.handler.php",
		type: "POST",
		data: ({							
			id_page : id_page
		}),
		success: function(response) {			
			if (response) {
				//$j("div.hdwslayer:last textarea").wysiwyg('setContent', response);
				$j("div.hdwslayer:last textarea").val(response);
			}
		}
	});
}

function OpenBlockContent (id_block) {

	$j("div.hdwslayer:first").clone(true).insertAfter("div.hdwslayer:last").show().draggable();
	
	$j("div.hdwslayer:last textarea").wysiwyg({
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
	$j("div.hdwslayer:last div.wysiwyg").hide();
	$j("div.hdwslayer:last textarea").show();
	
	$j("div.hdwslayer:last .filemanager-button-file-save-content")
		.removeClass("filemanager-button-file-save-content")
		.addClass("iblock-save-content");
	
	$j("div.hdwslayer:last input:hidden").val(id_block);
	
	$j.ajax({
		url: "/admin/modules/iblock/handler/get-content.handler.php",
		type: "POST",
		data: ({							
			id_block : id_block
		}),
		success: function(response) {			
			if (response) {
				//$j("div.hdwslayer:last textarea").wysiwyg('setContent', response);
				$j("div.hdwslayer:last textarea").val(response);
			}
		}
	});
}

function strpos( haystack, needle, offset){    // Find position of first occurrence of a string
    // 
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 
    var i = haystack.indexOf( needle, offset ); // returns -1
    return i >= 0 ? i : false;
}
