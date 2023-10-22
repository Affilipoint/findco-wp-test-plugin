<?php 

namespace Jamm;

// no direct access to file
! defined( 'ABSPATH' ) ? exit : '';

class FindcoVote {

    public function enqueueStatisAssets() {

        $css = @file_get_contents( JAMM_PLUGIN_PATH . "public/css/vote.css" );

        if( $css ) {

            $css = str_replace( "{{PLUGIN_URL}}", JAMM_PLUGIN_URL, $css );
            wp_register_style( 'findco-vote-css', false );
	        wp_enqueue_style( 'findco-vote-css' );
	        wp_add_inline_style( 'findco-vote-css', $css );
        }
    }

    public function voteBtns( $content ) {

        $voteBtnsTpl = JAMM_PLUGIN_PATH . "includes/templates/voteBtns.php";

        if(is_single() 
            && !is_home() 
            && file_exists( $voteBtnsTpl ) 
        ) {
        
            $voteBtnsHtml = '';
            ob_start();
            include $voteBtnsTpl;
            $voteBtnsHtml = ob_get_contents();
            ob_end_clean();

            $content .= $voteBtnsHtml;
        }

        return $content;
    }

    public function settingsMenu() {
        add_options_page( 
            'Article Voting Settings', 
            'Find.co Voting', 
            'manage_options', 
            'findco-vote-settings', 
            [ &$this, 'settingsPage' ]
        );
    }

    public function settingsPage() {

        $path = JAMM_PLUGIN_PATH . "includes/templates/adminSettings.php";

        if( file_exists( $path ) ) {

            load_template( $path );
        }
    }
}