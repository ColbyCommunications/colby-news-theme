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

/** This will ensure these are only loaded on Lando */
if ( getenv( 'LANDO_INFO' ) ) {
	/**  Parse the LANDO INFO  */
	$lando_info = json_decode( getenv( 'LANDO_INFO' ) );
	$lando_url  = array_slice( $lando_info->appserver->urls, -1 )[0];

	/** Get the database config */
	$database_config = $lando_info->database;
	/** The name of the database for WordPress */
	define( 'DB_NAME', $database_config->creds->database );
	/** MySQL database username */
	define( 'DB_USER', $database_config->creds->user );
	/** MySQL database password */
	define( 'DB_PASSWORD', $database_config->creds->password );
	/** MySQL hostname */
	define( 'DB_HOST', $database_config->internal_connection->host );

	/** URL routing (Optional, may not be necessary) */
	define( 'WP_HOME', $lando_url );
	define( 'WP_SITEURL', $lando_url . 'wordpress' );
}


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', 'put your unique phrase here' );
define( 'SECURE_AUTH_KEY', 'put your unique phrase here' );
define( 'LOGGED_IN_KEY', 'put your unique phrase here' );
define( 'NONCE_KEY', 'put your unique phrase here' );
define( 'AUTH_SALT', 'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT', 'put your unique phrase here' );
define( 'NONCE_SALT', 'put your unique phrase here' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
// @codingStandardsIgnoreStart
$table_prefix = 'wp_';
// @codingStandardsIgnoreEnd

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
define( 'WP_DEBUG', true );

/** Disable fatal error alert emails on local dev and on
 * the following domains:
 * - pantheonsite.io
 * - wpengine.com
 * - platformsh.site
**/
$no_email_domains = [
	'pantheonsite',
	'wpengine',
	'platform.sh',
	'localhost',
	'lndo.site'
];

foreach ($no_email_domains as $domain) {
	if (stripos(WP_HOME, $domain) > -1) {
		define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
	}
}


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

define( 'WP_CONTENT_URL', WP_HOME . '/wp-content' );
define( 'WP_CONTENT_DIR', dirname( ABSPATH ) . '/wp-content' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

/** Changes path to wp-content */

