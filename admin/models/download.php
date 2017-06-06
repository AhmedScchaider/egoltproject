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
 

class EgoltProjectModelDownload extends JModelAdmin
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
	public function getTable($type = 'Download', $prefix = 'EgoltProjectTable', $config = array()) 
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
		$form = $this->loadForm('com_egoltproject.download', 'download',
		                        array('control' => 'jform', 'load_data' => $loadData));
		$params = &JComponentHelper::getParams('com_egoltproject');
		if (empty($form)) 
		{
			return false;
		}
		$form->setFieldAttribute('demo_gallery', 'directory', $params->get('demos_dir', 'media/egoltproject/demos'));
		$form->setFieldAttribute('filename', 'directory', $params->get('downloads_dir', 'media/egoltproject/downloads'));
		return $form;
	}
	protected function loadFormData() 
	{	
		// check if not empty licenses table
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__egoltproject_licenses');
		$db->setQuery( (string)$query );	
		$db->query();
		if(!$db->getNumRows()) {
			JError::raiseWarning(500, '<a href="'.JRoute::_('index.php?option=com_egoltproject&view=licenses').'">'.JText::_('COM_EGOLTPROJECT_ADD_LIC_WARN').'</a>');				
		}
		
		// check if not empty Compatibility table
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__egoltproject_compats');
		$db->setQuery( (string)$query );	
		$db->query();
		if(!$db->getNumRows()) {
			JError::raiseWarning(500, '<a href="'.JRoute::_('index.php?option=com_egoltproject&view=compats').'">'.JText::_('COM_EGOLTPROJECT_ADD_COMPAT_WARN').'</a>');				
		}

		$id = (int) JRequest::getVar('id');
		$elang = JRequest::getVar('elang');
		
		if($id>0) {	
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('lang.*');
			$query->from('#__egoltproject_downloads_lg as lang');
			$query->where('lang.download_id = '.$id);
			$query->where('lang.lang_code = '.$this->_db->quote($elang));
			
			// Join over the general download
			$query->select('general.id, general.pubdate');
			$query->join('LEFT', '#__egoltproject_downloads AS general ON general.id = lang.download_id');
			
			$this->_data = $this->_getList($query);
			foreach($this->_data as $i => $item) {
				$title = $item->title;
				$notes = $item->notes;
				$doc_cat = $item->doc_cat;
				$pubdate = $item->pubdate;
			}
		}
		
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_egoltproject.edit.download.data', array());
		if (empty($data))
		{
			$data = $this->getItem();
			$data->set('elang', $elang);
			if(isset($title)) $data->set('title', $title);
			if(isset($notes)) $data->set('notes', $notes);			
			if(isset($doc_cat)) $data->set('doc_cat', $doc_cat);
			if(!isset($pubdate)) $data->set('pubdate', date('Y-m-d h:i:s'));
		}
		return $data;
	}
	
	protected function canDelete($record)
	{
		if (!empty($record->id)) {
			//check if language exist
			$query	= $this->_db->getQuery(true);
			$query->select('id');
			$query->from('#__egoltproject_downloads_lg');
			$query->where('`download_id` = '.$record->id);
			$this->_db->setQuery( (string)$query );	
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			if(!$this->_db->getNumRows()) {
				//check if item exist
				$query	= $this->_db->getQuery(true);
				$query->select('id');
				$query->from('#__egoltproject_downloads');
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
				$query = 'DELETE FROM #__egoltproject_downloads_lg'
						. ' WHERE download_id IN (' .$record->id. ')' ;
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
