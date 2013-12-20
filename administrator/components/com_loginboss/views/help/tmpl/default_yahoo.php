<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );
$callback_url = JURI::base();

$callback_url = substr($callback_url, 0 , strlen($callback_url) - strlen("/administrator/"));

?>
<ol>
<li><?php echo JText::_('COM_LOGINBOSS_HELP_OPEN');?> <a href="https://developer.apps.yahoo.com/projects" target="_blank">https://developer.apps.yahoo.com/projects</a>
</li>
<li><?php echo JText::_('COM_LOGINBOSS_YAHOO_CLICK_CREATE_PROJECT');?>
<img src="<?php echo JURI::base();?>components/com_loginboss/views/help/images/yahoo1.png" 
  style="display:block"/>
</li>
<li><?php echo JText::_('COM_LOGINBOSS_YAHOO_SELECT_STANDARD_APP');?></li>
<li><?php echo JText::_('COM_LOGINBOSS_YAHOO_CLICK_SAVE_BUTTON');?></li>
<li><?php echo JText::_('COM_LOGINBOSS_YAHOO_FILL_THE_FORM');?>
  <ol>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_YAHOO_APPLICATION_NAME');?></strong>
     - <?php echo JText::_('COM_LOGINBOSS_YAHOO_EXAMPLE_OAUTH_LOGIN');?></li>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_YAHOO_KIND_OF_APP');?></strong>
     - <?php echo JText::_('COM_LOGINBOSS_YAHOO_WEB_BASED');?></li>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_YAHOO_DESCRIPTION')?></strong>
     - <?php echo JText::_('COM_LOGINBOSS_YAHOO_DESCRIPTION_EXAMPLE');?></li>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_YAHOO_APPLICATION_URL');?></strong>
     - <?php echo $callback_url;?></li>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_YAHOO_APPLICATION_DOMAIN');?></strong>
     - <?php echo $callback_url;?></li>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_YAHOO_ACCESS_SCOPES');?></strong>
     - <?php echo JText::_('COM_LOGINBOSS_YAHOO_ACCESS_SCOPES_DETAILS');?>
      <img src="<?php echo JURI::base();?>components/com_loginboss/views/help/images/yahoo2.png" 
        style="display:block" 
        alt="<?php echo $this->escape( JText::_('COM_LOGINBOSS_YAHOO_ACCESS_SCOPES'));?>"/>
    </li>
    <li><strong><?php echo JText::_('COM_LOGINBOSS_YAHOO_TERMS_OF_USE');?></strong> 
     - <?php echo JText::_('COM_LOGINBOSS_YAHOO_CHECK_THE_CHECKBOX');?></li>
  </ol>
</li>

<li><?php echo JText::_('COM_LOGINBOSS_YAHOO_CLICK_GET_API_KEY');?></li>
<li><?php echo JText::_('COM_LOGINBOSS_YAHOO_COPY_SETTINGS');?>
<img src="<?php echo JURI::base();?>components/com_loginboss/views/help/images/yahoo3.png" style="display:block"/>
</li>
</ol>

