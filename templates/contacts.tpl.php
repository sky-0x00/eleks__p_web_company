{# include file='include/header.tpl.php' #}
	
	<div class="content" style="margin-top: -20px; height: 556px;">
		
		<div id="map" class="png">
			<div class="cross png">&nbsp;</div>
			<div class="name">����� �������</div>
			<div class="route">������ ���������</div>
		</div>
		
        <div id="breadcrumbs"><a href="/">�������</a> / <span>��������</span></div>
        
		<div class="left-column contacts">
			{# $DOCUMENT_CONTENT #}        
			<!--<div class="border"></div>-->
		</div>
        
		<div class="right-column">
			{# $cms_module_feedback0 #}
            
            <script src="/admin/modules/module/block/feedback/js/function.js"></script>
            <div id="feedback"  style="border: 1px none yellow;">            
                <form action="">
                	<h1 style="font-size: 18px;">����� ��� ������� �����:</h1>
                	<p>��� *</p>
                	<input id="feedback-name" type="text" />
                	<p>���������� �������</p>
                	<input id="feedback-phone" type="text" />
                	<p>E-mail *</p>
                	<input id="feedback-email" type="text" />
                	<p>����� ��������� *</p>
                	<textarea id="feedback-message" rows="" cols=""></textarea>
                	<p>* ����, ������������ ��� ����������</p>
                    <button class="png" id="feedback-send">���������</button>
                </form>
            </div>	
		</div>
        
		<!--<div class="center">			
			<span class="map png"><a>���������� ����� �������</a></span>
		</div>-->
	</div>
    
</div>
	
{# include file='include/footer.tpl.php' #}