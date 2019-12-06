=== Post to Social Media - WordPress to Hootsuite ===
Contributors: n7studios,wpzinc
Donate link: https://www.wpzinc.com/plugins/wordpress-to-hootsuite-pro
Tags: auto publish, auto post, social media automation, social media scheduling, hootsuite, promote old posts, promote posts, promote custom posts, promote selected posts, share posts, bulk share posts, share old posts, social, media, sharing, social media, social sharing, schedule, auto post, auto publish, publish, facebook, facebook post, facebook selected posts, facebook plugin, auto facebook post, post facebook, post to facebook, twitter, twitter post, tweet post twitter selected posts, tweet selected posts twitter plugin, auto twitter post, auto tweet post post twitter, post to twitter, linkedin, linkedin post, linkedin selected posts, linkedin plugin, auto linkedin post, post linkedin, post to linkedin, google, google post, google selected posts, google plugin, auto google post, post google, post to google, pinterest, pinterest post, pinterest selected posts, pinterest plugin, auto pinterest post, post pinterest, post to pinterest, best wordpress social plugin, best wordpress social sharing plugin, best social plugin, best social sharing plugin, best facebook social plugin, best twitter social plugin, best linkedin social plugin, best pinterest social plugin, best google+ social plugin, instagram, pinterest
Requires at least: 3.6
Tested up to: 5.2.3
Requires PHP: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically share WordPress Pages, Posts or Custom Post Types to Facebook, Twitter and LinkedIn using your Hootsuite (hootsuite.com) account.

== Description ==

WordPress to Hootsuite is a plugin for WordPress that auto posts your Posts, Pages and/or Custom Post Types to your Hootsuite (hootsuite.com) account for scheduled publishing to Facebook, Twitter and LinkedIn.

Don't have a Hootsuite account?  [Sign up for free](https://hootsuite.com)

Our [API](https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/data/) connects your website to [Hootsuite](https://hootsuite.com). An account with Hootsuite is required.

> #### WordPress to Hootsuite Pro
> <a href="https://www.wpzinc.com/plugins/wordpress-to-hootsuite-pro/" rel="friend" title="WordPress to Hootsuite Pro - Publish to Facebook, Twitter, LinkedIn and Pinterest">WordPress to Hootsuite Pro</a> provides additional functionality:<br />
>
> - **Instagram and Pinterest Support**<br />Post to Instagram (Personal Profiles only) and Pinterest Boards<br />
> - **Multiple, Customisable Status Messages**<br />Each Post Type and Social Network can have multiple, unique status message and settings<br />
> - **Separate Options per Social Network**<br />Define different statuses for each Post Type and Social Network<br />
> - **Dynamic Status Tags**<br />Dynamically build status updates with data from the Post, Author, Custom Fields, The Events Calendar, WooCommerce, Yoast and All-In-One SEO Pack<br />
> - **Shortcode Support**<br />Use shortcodes in status updates<br />
> - **Schedule Statuses**<br />Each status update can be posted immediately or scheduled at a specific time<br />
> - **Full Image Control**<br />Choose to display WordPress Featured Images with your status updates<br />
> - **Conditional Publishing**<br />Only send status(es) to Hootsuite based on Post Author(s), Taxonomy Term(s) and/or Custom Field Values<br />
> - **Override Settings on Individual Posts**<br />Each Post can have its own Hootsuite settings<br />
> - **Repost Old Posts**<br />Automatically Revive Old Posts that haven't been updated in a while, choosing the number of days, weeks or years to re-share content on social media.<br />
> - **Bulk Publish Old Posts**<br />Publish evergreen WordPress content and revive old posts with the Bulk Publish option<br />
> - **The Events Calendar Plugin Support**<br />Schedule Posts to Hootsuite based on your Event's Start or End date, as well as display Event-specific details in your status updates<br />
> - **WooCommerce Support**<br />Display Product-specific details in your status updates<br />
> - **Per-Post Settings**<br />Override Settings on Individual Posts: Each Post can have its own Hootsuite settings<br />
> - **Full Image Control**<br />Choose to display the WordPress Featured Image with your status updates, or define up to 4 custom images for each Post.<br />
> - **WP-Cron and WP-CLI Compatible**<br />Optionally enable WP-Cron to send status updates via Cron, speeding up UI performance and/or choose to use WP-CLI for reposting old posts<br />
> - **Support**<br />Access to one on one email support<br />
> - **Documentation**<br />Detailed documentation on how to install and configure the plugin<br />
> - **Updates**<br />Receive one click update notifications, right within your WordPress Adminstration panel<br />
> - **Seamless Upgrade**<br />Retain all current settings when upgrading to Pro<br />
>
> [Upgrade to WordPress to Hootsuite Pro](https://www.wpzinc.com/plugins/wordpress-to-hootsuite-pro/)

[youtube https://www.youtube.com/watch?v=9QOAxJONRYM]

= Support =

We will do our best to provide support through the WordPress forums. However, please understand that this is a free plugin, 
so support will be limited. Please read this article on <a href="http://www.wpbeginner.com/beginners-guide/how-to-properly-ask-for-wordpress-support-and-get-it/">how to properly ask for WordPress support and get it</a>.

If you require one to one email support, please consider <a href="http://www.wpzinc.com/plugins/wordpress-to-hootsuite-pro" rel="friend">upgrading to the Pro version</a>.

= Data =

We connect directly to your Hootsuite (hootsuite.com) account, via their API, to:
- Fetch your social media profile names and IDs, 
- Send your WordPress Posts to one or more of your social media profiles.  The profiles and content sent will depend on the plugin settings you have configured.

We connect to our own [API](https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/data/) to pass the following requests through to Hootsuite:
- Connect our Plugin to Hootsuite, when you click the Authorize button (this obtains an access token from Hootsuite, once you have approved authorization)
- Process image uploads to the ow.ly API, which is required by Hootsuite when sharing an image as part of a social media update.

Both of these are done via our own API, to ensure that no secret data (such as oAuth client secret keys) are included in this Plugin's code or made public.

We **never** store any information on our web site or API during this process.

= WP Zinc =
We produce free and premium WordPress Plugins that supercharge your site, by increasing user engagement, boost site visitor numbers
and keep your WordPress web sites secure.

Find out more about us at <a href="https://www.wpzinc.com" title="Premium WordPress Plugins">wpzinc.com</a>

== Installation ==

1. Upload the `wp-to-hootsuite` folder to the `/wp-content/plugins/` directory
2. Active the WordPress to Hootsuite plugin through the 'Plugins' menu in WordPress
3. Configure the plugin by going to the `WordPress to Hootsuite` menu that appears in your admin menu

== Frequently Asked Questions ==

== Screenshots ==

1. Settings Screen when Plugin is first installed.
2. Settings Screen when Hootsuite is authorized.
3. Settings Screen showing available options for Posts.
4. Post-level Logging.

== Changelog ==

= 1.1.8 =
* Added: Status: Tags: Content and Excerpt Tag options with Word or Character Limits
* Added: Gutenberg: Better detection to check if Gutenberg is enabled
* Added: Gutenberg: Better detection to check if Post Content contains Gutenberg Block Markup
* Fix: Status: Removed loading of unused tags.js dependency for performance
* Fix: Status: {content} would return blank on WordPress 5.1.x or older

= 1.1.7 =
* Added: Status: Textarea will automatically expand based on the length of the status text. Fixes issues for some iOS devices where textarea scrolling would not work
* Fix: Status: {content} and {excerpt} tags always return the full content / excerpt, which can then be limited using word / character limits
* Fix: Publish: Add checks to prevent duplicate statuses being sent when a Page Builder (Elementor) fires wp_update_post multiple times when publishing
* Fix: Status: Strip additional unwanted newlines produced by Gutenberg when using {content}
* Fix: Status: Convert <br> and <br /> in Post Content to newlines when using {content}
* Fix: Status: Trim Post Content when using {content}

= 1.1.6 =
* Added: Settings: Display notice if the Hootsuite account does not have any social media profiles attached to it
* Fix: Publish: Display errors and log if authentication fails, or profiles cannot be fetched

= 1.1.5 =
* Fix: Settings: Status: Display warning if a timezone in WordPress or Hootsuite is not a valid timezone, instead of throwing a fatal error

= 1.1.4 =
* Added: Status: Secondary level tabbed UI for Profile actions (Publish, Update)
* Added: Settings: Post Type: Profile: Display warning with instructions when the WordPress Timezone and Hootsuite Profile Timezone do not match
* Added: Settings: Warning if the max_input_vars PHP setting might be too low for the Plugin's settings to successfully be saved
* Fix: Status: Documentation Tab Link

= 1.1.3 =
* Added: New Installations: Automatically enable Publish and Update Statuses on Posts
* Added: Plugin Activation: Enable Logging by default
* Added: Status: Option to limit the number of characters output on a Template Tag
* Fix: Log: Output dates according to WordPress' installation date locale formatting
* Fix: Log: Split data into more table columns for easier reading
* Fix: Status: Don't attempt publishing to any existing linked Google+ Accounts, as Google+ no longer exists.
* Fix: Publish: Improved performance when sending several statuses for a single Post.
* Fix: Publish: Display errors on Post Edit screen if status(es) failed to send to Hootsuite

= 1.1.2 =
* Fix: Menu Icon size preserved when Gravity Forms no conflict mode is set to on
* Fix: Display White Menu Icon unless the User is using WordPress' Light Admin Color Scheme, in which case display the Dark Menu Icon

= 1.1.1 =
* Fix: Publish: Removed global $post reference, which caused some installations to fetch the wrong Post to send to Hootsuite

= 1.1.0 =
* Added: Status: Featured Image: Option to choose between using OpenGraph image (clicking image links to URL) and using image, not linked to URL.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/featured-image-settings/
* Fix: Compatibility when using multiple WP Zinc Plugins
* Fix: Minified all CSS and JS for performance

= 1.0.9 =
* Fix: Multisite: Network Activation: Ensure activation routines automatically run on all existing sites
* Fix: Multisite: Network Activation: Ensure activation routines automatically run created on new sites created after Network Activation of Plugin
* Fix: Multisite: Site Activation: Ensure activation routines automatically run

= 1.0.8 =
* Added: Settings: Header UI enhancements
* Fix: Settings: Added Pinterest Board URL option for Pinterest Statuses.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/status-settings/
* Fix: Settings: Display Twitter Usernames
* Fix: Settings: Status: When using Custom Time, ensure it is at least 5 minutes after Publish, Update or Repost (required by Hootsuite's API)
* Fix: PHP warning on count() when trying to fetch an excerpt for a Post
* Fix: Settings: Only load settings for the displayed screen, for better performance
* Fix: Settings: Save settings more efficiently, for better performance

= 1.0.7 =
* Fix: Settings: Changed Authentication Tab Icon
* Fix: Settings and Status Settings: UI Enhancements for mobile compatibility
* Fix: {title} would sometimes result in HTML encoded characters on Facebook

= 1.0.6 =
* Fix: Status: Apply WordPress default filters to Post Title, Excerpt and Content. Ensures third party Plugins e.g. qtranslate can process content and remove shortcodes

= 1.0.5 =
* Added: Gutenberg: Support for Custom Field Tags when Custom Fields / Meta are registered as a meta box outside of the Gutenberg editor.
* Added: REST API: Support for Custom Field Tags when Posts are created or updated via the REST API with Custom Field / Meta data.

= 1.0.4 =
* Added: Gutenberg Support
* Added: Settings and Status Settings: UI Enhancements to allow for a larger number of connected social media profiles
* Added: Status: Tag: Post ID option
* Fix: Removed unused datepicker dependency
* Fix: CRON Scheduled Posts: Don't rely on wp_get_current_user() for User Access settings, as it's not always available
* Added: Status: Support for Shortcode processing on Status Text

= 1.0.3 =
* Fix: Publish: Ensure Post has fully saved (including all Custom Fields / ACF / Yoast data etc) before sending status to Hootsuite
* Fix: Publish: Removed duplicate do_action() call on save_post to prevent some third party plugins running routines twice
* Fix: Log: Report 'Plugin: Request Sent' and 'Created At' datetime using WordPress configured date time zone.
* Fix: Profiles: Serve social media profile images over SSL to avoid mixed content warning messages
* Fix: Settings: Changed WordPress standard .nav-tab-active class to .wpzinc-nav-tab-active, to prevent third party plugins greedily trying to control our UI.

= 1.0.2 =
* Fix: Publish: Only consider publishing statuses to Hootsuite on supported Post Types (resolves issues with Advanced Custom Fields Free Version saving Fields).

= 1.0.1 =
* Fix: Call to member function get_error_message() on null when attempting to fetch Hootsuite User Profile.

= 1.0 =
* First release.

== Upgrade Notice ==

