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

class EgoltProjectViewDownloads extends JView
{
	protected $items;
	protected $state;
	protected $title;

	public function display($tpl = null)
	{
		$this->params2		= &JComponentHelper::getParams('com_egoltproject');
		$this->items		= $this->get('Items');
		$this->state		= $this->get('State');
		$this->title		= $this->get('Title');
		$this->params		= &$this->state->params;
		$this->pageclass_sfx= htmlspecialchars($this->params->get('pageclass_sfx'));
		
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		$title = $description = JText::_('COM_EGOLTPROJECT_DL_LIST') . ' ' . $this->title['title'];
		$this->document->setTitle($title);
		$this->document->setDescription($description);

		parent::display($tpl);
	}

}
