<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );
$callback_url = JURI::base();
if(strpos($callback_url, "http://") === 0){
  $callback_url = substr($callback_url, strlen("http://"));
}
if(strpos($callback_url, "https://") === 0){
  $callback_url = substr($callback_url, strlen("https://"));
}
$callback_url = substr($callback_url, 0 , strlen($callback_url) - strlen("/administrator/"));

?>
<ol>
  <li>
    <?php echo JText::_('COM_LOGINBOSS_HELP_OPEN');?>
    <a href="https://developers.facebook.com/apps">https://developers.facebook.com/apps</a>
  </li>
  <li><?php echo JText::_('COM_LOGINBOSS_FB_CREATE_NEW_APP');?></li>
  <li>
    <?php echo JText::_('COM_LOGINBOSS_FB_ENTER_APP_NAME');?>
    <img src="<?php echo JURI::base();?>components/com_loginboss/views/help/images/fb1.png" style="display:block"/>
  </li>
  <li><?php echo JText::_('COM_LOGINBOSS_FB_ENTER_CAPTCHA');?></li>
  <li><?php echo JText::_('COM_LOGINBOSS_FB_COPY_SETTINGS');?>
    <img src="<?php echo JURI::base();?>components/com_loginboss/views/help/images/fb2.png" style="display:block"/>
  </li>
  <li><?php echo JText::sprintf('COM_LOGINBOSS_FB_ENTER_CALLBACK_URL', $callback_url);?></li>
  <li><?php echo JText::_('COM_LOGINBOSS_FB_CHECK_FACEBOOK_LOGIN_OPTION');?></li>
  <li><?php echo JText::sprintf('COM_LOGINBOSS_FB_ENTER_SITE_URL', $callback_url);?>
    <img src="<?php echo JURI::base();?>components/com_loginboss/views/help/images/fb3.png" style="display:block"/>
  </li>
</ol>

