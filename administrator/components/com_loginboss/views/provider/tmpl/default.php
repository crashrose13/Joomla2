<?php 
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<?php if($this->provider == null){?>
<strong><?php echo JText::_('COM_LOGINBOSS_PROVIDER_AVAILABLE_IN_PRO_VERSION_ONLY');?></strong>
<?php }else{?>
<fieldset class="adminform">
<legend><?php echo JText::sprintf('COM_LOGINBOSS_OAUTH_CREDENTIALS_FOR', $this->provider->title);?></legend>
<ol class="adminformlist">
<li>
<p>
  <?php echo JText::sprintf('COM_LOGINBOSS_OAUTH_CREDENTIALS_FOR', $this->provider->title);?> 
  <a href="index.php?option=com_loginboss&task=help_oauth&provider=<?php echo $this->provider->provider?>" target="_blank">
    <?php echo JText::_('COM_LOGINBOSS_OAUTH_CREDENTIALS_READ_DOCUMENTATION');?>
  </a>
</p>
</li>
<li>
  <label for="client_id"><?php echo JText::_('COM_LOGINBOSS_CLIENT_ID');?>:</label>
  <input class="inputbox" type="text" name="client_id" id="client_id"
          size="50" 
          value="<?php if(isset($this->provider->client_id)) echo $this->provider->client_id;?>"/>
</li>
<li>        <label for="client_secret"><?php echo JText::_('COM_LOGINBOSS_CLIENT_SECRET');?>:</label>
        <input class="inputbox" type="text" name="client_secret" id="client_secret"
          size="50"  
          value="<?php if(isset($this->provider->client_secret)) echo $this->provider->client_secret;?>"/>
</li>
</ol>
</fieldset>
<fieldset class="adminform">
<legend><?php echo JText::sprintf('COM_LOGINBOSS_ENABLE_LOGIN_BY', $this->provider->title); ?></legend>
  <ol class="adminlist">
    <li>
        <label for="enabled"><?php echo JText::_('COM_LOGINBOSS_ENABLED'); ?>:</label>
        <input class="inputbox" type="checkbox" name="enabled" id="enabled" value="1"
        <?php if(isset($this->provider->enabled) && $this->provider->enabled==1) {?>checked="checked" <?php }?>/>
    </li>
  </ol>
</fieldset>

<input type="hidden" name="id" value="<?php echo $this->provider->provider; ?>"/>
<?php }?>
<input type="hidden" name="option" value="com_loginboss"/>
<input type="hidden" name="task" value="saveprovider"/>
</form>
