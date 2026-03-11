<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'wRKS3wDnBvL;@l-f%;#!&wF*Va?{3&1A9[]FEMq@n]Qq.Ac>O5pDt}:0^8/ng[;9' );
define( 'SECURE_AUTH_KEY',  'Yoi;[-#/j#KEo?^ozk_c];&V5r(%zprq~{o@d+Xyl&ywRH:S]uZ^B<:yr(wb)N|-' );
define( 'LOGGED_IN_KEY',    'e`jKQ~lP| jxRy`^j7fwLRxg2Ku^b^8O=U(UIPZ2I&Yr9<a0Ox$LZ;nrYT&Wsgh~' );
define( 'NONCE_KEY',        'Tt>XnU^5!Axj)*X#{5nvJWbTsH8Jh{pEUZ4UC^^ep{u;]9FF~taX04aNXt>$t<(I' );
define( 'AUTH_SALT',        ',>2cSrl*y.B?FK2)+[hk#fOqzjYizl?kQ>O3cH.ZX~+DRbbAXf[U97lB5ZB5e DR' );
define( 'SECURE_AUTH_SALT', '.BE8KlWh0#YRDC!/&_!L^Ee%]ivOx|aR1rTD4>h6Wu(43JFnGX*UZc?3;vt$Q ew' );
define( 'LOGGED_IN_SALT',   '=*YRaEIwA@u@hJK`}I|E[IZVLToh={I#XzS?I7V15Vob@9V74iC!|VQnyHIzM.HM' );
define( 'NONCE_SALT',       '-Uyt@#+?n%aR90Vmcwk~uY*rdp4fRQingj5)#TkM8C0X7RaJ$xUyJ{/tAv@n~>:$' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
