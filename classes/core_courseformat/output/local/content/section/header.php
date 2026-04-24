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
 * Contains the default section header format output class.
 *
 * @package   theme_boost_union
 * @copyright 2026 Luca Bösch <luca.boesch@bfh.ch>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_courseformat\output\local\content\section;

defined('MOODLE_INTERNAL') || die();

class header extends \core_courseformat\output\local\content\section\header {
    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param \renderer_base $output typically, the renderer that's calling this function
     * @return \stdClass|array data context for a mustache template
     */
    public function export_for_template(\renderer_base $output): \stdClass {

        throw new \moodle_exception('Theme override loaded');

        $format = $this->format;
        $section = $this->section;
        $course = $format->get_course();

        $data = (object)[
            'num' => $section->section,
            'id' => $section->id,
        ];

        $data->editing = $format->show_editor();

        if ($course->id == SITEID) {
            $data->title = $output->section_title_without_link($section, $course);
            $data->sitehome = true;
        } else {
            if (is_null($format->get_sectionid()) || $format->get_sectionid() != $section->id) {
                // All sections are displayed.
                if (!$data->editing && $section->uservisible) {
                    $data->title = "Ayeah";
                } else {
                    $data->title = "Ayeah";
                }
            } else {
                // Only one section is displayed.
                $data->displayonesection = true;
                $data->title = $output->section_title_without_link($section, $course);
            }
        }

        $coursedisplay = $format->get_course_display();
        $data->headerdisplaymultipage = ($coursedisplay == COURSE_DISPLAY_MULTIPAGE);

        if ($section->section > $format->get_last_section_number()) {
            // Stealth sections (orphaned) has special title.
            $data->title = get_string('orphanedactivitiesinsectionno', '', $section->section);
        }

        if (!$section->visible) {
            $data->ishidden = true;
        }

        if (!$data->editing && $section->uservisible) {
            $data->url = course_get_url($course, $section->section, ['navigation' => true]);
        }
        $data->name = get_section_name($course, $section);
        $data->selecttext = $format->get_format_string('selectsection', $data->name);

        if (!$format->get_sectionnum() && !$section->is_delegated()) {
            $data->sectionbulk = true;
        }

        // Delegated sections in main course page need to have h4 tag, h3 otherwise.
        $data->headinglevel = ($section->get_component_instance() && is_null($format->get_sectionid())) ? 4 : 3;

        return $data;
    }
}
