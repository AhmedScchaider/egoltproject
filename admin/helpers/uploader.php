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
defined('_JEXEC') or die;


abstract class UploaderHelper
{
	/**
	 * Checks if the file is an image
	 * @param string The filename
	 * @return boolean
	 */
	public static function isImage($fileName)
	{
		static $imageTypes = 'xcf|odg|gif|jpg|png|bmp';
		return preg_match("/\.(?:$imageTypes)$/i", $fileName);
	}

	/**
	 * Checks if the file is an image
	 * @param string The filename
	 * @return boolean
	 */
	public static function getTypeIcon($fileName)
	{
		// Get file extension
		return strtolower(substr($fileName, strrpos($fileName, '.') + 1));
	}

	/**
	 * Checks if the file can be uploaded
	 *
	 * @param array File information
	 * @param string An error message to be returned
	 * @return boolean
	 */
	public static function canUpload($file, $ftype, &$err)
	{
		$params = JComponentHelper::getParams('com_egoltproject');
		// $ftype	= JRequest::getVar('ftype');

		if (empty($file['name'])) {
			$err = 'COM_MEDIA_ERROR_UPLOAD_INPUT';
			return false;
		}

		jimport('joomla.filesystem.file');
		if ($file['name'] !== JFile::makesafe($file['name'])) {
			$err = 'COM_MEDIA_ERROR_WARNFILENAME';
			return false;
		}

		$format = strtolower(JFile::getExt($file['name']));
		
		if($ftype == 'image')
			$allowable = explode(',', $params->get('img_ext','bmp,gif,jpg,png,BMP,GIF,JPG,PNG'));
		else
			$allowable = explode(',', $params->get('file_ext','zip,rar,gz,gzip,tgz,tar,pdf,ppt,swf,txt,xls,doc,ZIP,RAR,GZ,GZIP,TGZ,TAR,PDF,PPT,SWF,TXT,XLS,DOC'));
		// $ignored = explode(',', $params->get('ignore_extensions'));
		// if (!in_array($format, $allowable) && !in_array($format, $ignored))
		if (!in_array($format, $allowable))
		{
			$err = 'COM_MEDIA_ERROR_WARNFILETYPE';
			// $err = implode(',', $allowable) . ' ' . $format . ' ' . $ftype;
			return false;
		}

		$maxSize = (int) ($params->get('upload_maxsize', 0) * 1024 * 1024);
		if ($maxSize > 0 && (int) $file['size'] > $maxSize)
		{
			$err = 'COM_MEDIA_ERROR_WARNFILETOOLARGE';
			return false;
		}

		$user = JFactory::getUser();
		$imginfo = null;
		// if ($params->get('restrict_uploads', 1)) {
		if (TRUE) {
			$images = explode(',', $params->get('img_ext','bmp,gif,jpg,png,BMP,GIF,JPG,PNG'));
			if (in_array($format, $images)) { // if its an image run it through getimagesize
				// if tmp_name is empty, then the file was bigger than the PHP limit
				if (!empty($file['tmp_name'])) {
					if (($imginfo = getimagesize($file['tmp_name'])) === FALSE) {
						$err = 'COM_MEDIA_ERROR_WARNINVALID_IMG';
						return false;
					}
				} else {
					$err = 'COM_MEDIA_ERROR_WARNFILETOOLARGE';
					return false;
				}
			// } elseif (!in_array($format, $ignored)) {
			} else {
				// if its not an image...and we're not ignoring it
				if($ftype == 'image')
					$allowed_mime = explode(',', $params->get('img_mime'));
				else
					$allowed_mime = explode(',', $params->get('file_mime'));					
				// $illegal_mime = explode(',', $params->get('upload_mime_illegal'));
				if (function_exists('finfo_open') && $params->get('check_mime', 0)) {
					// We have fileinfo
					$finfo = finfo_open(FILEINFO_MIME);
					$type = finfo_file($finfo, $file['tmp_name']);
					// if (strlen($type) && !in_array($type, $allowed_mime) && in_array($type, $illegal_mime)) {
					if (strlen($type) && !in_array($type, $allowed_mime)) {
						$err = 'COM_MEDIA_ERROR_WARNINVALID_MIME';
						return false;
					}
					finfo_close($finfo);
				} elseif (function_exists('mime_content_type') && $params->get('check_mime', 0)) {
					// we have mime magic
					$type = mime_content_type($file['tmp_name']);
					// if (strlen($type) && !in_array($type, $allowed_mime) && in_array($type, $illegal_mime)) {
					if (strlen($type) && !in_array($type, $allowed_mime)) {
						$err = 'COM_MEDIA_ERROR_WARNINVALID_MIME';
						return false;
					}
				} elseif (!$user->authorise('core.manage')) {
					$err = 'COM_MEDIA_ERROR_WARNNOTADMIN';
					return false;
				}
			}
		}

		$xss_check =  JFile::read($file['tmp_name'], false, 256);
		$html_tags = array('abbr', 'acronym', 'address', 'applet', 'area', 'audioscope', 'base', 'basefont', 'bdo', 'bgsound', 'big', 'blackface', 'blink', 'blockquote', 'body', 'bq', 'br', 'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'comment', 'custom', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'fn', 'font', 'form', 'frame', 'frameset', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'head', 'hr', 'html', 'iframe', 'ilayer', 'img', 'input', 'ins', 'isindex', 'keygen', 'kbd', 'label', 'layer', 'legend', 'li', 'limittext', 'link', 'listing', 'map', 'marquee', 'menu', 'meta', 'multicol', 'nobr', 'noembed', 'noframes', 'noscript', 'nosmartquotes', 'object', 'ol', 'optgroup', 'option', 'param', 'plaintext', 'pre', 'rt', 'ruby', 's', 'samp', 'script', 'select', 'server', 'shadow', 'sidebar', 'small', 'spacer', 'span', 'strike', 'strong', 'style', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'title', 'tr', 'tt', 'ul', 'var', 'wbr', 'xml', 'xmp', '!DOCTYPE', '!--');
		foreach($html_tags as $tag) {
			// A tag is '<tagname ', so we need to add < and a space or '<tagname>'
			if (stristr($xss_check, '<'.$tag.' ') || stristr($xss_check, '<'.$tag.'>')) {
				$err = 'COM_MEDIA_ERROR_WARNIEXSS';
				return false;
			}
		}
		return true;
	}

	public static function parseSize($size)
	{
		if ($size < 1024) {
			return JText::sprintf('COM_MEDIA_FILESIZE_BYTES', $size);
		}
		elseif ($size < 1024 * 1024) {
			return JText::sprintf('COM_MEDIA_FILESIZE_KILOBYTES', sprintf('%01.2f', $size / 1024.0));
		}
		else {
			return JText::sprintf('COM_MEDIA_FILESIZE_MEGABYTES', sprintf('%01.2f', $size / (1024.0 * 1024)));
		}
	}

	public static function imageResize($width, $height, $target)
	{
		//takes the larger size of the width and height and applies the
		//formula accordingly...this is so this script will work
		//dynamically with any size image
		if ($width > $height) {
			$percentage = ($target / $width);
		} else {
			$percentage = ($target / $height);
		}

		//gets the new value and applies the percentage, then rounds the value
		$width = round($width * $percentage);
		$height = round($height * $percentage);

		return array($width, $height);
	}

	public static function countFiles($dir)
	{
		$total_file = 0;
		$total_dir = 0;

		if (is_dir($dir)) {
			$d = dir($dir);

			while (false !== ($entry = $d->read())) {
				if (substr($entry, 0, 1) != '.' && is_file($dir . DIRECTORY_SEPARATOR . $entry) && strpos($entry, '.html') === false && strpos($entry, '.php') === false) {
					$total_file++;
				}
				if (substr($entry, 0, 1) != '.' && is_dir($dir . DIRECTORY_SEPARATOR . $entry)) {
					$total_dir++;
				}
			}

			$d->close();
		}

		return array ($total_file, $total_dir);
	}

}
