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
<li><?php echo JText::_('COM_LOGINBOSS_HELP_OPEN');?>
  <a href="https://www.linkedin.com/secure/developer">https://www.linkedin.com/secure/developer</a>
  <img src="<?php echo JURI::base();?>components/com_loginboss/views/help/images/linkedin1.png" style="display:block"/>
</li>
<li><?php echo JText::_('COM_LOGINBOSS_LINKEDIN_CLICK_ADD_NEW_APPLICATION');?>
  <img src="<?php echo JURI::base();?>components/com_loginboss/views/help/images/linkedin2.png" style="display:block"/>
</li>
<li><?php echo JText::_('COM_LOGINBOSS_LINKEDIN_FILL_THE_FORM');?>
  <ol>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_LINKEDIN_COMPANY');?></strong> 
     - <?php echo JText::_('COM_LOGINBOSS_LINKEDIN_COMPANY_NAME');?></li>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_LINKEDIN_APPLICATION_NAME');?></strong>
     - <?php echo JText::_('COM_LOGINBOSS_LINKEDIN_APPLICATION_NAME_EXAMPLE');?></li>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_LINKEDIN_DESCRIPTION');?></strong>
     - <?php echo JText::_('COM_LOGINBOSS_LINKEDIN_DESCRIPTION_EXAMPLE');?></li>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_LINKEDIN_WEBSITE_URL');?></strong>
     - <?php echo $callback_url?></li>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_LINKEDIN_APPLICATION_USE');?></strong>
     - <?php echo JText::_('COM_LOGINBOSS_LINKEDIN_SELECT_APPROPRIATE_ITEM');?></li>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_LINKEDIN_LIVE_STATUS');?></strong>
     - <?php echo JText::_('COM_LOGINBOSS_LINKEDIN_LIVE');?></li>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_LINKEDIN_CONTACT_INFO');?></strong>
     - <?php echo JText::_('COM_LOGINBOSS_LINKEDIN_CONTACT_INFO_DETAILS');?></li>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_LINKEDIN_REDIRECT_URL');?></strong>
     - http://<?php echo $callback_url?>/index.php?option=com_loginboss&task=callback&provider=linkedin</li>
  </ol>
</li>
<li><?php echo JText::_('COM_LOGINBOSS_LINKEDIN_CLICK_SAVE');?></li>
<li><?php echo JText::_('COM_LOGINBOSS_LINKEDIN_COPY_SETTINGS'); ?>
<img src="<?php echo JURI::base();?>components/com_loginboss/views/help/images/linkedin3.png" style="display:block"/>
</li>
</ol>
