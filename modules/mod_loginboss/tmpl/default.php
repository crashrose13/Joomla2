<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );
$linkEnable = false;
if($user->get('guest') == '1' || $linkEnable){
?>
<p>
<?php foreach($providers as $provider){ ?>
<a href="<?php echo $provider->getLoginUrl()?>" title="<?php 
  echo JText::sprintf('MOD_LOGINBOSS_LOGIN_BY_SERVICE', $provider->getDataObj()->title);?>"><img src="<?php echo JURI::base().$provider->getDataObj()->image ?>" alt="<?php 
  echo JText::sprintf('MOD_LOGINBOSS_LOGIN_BY_SERVICE', $provider->getDataObj()->title);?>"/></a>
<?php } 
?></p><?php
} elseif($profileInfo) {
?>
  <?php if($profileInfo["imageURL"]) { ?>
  <img src="<?php echo $profileInfo["imageURL"]; ?>" alt="<?php echo $profileInfo["name"]; ?>" style="display:block;"/>
  <?php } ?>
  <?php echo JText::sprintf('MOD_LOGINBOSS_LOGGED_IN_BY_SERVICE', $profileInfo["provider"]);?>
<?php }?>
<a href="http://joomboss.com/products/login-boss" style="color:gray;font-size:10px;display:block" target="_blank">LoginBoss social login</a>