<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );
$mainframe =& JFactory::getApplication();

//<<<<<<< HEAD
if(JRequest::getCmd("option") != "com_loginboss"){
  $return	= getReturnURL($params);
//=======
//$type 	= getType();
//if(JRequest::getCmd("option") != "com_loginboss"){
//  $return	= getReturnURL($params, $type);
//>>>>>>> facebook
  $mainframe->setUserState("loginboss.return.url", $return);
}
$user =& JFactory::getUser();

$db =& JFactory::getDBO();

require_once JPATH_BASE."/components/com_loginboss/classes/ProviderFactory.php";
$db->setQuery("SELECT provider, title, client_id, client_secret, image 
               FROM #__loginboss_providers 
               WHERE enabled=1");

$data = $db->loadObjectList();
$providers = array();
if($data){
    foreach($data as $provider)
    $providers[] = ProviderFactory::getProviderByData($provider);
}

$profileInfo = $mainframe->getUserState("loginboss.externalProfile", null);

require(JModuleHelper::getLayoutPath('mod_loginboss'));

function getReturnURL($params)
{
    $uri = JFactory::getURI();
    $url = $uri->toString(array('path', 'query', 'fragment'));
    return $url;
}
