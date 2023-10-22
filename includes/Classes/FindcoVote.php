<?php 

namespace Jamm;

// no direct access to file
! defined( 'ABSPATH' ) ? exit : '';

class FindcoVote {

    public function voteArticle() {

        if ( !wp_verify_nonce( $_REQUEST[ 'nonce' ], JAMM_NONCE_KEY ) ) {
            exit("This lake is dry! Go fish elsewhere :)");
        }

        $post_id = absint( @$_POST['post_id'] );
        $action = ( in_array( @$_POST['vote'], [ 'up', 'down' ] ) ? $_POST['vote'] : false );
        $meta_key = "findco_votes";

        $status = 400;
        $type = "error";
        $data['votes_count'] = 0;
        $data['votes_up'] = 0;
        $data['votes_down'] = 0;

        if( $post_id > 0 && $action ) {

            $status = 200;
            $type = "success";

            $votes = get_post_meta($post_id, $meta_key, true);

            if( $votes ) {
                $data['votes_count'] = ( !empty( $votes['votes_count'] ) ? $votes['votes_count'] : 0 );
                $data['votes_up'] = ( !empty( $votes['votes_up'] ) ? $votes['votes_up'] : 0 );
                $data['votes_down'] = ( !empty( $votes['votes_down'] ) ? $votes['votes_down'] : 0 );
            }
            
            $data = [
                'votes_count' => $data['votes_count']+1,
                'votes_up' => ( $action == "up" ? $data['votes_up']+1 : $data['votes_up'] ),
                'votes_down' => ( $action == "down" ? $data['votes_down']+1 : $data['votes_down'] )
            ];

            update_post_meta( $post_id, $meta_key, $data, $votes );
        }

        $response = [
            'status' => $status,
            'result' => [
                'type' => $type,
                'votes_count' => $data['votes_count'],
                'votes_up' => $data['votes_up'],
                'votes_down' => $data['votes_down']
            ]
        ];

        wp_send_json( $response, $status );
    }

    public function enqueueStatisAssets() {

        $css = @file_get_contents( JAMM_PLUGIN_PATH . "public/css/vote.css" );

        if( $css ) {

            $css = str_replace( "{{PLUGIN_URL}}", JAMM_PLUGIN_URL, $css );
            wp_register_style( 'findco-vote-css', false );
	        wp_enqueue_style( 'findco-vote-css' );
	        wp_add_inline_style( 'findco-vote-css', $css );
        }

        $js = @file_get_contents( JAMM_PLUGIN_PATH . "public/js/vote.js" );

        if( $js ) {

            wp_register_script( 'findco-vote-js', false, [ 'jquery' ] );
            wp_enqueue_script( 'findco-vote-js' );
            wp_localize_script( 'findco-vote-js', 'fvc_object', [ 
                'ajax_url' => admin_url( 'admin-ajax.php' ), 
                'nonce' => wp_create_nonce( JAMM_NONCE_KEY ) ] 
            );

            wp_add_inline_script( 'findco-vote-js', $js );
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