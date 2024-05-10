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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'test' );

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
define( 'AUTH_KEY',         '=t;eR#UW~5zqaqLT?nQj2=edwDkD)5e.@o4f{a~XJx#BRJg6S&HMrpcxAZ0Ub^fF' );
define( 'SECURE_AUTH_KEY',  ']!u&rlaIwZ-x5 A*zl);-R.5/B??D@XmJYS3(M{.rkQmYx8q!YtZ%<|n]M qKh)f' );
define( 'LOGGED_IN_KEY',    'MLNB`bN<9C`DTDxlL72)`GX5FKFsvgL@>}g&ntX|Z|9g3g+QHb|nlF:{tyWRe9=e' );
define( 'NONCE_KEY',        'mbk-G`r)3-Oz-LeMn94g[nA>-tfB-PUn{HW(Pafq<8X4d-UQ%ga}/-A87T*8)JDw' );
define( 'AUTH_SALT',        '!>rH-?S:m*]%$4%}#+PQ6pGXXbzX:_mn5KXhmO/G7{T&?LLF>6%6iky}{NzOL&3z' );
define( 'SECURE_AUTH_SALT', 'suO8*mWHE%gbg_O@]tP9wu15OtD,w ./p>-A)%iho&I4/wl#VtD}o5IYS~<yk~MM' );
define( 'LOGGED_IN_SALT',   'rHgz$a6YG*n-I%X=3/upX8#zPa9S!Q2(VgM`^V;^wZ=T{HD|75ggaiY[.>:HNth{' );
define( 'NONCE_SALT',       ']gc[Q=``eyyMH*}DF)_ F^jIk6Ke,#}@oO*fb_3X<T_yL|?>-KQ9v^?WAiM9(_G9' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
