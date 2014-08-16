# WordPress Plugin Boilerplate [![Gitter chat](https://badges.gitter.im/seb86/WordPress-Plugin-Boilerplate.png)](https://gitter.im/seb86/WordPress-Plugin-Boilerplate)  [![Build Status](https://travis-ci.org/seb86/WordPress-Plugin-Boilerplate.svg?branch=dev)](https://travis-ci.org/seb86/WordPress-Plugin-Boilerplate)

The best WordPress plugin boilerplate you will ever need. Start developing your plugins straight away. All the basics are already covered for you. Just change the example content using the documentation provided.

> Need a better description.

## Features

* Still to be listed.

## Contents

The WordPress Plugin Boilerplate includes the following files:

* This README, a ChangeLog, and a `gitignore` file.
* A subdirectory called `wordpress-plugin-boilerplate` that represents the core plugin file.

## Installation

1. Copy the `wordpress-plugin-boilerplate` directory into your `wp-content/plugins` directory
2. Navigate to the *Plugins* dashboard page
3. Locate 'WordPress Plugin Boilerplate'
4. Click on *Activate*

> This will activate the WordPress Plugin Boilerplate and we recommend that you install it on a development site not a live site.

## Recommended Tools

### Localization Tools

The WordPress Plugin Boilerplate uses a variable to store the text domain used when internationalizing strings throughout the Boilerplate. To take advantage of this method, there are tools that are recommended for providing correct, translatable files:

* [Poedit](http://www.poedit.net/)
* [makepot](http://i18n.svn.wordpress.org/tools/trunk/)
* [i18n](https://github.com/grappler/i18n)
* [grunt-wp-i18n](https://github.com/blazersix/grunt-wp-i18n)

Any of the above tools should provide you with the proper tooling to localize the plugin.

### GitHub Updater

The WordPress Plugin Boilerplate includes native support for the [GitHub Updater](https://github.com/afragen/github-updater) which allows you to provide updates to your WordPress plugin from GitHub.

This uses a new tag in the plugin header:

>  `* GitHub Plugin URI: https://github.com/<owner>/<repo>`

Here's how to take advantage of this feature:

1. Install the [GitHub Updater](https://github.com/afragen/github-updater)
2. Replace the url of the repository for your plugin
3. Push commits to the master branch
4. Enjoy your plugin being updated in the WordPress dashboard

The current version of the GitHub Updater supports tags/branches - whichever has the highest number.

To specify a branch that you would like to use for updating, just add a `GitHub Branch:` header. GitHub Updater will preferentially use a tag over a branch having the same or lesser version number. If the version number of the specified branch is greater then the update will pull from the branch and not from the tag.

The default state is either `GitHub Branch: master` or nothing at all. They are equivalent.

All that info is in [the project](https://github.com/afragen/github-updater).

## Documentation

> Documentation will be provided via the GitHub wiki pages.

## License

The WordPress Plugin Boilerplate is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

> You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

## Important Notes

### Licensing

The WordPress Plugin Boilerplate is licensed under the GPL v2 or later; however, if you opt to use third-party code that is not compatible with v2, then you may need to switch to using code that is GPL v3 compatible.

For reference, [here's a discussion](http://make.wordpress.org/themes/2013/03/04/licensing-note-apache-and-gpl/) that covers the Apache 2.0 License used by [Bootstrap](http://twitter.github.io/bootstrap/).
