{# include file='include/header.tpl.php' #}
	
	<div id="visual">
		<div class="lines" style="display: none; position: absolute;">			
		</div>
		
		<div id="info-asu" class="info" style="display: none;">
			<div class="close" title="��������">&nbsp;</div>
			{# $iblock->getData("asu") #}			
		</div> 
		<div id="popup-asu" class="popup" style="display: none;">
			<div class="cross" title="�������">&nbsp;</div>
			<div class="text">
				{# $iblock->getData("asu_further") #}
			</div>
		</div>
		
		<div id="info-montage" class="info" style="display: none;">
			<div class="close" title="��������">&nbsp;</div>
			{# $iblock->getData("montage") #}
		</div> 
		<div id="popup-montage" class="popup" style="display: none;">
			<div class="cross" title="�������">&nbsp;</div>
			<div class="text">
				{# $iblock->getData("montage_further") #}
			</div>
		</div>
		
		<div id="info-safety" class="info" style="display: none;">
			<div class="close" title="��������">&nbsp;</div>
			{# $iblock->getData("safety") #}
		</div> 
		<div id="popup-safety" class="popup" style="display: none;">
			<div class="cross" title="�������">&nbsp;</div>
			<div class="text">
				{# $iblock->getData("safety_further") #}
			</div>
		</div>
		
		<div id="info-construction" class="info" style="display: none;">
			<div class="close" title="��������">&nbsp;</div>
			{# $iblock->getData("construction") #}
		</div> 
		<div id="popup-construction" class="popup" style="display: none;">
			<div class="cross" title="�������">&nbsp;</div>
			<div class="text">
				{# $iblock->getData("construction_further") #}
			</div>
		</div>
		
		<div id="earth" class="png"></div>
		
		<div class="automation">
			<div class="text">
				<img class="png" src="/images/asu_big1.png" alt="������������������ ������� ����������" width="100" height="100" />
				<img class="hidden png" src="/images/asu_big.png" alt="������������������ ������� ����������" width="100" height="100" />
				<div class="desc">������������������<br />������� ����������</div>
			</div>
		</div>
		<div class="montage">
			<div class="text">
				<img class="png" src="/images/montage_big1.png" alt="���������������� ������" width="100" height="100" />
				<img class="hidden png" src="/images/montage_big.png" alt="���������������� ������" width="100" height="100" />
				<div class="desc">����������������<br />������</div>
			</div>
		</div>
		<div class="safety">
			<div class="text">
				<img class="png" src="/images/safety_big1.png" alt="������� ������������" width="100" height="100" />
				<img class="hidden png" src="/images/safety_big.png" alt="������� ������������" width="100" height="100" />
				<div class="desc">�������<br />������������</div>
			</div>
		</div> 
		<div class="construction">
			<div class="text">
				<img class="png" src="/images/constr_big1.png" alt="������������ ������" width="100" height="100" />
				<img class="hidden png" src="/images/constr_big.png" alt="������������ ������" width="100" height="100" />
				<div class="desc">������������<br />������</div>
			</div>
		</div>
				
	</div>
	
</div>
	
{# include file='include/footer.tpl.php' #}