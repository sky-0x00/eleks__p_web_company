{# include file='include/header.tpl.php' #}
	
	<div id="visual">
		<div class="lines png" style="display: none; position: absolute;">			
		</div>
		
		<div id="info-asu" class="info png" style="display: none;">
			<div class="close png" title="Свернуть">&nbsp;</div>
			{# $iblock->getData("asu") #}			
		</div> 
		<div id="popup-asu" class="popup png" style="display: none;">
			<div class="cross png" title="Закрыть">&nbsp;</div>
			<div class="text">
				{# $iblock->getData("asu_further") #}
			</div>
		</div>
		
		<div id="info-montage" class="info png" style="display: none;">
			<div class="close png" title="Свернуть">&nbsp;</div>
			{# $iblock->getData("montage") #}
		</div> 
		<div id="popup-montage" class="popup png" style="display: none;">
			<div class="cross png" title="Закрыть">&nbsp;</div>
			<div class="text">
				{# $iblock->getData("montage_further") #}
			</div>
		</div>
		
		<div id="info-safety" class="info png" style="display: none;">
			<div class="close png" title="Свернуть">&nbsp;</div>
			{# $iblock->getData("safety") #}
		</div> 
		<div id="popup-safety" class="popup png" style="display: none;">
			<div class="cross png" title="Закрыть">&nbsp;</div>
			<div class="text">
				{# $iblock->getData("safety_further") #}
			</div>
		</div>
		
		<div id="info-construction" class="info png" style="display: none;">
			<div class="close png" title="Свернуть">&nbsp;</div>
			{# $iblock->getData("construction") #}
		</div> 
		<div id="popup-construction" class="popup png" style="display: none;">
			<div class="cross png" title="Закрыть">&nbsp;</div>
			<div class="text">
				{# $iblock->getData("construction_further") #}
			</div>
		</div>
		
		<div id="earth" class="png"></div>
		
		<div class="automation">
			<div class="text">
				<img class="png clickable" src="/images/asu.png" alt="Автоматизированные системы управления" width="100" height="100" />
				<img class="hidden png clickable" src="/images/asu.png" alt="Автоматизированные системы управления" width="100" height="100" />
				<div class="desc">автоматизированные<br />системы управления</div>
			</div>
		</div>
		<div class="montage">
			<div class="text">
				<img class="png clickable" src="/images/montage.png" alt="Электромонтажные работы" width="100" height="100" />
				<img class="hidden png clickable" src="/images/montage.png" alt="Электромонтажные работы" width="100" height="100" />
				<div class="desc">Электромонтажные<br />работы</div>
			</div>
		</div>
		<div class="safety">
			<div class="text">
				<img class="png clickable" src="/images/safety.png" alt="Системы безопасности" width="100" height="100" />
				<img class="hidden png clickable" src="/images/safety.png" alt="Системы безопасности" width="100" height="100" />
				<div class="desc">Системы<br />безопасности</div>
			</div>
		</div> 
		<div class="construction">
			<div class="text">
				<img class="png clickable" src="/images/constr.png" alt="Строительные работы" width="100" height="100" />
				<img class="hidden png clickable" src="/images/constr.png" alt="Строительные работы" width="100" height="100" />
				<div class="desc">Строительные<br />работы</div>
			</div>
		</div>
				
	</div>
	
</div>
	
{# include file='include/footer.tpl.php' #}