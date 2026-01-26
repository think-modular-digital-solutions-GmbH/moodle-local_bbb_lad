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
 * Contains class for the helper functions to show the LAD table.
 *
 * @package    local_bbb_lad
 * @copyright  2026, think modular
 * @author     think modular (stefan.weber@think-modular.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_bbb_lad;

/**
 * Class for the helper functions to show the LAD table.
 *
 * @package    local_bbb_lad
 * @copyright  2026, think modular
 * @author     think modular (stefan.weber@think-modular.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class table {
    /**
     * Format username.
     *
     * @param array $attendee
     * @return string formatted username
     */
    public static function userlink($attendee) {

        global $OUTPUT;

        // Print user link.
        $userid = $attendee['ext_user_id'];
        $user = \core_user::get_user($userid);
        $username = fullname($user);
        $url = new \moodle_url('/user/profile.php', ['id' => $userid]);
        $html = \html_writer::link($url, $username);

        // Prepare join/leave info.
        $types = [
            'joins' => 'fa fa-sign-in',
            'leaves' => 'fa fa-sign-out',
        ];
        $joinleaves = [];
        foreach ($types as $key => $icon) {
            foreach ($attendee[$key] as $entry) {
                $timestamp = strtotime($entry);
                $date = userdate($timestamp);
                $joinleaves[$timestamp] = [
                    'key' => $key,
                    'icon' => $icon,
                    'date' => $date,
                ];
            }
        }
        ksort($joinleaves);

        // Append join/leave info to link.
        foreach ($joinleaves as $jl) {
            $icon = \html_writer::tag(
                'i',
                '',
                [
                    'class' => $jl['icon'] . ' me-1',
                    'aria-hidden' => 'true',
                    'role' => 'img',
                    'title' => get_string($jl['key'], 'local_bbb_lad'),
                ]
            );
            $text = $jl['date'];
            $html .= \html_writer::tag('small', $icon . $text, ['class' => 'd-block']);
        }

        return $html;
    }

    /**
     * Lists an array of dates.
     *
     * @param array $dates
     * @return string formatted datelist
     */
    public static function list_dates($dates) {
        $formatteddates = [];
        foreach ($dates as $date) {
            $timestamp = strtotime($date);
            $formatteddates[] = userdate($timestamp);
        }
        return implode(', ', $formatteddates);
    }

    /**
     * Formats time, but returns empty string for 0.
     *
     * @param int $timeinseconds
     * @return string formatted time or empty string
     */
    public static function format_time($timeinseconds) {
        if ($timeinseconds == 0) {
            return get_string('none');
        }
        return format_time($timeinseconds);
    }
}
