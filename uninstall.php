<?php

use Jamm\FindcoVote;

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// Includes
include_once JAMM_PLUGIN_PATH . "/vendor/autoload.php";

// class instantiation
$findcoVote = new FindcoVote();

// execute uninstall method when plugin is uninstalled
$findcoVote->uninstallPlugin();