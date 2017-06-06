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

class JFormFieldDownload extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Download';

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
		$query->select('g.id, g.uname, g.version');
		$query->from('#__egoltproject_downloads as g');
		
		// Join over the Download
		$query->select('lang.*');
		$query->join('LEFT', '`#__egoltproject_downloads_lg` AS lang ON lang.download_id = g.id');
		$query->where('lang.lang_code = ' . $db->quote($elang));				
	
		if($this->element['nounq'])
			$query->select('g.id as value');		
		else
			$query->select($query->concatenate(array('g.id','g.uname'),':') . ' as value');
		$query->select($query->concatenate(array('lang.title','g.version'),'-') . ' as text');
		
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
