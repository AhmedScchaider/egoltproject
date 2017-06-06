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
<table class="adminform">
<tr>
<td valign="center" width="25%">
		<center><img src="components/com_egoltproject/assets/images/egoltproject_big.png">
				<div class="jpane-slider content">
			<div class="inner-about" >
				<div class="aversion"><?php echo JText::_('COM_EGOLTPROJECT_VERSION') ?> 1.0</div>
				<div class="adownload"><a href="http://www.egolt.com/products/egoltproject" target="_blank"><?php echo JText::_('COM_EGOLTPROJECT_DOWNLOADS') ?></a></div>
				<div class="adocumentation"><a href="http://www.egolt.com/products/egoltproject" target="_blank"><?php echo JText::_('COM_EGOLTPROJECT_DOCUMENTS') ?></a></div>
				<div class="ademo"><a href="http://www.egolt.com/products/egoltproject" target="_blank"><?php echo JText::_('COM_EGOLTPROJECT_DEMOS') ?></a></div>
				<div class="aforum"><a href="http://www.egolt.com/products/egoltproject" target="_blank"><?php echo JText::_('COM_EGOLTPROJECT_SUPPORT') ?></a></div>
				<div class="alicense">
					<?php echo JText::_('COM_EGOLTPROJECT_LIC_UNDER') ?> <a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank"><?php echo JText::_('COM_EGOLTPROJECT_LIC_GPL') ?></a>
				</div>
			</div>
		</div>
		</center>
</td>
<td valign="top" width="50%">
	<div class="panel" style="margin:20px 40px;">
		<h1 class="jpane-toggler title" id="cpanel-panel-popular"><span><?php echo JText::_('COM_EGOLTPROJECT_SERVICENAME') ?></span></h1>
		<h3 class="jpane-toggler title" id="cpanel-panel-popular" style="padding:0 12px;"><span><?php echo JText::_('COM_EGOLTPROJECT_SERVICE_DESC') ?></span></h3>
		<ul style="line-height:25px;" >
			<?php echo JText::_('COM_EGOLTPROJECT_SERVICE_FTR') ?>	
		</ul>
		<p style="text-align:justify;line-height:20px;" >
			<?php echo JText::_('COM_EGOLTPROJECT_SERVICE_DETAILS') ?>
		</p>		
	</div>
</td>
<td valign="center" width="25%">
		<center>
		<img src="components/com_egoltproject/assets/images/egolt.png"><br/><br/>
		&copy; <?php echo JText::_('COM_EGOLTPROJECT_POWERED_BY') ?> <a href="http://www.egolt.com" target="_blank">
			<?php if($lang_tag == 'fa-IR') echo "ايگلت"; else echo "Egolt";?>		
		</a><br/><br/>
			<?php if($lang_tag == 'fa-IR') echo "سهيل نوين فرد"; else echo "Soheil Novinfard";?>
		<br/><br/>
		<a href="http://www.egolt.com" target="_blank">www.egolt.com</a><br/><br/>
		2009 - 2012<br/>
		</center>
</td>
</tr>
</table>
