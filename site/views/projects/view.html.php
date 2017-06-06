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

class EgoltProjectViewProjects extends JView
{
	protected $items;
	protected $state;

	public function display($tpl = null)
	{
		$this->params2		= &JComponentHelper::getParams('com_egoltproject');
		$this->items		= $this->get('Items');
		$this->state		= $this->get('State');
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
		//title
		if($tmph = $this->escape($this->params->get('page_heading')))
			$title = $tmph;
		else
			$title = JText::_('COM_EGOLTPROJECT_PROJECTS');

		//description
		$description = $title;
		if($tmp = $this->params->get('menu-meta_description'))
			$description = $tmp;
			
		//keywords
		$keywords = $title;
		if($tmp = $this->params->get('menu-meta_keywords'))
				$keywords = $tmp;

		$this->document->setTitle($title);
		$this->document->setDescription($description);
		$this->document->setMetadata('keywords', $keywords);
	}

}
