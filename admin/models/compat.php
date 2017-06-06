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
 

class EgoltProjectModelCompat extends JModelAdmin
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
	public function getTable($type = 'Compat', $prefix = 'EgoltProjectTable', $config = array()) 
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
		$form = $this->loadForm('com_egoltproject.compat', 'compat',
		                        array('control' => 'jform', 'load_data' => $loadData));
		$params = &JComponentHelper::getParams('com_egoltproject');
		if (empty($form)) 
		{
			return false;
		}
		$form->setFieldAttribute('imageurl', 'directory', $params->get('compats_dir', 'media/egoltproject/compats'));
		return $form;
	}
	protected function loadFormData() 
	{
		$id = (int) JRequest::getVar('id');
		$elang = JRequest::getVar('elang');
		
		if($id>0) {	
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from('#__egoltproject_compats_lg');
			$query->where('`compat_id` = '.$id);
			$query->where('`lang_code` = '.$this->_db->quote($elang));
			$this->_data = $this->_getList($query);
			foreach($this->_data as $i => $item) {
				$name = $item->name;
				$notes = $item->notes;
			}
		}
		
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_egoltproject.edit.compat.data', array());
		if (empty($data))
		{
			$data = $this->getItem();
			$data->set('elang', $elang);
			if(isset($name)) $data->set('name', $name);
			if(isset($notes)) $data->set('notes', $notes);			
		}
		return $data;
	}
	
	protected function canDelete($record)
	{
		if (!empty($record->id)) {
			//check if language exist
			$query	= $this->_db->getQuery(true);
			$query->select('id');
			$query->from('#__egoltproject_compats_lg');
			$query->where('`compat_id` = '.$record->id);
			$this->_db->setQuery( (string)$query );	
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			if(!$this->_db->getNumRows()) {
				//check if item exist
				$query	= $this->_db->getQuery(true);
				$query->select('id');
				$query->from('#__egoltproject_compats');
				$query->where('`id` = '.$record->id);
				$this->_db->setQuery( (string)$query );	
				if (!$this->_db->query()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
				if($this->_db->getNumRows()) {				
					parent::canDelete($record);
				}
			}
			else {
				$query = 'DELETE FROM #__egoltproject_compats_lg'
						. ' WHERE compat_id IN (' .$record->id. ')' ;
				$this->_db->setQuery( $query );
				if (!$this->_db->query()) {
					$this->setError( $this->_db->getErrorMsg() );
					return false;
				}
			}
			return true;
		}
		else {
			return false;
		}
	}
}
