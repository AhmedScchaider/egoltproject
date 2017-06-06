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
 
defined('_JEXEC') or die;
jimport('joomla.application.component.modellist');

class EgoltProjectModelDownloads extends JModelList
{

	protected $_extension = 'com_egoltproject';

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();
		$this->setState('filter.extension', $this->_extension);

		$params = $app->getParams();
		$this->setState('params', $params);

		$this->setState('filter.published',	1);
		$this->setState('filter.access',	true);
		
		// List state information.
		parent::populateState('lang.project_id', 'DESC');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . $this->getState('filter.search');
		$id.= ':' . $this->getState('filter.published');
		$id.= ':' . $this->getState('filter.language');

		return parent::getStoreId($id);
	}
	function getID()
	{
		$id 	= JRequest::getVar( 'project' );
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,alias,published');
		$query->from('#__egoltproject');
		$query->where('published = 1');
		$query->where('alias = ' . $db->quote($id));
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$project_id = null;
		foreach ( $rows as $row )
		{
			$project_id = $row->id;
		}
		return $project_id;
	}
	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		$lang =& JFactory::getLanguage();
		$lang_tag = $lang->getTag();
		$id 	= $this->getID();
		$db 	= JFactory::getDBO();
		$query	= $db->getQuery(true);
		
		$query->select('general.*');
		$query->from('#__egoltproject_downloads as general');
		$query->where('general.published = 1');
		$query->where('general.project_id = ' . $db->quote($id));
		$query->order('general.compat_id DESC');

		// Join over the Compat
		$query->select('cpg.*');
		$query->join('LEFT', '`#__egoltproject_compats` AS cpg ON cpg.id = general.compat_id');
		
		// Join over the Compat language
		$query->select('cp.*,cp.name as compat_name');
		$query->join('LEFT', '`#__egoltproject_compats_lg` AS cp ON cp.compat_id = general.compat_id');
		$query->where('cp.lang_code = ' . $db->quote($lang_tag));			
		
		// Join over the Download
		$query->select('lang.*');
		$query->join('LEFT', '`#__egoltproject_downloads_lg` AS lang ON lang.download_id = general.id');
		$query->where('lang.lang_code = ' . $db->quote($lang_tag));		

		$query->select($query->concatenate(array('general.id','general.uname'),'-') . ' as dlslug');

		// die($query);
		
		return $query;
	}
	function getTitle()
	{
		$lang =& JFactory::getLanguage();
		$lang_tag = $lang->getTag();
		$id 	= $this->getID();
		$db 	= JFactory::getDBO();
		$query	= $db->getQuery(true);
		
		$query->select('general.*');
		$query->from('#__egoltproject as general');
		$query->where('general.published = 1');
		$query->where('general.id = ' . $db->quote($id));
		
		// Join over the Language
		$query->select('lang.*');
		$query->join('LEFT', '`#__egoltproject_lg` AS lang ON lang.project_id = general.id');
		$query->where('lang.lang_code = ' . $db->quote($lang_tag));		
		
		// echo nl2br(str_replace('#__','wg1ow_',$query));

		
		$db->setQuery($query);
		return $rows = $db->loadAssoc();
		}
}
