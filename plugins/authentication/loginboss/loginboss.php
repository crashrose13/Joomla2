<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.event.plugin' );

class plgAuthenticationLoginBoss extends JPlugin
{
  function plgAuthenticationLoginBoss(& $subject)
  {
    parent::__construct($subject);
  }

  function onAuthenticate( $credentials, $options, &$response )
  {
    $response->status	= JAUTHENTICATE_STATUS_FAILURE;
    $response->error_message = 'authentication failed';

    if ( $credentials['username'] == 'loginboss:' && $credentials['password'] == 'foobar' && isset( $options["loginboss.user_id"] ) ) {
      $db = JFactory::getDBO();
      $db->setQuery("SELECT user_id FROM #__loginboss_oauth_users WHERE unique_name=".$db->quote($options["loginboss.user_id"]));
      $id = $db->loadResult();
      if($id){
        $user = new JUser();
        $user->load($id);
        $response->status	= JAUTHENTICATE_STATUS_SUCCESS;
        $response->username = $user->username;
        $response->fullname = $user->name;
        $response->error_message = '';
      }
    }
  }
	
	function onUserAuthenticate( $credentials, $options, &$response )
	{
	    $response->status	= JAuthentication::STATUS_FAILURE;
	    $response->error_message = 'authentication failed';
	    
	    if ( $credentials['username'] == 'loginboss:' && $credentials['password'] == 'foobar' && isset( $options["loginboss.user_id"] ) ) {
	        $db = JFactory::getDBO();
	        $db->setQuery("SELECT user_id FROM #__loginboss_oauth_users WHERE unique_name=".$db->quote($options["loginboss.user_id"]));
	        $id = $db->loadResult();
	        if($id){
	            $user = new JUser();
	            $user->load($id);
	            $response->status	= JAuthentication::STATUS_SUCCESS;
	            $response->username = $user->username;
	            $response->fullname = $user->name;
	            $response->error_message = '';
	        }
	    } 
	}
}
