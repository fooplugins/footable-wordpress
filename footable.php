<?php
/**
 * FooTable
 *
 * @package   FooTable
 * @author    Brad Vincent <brad@fooplugins.com>
 * @license   GPL-2.0+
 * @link      http://fooplugins.com/plugins/footable-lite/
 * @copyright 2013 FooPlugins LLC
 *
 * Plugin Name: FooTable
 * Plugin URI: http://fooplugins.com/plugins/footable-lite/
 * Description: FooTable makes your HTML tables look awesome on smaller devices
 * Version: 0.3.2
 * Author: Brad Vincent
 * Author URI: http://fooplugins.com
 * License: GPL2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: footable
 * Domain Path: /languages
**/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( 'class.footable.php' );

$GLOBALS['FooTable'] = new FooTable(__FILE__);