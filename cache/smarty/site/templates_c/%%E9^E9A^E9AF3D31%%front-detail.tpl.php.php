<?php /* Smarty version 2.6.18, created on 2012-12-08 01:56:53
         compiled from C:/Users/sky-0x00/Documents/Visual+Studio+2008/Projects/p_web_company/admin/modules/module/block/news/templates/front-detail.tpl.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'month', 'C:/Users/sky-0x00/Documents/Visual Studio 2008/Projects/p_web_company/admin/modules/module/block/news/templates/front-detail.tpl.php', 5, false),)), $this); ?>
<div class="left-column">
			<h3 class="news">Другие события</h3>
			<?php if ($this->_tpl_vars['articles']): ?>
			<?php $_from = $this->_tpl_vars['articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Item']):
?>
			<div class="date no-float"><?php echo ((is_array($_tmp=$this->_tpl_vars['Item']['date'])) ? $this->_run_mod_handler('month', true, $_tmp) : smarty_modifier_month($_tmp)); ?>
</div>
			<div class="news-text"><a href="/news/<?php echo $this->_tpl_vars['Item']['year']; ?>
/<?php echo $this->_tpl_vars['Item']['month']; ?>
/<?php echo $this->_tpl_vars['Item']['id_article']; ?>
/"><?php echo $this->_tpl_vars['Item']['title']; ?>
</a></div>	
			<?php endforeach; endif; unset($_from); ?>
			<?php endif; ?>
		</div>
		
		<div class="basic">
			<div id="breadcrumbs"><a href="/">На главную</a> / <a href="/news/">События</a> / <a href="/news/<?php echo $this->_tpl_vars['Article']['year']; ?>
/"><?php echo $this->_tpl_vars['Article']['year']; ?>
</a> / <span><?php echo $this->_tpl_vars['Article']['title']; ?>
</span></div>
			<h1>События</h1>
			<div class="date no-float"><?php echo ((is_array($_tmp=$this->_tpl_vars['Article']['date'])) ? $this->_run_mod_handler('month', true, $_tmp) : smarty_modifier_month($_tmp)); ?>
</div>
			<div class="topic"><?php echo $this->_tpl_vars['Article']['title']; ?>
</div>
			<div class="news-text"><?php echo $this->_tpl_vars['Article']['text']; ?>
</div>

			<div class="project-navigation">
				<?php if ($this->_tpl_vars['Prev']): ?>
				<a class="previous" href="/news/<?php echo $this->_tpl_vars['Prev']['year']; ?>
/<?php echo $this->_tpl_vars['Prev']['month']; ?>
/<?php echo $this->_tpl_vars['Prev']['id_article']; ?>
/">Предыдущее событие</a>
				<?php endif; ?>
				<a class="all" href="/news/">Все события</a>
				<?php if ($this->_tpl_vars['Next']): ?>
				<a class="next" href="/news/<?php echo $this->_tpl_vars['Next']['year']; ?>
/<?php echo $this->_tpl_vars['Next']['month']; ?>
/<?php echo $this->_tpl_vars['Next']['id_article']; ?>
/">Следующее событие</a>
				<?php endif; ?>
			</div>	

		</div>