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

class JFormFieldEgoltList extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'EgoltList';

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
		$table = $this->element['table'] ? '_'.$this->element['table'] : '';

		// Initialize JavaScript field attributes.
		$attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

		// Get some field values from the form.
		$lang =& JFactory::getLanguage();
		$lang_tag = $lang->getTag();
		$elang	= JRequest::getVar('elang', $lang_tag);
			
		// Build the query for the list.
		$db	=& JFactory::getDBO();
		$query	= $db->getQuery(true);
		if($table=='_releases') {
			// Select the required fields from the table.
			$query->select('*, general.id as value');
			$query->from('#__egoltproject_releases as general');

			// Join over the language Content
			$query->select('lang.release_id as id,lang.notes');
			$query->join('LEFT', '`#__egoltproject_releases_lg` AS lang ON lang.release_id = general.id');

			// Join over the project
			$query->select('pro.project_id, pro.title');
			$query->join('LEFT', '`#__egoltproject_lg` AS pro ON (pro.project_id = general.project_id AND lang.lang_code = pro.lang_code)');	
			
			$query->select($query->concatenate(array('pro.title','general.version'),':') . ' as text');

			$query->where('lang.lang_code = ' . $db->quote($elang));	
			
			// die($query);
		}
		else {
			$query->select($this->element['valcol'].' as value, '.$this->element['txtcol'].' as text');
			$query->from('#__egoltproject'. $table .'_lg');
			$query->where('lang_code = ' . $db->quote($elang));
		}
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
