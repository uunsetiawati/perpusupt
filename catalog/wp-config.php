<?php
define( 'WP_CACHE', true );
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
 
 define( 'WP_HOME', 'https://perpustakaan.uptkukm.id/catalog' );
define( 'WP_SITEURL', 'https://perpustakaan.uptkukm.id/catalog' );

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u9023553_wp524' );

/** Database username */
define( 'DB_USER', 'u9023553_wp524' );

/** Database password */
define( 'DB_PASSWORD', '[u.10p2S7N' );

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
define( 'AUTH_KEY',         'cmfh32xiur63yrli26r2nfabfklmwhf6pnll5h0j4ozwpdk4viog4i94omgyrdnv' );
define( 'SECURE_AUTH_KEY',  'vvaqgzlvoqo9vuy5x36t0e31m8f4kjdobibttwh2pgv49qav0eoi74egs5nz0e5r' );
define( 'LOGGED_IN_KEY',    'o4hhzckbsjbbsn7bjrbxuqxli6gt36hbo0a5exd0snzn6p8q0p30dvyabhexrpyi' );
define( 'NONCE_KEY',        'rljo4yljbgaly9xc1mnfweugjuae6e3am5wtrforft5avykdb0ai0vkyqlfkpxzu' );
define( 'AUTH_SALT',        'bwe4f7sugb29fxrho9xriakk9dxksqfgnflmqxpuvqubgy7nnmveqeiommnaklop' );
define( 'SECURE_AUTH_SALT', 'k25ngtv770dnibxnoaldbtkk9vcqxzk8onqxwbo29smnwuqaakahg74rpdc3omep' );
define( 'LOGGED_IN_SALT',   'qbetamx8cetuec8weku37g6ghfsj1seu7pawq6gjqmojsz8bqzo1cigoyqcrkwng' );
define( 'NONCE_SALT',       'soxbu8wcbxzynnvcevkzcv7a4jl6zgzxirvkmnnk5ymmvoemz7pb09pn1orwfpih' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpkq_';

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
