<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );
$callback_url = JURI::base();

$callback_url = substr($callback_url, 0 , strlen($callback_url) - strlen("/administrator"));

$callback_url .= "index.php?option=com_loginboss&task=dispatch&provider=twitter&action=callback";
?>
<ol>
<li><?php echo JText::_('COM_LOGINBOSS_HELP_OPEN');?> <a href="https://dev.twitter.com/apps/new">https://dev.twitter.com/apps/new</a></li>
<li><?php echo JText::sprintf('COM_LOGINBOSS_TWITTER_ENTER_DETAILS', $callback_url)?>
  <img src="<?php echo JURI::base();?>components/com_loginboss/views/help/images/twitter1.jpg" style="display:block;"/>
</li>
<li><?php echo JText::_('COM_LOGINBOSS_TWITTER_CLICK_ON_CREATE_APPLICATION');?></li>
<li><?php echo JText::_('COM_LOGINBOSS_TWITTER_CLICK_ON_GET_ACCESS_TOKEN');?>
  <img src="<?php echo JURI::base();?>components/com_loginboss/views/help/images/twitter2.jpg" style="display:block;"/>
</li>
<li><?php echo JText::_('COM_LOGINBOSS_TWITTER_ENTER_CONSUMER_KEY_AND_SECRET');?></li>
</ol>

