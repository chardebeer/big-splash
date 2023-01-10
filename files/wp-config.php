<?php
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
define( 'DB_NAME', 'EL_HMPzQ6N3' );

/** MySQL database username */
define( 'DB_USER', 'el_bigsplash' );

/** MySQL database password */
define( 'DB_PASSWORD', 'x3FB4Dzdt' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'Q{s8|6,NE*K!33<1>{yYuVrX?Qe.!y*>mm)NuGE;l,Y&Q}4|La5gcHw(Mg&Iia?~' );
define( 'SECURE_AUTH_KEY',   '>OL(uR[Iw(ZmFC +6d~K=_N+aY3d {<bImmcECD]worhz}!i@g7:}m!W_+!ELK/v' );
define( 'LOGGED_IN_KEY',     'oOe#O66lq,b&+@pvO]&X^nICcj2Kx!#-j8:!]ozbyp_C7sjqjCHJPuIw3:/D2(!]' );
define( 'NONCE_KEY',         'JPmW&2v/^+]A]=%~P^L>.^ .{DMBIIk$PTa.QEP{FqJUj.j>#+$Ci$gJ4;4Mm8z1' );
define( 'AUTH_SALT',         '*ixj X_GEtT_qO}-TuB(s[: IUmjZ o5M#lsil_rhfylhuIfXf1w4gVWQd=FK1=[' );
define( 'SECURE_AUTH_SALT',  '7A4 .Eo3}nZd6)XtW3k#){;$gV,wh0XdrE-!XmHF5^Y^BXi(&tv;-}KDL:yA SWv' );
define( 'LOGGED_IN_SALT',    '=7p|7Vj$|3:6*/L!62mZi;H&U3qp?]nRn.Hh/OD3@%Px#BOMPu$pw>%/YKeR!eJZ' );
define( 'NONCE_SALT',        ')RdI>XeR0sTbs}m[6p7*Hq/O:Y13$DbY`QOuWY{[mDRX~!H`[*AMg;1Zo5W.-|u1' );
define( 'WP_CACHE_KEY_SALT', 'Ts-H*x{OdV24|eX|7f_i(cU,bH@B&W(G[vy7xMaj9+EG,d#cZxBkly=^A(tqHM[%' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'eGHJD_';


    define('WP_HOME', "https://bigsplash.elementor.cloud/");
    define('WP_SITEURL', "https://bigsplash.elementor.cloud/");
    if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            $_SERVER['HTTPS'] = 'on';
    }


define( 'DISALLOW_FILE_EDIT', true );
define( 'WP_MEMORY_LIMIT', '512M' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
