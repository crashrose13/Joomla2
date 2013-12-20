<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');
jimport('joomla.client.helper');

/**
 * Login Controller
 *
 * @package		LoginBoss
 * @subpackage	Core
 * @since		1.0
 */
if(version_compare(JVERSION, "3.0", "ge")){
  class JBController extends JControllerLegacy{}
}else{
  class JBController extends JController{}
}

class LoginbossController extends JBController{
  function dispatch(){
    $provider=JRequest::getCmd("provider");
    $action=JRequest::getCmd("action");
    require_once dirname(__FILE__)."/classes/ProviderFactory.php";
    $provider = ProviderFactory::getProviderById($provider);
    $provider->executeAction($action);
  }

  function confirm_login(){
    $mainframe =& JFactory::getApplication();
    require_once dirname(__FILE__)."/classes/ProviderFactory.php";
    require_once dirname(__FILE__)."/classes/ExternalProfile.php";
    $externalProfile = new ExternalProfile( 
        $mainframe->getUserState("loginboss.externalProfile") );
    
    $providerId = $externalProfile->getProvider();
    $provider = ProviderFactory::getProviderById($providerId);
    $view =& $this->getView( 'Login' );
    
    $view->assign( "provider", $providerId );
    $view->assign( "login",$mainframe->getUserState("loginboss.login") );
    
    $view->assign( "email",$externalProfile->getEmail() );
    $view->assign( "original_email",$externalProfile->getEmail() );
    
    $params = JComponentHelper::getParams('com_users');
    $useractivation = $params->get('useractivation');
    $view->assign( "activation",$useractivation);
     
    $view->display();
  }

  function submit_login(){
    require_once dirname(__FILE__)."/classes/ExternalProfile.php";
    $mainframe =& JFactory::getApplication();
    $login=JRequest::getVar("login");
    $email=JRequest::getVar("email");
    $externalProfile = new ExternalProfile( 
        $mainframe->getUserState("loginboss.externalProfile") );
    $provider = $externalProfile->getProvider();
    require_once dirname(__FILE__)."/classes/ProviderFactory.php";
    $provider = ProviderFactory::getProviderById($provider);
    $user_name = $externalProfile->getName();
    $unique_id = $externalProfile->getId();
    $model = $this->getModel("Registration");
    $trustEmail = ( $email == $externalProfile->getEmail() && $email != "" ); 
    $status = $model->registerUser($unique_id, $provider->getProviderName(), 
      $login, $user_name, $email, $trustEmail);
    switch($status){
      case "ready":
        $provider->login( $login, $externalProfile );
        break;
      case "useractivate":
        $view =& $this->getView( 'Login' );
        $view->assign("message", JText::sprintf('COM_LOGINBOSS_ACCOUNT_NEEDS_TO_BE_ACTIVATED', $provider->getProviderName()));
        $view->display("activation");
        break;
      case "adminactivate":
        $view =& $this->getView( 'Login' );
        $view->assign("message", JText::sprintf('COM_lOGINBOSS_ACCOUNT_ADMIN_ACTIVATE', $provider->getProviderName()));
        $view->display("activation");
        break;
      case "error":
        $view =& $this->getView( 'Login' );
        $view->assign( "provider", $provider->getProviderName() );
        $view->assignRef( "login",$login );
        $view->assignRef( "email",$email );
        $view->assign( "original_email",$externalProfile->getEmail());
        $mainframe->enqueueMessage($model->getError(), "error");
        
        $params = JComponentHelper::getParams('com_users');
        $useractivation = $params->get('useractivation');
        $view->assign( "activation",$useractivation);
        $view->display();
        break;
    }
    
  }
}
?>
