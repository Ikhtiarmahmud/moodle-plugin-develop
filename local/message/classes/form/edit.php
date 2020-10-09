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
 * Library functions for local_message
 *
 * @package   local_message
 * @copyright ikhtiar_mitul
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once("$CFG->libdir/formslib.php");
 
class edit extends moodleform {

    public function definition() {
        global $CFG;
 
        $mform = $this->_form;
 
        $mform->addElement('text', 'message_text', 'Message Text');
        $mform->setType('message_text', PARAM_NOTAGS);
        $mform->setDefault('message_text', 'Enter message text');

        $choices = [
            'NOTIFY_SUCCESS' => 'Notify Success',
            'NOTIFY_WARNING' => 'Notify Warning',
            'NOTIFY_ERROR' => 'Notify Error',
            'NOTIFY_INFO' => 'Notify Info',
        ];

        $mform->addElement('select', 'message_type', 'Message Type', $choices);
        $mform->setDefault('message_type', 'NOTIFY_INFO');

        $this->add_action_buttons();
    }

    function validation($data, $files) {
        return array();
    }
}