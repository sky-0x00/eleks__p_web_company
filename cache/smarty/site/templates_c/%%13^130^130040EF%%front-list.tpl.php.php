<?php /* Smarty version 2.6.18, created on 2012-12-08 01:57:32
         compiled from C:/Users/sky-0x00/Documents/Visual+Studio+2008/Projects/p_web_company/admin/modules/module/block/articles/templates/front-list.tpl.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'month', 'C:/Users/sky-0x00/Documents/Visual Studio 2008/Projects/p_web_company/admin/modules/module/block/articles/templates/front-list.tpl.php', 35, false),)), $this); ?>
<div class="left-column" style="width: 180px">
			<h3 class="news">Архив статей</h3>
			<ul class="archive">
				<?php $_from = $this->_tpl_vars['months']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Item']):
?>
				<?php if ($this->_tpl_vars['Item']['active'] && ( ! isset ( $this->_tpl_vars['month'] ) || ( $this->_tpl_vars['month'] != $this->_tpl_vars['Item']['num'] ) )): ?>
				<li><a href="/articles/<?php echo $this->_tpl_vars['year']; ?>
/<?php echo $this->_tpl_vars['Item']['num']; ?>
/">/<?php echo $this->_tpl_vars['Item']['name']; ?>
</a></li>
				<?php elseif (( isset ( $this->_tpl_vars['month'] ) && ( $this->_tpl_vars['month'] == $this->_tpl_vars['Item']['num'] ) )): ?>
				<li class="active">/<?php echo $this->_tpl_vars['Item']['name']; ?>
</li>
				<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
			</ul>	
		</div>
		
		<div class="basic" style="margin-left: 180px">
			<div class="margin-left">
				<div id="breadcrumbs"><a href="/">Главная</a> / <span>Статьи</span></div>
				<h1>Статьи</h1>
				<div class="year-nav">
					<ul>
						<?php $_from = $this->_tpl_vars['years']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Key'] => $this->_tpl_vars['Item']):
?>
						<?php if (( isset ( $this->_tpl_vars['year'] ) && ( $this->_tpl_vars['year'] != $this->_tpl_vars['Item'] ) )): ?>
						<li><a href="/articles/<?php echo $this->_tpl_vars['Item']; ?>
/">/<?php echo $this->_tpl_vars['Item']; ?>
</a></li>
						<?php else: ?>
						<li>/<?php echo $this->_tpl_vars['Item']; ?>
</li>
						<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>						
					</ul>
				</div>
			</div>
			
			<?php unset($this->_sections['ext']);
$this->_sections['ext']['name'] = 'ext';
$this->_sections['ext']['loop'] = is_array($_loop=$this->_tpl_vars['articles']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ext']['step'] = ((int)$this->_tpl_vars['pager']) == 0 ? 1 : (int)$this->_tpl_vars['pager'];
$this->_sections['ext']['show'] = true;
$this->_sections['ext']['max'] = $this->_sections['ext']['loop'];
$this->_sections['ext']['start'] = $this->_sections['ext']['step'] > 0 ? 0 : $this->_sections['ext']['loop']-1;
if ($this->_sections['ext']['show']) {
    $this->_sections['ext']['total'] = min(ceil(($this->_sections['ext']['step'] > 0 ? $this->_sections['ext']['loop'] - $this->_sections['ext']['start'] : $this->_sections['ext']['start']+1)/abs($this->_sections['ext']['step'])), $this->_sections['ext']['max']);
    if ($this->_sections['ext']['total'] == 0)
        $this->_sections['ext']['show'] = false;
} else
    $this->_sections['ext']['total'] = 0;
if ($this->_sections['ext']['show']):

            for ($this->_sections['ext']['index'] = $this->_sections['ext']['start'], $this->_sections['ext']['iteration'] = 1;
                 $this->_sections['ext']['iteration'] <= $this->_sections['ext']['total'];
                 $this->_sections['ext']['index'] += $this->_sections['ext']['step'], $this->_sections['ext']['iteration']++):
$this->_sections['ext']['rownum'] = $this->_sections['ext']['iteration'];
$this->_sections['ext']['index_prev'] = $this->_sections['ext']['index'] - $this->_sections['ext']['step'];
$this->_sections['ext']['index_next'] = $this->_sections['ext']['index'] + $this->_sections['ext']['step'];
$this->_sections['ext']['first']      = ($this->_sections['ext']['iteration'] == 1);
$this->_sections['ext']['last']       = ($this->_sections['ext']['iteration'] == $this->_sections['ext']['total']);
?>
			<div class="news-page" <?php if (( $this->_sections['ext']['index'] != 0 )): ?> style="display: none;"<?php endif; ?>>  
				<?php unset($this->_sections['int']);
$this->_sections['int']['name'] = 'int';
$this->_sections['int']['loop'] = is_array($_loop=$this->_tpl_vars['articles']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['int']['start'] = (int)$this->_sections['ext']['index'];
$this->_sections['int']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['int']['max'] = (int)$this->_tpl_vars['pager'];
$this->_sections['int']['show'] = true;
if ($this->_sections['int']['max'] < 0)
    $this->_sections['int']['max'] = $this->_sections['int']['loop'];
if ($this->_sections['int']['start'] < 0)
    $this->_sections['int']['start'] = max($this->_sections['int']['step'] > 0 ? 0 : -1, $this->_sections['int']['loop'] + $this->_sections['int']['start']);
else
    $this->_sections['int']['start'] = min($this->_sections['int']['start'], $this->_sections['int']['step'] > 0 ? $this->_sections['int']['loop'] : $this->_sections['int']['loop']-1);
if ($this->_sections['int']['show']) {
    $this->_sections['int']['total'] = min(ceil(($this->_sections['int']['step'] > 0 ? $this->_sections['int']['loop'] - $this->_sections['int']['start'] : $this->_sections['int']['start']+1)/abs($this->_sections['int']['step'])), $this->_sections['int']['max']);
    if ($this->_sections['int']['total'] == 0)
        $this->_sections['int']['show'] = false;
} else
    $this->_sections['int']['total'] = 0;
if ($this->_sections['int']['show']):

            for ($this->_sections['int']['index'] = $this->_sections['int']['start'], $this->_sections['int']['iteration'] = 1;
                 $this->_sections['int']['iteration'] <= $this->_sections['int']['total'];
                 $this->_sections['int']['index'] += $this->_sections['int']['step'], $this->_sections['int']['iteration']++):
$this->_sections['int']['rownum'] = $this->_sections['int']['iteration'];
$this->_sections['int']['index_prev'] = $this->_sections['int']['index'] - $this->_sections['int']['step'];
$this->_sections['int']['index_next'] = $this->_sections['int']['index'] + $this->_sections['int']['step'];
$this->_sections['int']['first']      = ($this->_sections['int']['iteration'] == 1);
$this->_sections['int']['last']       = ($this->_sections['int']['iteration'] == $this->_sections['int']['total']);
?>
				<div class="news-block">
					<div class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['articles'][$this->_sections['int']['index']]['date'])) ? $this->_run_mod_handler('month', true, $_tmp) : smarty_modifier_month($_tmp)); ?>
</div>
					<div class="news-text"><a href="/articles/<?php echo $this->_tpl_vars['articles'][$this->_sections['int']['index']]['year']; ?>
/<?php echo $this->_tpl_vars['articles'][$this->_sections['int']['index']]['month']; ?>
/<?php echo $this->_tpl_vars['articles'][$this->_sections['int']['index']]['id_article']; ?>
/"><?php echo $this->_tpl_vars['articles'][$this->_sections['int']['index']]['title']; ?>
</a></div>
					<div class="news-text"><?php echo $this->_tpl_vars['articles'][$this->_sections['int']['index']]['annot']; ?>
</div>
				</div> 
				<?php endfor; endif; ?>
			</div>
			<?php endfor; endif; ?>
			
			<?php if ($this->_tpl_vars['pages'] > 1): ?>
			<ul class="nav-pages margin-left">
				<li class="first"><a class="left"></a></li>
				<li class="current">1</li>
				<?php unset($this->_sections['pages']);
$this->_sections['pages']['name'] = 'pages';
$this->_sections['pages']['loop'] = is_array($_loop=$this->_tpl_vars['pages']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['pages']['start'] = (int)1;
$this->_sections['pages']['show'] = true;
$this->_sections['pages']['max'] = $this->_sections['pages']['loop'];
$this->_sections['pages']['step'] = 1;
if ($this->_sections['pages']['start'] < 0)
    $this->_sections['pages']['start'] = max($this->_sections['pages']['step'] > 0 ? 0 : -1, $this->_sections['pages']['loop'] + $this->_sections['pages']['start']);
else
    $this->_sections['pages']['start'] = min($this->_sections['pages']['start'], $this->_sections['pages']['step'] > 0 ? $this->_sections['pages']['loop'] : $this->_sections['pages']['loop']-1);
if ($this->_sections['pages']['show']) {
    $this->_sections['pages']['total'] = min(ceil(($this->_sections['pages']['step'] > 0 ? $this->_sections['pages']['loop'] - $this->_sections['pages']['start'] : $this->_sections['pages']['start']+1)/abs($this->_sections['pages']['step'])), $this->_sections['pages']['max']);
    if ($this->_sections['pages']['total'] == 0)
        $this->_sections['pages']['show'] = false;
} else
    $this->_sections['pages']['total'] = 0;
if ($this->_sections['pages']['show']):

            for ($this->_sections['pages']['index'] = $this->_sections['pages']['start'], $this->_sections['pages']['iteration'] = 1;
                 $this->_sections['pages']['iteration'] <= $this->_sections['pages']['total'];
                 $this->_sections['pages']['index'] += $this->_sections['pages']['step'], $this->_sections['pages']['iteration']++):
$this->_sections['pages']['rownum'] = $this->_sections['pages']['iteration'];
$this->_sections['pages']['index_prev'] = $this->_sections['pages']['index'] - $this->_sections['pages']['step'];
$this->_sections['pages']['index_next'] = $this->_sections['pages']['index'] + $this->_sections['pages']['step'];
$this->_sections['pages']['first']      = ($this->_sections['pages']['iteration'] == 1);
$this->_sections['pages']['last']       = ($this->_sections['pages']['iteration'] == $this->_sections['pages']['total']);
?>
				<li><a><?php echo $this->_sections['pages']['index']+1; ?>
</a></li>
				<?php endfor; endif; ?>
				<li><a class="right"></a></li>
			</ul>
			<?php endif; ?>
			
		</div>