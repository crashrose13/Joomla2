<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */
jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

class LoginbossModelRegistration extends BaseRegistrationModel{
  public function registerJoomlaUser($login, $name, $email, $trustEmail){
  $config = JFactory::getConfig();
  JFactory::getLanguage()->load('com_users');
  $db		= $this->getDbo();
  $params = JComponentHelper::getParams('com_users');
  
  if($params->get("allowUserRegistration") == 0){
    $this->setError("Registration is denied.");
    return false;
  }
  // Initialise the table with JUser.
  $user = new JUser;
  $data = array();
  
  $password =JApplication::getHash(JUserHelper::genRandomPassword());
  $data["username"] = $login;
  $data["name"] = $name;
  $data["email"] = $email;
  $data["email1"] = $email;
  $data["password"] = $password;
  $data["password1"] = $password;
  
  $data["groups"] = array();
  $data["groups"][] = $params->get("new_usertype", 2);
  
  $useractivation = $params->get('useractivation');

  // Check if the user needs to activate their account.
  if (($useractivation == 1 && !$trustEmail) || ($useractivation == 2)) {
    $data['activation'] = JApplication::getHash(JUserHelper::genRandomPassword());
	$data['block'] = 1;
  }

  // Bind the data.
  if (!$user->bind($data)) {
    $this->setError(JText::sprintf('COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));
    return false;
  }
  
  // Load the users plugin group.
  JPluginHelper::importPlugin('user');

  // Store the data.
  if (!$user->save()) {
    $this->setError(JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $user->getError()));
    return false;
  }
  
  // Compile the notification mail values.
  $data = $user->getProperties();
  $data['fromname']	= $config->get('fromname');
  $data['mailfrom']	= $config->get('mailfrom');
  $data['sitename']	= $config->get('sitename');
  $data['siteurl']	= JUri::root();
  
  // Handle account activation/confirmation emails.
		if ($useractivation == 2)
		{
			// Set the link to confirm the user email.
			$uri = JURI::getInstance();
			$base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
			$data['activate'] = 
			  $base.JRoute::_('index.php?option=com_users&task=registration.activate&token='.
			  $data['activation'], false);

			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);

			$emailBody = JText::sprintf(
				"COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY",
				$data['name'],
				$data['sitename'],
				$data['siteurl'].
			      'index.php?option=com_users&task=registration.activate&token='.
			      $data['activation'],
				$data['siteurl'],
				$data['username'],
				$data['password_clear']
			);
		}
		elseif ($useractivation == 1)
		{
			// Set the link to activate the user account.
			$uri = JURI::getInstance();
			$base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
			$data['activate'] = $base.JRoute::_('index.php?option=com_users&task=registration.activate&token='.$data['activation'], false);

			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);

			$emailBody = JText::sprintf(
				"COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY",
				$data['name'],
				$data['sitename'],
				$data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'],
				$data['siteurl'],
				$data['username'],
				$data['password_clear']
			);
		} else {

			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);

			$emailBody = JText::sprintf(
				"COM_USERS_EMAIL_REGISTERED_BODY",
				$data['name'],
				$data['sitename'],
				$data['siteurl']
			);
		}

		// Send the registration email.
		$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);

		//Send Notification mail to administrators
		if (($params->get('useractivation') < 2) && ($params->get('mail_to_admin') == 1)) {
			$emailSubject = JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);

			$emailBodyAdmin = JText::sprintf(
				"COM_USERS_EMAIL_REGISTERED_NOTIFICATION_TO_ADMIN_BODY",
				$data['name'],
				$data['username'],
				$data['siteurl']
			);

			// get all admin users
			$query = 'SELECT name, email, sendEmail' .
					' FROM #__users' .
					' WHERE sendEmail=1';

			$db->setQuery( $query );
			$rows = $db->loadObjectList();

			// Send mail to all superadministrators id
			foreach( $rows as $row )
			{
				$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $row->email, $emailSubject, $emailBodyAdmin);

				// Check for an error.
				if ($return !== true) {
					$this->setError(JText::_("COM_USERS_REGISTRATION_ACTIVATION_NOTIFY_SEND_MAIL_FAILED"));
					return false;
				}
			}
		}
		// Check for an error.
		if ($return !== true) {
			$this->setError(JText::_("COM_USERS_REGISTRATION_SEND_MAIL_FAILED"));

			// Send a system message to administrators receiving system mails
			$db = JFactory::getDBO();
			$q = "SELECT id
				FROM #__users
				WHERE block = 0
				AND sendEmail = 1";
			$db->setQuery($q);
			$sendEmail = $db->loadColumn();
			if (count($sendEmail) > 0) {
				$jdate = new JDate();
				// Build the query to add the messages
				$q = "INSERT INTO ".$db->quoteName('#__messages')." (".$db->quoteName('user_id_from').
				", ".$db->quoteName('user_id_to').", ".$db->quoteName('date_time').
				", ".$db->quoteName('subject').", ".$db->quoteName('message').") VALUES ";
				$messages = array();

				foreach ($sendEmail as $userid) {
					$messages[] = "(".$userid.", ".$userid.", '".$jdate->toSql()."', 
					'".JText::_("COM_USERS_MAIL_SEND_FAILURE_SUBJECT")."', 
					'".JText::sprintf("COM_USERS_MAIL_SEND_FAILURE_BODY",
					$return, $data['username'])."')";
				}
				$q .= implode(',', $messages);
				$db->setQuery($q);
				$db->query();
			}
			return false;
		}
		return $user->id;
  }
}
?>