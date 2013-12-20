<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');

class LoginbossViewProviders extends JBView{
    function __construct($config = null)
    {
        parent::__construct($config);
        $this->_addPath('template', $this->_basePath.'/views/default/tmpl');
    }
    function display($tpl=null){
      JToolBarHelper::title(JText::_("OAuth providers"));
      parent::display($tpl);
    }
}
