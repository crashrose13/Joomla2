<?php
/**
 * GCalendar is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GCalendar is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GCalendar.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package		GCalendar
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2007 - 2013 Digital Peak. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

if(!empty($error)){
	echo $error;
	return;
}

GCalendarUtil::loadLibrary();

$data = array();
$now = false;
$targetDate = JFactory::getDate(0);
$title = '';
if($gcalendar_item != null){
	$data[] = $gcalendar_item;
	$targetDate = $gcalendar_item->getStartDate();
	if ($gcalendar_item->getStartDate()->format('U') < JFactory::getDate()->format('U')) {
		# Countdown to end of event, not currently implemented
		#$targetDate = $gcalendar_item->get_end_date();
		$now = true;
	}
	$title = $gcalendar_item->getTitle();
}

$tmp = clone JComponentHelper::getParams('com_gcalendar');

$output = $params->get('output', '{{#events}}<span class="countdown_row">{y<}<span class="countdown_section"><span class="countdown_amount">{yn}</span><br/>{yl}</span>{y>}{o<}<span class="countdown_section"><span class="countdown_amount">{on}</span><br/>{ol}</span>{o>}{w<}<span class="countdown_section"><span class="countdown_amount">{wn}</span><br/>{wl}</span>{w>}{d<}<span class="countdown_section"><span class="countdown_amount">{dn}</span><br/>{dl}</span>{d>}{h<}<span class="countdown_section"><span class="countdown_amount">{hn}</span><br/>{hl}</span>{h>}{m<}<span class="countdown_section"><span class="countdown_amount">{mn}</span><br/>{ml}</span>{m>}{s<}<span class="countdown_section"><span class="countdown_amount">{sn}</span><br/>{sl}</span>{s>}<div style="clear:both"><p><a href="{{{backlink}}}">{{title}}</a><br/>{{{description}}}</p></div></span>{{/events}}{{^events}}{{emptyText}}{{/events}}');
$layout = preg_replace('#\r|\n#', '', GCalendarUtil::renderEvents($data, $output, $tmp));

$output = $params->get('output_now', '{{#events}}<p>Event happening now:<br/>{{date}}<br/><a href="{{{backlink}}}">{{title}}</a>{{#maplink}}<br/>Join us at [<a href="{{{maplink}}}" target="_blank">map</a>]{{/maplink}}</p>{{/events}}{{^events}}{{emptyText}}{{/events}}');
$expiryText = preg_replace('#\r|\n#', '', GCalendarUtil::renderEvents($data, $output, $tmp));
$class = "countdown";
$class .= ($now) ? "now" : "";
$objid = "countdown-" . $module->id;

$document = JFactory::getDocument();
$document->addScript(JURI::base(). 'components/com_gcalendar/libraries/jquery/ext/jquery.countdown.min.js');
$document->addStyleSheet(JURI::base(). 'components/com_gcalendar/libraries/jquery/ext/jquery.countdown.css');

$labels = array(JText::_('MOD_GCALENDAR_NEXT_LABEL_YEARS'),
		JText::_('MOD_GCALENDAR_NEXT_LABEL_MONTHS'),
		JText::_('MOD_GCALENDAR_NEXT_LABEL_WEEKS'),
		JText::_('MOD_GCALENDAR_NEXT_LABEL_DAYS'),
		JText::_('MOD_GCALENDAR_NEXT_LABEL_HOURS'),
		JText::_('MOD_GCALENDAR_NEXT_LABEL_MINUTES'),
		JText::_('MOD_GCALENDAR_NEXT_LABEL_SECONDS')
);
$labels1 = array(JText::_('MOD_GCALENDAR_NEXT_LABEL_YEAR'),
		JText::_('MOD_GCALENDAR_NEXT_LABEL_MONTH'),
		JText::_('MOD_GCALENDAR_NEXT_LABEL_WEEK'),
		JText::_('MOD_GCALENDAR_NEXT_LABEL_DAY'),
		JText::_('MOD_GCALENDAR_NEXT_LABEL_HOUR'),
		JText::_('MOD_GCALENDAR_NEXT_LABEL_MINUTE'),
		JText::_('MOD_GCALENDAR_NEXT_LABEL_SECOND')
);

$calCode = "// <![CDATA[ \n";
$calCode .= "	gcjQuery(document).ready(function() {\n";
$calCode .= "	var targetDate; \n";
$calCode .= "	targetDate = new Date(".$targetDate->format("Y, m-1, d, H, i, 0", true).");\n";
$calCode .= "	gcjQuery('#".$objid."').countdown({until: targetDate, \n";
$calCode .= "				       description: '".str_replace('\'', '\\\'', $title)."', \n";
$calCode .= " 				       layout: '".str_replace('\'', '\\\'',$layout)."', \n";
$calCode .= " 				       labels: ['".implode("','", $labels)."'], \n";
$calCode .= " 				       labels1: ['".implode("','", $labels1)."'], \n";
$calCode .= "				       alwaysExpire: true, expiryText: '".str_replace('\'', '\\\'',$expiryText)."', \n";
$calCode .= "				       ".$params->get('style_parameters', "format: 'dHMS'")."});\n";
$calCode .= "});\n";
$calCode .= "// ]]>\n";
$document->addScriptDeclaration($calCode);
?>
<div class="gcalendar_next">
	<div id="<?php echo $objid;?>" class="<?php echo $class;?>"><?php echo JText::_("MOD_GCALENDAR_NEXT_JSERR");?></div>
</div>