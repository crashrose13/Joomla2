<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');
jimport('joomla.client.helper');
jimport('joomla.version');
if(version_compare(JVERSION, "3.0", "ge")){
  class JBController extends JControllerLegacy{}
}else{
  class JBController extends JController{}
}
class LoginbossController extends JBController{
    
    public function panel(){
        $model	= &$this->getModel( 'Provider' );
        $view = &$this->getView( 'Providers' );
        $providers = $model->getProviders();
        $view->assignRef("providers", $providers);
        $view->display();
    }
    
    public function editprovider(){
      $version = new JVersion();
      if($version->RELEASE == "1.5"){
        $document = JFactory::getDocument();
        $document->addStyleSheet("components/com_loginboss/views/provider/css/j15.css");
      }

        $id = JRequest::getCmd("id");
        $model	= &$this->getModel( 'Provider' );
        $provider = $model->getProvider($id);
        $view = &$this->getView( 'Provider' );
        $view->assignRef("provider", $provider);
        $view->display();
    }
    
    public function saveprovider(){
        $id = JRequest::getCmd("id");
        $client_id = JRequest::getCmd("client_id");
        $client_secret = JRequest::getCmd("client_secret");
        $enabled = JRequest::getCmd("enabled", "0");
        $model	= &$this->getModel( 'Provider' );
        $model->updateProvider($id, $client_id, $client_secret, $enabled);
        $this->setRedirect("index.php?option=com_loginboss&task=panel", 
                JText::_('COM_LOGINBOSS_PROVIDER_UPDATED'));
    }
    
    public function enableprovider(){
        $id = JRequest::getCmd("id");
        $model	= &$this->getModel( 'Provider' );
        $provider = $model->getProvider($id);
        if($provider->client_id && $provider->client_secret){
            $model->enableProvider($id);
            $this->setRedirect("index.php?option=com_loginboss&task=panel",
                    JText::_('COM_LOGINBOSS_PROVIDER_ENABLED'));
        }else{
            $this->setRedirect("index.php?option=com_loginboss&task=editprovider&id=$id",
                    JText::_('COM_LOGINBOSS_ENTER_REGISTRATION_DETAILS'));
        }
    }
    
    public function disableprovider(){
        $id = JRequest::getCmd("id");
        $model	= &$this->getModel( 'Provider' );
        $model->disableProvider($id);
        $this->setRedirect("index.php?option=com_loginboss&task=panel",
                JText::_('COM_LOGINBOSS_PROVIDER_DISABLED'));
    }

    public function help_oauth(){
      $provider = JRequest::getCmd("provider");
      $view = &$this->getView("Help");

      $view->display($provider);
    }

    public function help(){
      $view = &$this->getView("Help");
      $view->display();
    }
}
