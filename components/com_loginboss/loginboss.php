<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

JLoader::register('JBView', JPATH_COMPONENT."/views/view.php");
JLoader::register('JBModel', JPATH_COMPONENT."/models/model.php");

require_once( JPATH_COMPONENT.'/controller.php' );
$controller = new LoginbossController( array('default_task' => 'panel') );
$controller->execute( JRequest::getCmd('task') );
$controller->redirect();
?>