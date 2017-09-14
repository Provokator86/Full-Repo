<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'mydealfo_deal');

/** MySQL database username */
define('DB_USER', 'mydealfo_deal');

/** MySQL database password */
define('DB_PASSWORD', '#acumen');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'CVj4/CL.vENTh]~eZ0^YXIX>Ink+/{VfD?-u|>!:<mg!|f={XOm:I$=RPp;qM/+Q');
define('SECURE_AUTH_KEY',  '82RI|%70O<ue9VrlYy/=kM)n^dOp<=&7Ir!2JMM|A`?q8_Y?YDs`u#dN!Lv~zo?q');
define('LOGGED_IN_KEY',    '|QCGAz5jq5Vw)S7ceL=U9&rSwDAQ]o==o;)r_JDQYrdpSv|oZ]I+/mB|xp47aG[S');
define('NONCE_KEY',        '?D2;yWVDcjllX!>ST;_Bkn=kyNJdRz0co4F^3QwuvV%j`-qe:SU+KE=%cGd/C(P|');
define('AUTH_SALT',        'f{uKg @xDeQg|WP3)uY4`<z!0r9kS+jn=Qp!&&}x*IQ<~7Lyq6Kkc?8-ajnP!x4[');
define('SECURE_AUTH_SALT', '+T4,BP:>CM)(=x`-$y>Y/U63|oH/_wH:(k$a-kFr;nd}f-(W|SV >AvMP4Q3s_wt');
define('LOGGED_IN_SALT',   'j{C~CrWoX}TMYa3qPqw/AUV#,yw{R:zmKI5=kEz,EY?i^|_POk_i=+87Lg4G*uQ%');
define('NONCE_SALT',       '-rVmT@`Ms-wYP#*qvLQB=]SVMT4.@^;B)#g/*m9*A,;oSOI/]($M=b;$oHPsmj!q');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');