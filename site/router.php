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

jimport('joomla.application.categories');

function EgoltProjectBuildRoute( &$query )
{
       $segments = array();
	   if(isset($query['view']))
	   {
		   switch( $query['view'] )
		   {
				case 'project':
					if(isset($query['project']))
					{
						$segments[] = $query['project'];
						unset( $query['project'] );
					}
					if(isset($query['id']))
					{
						$segments[] = $query['id'];
						unset( $query['id'] );	
					}
					break;
				case 'downloads':				
				case 'download':
					if(isset($query['project']))
					{
						$segments[] = $query['project'];
						unset( $query['project'] );
					}
					$segments[] = 'downloads';
					if(isset($query['download-id']))
					{
						$segments[] = $query['download-id'];
						unset( $query['download-id'] );	
					}				
					if(isset($query['lang-id']))
					{
						$segments[] = $query['lang-id'];
						unset( $query['lang-id'] );	
					}		
					break;
			}
		}
       unset( $query['view'] );
       return $segments;
}

function EgoltProjectParseRoute( $segments )
{
       $vars = array();
       // Count segments
       $count = count( $segments );
	   switch( $count )
	   {
			case 0:
				$vars['view'] = 'projects';
				break;
			case 1:
				$vars['view'] = 'project';
				$vars['id'] = $segments[0];	
				break;				
			case 2:
				$vars['view'] = 'downloads';
				$vars['project'] = $segments[0];					
				break;				
			case 3:
				$vars['view'] = 'download';
				$vars['download-id'] = $segments[2];
				$vars['project'] = $segments[0];					
				break;				
			case 4:
				$vars['view'] = 'download';
				$vars['download-id'] = $segments[2];
				$vars['project'] = $segments[0];	
				$vars['lang-id'] = $segments[3];
				break;			
	   }
       return $vars;
}