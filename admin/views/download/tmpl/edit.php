<?php
/**
 * @package   	Egolt Project Publisher
 * @link 		http://www.egolt.com
 * @copyright 	Copyright (C) Egolt www.egolt.com
 * @author    	Soheil Novinfard
 * @license    	GNU/GPL 2
 *
 * Name:			Egolt Project Publisher
 * License:    		GNU/GPL 2
 * Project Page: 	http://www.egolt.com/products/egoltproject
 */
 
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<form action="<?php echo JRoute::_('index.php?option=com_egoltproject&view=download&layout=edit&id=' .  JRequest::getVar('id') ); ?>"
      method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="width-60 fltlft" >
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_EGOLTPROJECT_LANGCONTENT' ); ?></legend>
		<ul class="adminformlist">
		<?php $editor_fields = array('notes'); ?>
		<?php foreach($this->form->getFieldset('lang_attr') as $field): ?>
		<li>
			<?php if (in_array($field->fieldname,$editor_fields)): ?>
				<?php echo $field->label; ?>
				<div class="clr" ></div>
				<?php echo $field->input;?>
				<br/><br/><br/>
			<?php else: ?>
			<?php echo $field->label;echo $field->input;?>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
		</ul>
	</fieldset>
	</div>
	<div class="width-40 fltlft" >
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_EGOLTPROJECT_PUBDETAILS' ); ?></legend>
		<ul class="adminformlist">
		<?php foreach($this->form->getFieldset('general_attr') as $field): ?>
			<li><?php echo $field->label;echo $field->input;?></li>
		<?php endforeach; ?>
		</ul>
	</fieldset>
	</div>
	<div>
		<input type="hidden" name="task" value="download.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>