<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );
if(version_compare(JVERSION, "3.0", "ge")){
  class JBModel extends JModelLegacy{}
}else{
  class JBModel extends JModel{}
}

class LoginbossModelProvider extends JBModel{
    function getProviders(){
        $db = JFactory::getDBO();
        $db->setQuery("SELECT provider, title, enabled, client_id, client_secret, image FROM #__loginboss_providers");
        return $db->loadObjectList();
    }
    
    function getProvider($provider){
        $db = JFactory::getDBO();
        $db->setQuery("SELECT provider, title, enabled, client_id, client_secret 
                       FROM #__loginboss_providers
                       WHERE provider=".$db->quote($provider));
        $providerObj = $db->loadObject();
  if($providerObj->provider!='twitter' && $providerObj->provider!='facebook' && $providerObj->provider!='google'){
          $providerObj = null;
        }
        return $providerObj;
    }
    
    function updateProvider($provider, $client_id, $client_secret, $enabled=1){
        $db = JFactory::getDBO();
        $db->setQuery("UPDATE #__loginboss_providers SET
                `client_id`=".$db->quote($client_id).",
                `client_secret`=".$db->quote($client_secret).",
                `enabled`=".$db->quote($enabled)."
                WHERE `provider`=".$db->quote($provider));
        $db->query();
    }
    
    function enableProvider($provider){
        $db = JFactory::getDBO();
        $db->setQuery("UPDATE #__loginboss_providers SET `enabled`=1 WHERE `provider`=".$db->quote($provider));
        $db->query();
    }
    
    function disableProvider($provider){
        $db = JFactory::getDBO();
        $db->setQuery("UPDATE #__loginboss_providers SET `enabled`=1 WHERE `provider`=".$db->quote($provider));
        $db->query();
    }
}
?>