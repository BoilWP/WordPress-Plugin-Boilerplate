## 1.0.2 (9th March 2015)

* Tested on WordPress 4 and up.
* Corrected spelling errors within the whole of the boilerplate and README.md file.
* Corrected sub page links for the admin plugin page.
* Corrected Non-static method used on the plugin page, System Status and Tools pages.
* Corrected log directory location in the System Status.
* Improved the use of PHPDoc conventions to document the code.
* Improved @todo through out the boilerplate.
* Improved the System Report page.
* Added the name of the plugin before the navigation tabs.
* Added new function to create files and directories upon plugin activation.
* Added a new filter for the status tabs in the System Report page.
* Added a new action hook for 3rd parties so they can display their own debug information at the bottom.
* Added a new action hook for easy insertion of your own system restart functions.
* Added two new areas on the settings page. The top and bottom of the settings page can display anything you want for a single tab and section.
* Added a new feature column layout on the welcome page.
* Added a thank you message in the footer to allow users to rate and review the plugin on WordPress.org. This includes a new variable that only needs the plugin slug replaced.
* Added link to translate plugin in the right side footer of the admin pages.
* Changed the function name 'remove_roles' to 'remove_user_roles'.
* Removed incorrect file of 'activation.css' from folder 'assets/css/admin'
* Removed 'Author Email', 'Requires at least' and 'Tested up to' from the plugin header as they are not read by WordPress. These are mainly for the Readme.txt file.
* Moved the global $wpdb to the top of the uninstall.php file so both single and multisites can query the database.
* Removed the `countries` class and variables. - Can be added by following the documentation.
* Removed variable $theme_author_url. - Needs to be put back in. This was a mistake.
* Removed variable $changelog_url. - Needs to be put back in. This was a mistake.
* Removed 'after_setup_theme' action and setup_enviroment() function. - Can be added by following the documentation.
* Removed function set_admin_menu_separator(). This is no longer supported.
* Removed support for older versions of WordPress lower than version 3.8
* Removed .icon32 support on all plugin pages and the h2 icons from the assets.
* Updated welcome page badge to introduce the logo for BoilWP.com

## 1.0.1 (25th August 2014)

* Grunt Setup
* Text Domain corrections
* Admin javascript minified
* README.md file updated

## 1.0.0 (25th August 2014)

* Initial Release
