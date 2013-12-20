<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );
$callback_url = JURI::base();

$callback_url = substr($callback_url, 0 , strlen($callback_url) - strlen("/administrator"));

$callback_url .= "index.php?option=com_loginboss&task=dispatch&provider=google&action=callback";
?>
<ol>
  <li><?php echo JText::_('COM_LOGINBOSS_HELP_OPEN');?>
      <a href="https://code.google.com/apis/console#access">https://code.google.com/apis/console#access</a>.
  </li>
  <li><?php echo JText::_('COM_LOGINBOSS_GOOGLE_SELECT_API_ACCESS');?></li>
  <li><?php echo JText::_('COM_LOGINBOSS_GOOGLE_CLICK_CREATE_CLIENT_BUTTON');?>
    <img src="<?php echo JURI::base();?>components/com_loginboss/views/help/images/google1.jpg" style="display:block;"/>
  </li>
  <li><?php echo JText::sprintf('COM_LOGINBOSS_GOOGLE_ENTER_SITE_DETAILS', $callback_url);?></li>
  <li><?php echo JText::_('COM_LOGINBOSS_GOOGLE_GET_CLIENT_ID_AND_SECRET');?>
    <img src="<?php echo JURI::base();?>components/com_loginboss/views/help/images/google2.jpg" style="display:block;"/>
  </li>
  <li>
    <?php echo JText::_('COM_LOGINBOSS_GOOGLE_COPY_SETTINGS');?>
  </li>
</ol>

