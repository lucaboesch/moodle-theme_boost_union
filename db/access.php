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
 * Theme Boost Union - Capability definitions.
 *
 * @package    theme_boost_union
 * @copyright  2022 Moodle an Hochschulen e.V. <kontakt@moodle-an-hochschulen.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$capabilities = array(

    // Ability to configure the theme as non-admin.
        'theme/boost_union:configure' => array(
                'captype' => 'write',
                'contextlevel' => CONTEXT_SYSTEM,
                'riskbitmask' => RISK_XSS | RISK_CONFIG
        ),
    // Ability to see a hint for unrestricted self enrolment in a visible course.
        'theme/boost_union:viewhintcourseselfenrol' => array(
                'captype' => 'read',
                'contextlevel' => CONTEXT_COURSE,
                'archetypes' => array(
                        'teacher' => CAP_ALLOW,
                        'editingteacher' => CAP_ALLOW,
                        'manager' => CAP_ALLOW )
        ),
    // Ability to see a hint in a hidden course.
        'theme/boost_union:viewhintinhiddencourse' => array(
                'captype' => 'read',
                'contextlevel' => CONTEXT_COURSE,
                'archetypes' => array(
                        'teacher' => CAP_ALLOW,
                        'editingteacher' => CAP_ALLOW,
                        'manager' => CAP_ALLOW
                )
        )
);