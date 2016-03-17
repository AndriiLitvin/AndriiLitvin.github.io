=============
Mantra WordPress Theme
Copyright 2011-16 Cryout Creations

Author: Cryout Creations
Requires at least: 4.0
Tested up to: 4.4.2
Stable tag: 2.5.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Donate link: http://www.cryoutcreations.eu/donate/

Mantra is a do-it-yourself WordPress theme, featuring a pack of over 100 customization options and easy to use tweaks capable of tuning WordPress to your very specific needs and likes. With the help of a simple and efficient user interface you can customize everything:the layout (1,2 or 3 columns), total and partial site widths, colors (all texts, links, backgrounds etc.), fonts (over 35 font-families plus all Google Fonts), text and header sizes, post metas, post excerpts, post formats, header and background images, custom menus, 27 social media links and icons, pins, bullets and much much more. With a fully responsive layout,a customizable showcase presentation page, animated slider, magazine and blog layouts, 8 widget areas, modern graphics and an easy and intuitive admin section, you can start creating your dream site right now. 


== License ==

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see http://www.gnu.org/copyleft/gpl.html


== Third Party Resources ==

Mantra WordPress Theme bundles the following third-party resources:

Nivo Slider, Copyright Gilbert Pellegrom 
Nivo Slider is licensed under the terms of the MIT license 
Source: http://dev7studios.com/nivo-slider

FitVids, Copyright Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
FitVids is licensed under the terms of the WTFPLlicense 
Source: http://fitvidsjs.com/

TGM Plugin Activation, Copyright Thomas Griffin
Licensed under the terms of the GNU GPL v2-or-later license
Source: http://tgmpluginactivation.com/

tinyNav, Copyright Viljami Salminen
Licensed under the MIT license
Source: http://tinynav.viljamis.com/

CSS3 PIE, Copyright Sencha Inc.
Dual-licensed under Apache License 2.0 and GPLv2
Source: http://css3pie.com/

All other images bundled with the theme (used in the demo presentation page and admin section, as well as the social icons) are created by Cryout Creations and released with the theme under GPLv3 as well.


== Translations ==

Chinese (Simplified) - Lín Xuan Li
Czech - Satapouch 
Danish - IT-Fidusen
Dutch - Tim De Keyser
French - Luc Capronnier, Ikiu91
German - Thomas Baillivet, Jan Schulte
Greek - tomakrypodari
Hebrew - Ahrale
Hungarian - GeriSoft
Italian - Antonio Mercurio
Japanese - Yoshiki Osako
Norwegian (Bokmal) - kandasa
Persian (Farsi) - Sajjad
Polish - Pawe³ Przytu³a
Portuguese (Brazil) - Ivar P. Junior, Joao Lacerda
Russian - Dmitry Kiryanov
Spanish (Spain) - Raúl Antón Cuadrado, Sonia
Turkish - Emre Dalkiliç


== Changelog ==

= 2.5.0 =
* REMOVED THE THEME SETTINGS AND ADDED SUPPORT FOR THE SEPARATE THEME SETTINGS PLUGIN
* Integrated TGM to recommend and auto-install the theme settings plugin
* Removed theme SEO options as they are considered plugin territory and no longer allowed by the themes guidelines
* Fixed settings page to handle changed H3 to H2 headings in WordPress 4.4
* Added above and below content area widget areas to page templates (including custom page with intro)
* Fixed header site title to not use H1 tag when homepage is static
* Add warning in settings page when pp enabled and static page is set
* Fixed WordPress 4.4.1+ issue with plugin/theme notifications being moved in the Layout settings section
* Added version information to style/script enqueues on both frontend and dashboard (to fix caching issues between updates)
* Fixed PHP notice in settings page when theme news are not available
* Rewrote readme file and added changelog into readme

= 2.4.1.1 =
* Fixed a conflict in 2.4.1 with one of our provided child themes

= 2.4.1 =
* added our social links to the settings page
* added title-tag theme support (for WordPress 4.1)
* fixed a weird save issue affecting only some servers caused by an apostrophe in the sample in custom footer text
* fixed images issues in WooCommerce caused by a max-width styling
* reverted bullet list styling changes done in 2.4
* fixed text inside footer widgets not covered by general text options (and using styling defaults)

= 2.4 =
* removed shortcodes functionality (per WordPress Theme Guidelines)
* fixed wp.media issue
* fixed a namespace typo added in 2.3.3
* added option to enable/disable zoom for mobile devices
* added Dailymotion social icon (thanks to Jean-Louis Rosolen)
* fixed breadcrumbs not handling tag pages
* replaced get_bloginfo(‘url’) with home_url() per latest WordPress guidelines
* replaced wp_convert_bytes_to_hr() (deprecated) with size_format()
* fixed layout/image border option non-clickable on IE 11
* fixed title tag issue
* removed obsolete meta template tag
* fixed slider next/previous arrows always visible
* fixed slides count limitation when using custom posts by ID
* fixed disappearing/too small images inside tables issue on Chrome

= 2.3.4 =
* fixed the social icons (unable to disable) bug introduced in 2.3.3
* corrected the meta show/hide options not working for custom post types (pointed out by tkemmere)
* corrected content editor (html .mceContentBody) width to properly use the configured site width instead of an arbitrary number
* improved handling of empty site title and/or description (will no longer display a single dash in the browser title)
* updated French translation

= 2.3.3 =
* updated to the new WP 3.8 “fluid-layout” and “fixed-layout” tags
* 3 social icons are now enabled by default in two theme areas
* fixed import/export settings not working on some rare occasions
* hopefully fixed smileys getting huge in captions
* changed default table cell alignment to top (instead of bottom)
* fixed Google fonts to correctly handle SSL websites
* added Recaptcha, Math Captcha, Captcha compatibility styling (thanks to David B)
* corrected site title not resizing enough on the smallest mobile devices
* updated French translation
* added Czech translation

= 2.3.2 =
* re-redesigned captions (added left/right padding back)
* corrected (enlarged) social icons sizes in sidebars
* corrected presentation page columns responsiveness on larger mobile devices
* fixed incorrect pagination on custom category pages
* fixed custom css style output missing proper HTML tag
* fixed presentation page styling being displayed after the mobile style, breaking the layout
* fixed XSS vulnerability in frontend.js
* (almost) ready for WordPress 3.8

= 2.3.1 =
* added Steam social icon
* disabled auto-redirect to theme’s settings page after install (requested by WordPress)
* some cosmetic changes (multi-page pages/posts pagination, stikcy posts, post metas and author info)
* restored comments boxed styling
* fixes search form broken in 2.3.0

= 2.3.0 =
* added mobile browser detection and added a new step of responsiveness for mobile browsers
* updated the media uploader; hopefully this fixes all reported issues with the media selector for slide/column images (the new media uploader is the one introduced in WordPress 3.5 so if you’re using an older version of WordPress now would be a good time to update).
* resized social images to 26×26 pixels
* fixed an image with caption size too big issue (reported by Ferran)
* fixed image sizing issue on Chrome
* updated comments and form elements design
* updated admin interface design
* beautified jQuery warning to make it less scary and intrusive
* cleaned up some ghosts of the past
	
= 2.2.2 =
* fixed mobile menu items are reversed on right align menus (because the right align menu items needed to be arranged reversed); you’ll need to re-order your menu items if using right align after this update
* fixed new shortcodes still closed with the old shortcodes mantra tag
* fixed stray “1” in the secondary sidebar
* fixed presentation page column images wrong aspect ration on some Android devices (and hopefully did not break anything for iDevices)
* fixed notices related to empty Google fonts fields in sanitize.php under PHP 5.4

= 2.2.1 =
* added multi-column shortcode responsiveness
* added empty sidebar(s) notice(s)
* added [cryout-...] shortcodes (and we are deprecating the [mantra-...] ones, which we'll eventually remove) to prepare the switch to the upcoming shortcodes plugin
* fixed category page with intro template ignores the <more> tag
* fixed object/iframe enlarging issues
* fixed presentation page posts to use the correct excerpt length (reported by Edward & MrAwesome)
* fixed incorrect featured images size on presentation page posts (reported by Deby & Scott)
* theme auto featured images now adhere to the set featured image size
	
= 2.2.0 =
* added option to display latest posts on presentation page below the columns, with configurable post count
* added menu items alignment option
* added Amazon and Yelp social icons

= 2.1.1 =
* breadcrumbs text size increase from .8em to 1em and moved inside content
* fixed presentation page columns responsiveness
* added support for WordPress’ 3.6 new galleries
* updated jQuery warning message to be more clear on when and why it is visible
* fixed footer links to open in new windows
* fixed the (supposedly previously) fixed lists bullets positioning
	
= 2.1 =
* cosmetic update of the admin interface; sub-section settings should be easier to spot now
* updated NivoSlider (fixes a double-load of the frontpage which may increase site loading time)
* fixed the <!–more–> tag functionality on blog page template (reported by Olrik)
* added header image Keep aspect ratio option for responsiveness
* fixed Featured image as header image functionality to display the correctly sized image in the header (reported by Fulco)
* fixed mobile menu not working with automatically generated menus
* fixed mobile icon responsiveness on Safari for mobile
* fixed sticky posts padding on Magazine layout and mobile
* fixed unordered lists bullet image positioning
* top and bottom menus now only show the top level elements (sub-menus are not displayed)
* fixed small issue with the search-bar on Chrome
* improved dashboard jQuery functionality check

= 2.0.7.1 =
* fixed the issue with dropdown menus failing to work on automatically generated menus
* fixed the layout widths slider failing to work in WP 3.6
* fixed/improved mobile menu where it used to select incorrect item when the viewed page was not in the menu

= 2.0.7 =
* reverted the #content / .entry-content plugin compatibility “improvement” implemented in 2.0.4 as it was causing more issues than it solved
* fixed a couple of code typos (reported by Gary)
* improved drop down sub(-sub-sub…)menus usability by adding hoverintent and hiding delay (reported by Joel)
* fixed back-to-top button movement glitch on Firefox 17+
* fixed jQuery version checking on WP 3.6 (reported by Detlef)
* fixed admin accordion compatibility with WP 3.6

= 2.0.6 =
* fixed right sidebar padding for mobile devices
* fixed meta area height
* fixed one column layout right side spacing
* fixed top menu items being displayed in the reverse order
* fixed footer social icons sometimes being becoming partially hidden on mobile devices
* renamed “sub-header” to “headings” (according to W3C standards)
* added IMDb social icon
* improved compatibility with WordPress 3.4

= 2.0.5 =
* Fixed fonts loosing their styling in post excepts
* Added top margin for post headers and removed their text shadows
* Fixed header and footer social icons responsiveness
* Fixed right sidebar padding in responsive view
* The logo link in the header is now using home_url()

= 2.0.4.1 =
* Fixed optset(), echo_first_image() functions not being properly prefixed

= 2.0.4 =
* Added a new setting for the header: left margin to complement the existing top margin setting. You’ll find them both in the Header Settings. Now you should be able to position your logo or site tile just the way you want to.
* Fixed the content header sizes (h1-h6)
* Fixed the searchbar on 404 pages
* Added buttons linking to the Background and Header pages (under Appearance) from the Mantra settings page
* Fixed the presentation page columns animation quirk on FireFox
* Added 3 new social icons: Xing, VK and Twitch TV
* Added an edit button to the ‘category page with intro’ template
* Added custom fields catid/slug/key to ‘category page with intro’ template
* Changed ‘Mobile view’ setting name to ‘Responsiveness’ (this was such a radical change that we almost made this Mantra v3.0. Almost. )

= 2.0.3.1 =
* Fixed font-related issue introduced in 2.0.3
* Fixed special characters support in Custom JS/CSS fields

= 2.0.3 =
* fixed mailto:mailto:mailto bug for Mail social icon
* fixed favicon preview incorrectly displayed custom logo instead of icon in dashboard
* slider caption size now self adjusts in responsive mode on mobile devices
* added mobile devices touchscreen support for the main menu
* improved search box auto-resize to fit in the sidebar
* new .pot file (for translators)
* fixed blog page template had no meta description (now displays the description set in the theme for the homepage)
* separated post meta bar and meta tags control in Post Meta Settings
* implemented workaround for iSomething devices’ browser incomplete support for responsive images inside relative dimension containers
* fixed unequal content column spacing on the sidebar on each side layout
* updated shortcode buttons look and added target attribute for them (see demo page for examples)
* added support for google fonts custom styles (and broke standard fonts functionality)
* corrected paragraph alignment

= 2.0.2 =
* Added support for shortcodes inside the Presentation Page columns and extra text
* Fixed site width being 0 in some rare, x-files related occurrences
* Fixed multiple issues with the new header in IE
* Fixed caption opacity for IE
* Fixed issue where the ‘Custom logo’ option was selected for the header but no logo was uploaded and an empty image place-holder was displayed in some browsers
* Relative dimensions are now labelled as DEPRECATED. We recommend using absolute dimensions with mobile view enabled (full responsiveness)
* Fixed ‘column’ shortcode widths

= 2.0.1 =
* Fixed missing social icons in the header
* Improved woocommerce compatibility
* Further improved mobile view
* Fixed Settings page animation
* Some really minor fixes not worth listing individually

= 2.0 =
* New and improved Mantra Settings page
* Moved several settings around for better grouping
* The new Header options set: Header Height, Site Header selector (Site Title / Logo / Link / None), Custom Logo uploader, Header Top Spacing and Rounded Corners for Menu Items.
* (finally) Fixed header responsiveness
* Sanitize function is made pluggable
* Hopefully fixed some array merging which sometimes lost the Mantra options
* Improved jQuery plugins compatibility
* Improved mobile view
* Fixed social mail link
* Fixed columns shortcodes
* Fixed HTML layout on the ‘Category page with intro’ template
* Undefined amount of small bug fixes
	
Earlier changelogs are available at http://www.cryoutcreations.eu/mantra
