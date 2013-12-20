<?php
/**
* @package		Login Boss
* @copyright	JoomBoss team
* @license		GNU/GPL, see LICENSE.php
*/

defined('_JEXEC') or die( 'Restricted access' );
jimport('joomla.application.component.view');

if(version_compare(JVERSION, "3.0", "ge")){
  class JBView extends JViewLegacy{}
}else{
  class JBView extends JView{}
}