<?php /* Smarty version 2.6.18, created on 2012-12-06 10:37:24
         compiled from C:/Users/sky-0x00/Documents/Visual+Studio+2008/Projects/p_web_company/admin/modules/module/block/feedback/templates/front.tpl.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', 'C:/Users/sky-0x00/Documents/Visual Studio 2008/Projects/p_web_company/admin/modules/module/block/feedback/templates/front.tpl.php', 3, false),)), $this); ?>
<?php ob_start(); ?>

<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['module_content']), $this);?>


<?php $this->_smarty_vars['capture']['body'] = ob_get_contents(); ob_end_clean(); ?>

<?php echo $this->_smarty_vars['capture']['body']; ?>