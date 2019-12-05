<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'krestina_dk_db');

/** MySQL database username */
define('DB_USER', 'krestina_dk');

/** MySQL database password */
define('DB_PASSWORD', 'ninus2303');

/** MySQL hostname */
define('DB_HOST', 'mysql7.unoeuro.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '5HbZ#lVkC0JHdwcBQRKW4F3Z^NS&3@9(n%Q09M(k1RYnoa3l&1v4A5cz^o8*8sSC');
define('SECURE_AUTH_KEY',  'wmj5%es9#9a@Z3Glks7BHxc@DW3(23RQvr1BVnkRQlvhLNwYnra4GDJ!mP6N)tIQ');
define('LOGGED_IN_KEY',    '#UkaG^Y@kCkKQnUMMEwXf5Dq7r5ZODNN2McvK!eKqFMZcDedPaqRYu@nm6wVVTb#');
define('NONCE_KEY',        'HLBlRv!sPiP!!ZKtTDZLv&psOlE@QCewy7jomEsl^((TQxu!MAfvEL0yjTD%yVmO');
define('AUTH_SALT',        ')6NGi4V26B21d^dIs7iKKZs^(0r2RH@Hbp(tRAlSmn^Z&HcQp5hVU1I*b9C^)aUg');
define('SECURE_AUTH_SALT', 'P6yOzwpf2Zrd1Dw3A8t8@zBOueLpBdWowsDI0y#Rf8T*8Km@X@q4yR5jGVCV1h@F');
define('LOGGED_IN_SALT',   'lyQBlzRr(w4Yl^2^PfhVAC3fqDI9m!^8KpX%h*b&381a8TGIWRSBKkMw%awiBRlr');
define('NONCE_SALT',       '4GNgS!441t2pEYJboWgn8Adwkm98!4!OiPPZEvV7CDZ9QcTPIdZP1r(58CrEd5c9');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'clk_246d647e2c_wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* UnoEuro change */
define('WP_MEMORY_LIMIT', ini_get('memory_limit'));

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define( 'WP_ALLOW_MULTISITE', true );

define ('FS_METHOD', 'direct');
