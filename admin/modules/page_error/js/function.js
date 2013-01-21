$j(document).ready(function(){

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	�������������� �����
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("div.page-error-item-filename a").live("click", function(){
		var filename = "/templates/errors/" + $j(this).text() + ".tpl.php";
		OpenFileContent (filename);
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	��������� ����
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("div.page-error-list-item").live("mouseover",
		function () {
  			$j(this).css({
    			backgroundColor: "#E1D7C0"
  				});
		});
			
	$j("div.page-error-list-item").live("mouseout", 
		function () {
  			$j(this).css({
    			backgroundColor: "#FFFFFF"
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
//	��������� ����� ���������� ��������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j("#page-error-create-link").live("click", function(){
		$j("#page-error-create-div").slideToggle(300);
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	���������� ������ ��������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#page-error-button-create").click(function () {
		
		var name = $j("#page-error-name").val();
		var filename = $j("#page-error-filename").val();
		
		if ((name!="")&&(filename!=""))
			$j.ajax({
				url: "/admin/modules/page_error/handler/page-error-create.handler.php",
				type: "POST",
				data: ({				
					
					name 	 : name,
					filename : filename
				}),
				success: function(msg) {
				
					if (msg>0) {
						var div = $j(".page-error-list-item:first").clone(true).insertAfter(".page-error-list-item:last");
						$j(div).find("[name=id]").val(msg);
						$j(div).find("[name=filename]").val(filename);
						$j(div).find("a.under").text(filename);
						$j(div).find("[name=name]").val(name);
						$j(div).find(".page-error-item-name").text(name);
						$j(div).slideDown(300);
					}
					else
						alert("������. ���������� �������� ��������.");
				
				}
			});
		else
			alert("����������, ������� ��� �������� � ��� �����.");
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	�������� ��������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".drop-menu-delete-page-error").live("click", function () {
		
		var div	= $j(this).parent().parent().parent().parent().parent().parent();
		var id	= $j(div).find("[name=id]").val();
		var name = $j(div).find(".page-error-item-name").text();
		var filename = $j(div).find("a.under:first").text();
		
		if (id!=0)
		
			if (confirm("�� �������������� ������ ������� �������� \""+name+"\" ������ � �������� \""+filename+"\"?"))
			
				$j.ajax({
					url: "/admin/modules/page_error/handler/page-error-delete.handler.php",
					type: "POST",
					data: ({				
						
						id 		 : id,
						filename : filename
					}),
					success: function(msg) {
					
						if (msg==1) {
							$j(div).slideUp(300)
							setTimeout(function(){
								$j(div).remove();
							}, 300);
						}
						else
							alert("������. ���������� ������� ��������.");
					
					}
				});		
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	������� � �������������� ��������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".drop-menu-edit-page-error").live("click", function () {
		
		var div = $j(this).parent().parent().parent().parent().parent().parent();
		
		$j(div).find("div.page-error-name-div").hide();
		$j(div).find("div.page-error-rename-div").show();
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	������ �������������� ��������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("button.page-error-button-cancel").live("click", function () {
		
		var div = $j(this).parent().parent().parent();
		
		$j(div).find("div.page-error-rename-div").hide();
		$j(div).find("div.page-error-name-div").show();
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	���������� ��������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("button.page-error-button-rename").live("click", function () {
		
		var div = $j(this).parent().parent().parent();
		
		var id = $j(div).find("[name=id]").val();
		var name = $j(div).find("[name=name]").val();
		var filename = $j(div).find("[name=filename]").val();
		
		if ((name!="")&&(filename!="")) {
		
			$j.ajax({
				url: "/admin/modules/page_error/handler/page-error-update.handler.php",
				type: "POST",
				data: ({				
					
					id 		 : id,
					name	 : name,
					filename : filename
				}),
					success: function(msg) {
					
						if (msg==1) {
							
							alert("��������� ������� ���������.");
							$j(div).find(".page-error-item-name").text(name);
							$j(div).find("a.under:first").text(filename);
							$j(div).find("div.page-error-rename-div").hide();
							$j(div).find("div.page-error-name-div").show();
						}
						else
							alert("������. ���������� ��������� ��������.");					
					}
				});
		}		
		else
			alert("����������, ������� �������� �������� � ��� �������.");
				
	});
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			
});