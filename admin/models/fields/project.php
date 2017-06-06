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

class JFormFieldProject extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Project';

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

		// Initialize JavaScript field attributes.
		$attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

		// Get some field values from the form.
		$lang =& JFactory::getLanguage();
		$lang_tag = $lang->getTag();
		$elang	= JRequest::getVar('elang', $lang_tag);

		// Build the query for the list.
		$db	=& JFactory::getDBO();
		$query	= $db->getQuery(true);
		$query->select('*,general.alias as value, lang.title as text');
		$query->from('#__egoltproject as general');
		$query->join('LEFT', '`#__egoltproject_lg` AS lang ON lang.project_id = general.id');
		$query->where('lang_code = ' . $db->quote($elang));
		// die($query);
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		$options = array ();
		foreach ( $rows as $row )
		{
			$options[] = JHTML::_('select.option', $row->value, $row->text);		
		}

		// Render the HTML SELECT list.
		return JHTML::_('select.genericlist', $options, $this->name, $attr, 'value', 'text', $this->value );

	}
}
