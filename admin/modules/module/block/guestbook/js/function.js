//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	���������� ������� ���������� ���������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$j(document).ready(function(){

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	������������� ���������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j(".guestbook-message-button-submit").click(function(){
		
		var id_message 	= $j(this).parent().find(".message-id").val();
		var btn = this;
		
		if ((id_message!="") && (id_message>0)) {
			
			$j.ajax({
					
				url: "/admin/modules/module/block/guestbook/handler/message-submit.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					sess_id		: sess_id,
					id_message 	: id_message
				}),
					
				success: function(response){
							
					if (response.result=="success") {
						$j(btn).remove();
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
		
		return false;
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	���������� ��������� ���������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j(".guestbook-message-button-update").click(function(){
		
		var id_message 	= $j(this).parent().find(".message-id").val();
		var id_cat 		= $j(this).parent().parent().find(".message-cat").val();
		
		if ((id_message!="") && (id_message>0) && (id_cat!="") && (id_cat>0)) {
			
			$j.ajax({
					
				url: "/admin/modules/module/block/guestbook/handler/message-update.handler.php",
				type: "POST",
				dataType: "json",
				data: ({
					sess_id		: sess_id,
					id_message 	: id_message,
					id_cat		: id_cat
				}),
					
				success: function(response){
							
					if (response.result=="success") {
						if (response.text > 0) 
							alert(response.text+" ������ ������� ���������.");
						else
							alert("������� ��������� ������� �� ����.");
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
		
		return false;
	});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	�������� ���������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$j(".guestbook-message-button-delete").click(function(){
		
		var id_message 	= $j(this).parent().find(".message-id").val();
		var btn = this;
		
		if ((id_message!="") && (id_message>0)) {
			
			if (confirm("�� ������������� ������ ������� ���������?")) {
			
				$j.ajax({
						
					url: "/admin/modules/module/block/guestbook/handler/message-delete.handler.php",
					type: "POST",
					dataType: "json",
					data: ({
						sess_id		: sess_id,
						id_message 	: id_message
					}),
						
					success: function(response){
								
						if (response.result=="success") {
							
							$j(btn).parent().parent().remove();

							$j(".guestbook-message-table tbody tr:even").attr("class", "").addClass("even");
							$j(".guestbook-message-table tbody tr:odd").attr("class", "").addClass("odd");
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
		}
		
		return false;
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
});