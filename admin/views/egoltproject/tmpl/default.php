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
$lang =& JFactory::getLanguage();
$lang_tag = $lang->getTag();
?>
<div class="cpanel-left">

		<div id="cpanel">
		
		<div>
			<div class="icon">
				<a href="index.php?option=com_egoltproject&amp;view=projects" >
					<img src="components/com_egoltproject/assets/images/icons/projects.png" alt="<?php echo JText::_('COM_EGOLTPROJECT_PROJECTS') ?>"  />
					<span><?php echo JText::_('COM_EGOLTPROJECT_PROJECTS') ?></span></a>
			</div>
		</div>
		
		
		<div>
			<div class="icon">
				<a href="index.php?option=com_egoltproject&amp;view=downloads">
					<img src="components/com_egoltproject/assets/images/icons/downloads.png" alt="<?php echo JText::_('COM_EGOLTPROJECT_DOWNLOADS') ?>"  />
					<span><?php echo JText::_('COM_EGOLTPROJECT_DOWNLOADS') ?></span></a>
			</div>
		</div>
		
		<div>
			<div class="icon">
				<a href="index.php?option=com_egoltproject&amp;view=downlangs">
					<img src="components/com_egoltproject/assets/images/icons/downlangs.png" alt="<?php echo JText::_('COM_EGOLTPROJECT_DOWNLANGS') ?>"  />
					<span><?php echo JText::_('COM_EGOLTPROJECT_DOWNLANGS') ?></span></a>
			</div>
		</div>
		
		<div>
			<div class="icon">
				<a href="index.php?option=com_egoltproject&amp;view=revs">
					<img src="components/com_egoltproject/assets/images/icons/reviews.png" alt="<?php echo JText::_('COM_EGOLTPROJECT_REVIEWS') ?>"  />
					<span><?php echo JText::_('COM_EGOLTPROJECT_REVS') ?></span></a>
			</div>
		</div>
		
		<div>
			<div class="icon">
				<a href="index.php?option=com_egoltproject&amp;view=licenses">
					<img src="components/com_egoltproject/assets/images/icons/licenses.png" alt="<?php echo JText::_('COM_EGOLTPROJECT_LICENSES') ?>"  />
					<span><?php echo JText::_('COM_EGOLTPROJECT_LICENSES') ?></span></a>
			</div>
		</div>
		
		<div>
			<div class="icon">
				<a href="index.php?option=com_egoltproject&amp;view=compats">
					<img src="components/com_egoltproject/assets/images/icons/compats.png" alt="<?php echo JText::_('COM_EGOLTPROJECT_COMPATS') ?>"  />
					<span><?php echo JText::_('COM_EGOLTPROJECT_COMPATS') ?></span></a>
			</div>
		</div>
		
		<div>
			<div class="icon">
				<a href="index.php?option=com_egoltproject&amp;view=about">
					<img src="components/com_egoltproject/assets/images/icons/about.png" alt="<?php echo JText::_('COM_EGOLTPROJECT_ABOUT') ?>"  />
					<span><?php echo JText::_('COM_EGOLTPROJECT_ABOUT') ?></span></a>
			</div>
		</div>
		

		</div>
	
</div>
<div class="cpanel-right">
<div id="content-pane" class="pane-sliders">
	<div class="panel">
		<h3 class="jpane-toggler title" id="cpanel-panel-popular"><span><?php echo JText::_('COM_EGOLTPROJECT_PRODUCT_BY') ?>
		<?php if($lang_tag == 'fa-IR') echo "ايگلت"; else echo "Egolt";?>
		</span></h3>
		<div class="jpane-slider content" style="min-height:100px;">
			<div class="inner-content" style="background:#FFF;padding:7px;line-height:20px;" >
				<div class="elogo" ><img src="components/com_egoltproject/assets/images/egolt.png" width="200" height="75"></div>
				<?php echo JText::_('COM_EGOLTPROJECT_SERVICENAME') ?><br/>
				<?php echo JText::_('COM_EGOLTPROJECT_POWERED_BY') ?> <a href="http://www.egolt.com" target="_blank">
				<?php if($lang_tag == 'fa-IR') echo "ایگلت"; else echo "Egolt";?>
				- www.egolt.com</a><br/>
				&copy; 2009 - 2012 
				<?php if($lang_tag == 'fa-IR') echo "سهیل نوین فرد"; else echo "Soheil Novinfard";?>
			</div>
		</div>
	</div>
</div>
</div>