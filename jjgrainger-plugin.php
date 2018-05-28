<?php
/**
 * Plugin Name: Plugin Test
 * Plugin URI: https://jjgrainger.co.uk/
 * Description: Plugin tests for auto updates
 * Version: 1.0
 * Author: jjgrainger
 * Author URI: https://jjgrainger.co.uk
 * License: MIT
 */

require __DIR__ . '/vendor/autoload.php';

$hooks = [
    Plugin\Hooks\Plugin::class,
];

foreach ($hooks as $hook) {
    (new $hook)->register();
}
