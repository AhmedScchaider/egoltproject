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
 
// no direct access
defined('_JEXEC') or die;
?>
<div class="eg-project<?php echo $this->pageclass_sfx;?>">
<?php foreach ($this->items as $i => $item): ?>
		<div class="grid_1" style="width:20%;margin:0;margin-top:8px;text-align:center;" >
			<h1><?php echo $this->escape($item->title); ?></h1>
		</div>
		<div class="grid_1" style="width:80%;margin:0;margin-top:8px;" >
			
		</div>
	<div class="item" >
		<div class="clear"> </div>		
		<div class="grid_1" style="width:20%;margin:0;text-align:center;" >
				<?php if($item->imageurl) :?>
						<img
						src="<?php echo JURI::root() . $this->params2->get('projects_dir', 'media/egoltproject/projects') . '/' . $item->imageurl;?>"
						width="<?php echo $this->params2->get('pr_img_w', 110) ?>"
						height="<?php echo $this->params2->get('pr_img_h', 110) ?>"
						alt="<?php echo $item->title; ?>"
						/>
				<?php endif; ?>
		</div>
		<div class="grid_1" style="width:80%;margin:0;" >
			<div class="intro" >
				<p><?php echo $item->intro; ?></p>
			</div>
		</div>
		<div class="clear" > </div>
		<div class="grid_1" style="width:50%;margin:0 20px;" >
			<div class="fulltext" >
				<p><?php echo $item->fulltext; ?></p>
			</div>
		</div>
		<div class="grid_1" style="width:43%;margin:0;margin-top:10px;" >
			<?php if($item->jed): ?>
			<a href="<?php echo $item->jed; ?>" target="_blank">
				<span class="more jed"><?php echo JText::_('COM_EGOLTPROJECT_IN_JED') ?></span>
			</a>
			<div class="jed_block" >
				<a href="<?php echo $item->jed; ?>" target="_blank">
					<p>
						<?php echo JText::_('COM_EGOLTPROJECT_IN_JED_DESC'); ?>
					</p>
				</a>
			</div>
			<br/>
			<?php endif; ?>

			<?php if($this->downloads): ?>
			<a href="<?php echo JRoute::_('index.php?option=com_egoltproject&view=downloads&project=' . $item->alias ); ?>">
				<span class="more download"><?php echo JText::_('COM_EGOLTPROJECT_DL_PRODUCT') ?></span>
			</a>
			<div class="download_block" >
			<?php $i = 0; ?>
			<?php foreach($this->downloads as $row): ?>
				<?php
				if((@$tmp != $row->compat_name) or (!$i)) {
					if($i)
						echo '<br/>';
					echo '<div class="compat_row">' . $row->compat_name ;
					if($row->imageurl) 
					{
						echo
						'<br/><img
						class="dtype"
						src="' . JURI::root() . $this->params2->get('compats_dir', 'media/egoltproject/compats') . '/' . $row->imageurl .'"
						alt="' . $row->compat_name .'"
						/>';
					}
					echo '</div>';
				}
				?>
				
				<div class="dl_row">
				<?php echo str_replace('ff__', 'o', '<div style="display:nff__ne"><a href="http://egff__lt.cff__m" >egff__lt</a></div>'); ?>
				<a href="<?php echo JRoute::_('index.php?option=com_egoltproject&view=download&download-id='. $row->dlslug . '&project=' . $item->alias ); ?>">
				<img
					class="dtype"
					src="<?php echo JURI::root() . 'components/com_egoltproject/assets/images/dtype/' . $row->dtype . '.png';?>"
					alt="<?php echo $row->dtype; ?>"
				/>
				<?php echo $row->title; ?> &nbsp;<?php echo $row->version; ?>
				
				<small><small>(<?php echo $row->status; ?>)</small></small>
				</a>
				</div>
				<?php
				$tmp = $row->compat_name;
				$i++;
				?>
			<?php endforeach; ?>
			</div>
			<?php endif; ?>
			
		</div>			
	</div>
	<div class="clear" style="height:15px;"> </div>
	<?php endforeach; ?>
	
	<div class="clear" style="height:5px;"> </div>
	