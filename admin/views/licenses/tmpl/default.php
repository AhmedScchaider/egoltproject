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
 
// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));

?>

<form action="<?php echo JRoute::_('index.php?option=com_egoltproject&view=licenses'); ?>" method="post" name="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_EGOLTPROJECT_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">
		
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('all' => 0,'archived'=>0,'trash'=>0)), 'value', 'text', $this->state->get('filter.published'), true);?>
			</select>

			<select name="filter_language" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_LANGUAGE');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('contentlanguage.existing', false, true), 'value', 'text', $this->state->get('filter.language'));?>
			</select>
		</div>
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				<th width="25%">
					<?php echo JHtml::_('grid.sort',  'COM_EGOLTPROJECT_NAME', 'lang.name', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort',  'COM_EGOLTPROJECT_DESC', 'lang.notes', $listDirn, $listOrder); ?>
				</th>
				<th width="15%">
					<?php echo JHtml::_('grid.sort', 'COM_EGOLTPROJECT_CONTENTLANG', 'lang.lang_code', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort',  'JSTATUS', 'general.published', $listDirn, $listOrder); ?>
				</th>
				<th width="1%" class="nowrap">
					<?php echo JHtml::_('grid.sort',  'COM_EGOLTPROJECT_ID', 'lang.license_id', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item): ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->license_id); ?>
				</td>
				<td>
					<a href="<?php echo JRoute::_('index.php?option=com_egoltproject&task=license.edit&id='.(int) $item->license_id. '&elang='. $item->lang_code); ?>">
							<?php echo $this->escape($item->name); ?>
					</a>
					<p class="smallsub">
						<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias));?>
					</p>
				</td>
				<td>
					<?php echo substr(strip_tags($item->notes),0,200) . ' ...'; ?>
				</td>
				<td align="center">
				<?php foreach($this->langs as $i => $languages): ?>
					<?php
						$default_lang = '';
						if($item->lang_code == $languages->lang_code) 
							$default_lang = 'style="border:1px solid #000;padding:3px;"';
						else
							$default_lang = 'style="padding:3px;"';							
					?>
					<a href="<?php echo JRoute::_('index.php?option=com_egoltproject&task=license.edit&id='. $item->license_id . '&elang=' . $languages->lang_code); ?>">
						<img <?php echo $default_lang; ?> src="<?php echo JURI::root().'media/mod_languages/images/'.substr($languages->lang_code,0,2).'.gif' ?>" alt="<?php echo $languages->title_native?>" />
					</a>
				<?php endforeach; ?>
				</td>
				<td class="center">
					<?php echo JHTML::_('jgrid.published', $item->published, $i, 'licenses.'); ?>
				</td>
				<td class="center">
					<?php echo (int) $item->license_id; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
