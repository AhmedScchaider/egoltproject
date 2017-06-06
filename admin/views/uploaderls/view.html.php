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

class EgoltProjectViewUploaderls extends JView
{
	function display($tpl = null)
	{
		$language = JFactory::getLanguage();
		$language->load('com_media', JPATH_ADMINISTRATOR);
		
		// Do not allow cache
		JResponse::allowCache(false);

		$app = JFactory::getApplication();

		$lang	= JFactory::getLanguage();

		JHtml::_('stylesheet', 'media/popup-imagelist.css', array(), true);
		if ($lang->isRTL()) :
			JHtml::_('stylesheet', 'media/popup-imagelist_rtl.css', array(), true);
		endif;

		$document = JFactory::getDocument();
		$document->addScriptDeclaration("var ImageManager = window.parent.ImageManager;");

		$images = $this->get('images');
		// $folders = $this->get('folders');
		$docs = $this->get('documents');
		$state = $this->get('state');

		$this->assign('baseURL', COM_MEDIA_BASEURL);
		$this->assignRef('images', $images);
		// $this->assignRef('folders', $folders);
		$this->assignRef('docs', $docs);
		$this->assignRef('state', $state);
		
		parent::display($tpl);
	}


	function setFolder($index = 0)
	{
		if (isset($this->folders[$index])) {
			$this->_tmp_folder = &$this->folders[$index];
		} else {
			$this->_tmp_folder = new JObject;
		}
	}
	
	function setDoc($index = 0)
	{
		if (isset($this->docs[$index])) {
			$this->_tmp_doc = &$this->docs[$index];
		} else {
			$this->_tmp_doc = new JObject;
		}
	}

	function setImage($index = 0)
	{
		if (isset($this->images[$index])) {
			$this->_tmp_img = &$this->images[$index];
		} else {
			$this->_tmp_img = new JObject;
		}
	}
}
