<?php 
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

class ProviderFactory{
    public static function getProviderById($id){
        $db = JFactory::getDBO();
        $db->setQuery("SELECT provider, client_id, client_secret, image FROM `#__loginboss_providers` WHERE provider=".$db->quote($id));
        $provider = $db->loadObject();
        return ProviderFactory::getProviderByData($provider);
    }
    
    public static function getProviderByData($providerData){
        switch($providerData->provider){
            case "twitter":
                require_once(dirname(__FILE__)."/providers/Twitter.php");
                return new OAUTHTwitter($providerData);
                break;
            case "google":
                require_once(dirname(__FILE__)."/providers/Google.php");
                return new OAUTHGoogle($providerData);
                break;
            case "facebook":
                require_once(dirname(__FILE__)."/providers/Facebook.php");
                return new OAUTHFacebook($providerData);
                break;
        }
        return null;
    }
} 
?>
