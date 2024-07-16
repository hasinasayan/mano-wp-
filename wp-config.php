<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "mano" );

/** Database username */
define( 'DB_USER', "root" );

/** Database password */
define( 'DB_PASSWORD', "" );

/** Database hostname */
define( 'DB_HOST', "localhost" );

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
define( 'AUTH_KEY',         't96pspldbmnlqo08m7bguu4yxyumxwsgx26ylrspodktyb0qwpxu15ddhbrco626' );
define( 'SECURE_AUTH_KEY',  'pmdtxv065fscfdybhznrwsb5gddcyvzhrbs86lblkmzlzr66zfkznuisbd9zrsgo' );
define( 'LOGGED_IN_KEY',    'clm9qkzqwdub2nljps9cjpfi3n2rqupf2y9xxjtldws42yaxyrgbxsjqzwzqgte3' );
define( 'NONCE_KEY',        'yknofah7idh43iude5ma252nzxotkn8fl2clhvyrekvrposryo2xz8ln3qw8iznm' );
define( 'AUTH_SALT',        'n8odusexirzkwhazfkvtzomw07clpg0ntnxdiu5izwgjqhg4kyngukgoefkqhvwt' );
define( 'SECURE_AUTH_SALT', '16pulids2piky87aqfkogb4zfdbexoxhvoqe7qlas92zg8p6ngzwc4mzswm2ezjk' );
define( 'LOGGED_IN_SALT',   'twiaf5j49enpn9w12fitmrhfoxsnlukgrc3pd6hyshxq8ijg2hr8mezfenjucaqk' );
define( 'NONCE_SALT',       '1nxlw5yd6zm3abksl4mwt3ix8jj1vzom4pp5hygu9ijjzvowqm8xp6ijlwlry1ap' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wppp_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



define( 'WP_SITEURL', 'http://mano/' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
