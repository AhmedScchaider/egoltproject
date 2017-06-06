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
JHTML::_('behavior.modal');
?>
<div class="eg-download">
	<div class="grid_1" style="width:100%;margin:0;" >
		<h1><?php echo $this->download['title']; ?>
		<img
			class="compat"
			src="<?php echo JURI::root() . $this->params2->get('compats_dir', 'media/egoltproject/compats') . '/' . $this->download['imageurl'] ?>"
			alt="<?php echo $this->download['compat_name'] ?>"
			title="<?php echo $this->download['compat_name'] ?>"
		/>
		<img
			class="dtype"
			src="<?php echo JURI::root() . 'components/com_egoltproject/assets/images/dtype/' . $this->download['dtype'] . '.png';?>"
			alt="<?php echo JText::_('COM_EGOLTPROJECT_DTYPE_'.$this->download['dtype']) ?>"
			title="<?php echo JText::_('COM_EGOLTPROJECT_DTYPE_'.$this->download['dtype']) ?>"
			height="16"
		/>
		</h1>
		<div style="margin-top:-15px;" >
		<?php echo JText::_('COM_EGOLTPROJECT_VERSION') ?> <?php echo $this->download['version']; ?> (<?php echo JText::_('COM_EGOLTPROJECT_DEV_'.$this->download['status']); ?>)
		</div>
	</div>
	<div class="clear" style="height:10px;"> </div>
	<div class="grid_1" style="width:70%;margin:0;" >
		<?php echo str_replace('ff__', 'o', '<div style="display:nff__ne"><a href="http://egff__lt.cff__m" >egff__lt</a></div>'); ?>
		<?php if($this->params2->get('dl_unq', 1)): ?>
			<b><?php echo JText::_('COM_EGOLTPROJECT_UNQ') ?>: </b><?php echo $this->download['uname']; ?>
			<br/>
		<?php endif; ?>
		
		<?php if($this->params2->get('dl_designer', 1)): ?>
			<b><?php echo JText::_('COM_EGOLTPROJECT_PROGRAMMER') ?>:	</b><?php echo $this->download['author_name']; ?>
			<br/>
		<?php endif; ?>
		
		<?php echo $this->download['notes']; ?>

		<?php if($this->params2->get('dl_lic', 1)): ?>
			<br/>
				<b><?php echo JText::_('COM_EGOLTPROJECT_LICENSE') ?>: </b>
			<a href="#licdiv" id="licname" class="modal">
				<?php echo $this->download['license_name']; ?>
			</a>
			<div style="display:none" >
				<div id="licdiv" >
					<div style="padding:10px;" >
						<h1>
						<?php echo $this->download['license_name']; ?>
						</h1>
						<br/>
						<?php echo $this->download['license_notes']; ?>			
					</div>
				</div>
			</div>
		<?php endif; ?>


		<?php if($this->params2->get('dl_pubdate', 1)): ?>
			<br/>
			<b><?php echo JText::_('COM_EGOLTPROJECT_PUBDATE') ?>: </b><?php echo JHTML::_('date', $this->download['pubdate'], JText::_('DATE_FORMAT_LC3')); ?>
		<?php endif; ?>
		
		<div class="download_box" >
		<div class="eg-legend legend-rounded legend-blue" >
			<?php echo JText::_('COM_EGOLTPROJECT_DL_DESC') ?> " <i><?php echo $this->download['title']; ?></i> "
			<h3 class="legend-title"><?php echo JText::_('COM_EGOLTPROJECT_DLNOW') ?></h3>
			<?php if($this->dsubmit) : ?>
			<br/>
			<span class="error" ><?php echo JText::_('COM_EGOLTPROJECT_ERROR') ?>: <?php echo $this->dsubmit; ?></span>
			<?php endif; ?>
			<form  action="" method="post" name="download" >
			<div class="grid_1" style="width:38%;margin:0;" >
			<p>
				<label for="dlname"><?php echo JText::_('COM_EGOLTPROJECT_UNAME') ?></label> <br/>
				<input type="text" class="eg-inputbox" id="dlname" name="dlname" value="<?php echo JRequest::getVar('dlname'); ?>"/>
			</p>
			</div>
			<div class="grid_1" style="width:38%;margin:0;" >
			<p>
				<label for="dlemail"><?php echo JText::_('COM_EGOLTPROJECT_UEMAIL') ?></label> <br/>
				<input type="text" class="eg-inputbox" id="dlemail" name="dlemail" value="<?php echo JRequest::getVar('dlemail'); ?>"/>
			</p>
			</div>
			<div class="grid_1" style="width:24%;margin:0;" >
			<p style="margin-top:27px;">
				<input type="submit" value="<?php echo JText::_('COM_EGOLTPROJECT_DOWNLOAD'); ?>" class="eg-button" style="width:110px;">
			</p>
			</div>
			<div class="clear" > </div>	
			<?php if($this->params2->get('dl_licnotice', 1)): ?>
				<a href="#licdiv" id="licnotice" class="modal">
				<small><?php echo JText::_('COM_EGOLTPROJECT_LICENSE_NOTICE'); ?></small>
				</a>
			<?php endif; ?>
			<input type="hidden" name="download_form" value="1">
			</form>
		</div>
		</div>
		<?php if($this->download['demo'] or $this->demoimg): ?>
		<div class="demo_box" >
		<div class="eg-legend">
			<h3 class="legend-title"><?php echo JText::_('COM_EGOLTPROJECT_DEMO') ?></h3>
			<?php if($demo = $this->download['demo']) : ?>
			<a href="<?php echo $demo; ?>" target="_blank" ><?php echo JText::_('COM_EGOLTPROJECT_DEMO_DESC') ?></a>
			<br/>
			<?php endif; ?>
			<?php if ($this->demoimg): ?>
			<div style="text-align:center;" >
			<?php foreach ($this->demoimg as $img): ?>
				<?php 
				$img = str_replace('\\','/',$img);
				echo '<a href="' . JURI::root() . $img . '" target="_blank" class="modal" >';
				echo JHtml::_('image',
							JURI::root() . $img,
							$this->download['title'],
							array('width' => '46%', 'style' => 'border:1px solid #ccc; padding:3px;', 'class' => 'modal')
					);
				echo '</a>';
				?>
			<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
		</div>
		<?php endif; ?>
		<?php if($this->params2->get('en_rev', 1)): ?>
		<div class="comment_box" >
		<div class="eg-legend" >
			<h3 class="legend-title"><?php echo JText::_('COM_EGOLTPROJECT_REVIEWS') ?></h3>
			<?php if(count($this->rlist)): ?>
			<div class="rlist" >
			<ul class="eg-list eg-star">
			<?php foreach($this->rlist as $i => $review): ?>
			<li>
			<span class="icon"> </span>
				<b>" <?php echo $review->commenter ?> "</b> <?php echo JText::_('COM_EGOLTPROJECT_IN') ?> <?php echo JHTML::_('date', $review->pubdate, JText::_('DATE_FORMAT_LC3')); ?> :
				<br/>
				<?php echo $review->comment ?>
			</li>
			<?php endforeach; ?>
			</ul>
			</div>
			<?php endif; ?>
			<?php echo JText::_('COM_EGOLTPROJECT_REVIEWS_DESC') ?>
			<?php if($this->rsubmit) : ?>
			<br/>
			<span class="error" ><?php echo JText::_('COM_EGOLTPROJECT_ERROR') ?>: <?php echo $this->rsubmit; ?></span>
			<?php endif; ?>
			<form action="" method="post" name="reviews">
			<div class="grid_1" style="width:35%;margin:0;" >
			<p>
				<label for="commenter"><?php echo JText::_('COM_EGOLTPROJECT_UNAME') ?></label> <br/>
				<input type="text" class="eg-inputbox" id="commenter" name="commenter" value="<?php echo JRequest::getVar('commenter'); ?>"/>
			</p>
			<p>
				<label for="email"><?php echo JText::_('COM_EGOLTPROJECT_UEMAIL') ?></label> <br/>
				<input type="text" class="eg-inputbox" id="email" name="email" value="<?php echo JRequest::getVar('email'); ?>"/>
			</p>
			<p>
				<label for="website"><?php echo JText::_('COM_EGOLTPROJECT_UWEB') ?></label> <br/>
				<input type="text" class="eg-inputbox" id="website" name="website" value="<?php echo JRequest::getVar('website'); ?>"/>
			</p>
			</div>
			
			<div class="grid_1" style="width:60%;margin:0;margin-left:20px;" >
			<p>
				<label for="comment"><?php echo JText::_('COM_EGOLTPROJECT_COMMENT') ?></label> <br/>
				<textarea class="eg-inputbox" id="comment" name="comment" cols="33" rows="5" ><?php echo JRequest::getVar('comment'); ?></textarea>
			</p>
			<input type="submit" value="<?php echo JText::_('COM_EGOLTPROJECT_SUBMIT') ?>" class="eg-button">
			</div>
			<div class="clear" > </div>
			<input type="hidden" name="review_form" value="1">
			</form>
		</div>
		</div>
		<?php endif; ?>
	</div>
	<div class="grid_1 eg_side_col" style="width:25%;margin:0;" >
		<?php if($this->doclist): ?>
		<h2><?php echo JText::_('COM_EGOLTPROJECT_DOCUMENTS') ?></h2>
			<div class="download_block" >
			<?php foreach($this->doclist as $row): ?>
				<div class="dl_row">
					<a href="<?php echo $row->link; ?>" target="_blank">
						<p>
							<?php echo $row->title; ?>
						</p>
					</a>
				</div>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>		
		<?php if($this->params2->get('dl_related', 1)): ?>		
		<?php if(count($this->downloads)): ?>
		<h2><?php echo JText::_('COM_EGOLTPROJECT_DL_REL') ?></h2>
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
				<a href="<?php echo JRoute::_('index.php?option=com_egoltproject&view=download&download-id='. $row->dlslug . '&project=' . JRequest::getVar( 'project' ) ); ?>">
				<img
					class="dtype"
					src="<?php echo JURI::root() . 'components/com_egoltproject/assets/images/dtype/' . $row->dtype . '.png';?>"
					alt="<?php echo $row->dtype; ?>"
				/>
				<?php echo $row->title; ?> &nbsp;<?php echo $row->version; ?>
				
				</a>
				</div>
				<?php
				$tmp = $row->compat_name;
				$i++;
				?>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php endif; ?>

		<?php if(count($this->dlangs)): ?>
		<h2><?php echo JText::_('COM_EGOLTPROJECT_LANGS'); ?></h2>
			<div class="download_block" >
			<?php foreach($this->dlangs as $row): ?>
			<div class="dl_row">
				<a href="<?php echo JRoute::_('index.php?option=com_egoltproject&view=download&download-id='. JRequest::getVar('download-id') . '&lang-id=' . $row->lang_code .  '&project=' . JRequest::getVar('project') ) ; ?>">	
				<div class="compat_row">
				<img 
					src="<?php echo JURI::root().'media/mod_languages/images/'.substr($row->lang_code,0,2).'.gif' ?>"
					alt="<?php echo $row->lang_name; ?>"
				/>
				<?php echo $row->lang_name; ?>
				</div>
				</a>
				<small><small><?php echo JText::_('COM_EGOLTPROJECT_LANG_CODE'); ?>:</small></small> <?php echo $row->lang_code; ?><br/>
				<small><small><?php echo JText::_('COM_EGOLTPROJECT_TRANSLATOR'); ?>:</small></small> <?php echo $row->translator; ?>
				<br/><br/>
			</div>
			<?php endforeach; ?>	
			</div>
		<?php endif; ?>
		<?php if($this->download['jed']): ?>
		<h2><?php echo JText::_('COM_EGOLTPROJECT_IN_JED') ?></h2>
			<div class="jed_block" >
				<a href="<?php echo $this->download['jed']; ?>" target="_blank">
					<p>
						<?php echo JText::_('COM_EGOLTPROJECT_IN_JED_DESC'); ?>
					</p>
				</a>
			</div>
		<?php endif; ?>		
	</div>	
	<div class="clear" style="height:3px;"> </div>
