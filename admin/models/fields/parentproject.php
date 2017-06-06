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

defined('JPATH_BASE') or die;


class JFormFieldParentProject extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'ParentProject';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		// Initialize variables.
		$html = array();
		$attr = '';

		// Initialize some field attributes.
		$attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$attr .= ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';
		$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';

		// Initialize JavaScript field attributes.
		$attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

		// Get some field values from the form.
		$contactId	= (int) $this->form->getValue('id');
		$categoryId	= (int) $this->form->getValue('catid');

		// Build the query for the list.
		$db	=& JFactory::getDBO();
		$query = 'SELECT id AS value, alias AS text,parentid' .
				' FROM #__egoltproject' ;
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		$options = array ();
		$options[] = JHTML::_('select.option', 0, JText::_('COM_EGOLTPROJECT_ROOT'));		
		foreach ( $rows as $row )
		{


		// Create a read-only list (no name) with a hidden input to store the value.
		// if ((string) $this->element['readonly'] == 'true') {
			// $html[] = JHtml::_('list.ordering', '', $query, trim($attr), $this->value, $contactId ? 0 : 1);
			// $html[] = '<input type="hidden" name="'.$this->name.'" value="'.$this->value.'"/>';
		// }
		
			// Construct an array of the HTML OPTION statements.
			if($row->parentid != 0)
				$row->text =  '|- ' . $row->text;
				
			$options[] = JHTML::_('select.option', $row->value, $row->text);
		
		}
		// $attribs	= ' ';
		// if ($v = $node->attributes( 'size' )) {
			// $attribs	.= 'size="'.$v.'"';
		// }
		// if ($v = $node->attributes( 'class' )) {
			// $attribs	.= 'class="'.$v.'"';
		// } else {
			// $attribs	.= 'class="inputbox"';
		// }
 
		// Render the HTML SELECT list.
		return JHTML::_('select.genericlist', $options, $this->name, $attr, 'value', 'text', $this->value );

	}
}
