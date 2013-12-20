<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

class ExternalProfile{
  private $id=null;
  private $name=null;
  private $profileURL=null;
  private $imageURL=null;
  private $email=null;
  private $provider=null;
  
  public function __construct($arr=null){
    if(is_array($arr)){
      $this->id = $arr["id"];
      $this->name = $arr["name"];
      $this->email = $arr["email"];
      $this->profileURL = $arr["profileURL"];
      $this->imageURL = $arr["imageURL"];
      $this->provider = $arr["provider"];
    }
  }
  public function getId(){
    return $this->id;
  }
  
  public function setId($id){
    $this->id = $id;
  }
  
  public function getName(){
    return $this->name;
  }
  
  public function setName($name){
    $this->name = $name;
  }
  
  public function getProfileURL(){
    return $this->profileURL;
  }
  
  public function setProfileURL($url){
    $this->profileURL = $url;
  }
  
  public function getImageURL(){
    return $this->imageURL;
  }
  
  public function setImageURL($url){
    $this->imageURL = $url;
  }
  
  public function getEmail(){
    return $this->email;
  }
  
  public function setEmail($email){
    $this->email = $email;
  }
  
  public function getProvider(){
    return $this->provider;
  }
  
  public function setProvider($provider){
    $this->provider = $provider;
  }
  
  public function toArray(){
    return array(
        "id"=>$this->id,
        "name"=>$this->name,
        "email"=>$this->email,
        "profileURL"=>$this->profileURL,
        "imageURL"=>$this->imageURL,
        "provider"=>$this->provider
        );
  }
}