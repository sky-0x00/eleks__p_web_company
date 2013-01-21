{# include file='include/header.tpl.php' #}
	
	<div class="content" style="height: auto">
		
		<div class="comments-form png">
			<div class="cross png" title="�������"></div>
			<div class="inside">
				<h1 style="font-size: 18px; margin-bottom: 10px">������</h1>
				<div class="full-size">
					<img src="{# $Comments[0].photo #}" alt="" />
				</div>
				<div class="comment-text">{# $Comments[0].descr #}</div>
				<div class="comment-nav">
					<ul>
						{# foreach from=$Comments item=Item #}
						<li>
							<input type="hidden" name="id_photo" value="{# $Item.id_photo #}" />
							<input type="hidden" name="photo" value="{# $Item.photo #}" />
							<input type="hidden" name="descr" value="{# $Item.descr #}" />
							<img title="{# $Item.name #}" src="{# $Item.thumb #}" alt="" style="width: 60px; height: 83px; cursor: pointer;" />
						</li>
						{# /foreach #}
					</ul>
				</div>
				<div class="slider-wrap">					
				</div>	
			</div>	
		</div>
			
		<div class="left-column" style="width: 178px">
			<h1 style="font-size: 18px">������</h1>
			<img class="png" src="/images/comments.png" width="135" height="145" alt="" />
			<span class="comments png"><a>���������� ������</a></span>
		</div>
		
		<div class="basic">
			<div id="breadcrumbs"><a href="/">�� �������</a> / <span>� ��������</span></div>			
			<h1>� ��������</h1>
			<div class="company">
				<p>{# $DOCUMENT_CONTENT #}</p>
			</div>
		</div>	
		<div class="advantage-tree png">
			<div class="head png"><span class="png">������������ ������������</span></div>
			<div class="branch png" style="top: 90px"><span class="png"><a href="/about/partners/">����������� � �������� �������������</a></span></div>
			<div class="branch png" style="top: 180px; left: 142px"><span class="png"><a href="/services/">����������� ������ � ���������� �����</a></span></div>
			<div class="branch png" style="top: 104px; left: 442px"><span class="png"><a href="/services/">����������� ���� ������</a></span></div>
			<div class="branch png" style="top: 160px; left: 600px"><span class="png" style="cursor: text">����������������������� ��������</span></div>
			<div class="branch png" style="top: 250px; left: 415px"><span class="png"><a href="/products/">����������� ���������� � ������� ������������� ������������</a></span></div>
		</div>	
		<h1 style="font-size: 18px">����������� � �������</h1>
		<div class="certificates png">
			<div class="to-left png" title="�����">&nbsp;</div>
			<div class="to-right png" title="������">&nbsp;</div>
			<div class="wrapper">
				<ul>
					{# foreach from=$Sertificates item=Item #}
					<li>
						<a class="highslide" href="{# $Item.photo #}" onclick="return hs.expand(this, {  })">
							<img title="{# $Item.name #}" src="{# $Item.thumb #}" alt="" style="width: 79px; height: 106px;" />
						</a>	
					</li>
					{# /foreach #}
				</ul>	
			</div>
		</div>		
	</div>	
	
	
	
	
</div>
	
{# include file='include/footer.tpl.php' #}