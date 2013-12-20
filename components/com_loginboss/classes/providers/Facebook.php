<?php 
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
require_once "OAUTH.php";

class OAUTHFacebook extends OAUTHLoginBoss{
    private $dataObj;
    function __construct($data){
        $this->setDataObj($data);
    }
    
    public function getProviderName(){
      return "Facebook";
    }
    
    public function getProfileUrl($profileId){
      return "http://www.facebook.com/$profileId";
    }
    
    public function getLoginUrl(){
        return "https://www.facebook.com/dialog/oauth?".
	"client_id=".$this->getDataObj()->client_id."&".
	"redirect_uri=".
	rawurlencode(JURI::base()."index.php?option=com_loginboss&task=dispatch&provider=facebook&action=callback").
	"&response_type=code";
    }
    
    public function executeAction($action){
        switch($action){
            case "callback":
                $this->callback();
                break;
        
        }
    }
    
    public function callback(){
        global $mainframe;
        
        $code = rawurlencode($_REQUEST["code"]);
        
        $client_id= rawurlencode($this->getDataObj()->client_id);
        $client_secret=rawurlencode($this->getDataObj()->client_secret);
        
        $redirect_url=rawurlencode(JURI::base()."index.php?option=com_loginboss&task=dispatch&provider=facebook&action=callback");
        
        $fb_url = "https://graph.facebook.com/oauth/access_token?".
          "client_id=$client_id&".
          "redirect_uri=$redirect_url&".
          "client_secret=$client_secret&".
          "code=$code";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fb_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
                array("Content-Type:application/x-www-form-urlencoded",
                        "Expect:"
                        /*"Content-Length:"*/));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $body = curl_exec($ch);
        parse_str($body, $data);
        $fb_url = "https://graph.facebook.com/me?fields=id,name,username,link,picture&access_token=".$data["access_token"];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fb_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
        array("Content-Type:application/x-www-form-urlencoded",
            "Expect:"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $body = json_decode($response);
        
        require_once dirname(__FILE__).'/../ExternalProfile.php';
        $profile = new ExternalProfile();
        $profile->setId($body->id);
        $profile->setName($body->name);
        $profile->setProfileURL($body->link);
        $profile->setImageURL($body->picture->url);
        $profile->setProvider($this->getProviderName());
        $this->login($body->username, $profile);
    }
}
?>
