$j(document).ready(function(){

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	���������� ������� �������� ���� ���������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("div.old-div a").live("click", function(){
	
		var filename = $j("#filemanager-current-path").val() + "/" + $j(this).text();
		
		if ( (!$j(this).hasClass("icon_folder"))&&(!$j(this).hasClass("icon_img")) )		
			OpenFileContent (filename);
		
		if ($j(this).hasClass("icon_img")) {
			$j("div.hdwslayer:first").next().clone(true).insertAfter("div.hdwslayer:last").show().draggable();		
			$j("div.hdwslayer:last img").attr("src", filename);
		}
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	���������� ������� �������� �����
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if ($j("#filemanager-file-upload-button-browse").length) {
		
		var upload = new AjaxUpload("#filemanager-file-upload-button-browse", {
 		
			action: "/admin/modules/filemanager/handler/file-upload.handler.php",
  			name: "newfile",
  			autoSubmit: false,
  			onChange: function(file, ext){
  				$j("#filemanager-file-upload").val(file);
  			},
  			onSubmit: function(file, ext){},
			onComplete: function(file, response) {
				
				if (response=="success") {
					refreshlist();
				}
				else
					alert(response);
			}
		});
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#filemanager-file-upload-button-submit").click(function(){
		
		var path = $j("#filemanager-current-path").val();
		var name = $j("#filemanager-file-upload").val();
		
		$j.ajax({
			url: "/admin/modules/filemanager/handler/file-check.handler.php",
			type: "POST",
			data: ({							
				name : path+"/"+name
			}),
			success: function(response) {			
				if (response==1) {				
					if (confirm("����� ���� ��� ����������. ��������?")) {					
						upload.setData({
							"sess" 	: sess,
							"path"	: $j("#filemanager-current-path").val()
						});		
						upload.submit();
					}
				}
				else {				
					upload.setData({
						"sess" 	: sess,
						"path"	: $j("#filemanager-current-path").val()
					});					
					upload.submit();
				}
			}
		});		
			
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	����������� ����
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
//	�������� ����� ��� ��������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".drop-menu-delete").live("click", function () {
		
		var path = $j("#filemanager-current-path").val();
		var type = $j(this).parent().find("[name=type]").val();
		var name = $j(this).parent().find("[name=name]").val();
		
		switch (type) {
		
			case "folder":			
				if (confirm("�� �������������� ������ ������� ������� \""+name+"\" � ��� ����� ������������ � ���?"))			
					$j.ajax({
						url: "/admin/modules/filemanager/handler/folder-delete.handler.php",
						type: "POST",
						data: ({							
							name : path+"/"+name
						}),
						success: function(response) {							
							if (response==1) {
								refreshlist();	
							}
							else
								alert("������. ���������� ������� �������.");							
						}
					});					
				break;
			
			case "file":			
				if (confirm("�� �������������� ������ ������� ���� \""+name+"\"?"))			
					$j.ajax({
						url: "/admin/modules/filemanager/handler/file-delete.handler.php",
						type: "POST",
						data: ({							
							name : path+"/"+name
						}),
						success: function(response) {							
							if (response==1) {
								refreshlist();								
							}
							else
								alert("������. ���������� ������� ����.");							
						}
					});
				break;
				
			default:
				break;
		}
		
	});
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	�������������� ����� ��� ��������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".drop-menu-rename").live("click", function () {
	
		var row = $j(this).parent().parent().parent().parent().parent().parent();
		var name = $j(row).find(".old-div").find("a").text();
		$j(row).find(".new-div").find("[name=new_name]").val(name);
		
		$j(row).find(".old-div").hide();
		$j(row).find(".new-div").show();
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j(".filemanager-button-cancel").live("click", function () {
	
		$j(this).parent().parent().parent().find(".new-div").hide();
		$j(this).parent().parent().parent().find(".old-div").show();
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	$j(".filemanager-button-rename").live("click", function () {
		
		var row = $j(this).parent().parent().parent().parent().parent();
		
		var path = $j("#filemanager-current-path").val();
		var type = $j(row).find("[name=type]").val();
		var oldname = $j(row).find("[name=name]").val();
		var newname = $j(row).find("[name=new_name]").val();
		
		$j.ajax({
			url: "/admin/modules/filemanager/handler/rename.handler.php",
			type: "POST",
			data: ({
				type	: type,
				path	: path,
				oldname : oldname,
				newname : newname
			}),
			success: function(response) {							
				if (response==1) {
					refreshlist();	
				}
				else
					alert("������. ���������� �������������.");							
			}
		});					
		
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	�������� ������ ��������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#filemanager-button-folder-create").live("click", function () {
		
		var name = $j("#filemanager-new-folder-name").val();
		var path = $j("#filemanager-current-path").val();
		
		if (name!="")
			$j.ajax({
				url: "/admin/modules/filemanager/handler/folder-create.handler.php",
				type: "POST",
				data: ({
					path		: path,
					foldername 	: name
				}),
				success: function(response) {							
					if (response==1) {
						refreshlist();	
					}
					else
						alert("������. ���������� ������� ������� (�������� ��� ��������, ��� ������� ��� ����������).");							
				}
			});
		else
			alert("������� ��� ��������.");
		
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	�������� ������ �����
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#filemanager-button-file-create").live("click", function () {
		
		var name = $j("#filemanager-new-file-name").val();
		var path = $j("#filemanager-current-path").val();
		
		if (name!="") {
		
			name += $j("#filemanager-new-file-ext").val();
			
			$j.ajax({
				url: "/admin/modules/filemanager/handler/file-create.handler.php",
				type: "POST",
				data: ({
					path		: path,
					filename 	: name
				}),
				success: function(response) {							
					if (response==1) {
						refreshlist();	
					}
					else
						alert("������. ���������� ������� ���� (�������� ��� �����, ��� ���� ��� ����������).");							
				}
			});
		}
		else
			alert("������� ��� �����.");
		
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	�������� �������/����
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#show-slice-file").click(function(){
		$j("#slice-file").slideToggle(300);
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	��������� ����
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#show-slice-upload").click(function(){
		$j("#slice-upload").slideToggle(300);
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
});
