<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */

// AUTH_SALT is loaded from project root .env (see public/index.php). Same pattern as Model_Weather API keys.
$auth_salt = getenv('AUTH_SALT');
if ($auth_salt === false || $auth_salt === '') {
    $auth_salt = $_ENV['AUTH_SALT'] ?? '';
}
if ($auth_salt === '') {
    $auth_salt = 'lux_mundi_anno_domini_MMXXVI';
}

return array(
    'driver'                 => 'Simpleauth',
    'verify_multiple_logins' => false,
    'salt'                   => $auth_salt,
    'iterations'             => 10000,
);
