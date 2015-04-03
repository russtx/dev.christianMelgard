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
define('WP_MEMORY_LIMIT', '64M');
define( 'DB_NAME', 'christia_db2' );

/** MySQL database username */
define( 'DB_USER', 'christia_russ170' );

/** MySQL database password */
define( 'DB_PASSWORD', '$7w!O!xh&)S6' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('FTP_HOST', 'christianmelgard.com');
define('FTP_USER', 'melgard');
define('FTP_PASS', '1zVtus2W');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '%o0syoj@9{}qnZ/kKq{nIXGPNFG||ezUc/v`!;G%aDN&/MF_VzOx3jRum`c6Am8y');
define('SECURE_AUTH_KEY',  '(U?zm/&X q+j$k*@d%z=otBM,$4M|)!{HSv+]o.k)sq|s[g6?+pTYe>x%{C~-t%{');
define('LOGGED_IN_KEY',    '_u=YL^*8mL,4e8QT+W-I5}u_T>n*mCm+z_xrwe8.b&;ltI=ft/;Z*%kvt2!>p%mv');
define('NONCE_KEY',        'J`.By{$N]5H$X0c5PpZ:WL)xi(2C_sF>WEw7XyuElJlDmmNqV|)`,TgCV4*:$j!N');
define('AUTH_SALT',        '4+/axhMvoJl|=,-}.XJ/<&tNSSRjoI1GVnx<7.FtRE-o+V_<zfHGlH-)_C(@SSJ-');
define('SECURE_AUTH_SALT', '-;?vuo`H-U(&5c7rN>Yaihl[]y&+Lq(P(Pr6k(~i;92gAvSZ,L$L}hX;vSNW_!xQ');
define('LOGGED_IN_SALT',   '[z![LUh_?{XCL.#_,2L^Hp#?8Y)1je.,9^rSB|`hk-X08/=KGCH(S|cy(Zx4(WI%');
define('NONCE_SALT',       'boT51yc$ oa>]r]h%1Lj|S.s)A+)+|9<;`DJw->u=_5_1zKxUS# L|_q!|675)po');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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

