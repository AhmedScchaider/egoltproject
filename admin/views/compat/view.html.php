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
 
// import Joomla view library
jimport('joomla.application.component.view');

class EgoltProjectViewCompat extends JView
{

	public function display($tpl = null) 
	{
		// get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;
 
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JRequest::setVar('hidemainmenu', true);
		@$isNew = ($this->item->id == 0);
		$suffix1 = $isNew ? JText::_('COM_EGOLTPROJECT_ADD') : JText::_('COM_EGOLTPROJECT_EDIT');
		$egolt_title = JText::_( 'COM_EGOLTPROJECT' );
		$egolt_title_suffix = JText::_( 'COM_EGOLTPROJECT_COMPATS' ) . ' : ' . $suffix1 ;
		$egolt_title1 = $egolt_title .  ' - [ ' . $egolt_title_suffix .' ]' ;
		$egolt_title2 = $egolt_title .  ' - ' . $egolt_title_suffix ;
		
        JToolBarHelper::title($egolt_title1 ,'egoltproject');
		$document = JFactory::getDocument();
		$document->setTitle($egolt_title2);	
		
		JToolBarHelper::save('compat.save');
		JToolBarHelper::cancel('compat.cancel', $isNew ? 'JTOOLBAR_CANCEL'
		                                                   : 'JTOOLBAR_CLOSE');
	}
}
