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

JLoader::import('components.com_gcalendar.libraries.GCalendar.view', JPATH_ADMINISTRATOR);

class GCalendarViewImport extends GCalendarView {

	protected $onlineItems = null;
	protected $dbItems = null;

	protected function addToolbar() {
		if (strpos($this->getLayout(), 'login') === false) {
			$canDo = GCalendarUtil::getActions();
			if ($canDo->get('core.create')){
				JToolBarHelper::custom('import.save', 'new.png', 'new.png', 'COM_GCALENDAR_VIEW_IMPORT_BUTTON_ADD', false);
			}
			JToolBarHelper::cancel('gcalendar.cancel', 'JTOOLBAR_CANCEL');
		}

		JRequest::setVar('hidemainmenu', 0);

		parent::addToolbar();
	}

	protected function init() {
		if (strpos($this->getLayout(), 'login') === false) {
			$this->onlineItems = $this->get('OnlineData');
			$this->dbItems = $this->get('DBData');
		}
	}
}