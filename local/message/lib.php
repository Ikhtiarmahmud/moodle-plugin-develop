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


 function local_message_before_footer() {

   global $DB, $USER;

   $sql = "SELECT lm.id, lm.message_text, lm.message_type 
           FROM {local_message} lm 
           left outer join {local_message_read} lmr 
           ON lm.id = lmr.local_message_id 
           WHERE lmr.user_id <> :user_id OR lmr.user_id IS NULL";

   $params = [
      'user_id' => $USER->id,
   ];

   $messages = $DB->get_records_sql($sql, $params);

   $choices = [
      'NOTIFY_SUCCESS' => \core\output\notification::NOTIFY_SUCCESS,
      'NOTIFY_WARNING' => \core\output\notification::NOTIFY_WARNING,
      'NOTIFY_ERROR'   => \core\output\notification::NOTIFY_ERROR,
      'NOTIFY_INFO'    => \core\output\notification::NOTIFY_INFO,
   ];


   foreach($messages as $message) {

      $notify = $choices[$message->message_type];
      
      \core\notification::add($message->message_text, $notify);

      $readRecord = new stdClass();
      $readRecord->local_message_id = $message->id;
      $readRecord->user_id = $USER->id;
      $readRecord->timeread = time();

      $DB->insert_record('local_message_read', $readRecord);
   }

 }