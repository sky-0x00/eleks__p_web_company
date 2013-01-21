<?php /* Smarty version 2.6.18, created on 2013-01-21 08:32:14
         compiled from include/footer.tpl.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'include/footer.tpl.php', 7, false),array('modifier', 'truncate', 'include/footer.tpl.php', 9, false),)), $this); ?>
<?php if ($this->_tpl_vars['DOCUMENT_SECTION'] == ""): ?>
<tr><td class="footer-index" style="border: 0px solid orange;">
	<div class="contents" style="border: 0px solid yellow;">
		<div class="caption">События<a href="/news/">Все события</a></div>
		<?php $_from = $this->_tpl_vars['News']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Item']):
?>
		<div class="column">
			<div class="date no-float"><?php echo ((is_array($_tmp=$this->_tpl_vars['Item']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</div>
			<div class="news-name"><a href="/news/<?php echo $this->_tpl_vars['Item']['year']; ?>
/<?php echo $this->_tpl_vars['Item']['month']; ?>
/<?php echo $this->_tpl_vars['Item']['id_article']; ?>
/"><?php echo $this->_tpl_vars['Item']['title']; ?>
</a></div>
			<div class="news-text"><?php echo ((is_array($_tmp=$this->_tpl_vars['Item']['annot'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 80, "...", false) : smarty_modifier_truncate($_tmp, 80, "...", false)); ?>
</div>
		</div>
		<?php endforeach; endif; unset($_from); ?>
		<div class="search">
			<form method="get" action="/search/">
				<input class="text" type="text" name="text" value="введите текст" />
				<input class="submit" type="submit" value="поиск" />
			</form>
		</div>
		<div class="copyright">
			<div class="year">&copy;&nbsp;ООО&nbsp;&laquo;Группа компаний ЭЛЕКС&raquo;, 2012</div>
		</div>	
	</div>
</td>
<?php else: ?>
    </div></td></tr>
        <tr><td class="footer">
            	<div class="contents">
            		<div class="copyright">
            			<div class="year">&copy;&nbsp;ООО&nbsp;&laquo;Группа компаний ЭЛЕКС&raquo;, 2012</div>
            		</div>	
            	</div>
<?php endif; ?>       
        </td></tr></table>
    </body>
</html>