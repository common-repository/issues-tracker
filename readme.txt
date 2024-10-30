=== Issues Tracker ===

Contributors: lysyiweb
Tags: debug, logging, WP_DEBUG, security, error-tracking
Requires at least: 4.6
Tested up to: 6.6.2
Stable tag: 1.15
Requires PHP: 5.4
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Tested up to ==
WordPress Version: 6.6.2
PHP Version: 8.2.0

Issues Tracker helps monitor WordPress logs, track 404 errors, view server settings, and receive security advice

== Description ==
Issues Tracker allows you view and search WordPress logs, receive security advice, track 404 errors, and view your server settings.

We've designed the Issues Tracker plugin with accessibility and simplicity in mind. Say goodbye to the hassle of reading and searching through the debug.log file on your server. With the Issues Tracker, you can access and search logs directly within your CMS, making them easily readable and searchable.

Additionally, our plugin provides email notifications for various error events and covers more issues than a typical WP health checker.

Enhance your website's security and performance with these key features:

**Debug Log Viewer**
Effortlessly view notices, warnings, and errors from the WordPress debug.log file in a user-friendly table format. Utilize advanced search options (by error type, line, and file) and pagination for quick and convenient log management.

**WordPress 404 Errors**
Identify and list all 404 (page not found) errors on your website, and configure email notifications for these events. For example, receive email alerts for every 404 event.

**Advisor**
Receive expert recommendations on server and site settings to boost your website's speed and security. Get notified via email if your server's condition deteriorates.

**Server info**
Keep track of all your server settings in one centralized location. Issues Tracker automatically parses the `phpinfo()` output, providing you with comprehensive server information. No need to dig into the server configuration files manually - everything is neatly displayed for you.

**Website Checks**
Our plugin evaluates your website based on various criteria, including:
- Checking if the database username used in wp-config.php is widely used.
- Verifying the security of the database password in wp-config.php.
- Examining the state of the WP_DEBUG_DISPLAY constant.
- Ensuring you are not using the default database prefix.
- Verifying SSL (https) encryption status.
- Checking the PHP version for updates.
- Confirming that the WordPress version matches the HTML code.
- Checking if search engines allowed to index a website

...and many more checks in future releases.

**Dashboard**
Monitor all your website's performance and security issues conveniently from one central location. Access log file entries, server checks, and 404 error reports in a single dashboard.

== Pro Features ==
* Receive Email notifications when the Advisor module detects security issues
* Get Email notifications in case of 404 request hourly or once per day
* Get Email notifications with new entries in the debug.log to keep you inform about problems on the site
* Enjoy priority email support

== Installation ==

### How to activate withing Wordpress

1. Go to 'Plugins > Add New'
2. Search for Issues tracker
3. Click install then activate

### How to activate manually

1. Upload the plugin files to the /wp-content/plugins/ directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" page in Dashboard


== Screenshots ==
1. **Dashboard** get access to all features in one place.
2. **Debug Log Viewer** allows a convenient way to browse the debug.log file.
3. **404 catcher** shows you all the 404s on your website.
4. **Advisor** extends WordPress health checker to improve website security.
4. **Server info** Your php.ini in convenient view 

== Use cases ==
* *Debugging WordPress Sites:* Developers can use the plugin to identify, track, and resolve bugs in WordPress themes or plugins. This is crucial for maintaining site performance, security, and overall functionality.
* *Monitoring Website Health:* Website administrators and webmasters can see advice and hints how to improve performance and stability of their website. This proactive monitoring helps in maintaining a smooth and efficient operation of the website, ensuring a better user experience.
* *Real-Time 404 Error Detection:* When a visitor encounters a 404 error (page not found) on your website, whether due to a broken link in a post, page, or image, the "Issues Tracker" plugin immediately captures this URL. It presents these 404 URLs in an organized table, allowing for swift review and rechecking with just one click. For Pro plan users, the plugin offers additional convenience by sending instant email notifications whenever a new 404 error is detected, ensuring you're always up-to-date and can address these issues promptly to maintain a smooth user experience on your site.

== FAQ ==

**How do I debug a WordPress website?**
To debug a WordPress website, follow these steps:
* Enable needed switchers in header of Issues Tracker plugin.
* The server will log errors into the `wp-content/debug.log` file. You can search this log file directly on the server or within your CMS using the Issues Tracker plugin.
* Keep in mind that after enabling debug mode, your website's behavior may change, and errors may be displayed to users or administrators.

For more detailed information, refer to the [official WP debug guide](https://wordpress.org/support/article/debugging-in-wordpress/).

**Why is the debug.log important?**
The `debug.log` is a crucial component of the WordPress system for debugging code, encompassing core, plugins, and themes. It plays a vital role in ensuring code quality and the smooth operation of your website.

You should aim to maintain an empty `debug.log` file, free from notices, warnings, or critical errors. If a new line appears in the `debug.log`, take prompt action to resolve the underlying code issue to provide the highest quality user experience for your website visitors.

**What should I do with 404 errors on WordPress?**
In WordPress, a 404 page is displayed when a requested page is not available, often accompanied by the message "Page Not Found." These 404 errors indicate a need for improving the user experience. Numerous errors of this kind can deter users from your website and negatively impact search engine optimization.

Search engine crawlers do not index 404 pages, which can lead to a decrease in your website's search result rankings. It's essential to address and resolve 404 errors to enhance your website's usability and SEO performance.

**What are the common WordPress issues that can be tracked in the debug.log file?**
The `debug.log` file serves as the default issues tracking log for WordPress. It provides valuable insights into various plugin errors. While some of these errors may not be critical immediately, they can lead to severe issues, such as the "White Screen of Death," in the future.

Additionally, you can use the `debug.log` file to track errors in the code of the active theme. Regularly monitoring and addressing these issues is essential for maintaining the stability and functionality of your WordPress website.

== Changelog ==

= 1.15 =
* General: Updated Freemius SDK and WP-CLI
* General: Fixed a bug where the wp-config.php file could not be used if it was located outside the root directory

= 1.14 =
* General: Updated Freemius SDK
* General: Fixed jumping menu on hover
* Log view: Improved UI for the case if no debug.log file found
* Log view: Improved text for the first demo logger record

= 1.13 =
* General: Updated Freemius SDK
* 404: Implemented suspension of logging 404 errors in the event of an attack. The primary objective is to prevent mass database inserts. If more than 10 records for hour are inserted, the component suspends tracking for one hour before automatically resuming its operations.

= 1.12 =
* General: Updated Freemius SDK
* General: Checked compatibility with 6.5.2

= 1.11 =
* General: Fixed bug with review dialog

= 1.10 =
* Log view: Added Live Updates for Pro plan users
* Log view: Added column visibility checkboxes
* 404: Added column visibility checkboxes
* 404: Added export buttons for .csv and .xlsx
* 404: Added print button
* General: Added check nonce() for security reasons

= 1.9.1 =
* 404: Added User Agent support
* General: Updated Freemius SDK

= 1.9 =
* 404: Added column with country name and flag of visitor
* General: UI improvenments
* General: Added checkbox in notifications section to send test Email

= 1.8 =
* General: Improved design

= 1.5 = 
* Log view: Added notifications about database, fatal, deprecated and parse errors
* Log view: Added support of deprecation error
* Advisor: Added check if site indexing is allowed for non-localhost Installations
* General: Fixed but when the notification email sends just after enabling notifications
* General: Bug fixes, styles amproenments

= 1.4 =
* Log view: Improved library for setting up constants in wp-config.php
* Log view: Added stack trace output
* 404: Added periodicity for Email notifications
* 404: Fixed bug with removing URL without slash at the begining
* Advisor: Added periodicity for Email notifications

= 1.3 =
* Server info: Added a new module
* General: Improved UX
* General: Improved texts
* General: Added links to Contact Us and Support Forum
* Log view: Added ability to  clear, download and reload log

= 1.2.3 =
* General: checked compatibility with WordPress 6.3.1
* General: Updated Freemius SDK; Reduced plugin size
* General: Fixed bug with the Pro version of the plugin
* General: Added links to  support form and  forum

= 1.2.2 =
* General: checked compatibility with WordPress 6.1.1

= 1.2.1 =
* Log viewer: Added switchers for changing debug constants values

= 1.2 =
* Advisor: Added free disk space check (beta)
* Advisor: Applied template for Emails
* Dashboard: Fixed wrong checks count

= 1.1 =
* Advisor: Fixed wrong name of checks
* Advisor: Added progress-bar
* 404: Added recheck URL functionality
* 404: Added remove URL functionality

= 1.0.8 =
* General: Updated Freemius SDK
* General: Tested with Wordpress 5.9.2

= 1.0.7 =
* Log viewer: added support of logs with overrided path in WP_DEBUG_LOG('path/to/log.txt');
* General: added ability to translate an interface of the plugin

= 1.0.6 =
* 404: Fixed "loading" when no data presented in the table
* Advisor: minor fixes

= 1.0.5 =
* Advisor: Added daily checks and notifications about security issues
* General: Fixed typos

= 1.0.4 =
* Improved design (UI)
* Added 404 catcher with notifications (Pro plan only)
* Improved performance
* Bugs fixes

= 1.0.3 =
* Dashboard: a little changed UI
* Log viewer: increased debug.log limit from 20 to 100Mb
* General: added Freemius
* General: changed logo

= 1.0.2 =
* Log viewer: Fixed row direction (from newest to oldest)
* Advisor: Added check is Wordpress version is showed in HTML code of a site
* Advisor: Added check is WP_DEBUG_DISPLAY is enabled

= 1.0.1 =
* Fixed typos
* Added message in case is debug.log is not found

= 1.0.0 =
* Initial release

