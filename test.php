<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Callback URL for the local_bbb_lap plugin.
 *
 * @package    local_bbb_lad
 * @copyright  2026, think modular
 * @author     think modular (stefan.weber@think-modular.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

defined('MOODLE_INTERNAL') || die();

global $DB;

$records = $DB->get_records('local_bbb_lad');
foreach ($records as $record) {
    if ($record->data === null) {
        continue;
    }
    echo "<strong>" . userdate($record->timestamp) . "@ instance $record->bigbluebuttonbn</strong><br>";
    $data = $record->data;
    echo "<pre>";
    echo print_r($data) . "<br><br>";
    echo "</pre>";
}