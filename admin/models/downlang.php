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
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 

class EgoltProjectModelDownlang extends JModelAdmin
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Downlang', $prefix = 'EgoltProjectTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_egoltproject.downlang', 'downlang',
		                        array('control' => 'jform', 'load_data' => $loadData));
		$params = &JComponentHelper::getParams('com_egoltproject');
		if (empty($form)) 
		{
			return false;
		}
		$form->setFieldAttribute('langfile', 'directory', $params->get('languages_dir', 'media/egoltproject/languages'));
		return $form;
	}
	protected function loadFormData() 
	{
		$id = (int) JRequest::getVar('id');
		
		if($id>0) {	
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from('#__egoltproject_downloads_langs');
			$query->where('`id` = '.$id);
			$this->_data = $this->_getList($query);
			foreach($this->_data as $i => $item) {
				$pubdate = $item->pubdate;
			}
		}
		
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_egoltproject.edit.download.data', array());
		if (empty($data))
		{
			$data = $this->getItem();
			if(!isset($pubdate)) $data->set('pubdate', date('Y-m-d h:i:s'));
		}
		return $data;
	}

}
