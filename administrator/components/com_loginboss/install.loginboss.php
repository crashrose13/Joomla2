<?php
/*------------------------------------------------------------------------
# Login Boss
# ------------------------------------------------------------------------
# author    JoomBoss
# copyright Copyright (C) 2012 Joomboss.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomboss.com
# Technical Support:  Forum - http://joomboss.com/forum
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
class com_loginbossInstallerScript{
  public function __constructor(JAdapterInstance $adapter){}
  public function preflight($route, JAdapterInstance $adapter){
    return true;
  }
  public function postflight($route, JAdapterInstance $adapter){
    return true;
  }
  public function install(JAdapterInstance $adapter){
    return true;
  }
  public function update(JAdapterInstance $adapter){
    $db =& JFactory::getDBO();
    $db->setQuery("INSERT IGNORE INTO `#__loginboss_providers` (provider, title, enabled, image) VALUES ('facebook', 'Facebook', '0', 'components/com_loginboss/images/facebook-icon.png')");
    $db->query();
    
    $db->setQuery("INSERT IGNORE INTO `#__loginboss_providers` (provider, title, enabled, image) VALUES ('yahoo', 'Yahoo', '0', 'components/com_loginboss/images/yahoo-icon.png')");
    $db->query();
    
    $db->setQuery("INSERT IGNORE INTO `#__loginboss_providers` (provider, title, enabled, image) VALUES ('linkedin', 'LinkedIn', '0', 'components/com_loginboss/images/linkedin-icon.png')");
    $db->query();
    
    $db->setQuery("INSERT IGNORE INTO `#__loginboss_providers` (provider, title, enabled, image) VALUES ('microsoft', 'Microsoft', '0', 'components/com_loginboss/images/microsoft-icon.png');");
    $db->query();
    return true;
  }
  public function uninstall(JAdapterInstance $adapter){
    return true;
  }
}

?>