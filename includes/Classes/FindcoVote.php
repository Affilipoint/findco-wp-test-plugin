<?php 

namespace Jamm;

// no direct access to file
! defined( 'ABSPATH' ) ? exit : '';

class FindcoVote {

    public function voteBtns( $content ) {

        if(is_single() 
            && !is_home() 
            && file_exists( $voteBtnsTpl = JAMM_PLUGIN_PATH . "includes/templates/voteBtns.php" ) 
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

        if( $path = file_exists( JAMM_PLUGIN_PATH . "includes/templates/adminSettings.php" ) ) {
            
            load_template( $path );
        }
    }
}