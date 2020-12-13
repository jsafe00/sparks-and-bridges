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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sparksandbridges' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'd_FaDeWY9-]8R,Ns-h9$rh$NkWTAt_B1?`#V`?z/vdvTh/-uK>A0VK<7X3HA,=Hp' );
define( 'SECURE_AUTH_KEY',  '4f)3F`UwkVAFGm0x~&fzP=O<0Y.hnY# ZUURvvf[~T8,WiF`e}nR8q5?vL !Qw{k' );
define( 'LOGGED_IN_KEY',    'Ht `X/AO@Th@=S<,|@yG6(N/TGEe5++al_33Jz9wCjM>0w!@[`Bz7I|.]$ZQ3-8U' );
define( 'NONCE_KEY',        'K{EfMK]2h1m,jfN4g2x,[+Adrs7bBp/S1}MjzXI|ayeO>IGrBpw/v,~YqH+k9%:c' );
define( 'AUTH_SALT',        '<l#{Gh4#`t@O4M@Dl7CJAtAI&iwN*>N#HJRzFKUtJkw)c_;r2k^DA;^Q{eXWF<%t' );
define( 'SECURE_AUTH_SALT', 'Nb3g^8H&RT*Sn)TY!by@Z1o}9W;ZZ`Wq!q?jr@wC9&.R YYb~i*{myamcO6A`dOp' );
define( 'LOGGED_IN_SALT',   '4;yHE>,ObxFvtTP?)kR<-6GmcRI!. GF8O1-SDr{H(ZKGKWBjKKM@MUo>{d]]V>o' );
define( 'NONCE_SALT',       '4ij4y<zBf]!*(PJF@UXKh>yU5++UPPFUe(`E^s1tBJY1>cg!xGWN-!@f[o+Di6rZ' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
