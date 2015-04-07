<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'heroku_app_db');

/** MySQL database username */
define('DB_USER', 'gk9t77j7np05vzzc');

/** MySQL database password */
define('DB_PASSWORD', 'y8125pb89j8m596r');

/** MySQL hostname */
define('DB_HOST', 'zi4y1756np2trlq0.cbetxkdyhwsb.us-east-1.rds.amazonaws.com');

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
define('AUTH_KEY',         '-Njv?Xeo}@8&hP=^a9loJ1}cZ`/>S]^}:i5/Z9VuyeX|m6kt)bDhqd1GLq2A=z{o');
define('SECURE_AUTH_KEY',  '2Kui[}F 6T7TF$Q }tLIc`WIsxU0v<!mx`hh|Edy Sl]C&o$-RptXxcLzK{(r%DJ');
define('LOGGED_IN_KEY',    '8PzXsr_-taRaSDW>AsH:8x/W7d!Ax)1W6=LH@0vOZ~r7^sj_88gOt7g{8[S< ~wl');
define('NONCE_KEY',        '!W|I,m0,G=2~5$xAM%g;M5bVdZC{: LZdwrjv3*Ib|`g$k3<YWW-;P$a`i=G=U+v');
define('AUTH_SALT',        '/Yidc]DM4 oqlfy01vY$NG&[?.$u0!jJ!wM]T&d_{wm|hyfz+%|fgBTVnW%N-kKo');
define('SECURE_AUTH_SALT', 'a].h;9#+lm.9T|k=DD$;(GCkfBpccl)a*#CSrZA~lkfd`xmV|d4Dmg=Iw-VCwW{.');
define('LOGGED_IN_SALT',   'a~<[A~dxti[e![,)>hCPm#B^-_,zd+{%5OmM(]6.0pj:-s)t@gcT1=)72!3co-}}');
define('NONCE_SALT',       'd%htaYl=;<XVv1^f~`dNQI2wo_c^W1H@0UrVU~paRXeKo`Y1zN-:j`Wz5?7dQ,c0');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
