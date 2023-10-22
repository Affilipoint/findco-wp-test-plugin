<?php
/**
 * Find.co Voting
 *
 * @package   findco-voting
 * @link      https://github.com/plugins/
 * @author    James Ramroop
 * @license   GPL v2 or later
 *
 * 
 * Plugin Name: Find.co Voting
 * Plugin URI: https://github.com/plugins/
 * Description: WP Article voting plugin
 * Version: 1.0.0
 * Author: James Ramroop
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: findco-voting
 * Domain Path: /i18n
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
*/

use Jamm\FindcoVote;

// disallow direct access to file
! defined( 'ABSPATH' ) ? exit : '';

define( 'JAMM_VERSION', '1.0.0' );
define( 'JAMM_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'JAMM_PLUGIN_URL', plugin_dir_url(__FILE__) );

// Includes
include_once JAMM_PLUGIN_PATH . "/vendor/autoload.php";

$findcoVote = new FindcoVote();

// Actions
//add_action( 'init', array( $igniterAuth, 'lock' ) );
add_action( 'admin_menu', array( $findcoVote, 'settingsMenu' ) );

// Filters
//add_filter( 'plugin_action_links_igniter-auth/index.php', array($igniterAuth, 'settingsLink') );
add_filter( 'the_content' , [ $findcoVote, 'voteBtns' ] );

// Hooks