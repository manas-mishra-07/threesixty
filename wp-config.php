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
define('DB_NAME', 'u739133933_threesixty');
/** MySQL database username */
define('DB_USER', 'u739133933_threesixty');
/** MySQL database password */
define('DB_PASSWORD', 'XXJEw&8Z');
/** MySQL hostname */
define('DB_HOST', 'localhost');
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');
/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define('FS_METHOD', 'direct');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'dzbhvpv8s4fveudl2enkskinvhwzanghhd5djnmt766csjdti4crayttcdebtfun');
define('SECURE_AUTH_KEY',  'oihsnsw0wenwz6pnvl9bwhjw5cbyjbh5syoi0iafp2qjjyj7wtin97zx4myxqnlz');
define('LOGGED_IN_KEY',    'eaovmjc3wdfasqianodogqqnano971kj0np4aovwa4cdmkrtjhkrmwn5bi1ychyg');
define('NONCE_KEY',        'pe2xn0vxtwgbtfrovnyxr5cdfimybjt3vk5vg6ehp9bspk3egosmirujb4na1iys');
define('AUTH_SALT',        '5rfkgbul3mqi0oazjjhd3dl7euzz5k8f1zj7kaggh29belmeyl2fakkh6corbkhn');
define('SECURE_AUTH_SALT', 'zdjlbe9v9weohfymn38j6cozqv2xovxpqdcgk9roslca8uhdlihtayrful0ous1y');
define('LOGGED_IN_SALT',   'dbmco3zt9hkzdcq79qfno6xhz29ptsplrdou6g1gaur6tlnzavpo0ihmthjzdjuk');
define('NONCE_SALT',       'bvheqbsd1juagpbwnrai7b9ildfo7bbvcn9ygqz7l84ucm1xuttdxzqyjbetncbi');
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = '360dgrdb_';
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */

define('WP_MEMORY_LIMIT', '256M');

define('WP_DEBUG', false);
/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('DISABLE_WP_CRON', true);
