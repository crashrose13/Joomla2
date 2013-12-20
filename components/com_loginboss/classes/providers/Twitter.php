<?php 
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
require_once "OAUTH.php";
    class OAUTHTwitter extends OAUTHLoginBoss{
        private $dataObj;
        function __construct($data){
            $this->setDataObj($data);
        }
        
        public function getProviderName(){
          return "Twitter";
        }
        
        public function getProfileUrl($profileId){
          return "https://twitter.com/$profileId/";
        }
        
        public function getLoginUrl(){
            return JRoute::_( 'index.php?option=com_loginboss&task=dispatch&provider=twitter&action=login' );
        }
        
        public function executeAction($action){
            switch($action){
                case "login":
                    $this->twitterLogin();
                    break;
                case "callback":
                    $this->callback();
                    break;
                    
            }
        }
        
        private function twitterLogin(){
            $twitter_url = "https://api.twitter.com/oauth/request_token";
            
            $callback=rawurlencode(JURI::base()."index.php?option=com_loginboss&task=dispatch&provider=twitter&action=callback");
            $consumer_key = $this->getDataObj()->client_id;
            $consumer_secret = $this->getDataObj()->client_secret;
            
            $nonce=md5(time());
            
            $time = time();
            $request_string="POST&".
                    rawurlencode($twitter_url)."&".
                    rawurlencode("oauth_callback=$callback&oauth_consumer_key=$consumer_key&oauth_nonce=$nonce&oauth_signature_method=HMAC-SHA1&oauth_timestamp=$time&oauth_version=1.0");
            
            $sign = rawurlencode( base64_encode( hash_hmac("sha1", $request_string, $consumer_secret."&", true) ) );
            
            $authorisationHeader = "OAuth oauth_callback=\"$callback\", ".
                    "oauth_consumer_key=\"$consumer_key\", oauth_nonce=\"$nonce\", ".
                    "oauth_signature_method=\"HMAC-SHA1\", oauth_timestamp=\"$time\", ".
                    "oauth_signature=\"$sign\", oauth_version=\"1.0\"";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $twitter_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER,array("Authorization: $authorisationHeader", "Expect:", "Content-Type:", "Content-Length:"));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $body = curl_exec($ch);
            
            $responseTokens = array();
            parse_str($body, $responseTokens);
            if(isset($responseTokens["oauth_token"])){
                header("Location: https://api.twitter.com/oauth/authenticate?oauth_token=".$responseTokens["oauth_token"]);
                exit;
            }else{
                //Error requesting the token;
                echo "ERROR:\n";
                echo $body;
            }
        }
        
        private function callback(){
            global $mainframe;
            $oauth_token = JRequest::getVar("oauth_token");
            $oauth_verifier = JRequest::getVar("oauth_verifier");
            
            $twitter_url = "https://api.twitter.com/oauth/access_token";
            
            $consumer_key = $this->getDataObj()->client_id;
            $consumer_secret = $this->getDataObj()->client_secret;
            
            $nonce=md5(time());
            
            $time = time();
            
            $request_string="POST&".
                    rawurlencode($twitter_url)."&".
                    rawurlencode(
                            "oauth_consumer_key=$consumer_key&".
                            "oauth_nonce=$nonce&".
                            "oauth_signature_method=HMAC-SHA1&".
                            "oauth_timestamp=$time&".
                            "oauth_token=$oauth_token&".
                            "oauth_verifier=$oauth_verifier&".
                            "oauth_version=1.0");
            
            $sign = rawurlencode( base64_encode( hash_hmac(
                    "sha1", $request_string, $consumer_secret."&", true) ) );
            
            $authorisationHeader = "OAuth ".
                    "oauth_consumer_key=\"$consumer_key\", ".
                    "oauth_nonce=\"$nonce\", ".
                    "oauth_signature_method=\"HMAC-SHA1\", ".
                    "oauth_timestamp=\"$time\", ".
                    "oauth_signature=\"$sign\", ".
                    "oauth_token=\"$oauth_token\", ".
                    "oauth_verifier=\"$oauth_verifier\", ".
                    "oauth_version=\"1.0\"";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $twitter_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER,array("Authorization: $authorisationHeader", "Expect:", "Content-Type:", "Content-Length:"));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "oauth_verifier=$oauth_verifier" );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $body = curl_exec($ch);
            
            $responseTokens = array();
            parse_str($body, $responseTokens);
            
            $twitter_url = "https://api.twitter.com/1/users/lookup.json";
            
            $nonce=md5(time());
            
            $time = time();
            
            $request_string="GET&".
                    rawurlencode($twitter_url)."&".
                    rawurlencode(
                            "oauth_consumer_key=$consumer_key&".
                            "oauth_nonce=$nonce&".
                            "oauth_signature_method=HMAC-SHA1&".
                            "oauth_timestamp=$time&".
                            "oauth_token={$responseTokens["oauth_token"]}&".
                            "oauth_verifier=$oauth_verifier&".
                            "oauth_version=1.0&".
                            "user_id=".$responseTokens["user_id"]);
            
            $sign = rawurlencode(
               base64_encode(
                 hash_hmac("sha1", $request_string,
                   $consumer_secret."&".$responseTokens["oauth_token_secret"], true) ) );
            
            
            $authorisationHeader = "OAuth ".
                    "oauth_consumer_key=\"$consumer_key\", ".
                    "oauth_nonce=\"$nonce\", ".
                    "oauth_signature_method=\"HMAC-SHA1\", ".
                    "oauth_timestamp=\"$time\", ".
                    "oauth_signature=\"$sign\", ".
                    "oauth_token=\"{$responseTokens["oauth_token"]}\", ".
                    "oauth_verifier=\"$oauth_verifier\"";
                    "oauth_version=\"1.0\"";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $twitter_url."?user_id=".$responseTokens["user_id"]);
            curl_setopt($ch, CURLOPT_HTTPHEADER,array("Authorization: $authorisationHeader", "Expect:", "Content-Type:", "Content-Length:"));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $body = curl_exec($ch);
            
            $user_name = $responseTokens["screen_name"];
            $data = json_decode($body, true);
            require_once dirname(__FILE__).'/../ExternalProfile.php';
            $profile = new ExternalProfile();
            $profile->setId($user_name);
            $profile->setName($user_name);
            $profile->setProfileURL("https://twitter.com/$user_name/");
            $profile->setImageURL($data[0]["profile_image_url"]);
            $profile->setProvider($this->getProviderName());
            $this->login($user_name, $profile);
        }
    }
?>
