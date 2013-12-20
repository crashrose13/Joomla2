<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class OAUTHLoginBoss{
  private $dataObj = null;

  public function getDataObj(){
    return $this->dataObj;
  }

  public function setDataObj( $obj ){
    $this->dataObj = $obj;
  }
  
  public function getProvider(){
    return "Unknown";
  }

  public function login( $login, $externalProfile){
    $mainframe =& JFactory::getApplication();
    $unique_id = $externalProfile->getId();
    $user_name = $externalProfile->getName();
    $email = $externalProfile->getEmail();
    
    $user =& JFactory::getUser();
    $id =$this->oauthUserExists($unique_id, $externalProfile->getProvider() ); 
    if($id){
      if($user->id){
        if($user->id == $id){
          $return_url = $mainframe->getUserState("loginboss.return.url", JRoute::_('/index.php'));
          $mainframe->setUserState("loginboss.externalProfile", $externalProfile->toArray() );
          $mainframe->redirect( $return_url );
        }else{
          $return_url = $mainframe->getUserState("loginboss.return.url", JRoute::_('/index.php'));
          $mainframe->enqueueMessage(JText::sprintf('COM_LOGINBOSS_PROFILE_LINKED_WITH_DIFFERENT_USER', 
              $externalProfile->getProvider()), 'warning');
          $mainframe->redirect( $return_url );
        }
      }else{
        $mainframe->login(array('username' => 'loginboss:', 'password' => 'foobar'),
          array("loginboss.user_id"=>$unique_id));
        $return_url = $mainframe->getUserState("loginboss.return.url", JRoute::_('/index.php'));
        $mainframe->setUserState("loginboss.externalProfile", $externalProfile->toArray() );
        $mainframe->redirect( $return_url );
      }
    }else{
      if($user->id){
        $mainframe->logout();
      }else{
        $login = trim($login);
        if(!$login){
          //create login from email
          $login = substr($email, 0, strpos($email, "@"));
        }
        $login = $this->createUniqueLogin($login);
        $mainframe->setUserState("loginboss.login", $login );
        
        $mainframe->setUserState("loginboss.externalProfile", $externalProfile->toArray() );
        $mainframe->redirect("?option=com_loginboss&task=confirm_login");
        exit;
      }
    }
  }
  
  public function oauthUserExists($unique_name, $provider){
    $db =& JFactory::getDBO();
    $db->setQuery(
       "SELECT user_id 
        FROM #__loginboss_oauth_users 
        WHERE 
          `unique_name`=".$db->quote($unique_name). "
        AND
          `provider`=".$db->quote(strtolower($provider)));
    $user_id = $db->loadResult();
    return $user_id;
  }

  private function createUniqueLogin($login){
    $db =& JFactory::getDBO();
    //$db->setQuery("SELECT user_id FROM #__users WHERE username=".$db->quote($login."[from {$this->getProviderName()}]"));
    $user=JFactory::getUser( $login."[from {$this->getProviderName()}]" );
    $counterSuffix=0;
    while($user->id != 0){
      $counterSuffix = $counterSuffix+1;
      $user=JFactory::getUser( $login.$counterSuffix."[from {$this->getProviderName()}]" );
    }
    return $login.($counterSuffix>0?$counterSuffix:"")."[from {$this->getProviderName()}]";
  } 

  function oauthRequest($method, $url, $params, $consumer_secret, $token_secret=""){
      $method = strtoupper($method);
      ksort($params);
      $url_encoded = rawurlencode($url);
      $params_str ="";
      foreach($params as $key=>$value){
          $key = rawurlencode($key);
          $value = rawurlencode($value);
          if($params_str!=''){
              $params_str = $params_str."&";
          }
          $params_str = $params_str."$key=$value";
      }
      if($consumer_secret){
      $params_encoded = rawurlencode($params_str);
      $sign = rawurlencode( base64_encode( hash_hmac("sha1", $method."&".$url_encoded."&".$params_encoded, $consumer_secret."&".$token_secret, true) ) );
      $params["oauth_signature"] = $sign;
      if($params_str!=''){
          $params_str = $params_str."&";
      }
      $params_str = $params_str."oauth_signature=$sign";
      }
      $ch = curl_init();
      if($method=="POST"){
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $params_str);
      }else{
          curl_setopt($ch, CURLOPT_URL, $url."?".$params_str);
      }
      curl_setopt($ch, CURLOPT_HTTPHEADER,array("Expect:"));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $body = curl_exec($ch);
      return $body;
  }
  
  public function createOauthUser($userId, $provider, $uniqueId, $linked=0){
    $db =& JFactory::getDBO();
    $db->setQuery("INSERT INTO `#__loginboss_oauth_users`
        (user_id, provider, `unique_name`, `linked`)
        VALUES (".$db->quote($userId).",
        ".$db->quote(strtolower($provider)).",
        ".$db->quote($uniqueId).",
        ".$db->quote($linked).")");
    return $db->query()!=false;
  }
}
?>
