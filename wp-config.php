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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'code_assistant_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'Admin@123#@!' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'b:<QOePbEAbqhN&sz?SlbE]#r#h/j_{dGaxGYurD`<;6i{&}e2<#56#2yrviveV`' );
define( 'SECURE_AUTH_KEY',   '5]erp1a-)dyC=Sj8a>QTaT}vb>4.nwgG}nH(:q-As#S(!6m_7vTehM mdoQcKv2)' );
define( 'LOGGED_IN_KEY',     'y|JJN)@{kq-{?zqwDE%UqDxYC=iu)Nd?P,s%{;Dl{XYtD+5D[^vwd}Xn=o[jX&b_' );
define( 'NONCE_KEY',         'nJ;MR}kB=C$WL-Y){i!qcmuUAB(I.7rV FHvrBVw@s|(g5JKw%Q`gy?i>OA7?s%.' );
define( 'AUTH_SALT',         '[ij};*%+$#cl><[pp~T%rpk=Oa>r0@T~lT W?MtHZrytMTiuXd:83xqO:O4Sz`3$' );
define( 'SECURE_AUTH_SALT',  'qdk$3R;Oo6n3 48V(eOp;T[N{9&IBZB=:y_}.G@k9adsx#;&00GBPh;a/%8%=$4r' );
define( 'LOGGED_IN_SALT',    'cUpuiipLdt*vdY]8[gv OFIS3/<y 7;D*%NXk^c=pGQj22MT:]Z3@w~_N7G`jQp^' );
define( 'NONCE_SALT',        'v^kGxxGOc(^=Nd%tf0:g?;q-Z/#4B$`.!r^!2LEwoeY>;sYj,JFF:(VSYuCKj|8P' );
define( 'WP_CACHE_KEY_SALT', '_:m:#:gdQgBq]d+I~fA-s6-s`omX0NEWH 9n6pVB4H{-_s0xh/Hdq1`(|8K6(,H>' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
