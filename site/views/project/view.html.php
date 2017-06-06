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

class EgoltProjectViewProject extends JView
{
	protected $items;
	protected $state;
	protected $downloads;

	public function display($tpl = null)
	{
		$this->params2		= &JComponentHelper::getParams('com_egoltproject');
		$this->items		= $this->get('Items');
		$this->state		= $this->get('State');
		$this->downloads	= $this->get('Downloads');
		$this->params		= &$this->state->params;
		$this->pageclass_sfx= htmlspecialchars($this->params->get('pageclass_sfx'));

		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		$this->meta();
		parent::display($tpl);
	}

	public function meta()
	{
		$gtitle;
		$gdesc;
		$gkey = array();
		foreach($this->items as $item)
		{
			$gtitle = $item->title;
			$gdesc = substr(strip_tags($item->intro),0,155) . ' ...';
		}
		$gkey[] = $gtitle;
		foreach($this->downloads as $item)
		{
			$gkey[] = $item->title;
		}	
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
