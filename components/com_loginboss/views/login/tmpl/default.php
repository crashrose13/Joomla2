<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

?>
  <h1><?php echo JText::sprintf('COM_LOGINBOSS_AUTHENTICATION_VIA', $this->provider);?></h1>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<input type="hidden" name="option" value="com_loginboss" />
<input type="hidden" name="task" value="submit_login"/>
  <fieldset >
  <p> 
<?php echo JText::sprintf('COM_LOGINBOSS_AUTHENTICATION_FIRST_TIME', $this->provider);?></p>
<p>
<label for="seoboss.login" style="font-weight:bold"><?php echo JText::_('COM_LOGINBOSS_AUTHENTICATION_YOUR_LOGIN');?>:</label>
<input class="inputbox required" id="seoboss.login" type="text" name="login" size="50" value="<?php echo $this->escape($this->login)?>"/>
</p>
<p>
<label for="seoboss.email" style="font-weight:bold"><?php echo JText::_('COM_LOGINBOSS_AUTHENTICATION_YOUR_EMAIL');?>:</label>
<input class="inputbox required" id="seoboss.email" type="text" name="email" size="50" value="<?php echo $this->escape($this->email)?>"/>
</p>
<?php if($this->original_email && $this->activation){?>
<p><span style="color:red; font-weight:bold;">!</span>
  <?php echo JText::sprintf('COM_LOGINBOSS_AUTHENTICATION_CHANGE_EMAIL', $this->provider, $this->original_email);?>
</p>
<?php }?>
<input type="submit" value="<?php echo $this->escape(JText::_('COM_LOGINBOSS_AUTHENTICATION_SUBMIT_BUTTON'));?>"/>
</fieldset>
</form>
