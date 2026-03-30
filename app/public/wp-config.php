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
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',          '-*UyXYbybR9D*S{tBUM3;1G*?$Yn;Z0Vr=`Eta5|sf`AZ6>Rt:pl#nQFL^)3]_;u' );
define( 'SECURE_AUTH_KEY',   '6AE$vbNR0ccT_b{xKS20wq]c} wJ&G`dSW3fnE[a*w&JiO_pa*TZeJJEhX2.E*y$' );
define( 'LOGGED_IN_KEY',     '5/NiJ<JLT]N<)|-[#hM)(6^++[c$HfL^!l)KPjo_*Q/$g)7QGdfmdr{[RY8plPQ%' );
define( 'NONCE_KEY',         'Pf|Q|L5NO^t,~?-Js&1oG{(-L5_nbzu/OJ&:c[%:U_j%c4E4Qu.obH*owcBNJtwD' );
define( 'AUTH_SALT',         '7*0MQp7snh<9~`*]!M#9~EM8]# iZFNQifgvMEfs 8Gjj#UB| Gk)Qn-{?_|PPGh' );
define( 'SECURE_AUTH_SALT',  '%O29$R(h3@#]lXy0D^Z*Kx,?w.gz[;_DnF-+-8I^7KWNBHT)eB]/q&LMc^jcd0(W' );
define( 'LOGGED_IN_SALT',    ',a:lSKcOU0iFw5(OfpcUM9$|/fn#8z&[Vg)|Obqr^e(b8;3=Rh|q<lU]AzKlV?n:' );
define( 'NONCE_SALT',        '@ z31};tkUY2K]_g~@D9P3rzDA}[Ct*a:0s>d_HKUku!8rd6bUpe8>7*YusnXzv5' );
define( 'WP_CACHE_KEY_SALT', 'T0tZR<vl*hTeRuW[yAHSV+`~lLbuxm&EC<(,Z|{:Aam71s}S0[:&*^=<,,x&;#un' );


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

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
