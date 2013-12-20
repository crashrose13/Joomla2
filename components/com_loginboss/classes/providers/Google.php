<?php 
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
require_once "OAUTH.php";

class OAUTHGoogle extends OAUTHLoginBoss{
    private $dataObj;
    function __construct($data){
        $this->setDataObj($data);
    }
    
    public function getProviderName(){
      return "Google";
    }
    
    public function isValidEmail(){
      return true;
    }
    
    public function getLoginUrl(){
        return "https://accounts.google.com/o/oauth2/auth?".
	"redirect_uri=".
	rawurlencode(JURI::base()."index.php?option=com_loginboss&task=dispatch&provider=google&action=callback").
	"&response_type=code&".
	"client_id=".$this->getDataObj()->client_id."&".
	"scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile";
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
        $google_url = "https://accounts.google.com/o/oauth2/token";
        
        $client_id= rawurlencode($this->getDataObj()->client_id);
        $client_secret=rawurlencode($this->getDataObj()->client_secret);
        
        $redirect_url=rawurlencode(JURI::base()."index.php?option=com_loginboss&task=dispatch&provider=google&action=callback");
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $google_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
                array("Content-Type:application/x-www-form-urlencoded",
                        "Expect:"
                        /*"Content-Length:"*/));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                "code={$code}&".
                "client_id={$client_id}&".
                "client_secret={$client_secret}&".
                "redirect_uri=$redirect_url&".
                "grant_type=authorization_code" );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
                $body = curl_exec($ch);
        
                $data = json_decode($body);
        
                $google_url = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=".$data->access_token;
        
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $google_url);
                curl_setopt($ch, CURLOPT_HTTPHEADER,
                array("Content-Type:application/x-www-form-urlencoded",
                        "Expect:"));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
                $response = curl_exec($ch);
        
                $body = json_decode($response);
                
                require_once dirname(__FILE__).'/../ExternalProfile.php';
                $profile = new ExternalProfile();
                $profile->setId($body->email);
                $profile->setName($body->name);
                if(isset($body->link)){
                  $profile->setProfileURL($body->link);
                }
                if(isset($body->picture)){
                  $profile->setImageURL($body->picture);
                }
                $profile->setEmail($body->email);
                $profile->setProvider($this->getProviderName());
                
                $this->login($body->name, $profile);
    }
}
?>
