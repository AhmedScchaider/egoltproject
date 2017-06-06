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
 
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class EgoltProjectViewDownload extends JView
{
	protected $download;

	public function display($tpl = null)
	{
		$this->params2		= &JComponentHelper::getParams('com_egoltproject');
		$this->download		= $this->get('Download');
		$this->downloads	= $this->get('Downloads');
		$this->params		= &$this->state->params;
		$this->demoimg		= $this->demogallery();
		$this->dsubmit		= $this->get('DownloadSubmit');
		$this->hitsumbit	= $this->get('HitSubmit');
		$this->rlist		= $this->get('ReviewList');
		$this->dlangs		= $this->get('DLangs');
		if($this->params2->get('en_rev', 1))
		{
			$this->rsubmit		= $this->get('ReviewSubmit');
		}
		
		if($this->download['doc_cat']) {
			$model = &$this->getModel();
			$this->doclist = $model->getDocList($this->download['doc_cat']);
		}
		else
			$this->doclist = null;
		
		if(JRequest::getVar('lang-id'))
			$this->langdlsubmit = $this->get('LangDLSubmit');
		
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		$this->meta();
		parent::display($tpl);
	}
	
	public function demogallery(){
		//import important classes
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		
		// Get the path in which to search for file options.
		$demos_dir = $this->params2->get('demos_dir', 'media/egoltproject/demos');
		$path = (string) $demos_dir  . DS . $this->download['demo_gallery'];
		// die($path);
		if (!is_dir($path))
		{
			$path = JPATH_ROOT . '/' . $path;
		}

		// Get a list of files in the search path with the given filter.
		$files = JFolder::files($path, '\.png$|\.jpg$', false, true);

		return $files;
	}

	public function meta()
	{
		$gtitle = $this->download['title'] . ' ' . $this->download['version'];
		
		$gdesc = $this->download['title'] . ' ' . $this->download['version'];
		
		$gkey = array();
		$gkey[] = $this->download['title'];
		$gkey[] = 'version ' . $this->download['version'];
		$gkey[] = JText::_('COM_EGOLTPROJECT_DTYPE_'.$this->download['dtype']);
		$gkey[] = JText::_('COM_EGOLTPROJECT_DEV_'.$this->download['status']);
		$gkey[] = $this->download['compat_name'];
		$gkey[] = $this->download['uname'];
		$gkey[] = $this->download['author_name'];
		$gkey[] = JHTML::_('date', $this->download['pubdate'], JText::_('DATE_FORMAT_LC3'));
		$gkey[] = $this->download['license_name'];
		$gkeyword =  implode(',', $gkey);
		
		
		//title
		if($gtitle)
			$title = $gtitle;
		else if($tmph = $this->escape($this->params->get('page_heading')))
			$title = $tmph;

		//description
		if($gdesc)
			$description = $gdesc;
		else if($title)
			$description = $title;
		else if($tmp = $this->params->get('menu-meta_description'))
			$description = $tmp;
			
		//keywords
		if($gkeyword)
			$keywords = $gkeyword;
		else if($tmp = $this->params->get('menu-meta_keywords'))
			$keywords = $tmp;

		$this->document->setTitle($title);
		$this->document->setDescription($description);
		$this->document->setMetadata('keywords', $keywords);
	}	
}
