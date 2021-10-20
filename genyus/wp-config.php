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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:8000' );

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
define( 'AUTH_KEY',         'N-T_=Cj(:oqZpr>@Og5zK!2xX?&QI.d9)`y}C6hS`L}p<,}&V$?&,!/<?~+*4MuQ' );
define( 'SECURE_AUTH_KEY',  'N8|*){&*ps)|X}7cd6y;0MEr6xK^pCeLUuy , RVeYQ7#?[+FsK&tK5~@w4#`fCX' );
define( 'LOGGED_IN_KEY',    '.g5$6$X5RN@sdpqj~$ JS3^:S.kt,Vil=I#T86b$4O_TCCH^?Muot!.Ccvp[o4]L' );
define( 'NONCE_KEY',        'sSro_MogY[=J<|sG^p2T(b@Z61=*H,L8];;o/?!(0i3kmKmC$QXlkn)P`%u.Lx);' );
define( 'AUTH_SALT',        'yFEB*$J?N)Vuz=+nO{_z*V>mkt%`2xr}U$v)0Gg+O9QUa ;i{j<;+&<V5Vw0HI7~' );
define( 'SECURE_AUTH_SALT', 'YI,nW:Ycy7Th8AC7g8E#M#r%t6?o,^06q{2WCt:a1$9o/p0g4=I$#Euk)NPmGVN9' );
define( 'LOGGED_IN_SALT',   '/q+q![aG_;zquQfsW2%AQm2wj`Q=j:RorGwB RFx/RA(*lxPw$;ggLGD-hk~p|rY' );
define( 'NONCE_SALT',       'i.*8f,]OxDEf{MPU~Mp$Ry0:bO-DH5A(Xe5h )QsM,*0RfO;vH(Wk#r@CcusS/, ' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
//define( 'WP_DEBUG', false );
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
