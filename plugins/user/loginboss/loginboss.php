<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.event.plugin' );

class plgUserLoginBoss extends JPlugin
{
  //2.5 on user delete trigger
  public function onUserAfterDelete($user, $success, $msg){
      if($success && $user && isset($user["id"])){
          $db = JFactory::getDBO();
          $db->setQuery("DELETE FROM #__loginboss_oauth_users WHERE user_id=".$db->quote($user["id"]));
          $db->query();
      }
  }
  //1.5 on user delete trigger
  public function onAfterDeleteUser($user, $success, $msg){
      $this->onUserAfterDelete($user, $success, $msg);
  }
}
