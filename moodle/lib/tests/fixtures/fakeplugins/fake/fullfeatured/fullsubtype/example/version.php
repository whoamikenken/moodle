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
 * fakeplugins/access/subtype
 * fake -> fake_access
 *              -> accesssubtype -> accesssubtype_example
 *
 * mod/lti/service/
 * mod -> mod_lti
 *              -> ltiservice -> ltiservice_name
 *
 * Fake subplugin 'fullsubtype_example' residing under the 'fake_fullfeatured' mock plugin.
 *
 * @package    core
 * @copyright  2024 Jake Dallimore <jrhdallimore@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2022050200;
$plugin->requires  = 2022041200;
$plugin->component = 'fullsubtype_example';
