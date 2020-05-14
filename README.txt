=== Simply Strata ===
Contributors: JavaHat Solutions
Requires at least: WordPress 4.7
Version: 1.0

License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: one-column, two-columns, right-sidebar, left-sidebar, no-sidebar, accessibility-ready, custom-background, custom-colors, custom-header, custom-menu, editor-style, flexible-header, threaded-comments, translation-ready

== Description ==

Simply Strata is the perfect solution for Building Strata Councils to share information with residents. Rather than a blogging site, the focus is on sharing documents. Our goal is to only provide the necessary features. We have replaced 'blog posts' with 'document posts' for an easier interface. This theme features a widgetized area in the header to display important updates, as well as a background image, logo, and navigation.  Personalize this theme with a custom color scheme and organize your documents throughout the site based on document type. Our theme is designed for any abilities, any device and also works great in many languages.

The theme includes the following template files:
- index.php: default page with sidebar on the right
- page-sidebar-left.php
- page-no-sidebar.php
  - header.php
  - content.php: loop for page content
  - content-home.php
    - post-page-documents.php: documents assigned to a page
    - post-minutes.php: all meeting minutes organized by year
    - post-notices.php: important notices within the past month
    - post-documents.php: archive of all documents other than minutes
  - sidebar.php
  - footer.php
- functions.php
  - admin.php: functions for admin use
  - back-compat.php
  - breadcrumbs.php
  - customizer.php
  - pages.php: adds core documents to template
  - shortcodes.php
  - widgets.php

Widget Areas
There are two widget areas:
- one in the header
- one in the sidebar

For more information about Simply Strata please go to https://simply-strata.templatedesign.ca/.

== Recommended Plugins ==

Advanced Custom Fields By Elliot Condon
Description: Add custom fields for document posts
Source: https://wordpress.org/plugins/advanced-custom-fields/

Profile Builder By Cozmoslabs, Madalin Ungureanu, Antohe Cristian, Barina Gabriel, Mihai Iova 
Description: Login, registration and add/modify profile roles
Source: https://wordpress.org/plugins/profile-builder/

Ninja Forms by By The WP Ninjas
Description: A webform builder with unparalleled ease of use and features.
Source: https://wordpress.org/plugins/ninja-forms/




Simply Strata Theme, Copyright 2018 JavaHat.com


== Copyright ==

Simply Strata Theme, Copyright 2018 JavaHat.com
Simply Strata is distributed under the terms of the GNU GPL

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

Simply Strata bundles the following third-party resources:

HTML5 Shiv, Copyright 2014 Alexander Farkas
Licenses: MIT/GPL2
Source: https://github.com/aFarkas/html5shiv

jQuery skip-link-focus-fix.js, Copyright 2013 by Nicholas C. Zakas
Source: http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/

Font Awesome icons, Copyright Dave Gandy
License: SIL Open Font License, version 1.1.
Source: http://fontawesome.io/


== Changelog ==

= 1.2 =
* Update: May 1, 2020
*Added support for Council Only documents - National
*Updated order of documents - All sites
  * post-page-documents.php
  * single.php
  * post-documents.php
  * content.php
  * post-council-documents.php

= 1.0 =
* Released: February 7, 2018

Initial release
