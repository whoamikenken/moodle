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
 * Hook listener callbacks for the Ollama Provider.
 *
 * @package    aiprovider_ollama
 * @copyright  2025 Huong Nguyen <huongnv13@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$callbacks = [
    [
        'hook' => \core_ai\hook\after_ai_provider_form_hook::class,
        'callback' => \aiprovider_ollama\hook_listener::class . '::set_form_definition_for_aiprovider_ollama',
    ],
    [
        'hook' => \core_ai\hook\after_ai_action_settings_form_hook::class,
        'callback' => \aiprovider_ollama\hook_listener::class . '::set_model_form_definition_for_aiprovider_ollama',
    ],
];
