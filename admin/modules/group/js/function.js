$j(document).ready(function(){

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	���������� ������� ������� �� ������ "�������� ������"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j("#user-group-addnew").click(function(){
		$j("div.user-group-div:first").clone(true).insertAfter("div.user-group-div:last");
		$j("div.user-group-div:last").slideDown(300);
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	���������� ������� ������� ������ "�������"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".picture-button-delete").click(function(){
		
		var btn 		= this;
		var id_group 	= $j(btn).parent().parent().find("input:hidden").val();
		
		if (id_group==0) {
			$j(btn).parent().parent().slideUp(300)
			setTimeout(function(){
					$j(btn).parent().parent().remove();
				}, 300);
		}
		else {
				
			if (confirm("�� ������������� ������ ������� ��������� ������?")) 
				$j.ajax({
					
					url: "/admin/modules/group/handler/group-delete.handler.php",
					dataType: "json",
					type: "POST",
					data: ({

						id_group : id_group
					}),
					success: function(data){
						alert(data.message);
						if (data.success==1) {
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
//	���������� ������� ������� ������ "���������"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$j(".picture-button-save").click(function(){
		
		var btn 		= this;
		var name 		= $j(this).parent().parent().find("input:text[name=name]").val();
		var admin		= $j(this).parent().parent().find("input:checkbox[name=admin]").filter(":checked").val();
		var id_group 	= $j(this).parent().parent().find("input:hidden[name=id_group]").val();
		
		if ((id_group==0)&&(name!="")) {
				
			$j.ajax({
					
				url: "/admin/modules/group/handler/group-create.handler.php",
				type: "POST",
				data: ({

					name 	: 	name,
					admin 	: 	admin
				}),
				success: function(data){
				
					if (data) {
						$j(btn).parent().parent().find("input:hidden[name=id_group]").val(data);
						alert("������ ������� ���������.");
					}
					else
						alert("������. ���������� �������� ����� ������.");
				}
			});
		}
		else 
			if (name!="") {
				
				$j.ajax({
					
					url: "/admin/modules/group/handler/group-update.handler.php",
					dataType: "json",
					type: "POST",
					data: ({

						id_group 	: 	id_group,
						name 		: 	name,
						admin 		: 	admin
					}),
					success: function(data){
						alert(data.message);
					}
				});
			}
			else
				alert("����������, ������� �������� ������.");
				
	});
			
});