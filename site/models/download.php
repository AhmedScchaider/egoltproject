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
jimport('joomla.application.component.modelitem');

class EgoltProjectModelDownload extends JModelItem
{
	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	public function getDownload()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$user	= JFactory::getUser();
		$id 	= JRequest::getVar( 'download-id' );
		$id2 	= explode(':', $id);
		$id		= (int) $id2[0];
		$lang 	=& JFactory::getLanguage();
		$lang_tag	= $lang->getTag();
				
		// Select the required fields from the table.
		$query->select('general.*');
		$query->from('#__egoltproject_downloads as general');

		// Join over the language Content
		$query->select('lang.*,lang.download_id as id');
		$query->join('LEFT', '`#__egoltproject_downloads_lg` AS lang ON lang.download_id = general.id');
		$query->where('lang.lang_code = ' . $db->quote($lang_tag));			

		// Join over the Compat
		$query->select('cpg.*');
		$query->join('LEFT', '`#__egoltproject_compats` AS cpg ON cpg.id = general.compat_id');
		
		// Join over the License
		$query->select('lic.lang_code, lic.license_id, lic.name as license_name, lic.notes as license_notes');
		$query->join('LEFT', '`#__egoltproject_licenses_lg` AS lic ON lic.license_id = general.license_id');
		$query->where('lic.lang_code = ' . $db->quote($lang_tag));
		
		// Join over the users for the author.
		$query->select('ua.id, ua.name AS author_name');
		$query->join('LEFT', '#__users AS ua ON ua.id = general.user_id');
		
		// Join over the Compat language
		$query->select('cp.lang_code,cp.compat_id, cp.name as compat_name');
		$query->join('LEFT', '`#__egoltproject_compats_lg` AS cp ON cp.compat_id = general.compat_id');
		$query->where('cp.lang_code = ' . $db->quote($lang_tag));			
	
		$query->where('lang.lang_code = ' . $db->quote($lang_tag));
		
		$query->where('general.published = 1');
		
		$query->where('general.id = ' . $db->quote($id));

		$db->setQuery($query);

		// echo nl2br(str_replace('#__','wg1ow_',$query));


		return $rows = $db->loadAssoc();
	
	}
	
	public function getDLangs()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$user	= JFactory::getUser();
		$id 	= JRequest::getVar( 'download-id' );
		$id2 	= explode(':', $id);
		$id		= (int) $id2[0];
		
		// Select the required fields from the table.
		$query->select('g.*');
		$query->from('#__egoltproject_downloads_langs as g');	

		// Join over the languages
		$query->select('l.lang_code, l.title_native as lang_name');
		$query->join('LEFT', '`#__languages` AS l ON l.lang_code = g.lang_code');

		// Join over the users
		$query->select('u.id, u.name AS translator');
		$query->join('LEFT', '#__users AS u ON u.id = g.user_id');	
		
		$query->where('g.published = 1');		
		$query->where('g.download_id = ' . $db->quote($id));		

		// echo nl2br(str_replace('#__','wg1ow_',$query));
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return $rows;
	}

	function getLangDLSubmit()
	{
		$params = &JComponentHelper::getParams('com_egoltproject');
		$id 	= JRequest::getVar( 'download-id' );
		$id2 	= explode(':', $id);
		$id		= (int) $id2[0];
		if($lang_code = JRequest::getVar('lang-id')) {
			$lang_code = str_replace(':', '-', $lang_code);
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from('#__egoltproject_downloads_langs');
			$query->where('published = 1');
			$query->where('download_id = ' . $db->quote($id));
			$query->where('lang_code = ' . $db->quote($lang_code));
			$db->setQuery($query);
			$row = $db->loadObject();

			$db = JFactory::getDBO();
			$query = $db->getQuery(true);			
			$query->update('`#__egoltproject_downloads_langs`');
			$query->set('`hit` = '. ++$row->hit);
			$query->where('`id` = '. $row->id);
			$db->setQuery($query);
			$db->query();			

			if($row->langfile)
			{
				$file = JPATH_ROOT . DS . $params->get('languages_dir', 'media/egoltproject/languages') . DS . $row->langfile;
				if (file_exists($file)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename='.basename($file));
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					ob_clean();
					flush();
					readfile($file);
					exit;
				}
			}
		}
	}

	function getHitSubmit()
	{
		$params = &JComponentHelper::getParams('com_egoltproject');
		$id 	= JRequest::getVar( 'download-id' );
		$id2 	= explode(':', $id);
		$id		= (int) $id2[0];
		$db		= JFactory::getDBO();
		$query	= $db->getQuery(true);
		$query->select('id,published,hit');
		$query->from('#__egoltproject_downloads');
		$query->where('published = 1');
		$query->where('id = ' . $db->quote($id));
		$db->setQuery($query);
		$row = $db->loadObject();

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);			
		$query->update('`#__egoltproject_downloads`');
		$query->set('`hit` = '. ++$row->hit);
		$query->where('`id` = '. $row->id);
		$db->setQuery($query);
		$db->query();			
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
		if(!JRequest::getVar( 'project' ))
		{
			$id 	= JRequest::getVar( 'download-id' );
			$id2 	= explode(':', $id);
			$id		= (int) $id2[0];	
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('id,project_id,published');
			$query->from('#__egoltproject_downloads');
			$query->where('published = 1');	
			$query->where('id = ' . $db->quote($id));
			$db->setQuery($query);
			$row = $db->loadObject();
			return $row->project_id;
		}
		else
		{
			$id 	= JRequest::getVar( 'project' );
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('id,alias,published');
			$query->from('#__egoltproject');
			$query->where('published = 1');
			$query->where('alias = ' . $db->quote($id));
			$db->setQuery($query);
			$row = $db->loadObject();
			return $row->id;
		}
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
		
		$id 		= JRequest::getVar( 'download-id' );
		$id2 		= explode(':', $id);
		$download_id = (int) $id2[0];
		$query->where('general.id != ' . $db->quote($download_id));		
		
		
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
			$items[$i]->dtype		= $row->dtype ;
		}
		return $items;
		
	}
	
	function getReviewList()
	{
		$id 		= JRequest::getVar( 'download-id' );
		$id2 		= explode(':', $id);
		$download_id = (int) $id2[0];
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__egoltproject_reviews');
		$query->where('download_id = ' . $db->quote($download_id));		
		$query->where('published = ' . $db->quote('1'));		
		$query->order('pubdate ASC');
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return $rows;
	}
	
	public function getDownloadSubmit (){
		$params = &JComponentHelper::getParams('com_egoltproject');
		if(JRequest::getVar('download_form')) {
			$regex = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix';
			$valid_email = preg_match($regex, JRequest::getVar('dlemail')) ? true : false; 
			// $valid_email = preg_match($regex, JRequest::getVar('dlemail'));

			if(JRequest::getVar('dlemail') and JRequest::getVar('dlname') and $valid_email) {
				if($params->get('log_dl', 1))
				{
					$id 		= JRequest::getVar( 'download-id' );
					$id2 		= explode(':', $id);
					$download_id = (int) $id2[0];
					$logemail	= JRequest::getVar('dlemail');
					$logname	= JRequest::getVar('dlname');
					$logip		= $_SERVER['REMOTE_ADDR'];
					$lang		=& JFactory::getLanguage();
					$lang_tag 	= $lang->getTag();
					$project_id = $this->getID();
					$logdate	= date('Y-m-d');
					$db 		= JFactory::getDBO();
					$query		= $db->getQuery(true);
					$query->insert('#__egoltproject_logs');
					$query->set('project_id	= ' . $db->quote($project_id));
					$query->set('download_id = ' . $db->quote($download_id));
					$query->set('logname = ' . $db->quote($logname));
					$query->set('logemail = ' . $db->quote($logemail));
					$query->set('logip = ' . $db->quote($logip));
					$query->set('logdate = ' . $db->quote($logdate));
					// die($query);
					$db->setQuery($query);
					if (!$db->query()) {
						$this->setError($db->getErrorMsg());
						return false;
					}			
				}
				
				$this->download = $this->getDownload();
				
				$file = JPATH_ROOT . DS . $params->get('downloads_dir', 'media/egoltproject/downloads') . DS . $this->download['filename'];
				if($this->download['filename'])
				{
					if (file_exists($file)) {
						header('Content-Description: File Transfer');
						header('Content-Type: application/octet-stream');
						header('Content-Disposition: attachment; filename='.basename($file));
						header('Content-Transfer-Encoding: binary');
						header('Expires: 0');
						header('Cache-Control: must-revalidate');
						header('Pragma: public');
						header('Content-Length: ' . filesize($file));
						ob_clean();
						flush();
						readfile($file);
						exit;
					}
				}
			}
			else
			{
				$error_msg = JText::_('COM_EGOLTPROJECT_FILL_F_FIELDS') . ': ';
				if(!JRequest::getVar('dlname'))
					$error_arr[] = ' <b>'.JText::_('COM_EGOLTPROJECT_NAME').'</b>';
				if(!JRequest::getVar('dlemail'))
				{
					$error_arr[] = ' <b>'.JText::_('COM_EGOLTPROJECT_EMAIL').'</b>';
				}
				else
				{
					if(!$valid_email)
						$error_arr[] = ' <b>'.JText::_('COM_EGOLTPROJECT_INVALID_EMAIL').'</b>';
				}
				return $error_msg . implode($error_arr , ',');
			}
		}
	}

	public function getReviewSubmit (){
		if(JRequest::getVar('review_form')) {
			if(JRequest::getVar('commenter') and JRequest::getVar('comment')) {
				$id 		= JRequest::getVar( 'download-id' );
				$id2 		= explode(':', $id);
				$download_id = (int) $id2[0];
				$commenter	= JRequest::getVar('commenter');
				$comment	= JRequest::getVar('comment');
				$email		= JRequest::getVar('email');
				$website	= JRequest::getVar('website');
				$lang		=& JFactory::getLanguage();
				$lang_code 	= $lang->getTag();
				$pubdate	= date('Y-m-d h:i:s');
				// $project_id = $this->getID();
				$db 		= JFactory::getDBO();
				$query		= $db->getQuery(true);
				$query->insert('#__egoltproject_reviews');
				// $query->set('project_id	= ' . $db->quote($project_id));
				$query->set('download_id = ' . $db->quote($download_id));
				$query->set('lang_code = ' . $db->quote($lang_code));
				$query->set('comment = ' . $db->quote($comment));
				$query->set('commenter = ' . $db->quote($commenter));
				$query->set('email = ' . $db->quote($email));
				$query->set('website = ' . $db->quote($website));
				$query->set('pubdate = ' . $db->quote($pubdate));
				// die($query);
				$db->setQuery($query);
				if (!$db->query()) {
					$this->setError($db->getErrorMsg());
					return false;
				}
				$content = 'alert( \''.JText::_('COM_EGOLTPROJECT_THANKU').', '. $commenter .'. '.JText::_('COM_EGOLTPROJECT_COMMENT_SUBNOTE').'\' )';
				$doc =& JFactory::getDocument();
				$doc->addScriptDeclaration( $content );
			}
			else
			{
				$error_msg =  JText::_('COM_EGOLTPROJECT_FILL_R_FIELDS') . ': ';
				if(!JRequest::getVar('commenter'))
					$error_arr[] = ' <b>'.JText::_('COM_EGOLTPROJECT_NAME').'</b>';
				if(!JRequest::getVar('comment'))
					$error_arr[] = ' <b>'.JText::_('COM_EGOLTPROJECT_COMMENT').'</b>';
				return $error_msg . implode($error_arr , ',');
			}
		}
	}
	public function getDocList ($doc_cat){
		$params = &JComponentHelper::getParams('com_egoltproject');
		require_once JPATH_SITE.'/components/com_content/helpers/route.php';
		JModel::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');
		
		// Get the dbo
		$db = JFactory::getDbo();

		// Get an instance of the generic articles model
		$model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

		// Set application parameters in model
		$app = JFactory::getApplication();
		$appParams = $app->getParams();
		$model->setState('params', $appParams);
		
		// Set the filters based on the module params
		$model->setState('list.start', 0);
		$model->setState('list.limit', (int) $params->get('doc_count', 0));
		$model->setState('filter.published', 1);

		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);

		// Category filter
		$model->setState('filter.category_id', array($doc_cat));
		
		// Filter by language
		$model->setState('filter.language', $app->getLanguageFilter());
		
		// Set ordering
		$order_map = array(
			'm_dsc' => 'a.modified DESC, a.created',
			'mc_dsc' => 'CASE WHEN (a.modified = '.$db->quote($db->getNullDate()).') THEN a.created ELSE a.modified END',
			'c_dsc' => 'a.created',
			'p_dsc' => 'a.publish_up',
		);
		$ordering = JArrayHelper::getValue($order_map, $params->get('ordering'), 'a.publish_up');
		$dir = 'DESC';

		$model->setState('list.ordering', $ordering);
		$model->setState('list.direction', $dir);

		$items = $model->getItems();

		foreach ($items as &$item) {
			$item->slug = $item->id.':'.$item->alias;
			$item->catslug = $item->catid.':'.$item->category_alias;

			if ($access || in_array($item->access, $authorised)) {
				// We know that user has the privilege to view the article
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
			} else {
				$item->link = JRoute::_('index.php?option=com_users&view=login');
			}
		}
		
		return $items;
	}
}
