<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */
jimport('joomla.version');

abstract class BaseRegistrationModel extends JBModel{
  private $error = "";
  
  public function getError(){
    return $this->error;
  }
  
  public function setError($error){
    $this->error = $error;
  }
  
  abstract function registerJoomlaUser($login, $name, $email, $trustEmail);
  
  function registerUser($unique_id, $providerName, $login, $user_name, $email, $trustEmail){
    
    $db =& JFactory::getDBO();
    $userId = $this->registerJoomlaUser($login, $user_name, $email, $trustEmail);
    if(!$userId){
      return "error";
    }
    
    
    $db->setQuery("INSERT INTO `#__loginboss_oauth_users` 
        (user_id, provider, `unique_name`) 
        VALUES (".$db->quote($userId).", 
        ".$db->quote(strtolower($providerName)).", 
        ".$db->quote($unique_id).")");
    $db->query();
    
    $params = JComponentHelper::getParams('com_users');
    $useractivation = $params->get('useractivation');
    
    if ($useractivation == 1 &&!$trustEmail)
      return "useractivate";
    elseif ($useractivation == 2)
      return "adminactivate";
    else
      return "ready";
  }
  
  public function getUserIdByName($name){
    $db =& JFactory::getDBO();
    $db->setQuery("SELECT id FROM #__users WHERE username=".$db->quote($name));
    return $db->loadResult();
  }
  
  public function getUserIdByEmail($email){
    $db =& JFactory::getDBO();
    $db->setQuery("SELECT id FROM #__users WHERE email=".$db->quote($email));
    return $db->loadResult();
  }
}
if(version_compare(JVERSION, "1.6", "ge")){
  require_once(dirname(__FILE__)."/registration_j2.php");
}else{
  require_once(dirname(__FILE__)."/registration_j1.php");
}
?>