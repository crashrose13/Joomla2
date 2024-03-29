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

JLoader::import('joomla.plugin.plugin');
JLoader::import('components.com_gcalendar.util', JPATH_ADMINISTRATOR);

class plgSearchGCalendar extends JPlugin {

	public function __construct(& $subject, $config) {
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function onContentSearchAreas() {
		static $areas = array(
				'gcalendar' => 'GCalendar'
		);
		return $areas;
	}

	public function onContentSearch($text, $phrase='', $ordering='', $areas=null) {
		$user	= JFactory::getUser();

		$text = trim( $text );
		if ($text == '') {
			return array();
		}
		if ($phrase == 'exact')
			$text = "\"".$text."\"";

		switch ($ordering) {
			case 'oldest':
				$orderasc = GCalendarZendHelper::SORT_ORDER_ASC;
				break;

			case 'newest':
			default:
				$orderasc = GCalendarZendHelper::SORT_ORDER_DESC;
		}

		if (is_array($areas)) {
			if (!array_intersect($areas, array_keys($this->onContentSearchAreas()))) {
				return array();
			}
		}

		$pluginParams = $this->params;

		$limit = $pluginParams->def('search_limit', 50);

		$calendarids = $pluginParams->get('calendarids', NULL);
		$pastevents = $pluginParams->get('pastevents', 1) == 1;
		$results = GCalendarDBUtil::getCalendars($calendarids);
		if(empty($results))
			return array();

		$events = array();
		foreach ($results as $result) {
			$tmp = GCalendarZendHelper::getEvents($result, null, null, $limit, $text, GCalendarZendHelper::ORDER_BY_START_TIME, $pastevents, $orderasc);
			foreach ($tmp as $event) {
				$events[] = $event;
			}
		}

		if($orderasc == GCalendarZendHelper::SORT_ORDER_ASC){
			usort($events, array("GCalendar_Entry", "compare"));
		} else {
			usort($events, array("GCalendar_Entry", "compareDesc"));
		}
		array_splice($events, $limit);

		$return = array();
		foreach($events as $event){
			$params = clone JComponentHelper::getParams('com_gcalendar');

			$title = GCalendarUtil::renderEvents(array($event), '{{#events}}{{date}} {{{title}}}{{/events}}', $params);
			$text = GCalendarUtil::renderEvents(array($event), '{{#events}}{{{description}}}{{/events}}', $params);

			$itemID = GCalendarUtil::getItemId($event->getParam('gcid'));
			if(!empty($itemID))
				$itemID = '&Itemid='.$itemID;

			$row->href = JRoute::_('index.php?option=com_gcalendar&view=event&eventID='.$event->getGCalId().'&gcid='.$event->getParam('gcid').$itemID);
			$row->title = $title;
			$row->text = $text;
			$row->section = JText::_('PLG_SEARCH_GCALENDAR_OUTPUT_CATEGORY');
			$row->category = $event->getParam('gcid');
			$row->created = $event->getStartDate()->format('U', true);
			$row->browsernav = '';
			$return[] = $row;
			$row = null;
		}
		return $return;
	}
}