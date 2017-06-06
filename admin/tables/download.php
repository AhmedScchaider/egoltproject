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
 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.database.table');

class EgoltProjectTableDownload extends JTable
{
	function __construct(&$db) 
	{
		parent::__construct('#__egoltproject_downloads', 'id', $db);
	}
	
   function store($post)
   {
		parent::store($post);
		$id = JRequest::getVar('id');
		if($id)
			$last_id = $id;
		else
			$last_id = $this->_db->insertid();
			$data = JRequest::getVar('jform', array(), 'post', 'array'); 
		
			//check if language exist
			$query	= $this->_db->getQuery(true);
			$query->select('id');
			$query->from('#__egoltproject_downloads_lg');
			$query->where('`download_id` = '.(int)$id);
			$query->where('`lang_code` = '.$this->_db->quote($data['elang']));
			$this->_db->setQuery( (string)$query );	
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		if($this->_db->getNumRows()) {
				$query	= $this->_db->getQuery(true);
				$query->update('`#__egoltproject_downloads_lg`');
				$query->set('`title` = '.$this->_db->quote($data['title']));
				$query->set('`notes` = '.$this->_db->quote($data['notes']));
				$query->set('`doc_cat` = '.$this->_db->quote($data['doc_cat']));
				$query->where('`download_id` = '.(int)$id);
				$query->where('`lang_code` = '.$this->_db->quote($data['elang']));
				$this->_db->setQuery( (string)$query );	
				if (!$this->_db->query()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
		}
		else {
			$query = "INSERT INTO `#__egoltproject_downloads_lg` (`lang_code`, `download_id`, `title`, `notes`, `doc_cat`) VALUES ('{$data['elang']}', '{$last_id}', {$this->_db->quote($data['title'])}, {$this->_db->quote($data['notes'])}, '{$data['doc_cat']}' );";	  
			  
			$this->_db->setQuery($query);

			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
		
	}
	
}
