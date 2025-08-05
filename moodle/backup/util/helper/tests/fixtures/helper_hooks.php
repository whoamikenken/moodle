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
 * Hook definitions.
 *
 * @package core_backup
 * @copyright 2024 Monash University (https://www.monash.edu)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core_backup\fixtures\helper_hook_callbacks;
use core_backup\hook\copy_helper_process_formdata;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once(__DIR__ . '/helper_hook_callbacks.php');

$callbacks = [
    [
        'hook' => copy_helper_process_formdata::class,
        'callback' => [
            helper_hook_callbacks::class,
            'copy_helper_process_formdata',
        ],
    ],
];
