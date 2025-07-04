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
 * Theme Boost Union - Local login page
 *
 * This file is copied and modified / reduced from /login/index.php.
 *
 * @package   theme_boost_union
 * @copyright 2023 Alexander Bias <bias@alexanderbias.de>
 *            based on code 1999 onwards Martin Dougiamas
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Include config.php.
// Let codechecker ignore the next line because otherwise it would complain about a missing login check
// after requiring config.php which is really not needed.
require(__DIR__.'/../../config.php'); // phpcs:disable moodle.Files.RequireLogin.Missing

// Require the necessary libraries.
require_once($CFG->dirroot.'/lib/authlib.php');
require_once($CFG->dirroot.'/theme/boost_union/lib.php');

// Set page URL.
$PAGE->set_url('/theme/boost_union/locallogin.php');

// Set page layout.
$PAGE->set_pagelayout('login');

// Set page context.
$PAGE->set_context(context_system::instance());

// Do not allow caching of this page.
$PAGE->set_cacheable(false);

// Get theme config.
$config = get_config('theme_boost_union');

// If
// 1. the side entrance local login is not always enabled,
// 2. the side entrance local login is not in auto mode and the local login is disabled,
// 3. no alternateloginurl is set for which the side entrance local login would be needed as fallback,
// we just show a short friendly warning page and are done.
if ($config->sideentranceloginenable != THEME_BOOST_UNION_SETTING_SELECT_ALWAYS &&
        $config->loginlocalloginenable != THEME_BOOST_UNION_SETTING_SELECT_NO &&
        empty($CFG->alternateloginurl)) {
    echo $OUTPUT->header();
    $loginurl = new core\url('/login/index.php');
    $notification = new \core\output\notification(
            get_string('loginlocalloginlocalnotdisabled', 'theme_boost_union', ['url' => $loginurl]),
            \core\output\notification::NOTIFY_INFO);
    $notification->set_show_closebutton(false);
    echo $OUTPUT->render($notification);
    echo $OUTPUT->footer();
    die;
}

// If the user is already logged in and is _not_ a guest user (as guest users should be able to use the side entrale local login).
if (isloggedin() && !isguestuser()) {
    // We just redirect him to the standard login page to handle this case.
    // And, if alternateloginurl is set, add the loginredirect parameter.
    if (!empty($CFG->alternateloginurl)) {
        redirect('/login/index.php?loginredirect=0');
    } else {
        redirect('/login/index.php');
    }
}

// Set page title.
$PAGE->set_title(get_string('loginsite'));

// Start page output.
echo $OUTPUT->header();

// Prepare the local login form.
$templatecontext = [];
$templatecontext['loginurl'] = new core\url('/login/index.php');
$templatecontext['logintoken'] = \core\session\manager::get_login_token();

// Output the local login form.
echo $OUTPUT->render_from_template('theme_boost_union/localloginform', $templatecontext);

// Finish page.
echo $OUTPUT->footer();
