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

// defining constants
define( 'JAMM_VERSION', '1.0.0' ); // plugin version
define( 'JAMM_PLUGIN_PATH', plugin_dir_path(__FILE__) ); // plugin path
define( 'JAMM_PLUGIN_URL', plugin_dir_url(__FILE__) ); // plugin URL
define( 'JAMM_NONCE_KEY', 'findco_vote_single-post' ); // nonce secret

// Includes
include_once JAMM_PLUGIN_PATH . "/vendor/autoload.php";

// class instantiation
$findcoVote = new FindcoVote();

// Actions
add_action( 'admin_menu', [$findcoVote, 'settingsMenu'] ); // admin settings menu
add_action( 'wp_footer', [$findcoVote, 'enqueueStaticAssets'] ); // enqueue css/js inline in footer
add_action( 'wp_ajax_vote_article', [$findcoVote, 'voteArticle'] ); // ajax request for voting
add_action( 'wp_ajax_nopriv_vote_article', [$findcoVote, 'voteArticle'] ); // ajax request for non logged in users
add_action( 'add_meta_boxes', [$findcoVote, 'votes_meta_box'] ); // post meta box with votes count

// Filters
add_filter( 'the_content' , [$findcoVote, 'voteBtns'] ); // add vote buttons at the end of post article
add_filter( 'plugin_action_links_' . basename( dirname( __FILE__ ) ) . '/findco-vote.php', [$findcoVote, 'settingsLink'] ); // add a settings link under plugin name

// Hooks
register_activation_hook( __FILE__, [$findcoVote, 'activatePlugin'] ); // set default options on activation
