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
define( 'DB_NAME', 'vtech' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '~%lS,5mhSTJLpBPH9p}9q~$80Bj-a@oi+PG8H:m.jkB%Z&UIiw|3eYhMg8)j.P35' );
define( 'SECURE_AUTH_KEY',  '1Vu>t}[41+e9NB}eaXhFj>(Y8A#$ap5q3C()^mr[0JRy-:_;ZH 4mL6u$J:H~ K9' );
define( 'LOGGED_IN_KEY',    'b~VC:Po(Ku_*|]6DTP8V,[F%VOZ4`%Z-;?w[{lM8klCX`qcz #}QDg`IlErTNr,Z' );
define( 'NONCE_KEY',        '0(Fhj4{3|]`w iK`)3:07|il!Fj4LgBVyY(}/y|V1ry0q%3C{~G#B;xz;y0:ZA{e' );
define( 'AUTH_SALT',        'Mt(F`aL&(}-0.o56l8q&ovVHnVEGy6&4dN5pe}I>+C?*>C,)QWC(;,gq<fvz_>yA' );
define( 'SECURE_AUTH_SALT', '#l.ha[D,0Nha_p?x2Ch&O)*e/ag46Xefoy 5A]fNxCaadzmVUHe<}eoKqU ;e+XX' );
define( 'LOGGED_IN_SALT',   's`S9;+<En!yK+@YXyTbRiMGP/Bh9d%G/HU_wli+9$i>Yks!RU,Be89miK[B61lGf' );
define( 'NONCE_SALT',       '@,M${Z*<i3xQD0WD;x,.5k1!WqPL.SF}Q!}s_OZFMe7&BjdlfuEu4^zNL1guCb3U' );

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
