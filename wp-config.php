<?php
define( 'WP_CACHE', true );
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
define( 'DB_NAME', 'magiaalb_magicalbeehive' );

/** MySQL database username */
define( 'DB_USER', 'magiaalb_admin' );

/** MySQL database password */
define( 'DB_PASSWORD', '5eqMhdC5Y4%Hf&c^' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '<zwDv<Kc1$.2lE:Le>KeqbHrQ)h>Gnj6`J9]ZuiqgWtl>TdZE7^_^+CZ`d e&{+!');
define('SECURE_AUTH_KEY',  'G%Y)ByY#!S?Hfyl&nd+S$Is:}-hGk|3|HXo>&-mN~`,Q:/LmEV<@YKZ+P:2m%q?Q');
define('LOGGED_IN_KEY',    ')z_i}|5q!u3)^`cJ)Q_JQe2t1+]_:aE;|3o^Lxpjt*8fU.T;&BKak|wE-H[J-l&1');
define('NONCE_KEY',        'Tp6X|]ba6 X.9wSU)@gKcpg[mln@: |:>`sqTDU0T)jT?Xj}J[mNyIa]@)n.J}x(');
define('AUTH_SALT',        'E+p>m!|Yxw^V}Qe |EFrsY]+fh;:93dl VGy!`*=:a)W8G^%+-mh,-1os<NM3WA6');
define('SECURE_AUTH_SALT', 'QW7ddT,l5[dyZdoxU~xSn)MqJyTg8,*W{$0MtiL%@TF B `GVB%@$4Pjra9=A8aB');
define('LOGGED_IN_SALT',   'A+r;z)LN@|{C%h3e.^~0-F>;MlNxXan^j8MU(Dx=V7E99AHC;-~]en{eCJutr56_');
define('NONCE_SALT',       '{{ m-YuK9+Z/R]1>]49:~0}1RFM$d.-R |2XR8|X4xl~pS:<flJl.J-#cuW2RM0O');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

define('WP_HOME','https://www.magiaalbinelor.com');
define('WP_SITEURL','https://www.magiaalbinelor.com');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
