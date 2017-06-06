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

class EgoltProjectModelProject extends JModelList
{

	protected $_extension = 'com_egoltproject';


	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'lang.project_id',
				'title', 'lang.title',
				'lang_code', 'lang.lang_code',
				'jed', 'general.jed',
				'intro', 'lang.intro',
				'alias', 'general.alias',
				'pubdate', 'general.pubdate',
				'published', 'general.published',
			);
		}

		parent::__construct($config);
	}


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

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$user	= JFactory::getUser();
		$id 	= JRequest::getVar( 'id' );
		
		// Select the required fields from the table.
		$query->select('general.*');
		$query->from('#__egoltproject as general');

		// Join over the language Content
		$query->select('lang.*,lang.project_id as id');
		$query->join('LEFT', '`#__egoltproject_lg` AS lang ON lang.project_id = general.id');
		
		$lang =& JFactory::getLanguage();
		$lang_tag = $lang->getTag();
		$query->where('lang.lang_code = ' . $db->quote($lang_tag));
		
		$query->where('general.published = 1');
		
		$query->where('general.alias = ' . $db->quote($id));

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');

		$query->order($db->getEscaped($orderCol.' '.$orderDirn));

		return $query;
	}
	
	function getLangs()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('lang_code, title_native');
		$query->from('#__languages');
		$query->order('lang_code ASC');
		$this->_data = $this->_getList($query);
		return $this->_data;
	}

	function getID()
	{
		$id 	= JRequest::getVar( 'id' );
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

	function getDownloads()
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
		
		// echo nl2br(str_replace('#__','wg1ow_',$query));

		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$items	= array();
		foreach ( $rows as $i => $row )
		{
			$items[$i]->id			= $row->download_id;
			$items[$i]->dlslug		= $row->dlslug;
			$items[$i]->title		= $row->title;
			$items[$i]->imageurl	= $row->imageurl;
			$items[$i]->compat_name	= $row->compat_name;
			$items[$i]->version		= $row->version;
			$items[$i]->status		= JText::_('COM_EGOLTPROJECT_DEV_'.$row->status);
			$items[$i]->dtype		= $row->dtype;
		}
		return $items;
		
	}
}
