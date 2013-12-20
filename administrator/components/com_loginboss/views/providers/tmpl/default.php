<?php
/**
 * @package		Login Boss
 * @copyright	JoomBoss team
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<table class="adminlist">
	    <thead>
	    <tr>
	        <th class="title" width="40"></th>
	    	<th class="title" ><?php echo JText::_('COM_LOGINBOSS_LOGIN_PROVIDER');?></th>
	    	<th class="title" width="50"><?php echo JText::_('COM_LOGINBOSS_ENABLED');?></th>
	    </tr>
	    </thead>
	    <tbody>
		<?php
		$rowNumber=0; 
		foreach($this->providers as $provider){
		    if($provider->enabled){
                      $img="tick.png";
                      $alt=JText::_('COM_LOGINBOSS_DISABLE_PROVIDER');
		    }else{
                      $img="publish_x.png";
                      $alt=JText::_('COM_LOGINBOSS_ENABLE_PROVIDER');
		    }
		    ?>
		<tr class="<?php echo $rowNumber;?>">
		    <td><img src="<?php echo JURI::base()."../".$provider->image?>"/></td>
			<td><a href="index.php?option=com_loginboss&task=editprovider&id=<?php echo $provider->provider;?>"><?php echo $provider->title?></a></td>
                        <td>

<a href="index.php?option=com_loginboss&task=<?php echo $provider->enabled?"disableprovider":"enableprovider";?>&id=<?php echo $provider->provider?>" ><?php echo JHtml::_("image", "admin/".$img, $alt, null , true);?></a></td>
		</tr>
		<?php
		  $rowNumber = 1 - $rowNumber;  
		} ?>
	     </tbody>
	</table>
</form>
