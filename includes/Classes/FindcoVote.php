<?php 

namespace Jamm;

// no direct access to file
! defined( 'ABSPATH' ) ? exit : '';

/**
 * Plugin main class
 */
class FindcoVote {

    public function votes_meta_box() {
        
        // adds meta box to post edit page with callback function `votes_meta_box_callback`
        add_meta_box( 
            'findco_vote_meta_box', 
            __( 'Helpful Article?', 'findco-vote' ), 
            [ &$this, 'votes_meta_box_callback'], 
            'post', 
            'side' 
        );
    }

    public function votes_meta_box_callback( $post, $box ) {

        // path of the UI template
        $metaBoxTpl = JAMM_PLUGIN_PATH . "includes/templates/metaBoxTpl.php";

        // fetching data from post meta
        $votes = get_post_meta($post->ID, 'findco_votes', true);

        $data['votes_count'] = ( !empty( $votes['votes_count'] ) ? $votes['votes_count'] : 0 );
        $data['votes_up'] = ( !empty( $votes['votes_up'] ) ? $votes['votes_up'] : 0 );
        $data['votes_down'] = ( !empty( $votes['votes_down'] ) ? $votes['votes_down'] : 0 );

        // loading template and data
        load_template( $metaBoxTpl, true, $data );
    }

    public function voteArticle() {

        // verifying nonce value from ajax request
        if ( !wp_verify_nonce( $_REQUEST[ 'nonce' ], JAMM_NONCE_KEY ) ) {

            // exit script if nonce cannot be verified
            exit("This lake is dry! Go fish elsewhere :)");
        }

        // sanitize input for security
        $post_id = absint( @$_POST['post_id'] );
        $action = ( in_array( @$_POST['vote'], [ 'up', 'down' ] ) ? $_POST['vote'] : false );
        $meta_key = "findco_votes";

        $status = 400;
        $type = "error";
        $data['votes_count'] = 0;
        $data['votes_up'] = 0;
        $data['votes_down'] = 0;

        // check if data sent is valid
        if( $post_id > 0 && $action ) {

            $status = 200;
            $type = "success";

            // fetching current post meta values
            $votes = get_post_meta($post_id, $meta_key, true);

            if( $votes ) {
                $data['votes_count'] = ( !empty( $votes['votes_count'] ) ? $votes['votes_count'] : 0 );
                $data['votes_up'] = ( !empty( $votes['votes_up'] ) ? $votes['votes_up'] : 0 );
                $data['votes_down'] = ( !empty( $votes['votes_down'] ) ? $votes['votes_down'] : 0 );
            }

            // updating post meta values
            $data = [
                'votes_count' => $data['votes_count']+1,
                'votes_up' => ( $action == "up" ? $data['votes_up']+1 : $data['votes_up'] ),
                'votes_down' => ( $action == "down" ? $data['votes_down']+1 : $data['votes_down'] )
            ];

            update_post_meta( $post_id, $meta_key, $data, $votes );
        }

        // ajax response
        $response = [
            'status' => $status,
            'result' => [
                'type' => $type,
                'votes_count' => $data['votes_count'],
                'votes_up' => $data['votes_up'],
                'votes_down' => $data['votes_down']
            ]
        ];

        // sending response as json object
        wp_send_json( $response, $status );
    }

    public function enqueueStaticAssets() {

        // initializing minifier class
        $minifier = new AssetsMinifier();

        // only enqueue assets on single post pages
        if(is_single() 
            && !is_home()
        ) {
            // fetching content for CSS
            $css = @file_get_contents( JAMM_PLUGIN_PATH . "public/css/vote.css" );

            if( $css ) {

                // performing search/replace for image paths since relative paths won't work inline
                $css = str_replace( "{{PLUGIN_URL}}", JAMM_PLUGIN_URL, $css );

                // enqueueing CSS inline, better performance in general (debatable)
                wp_register_style( 'findco-vote-css', false );
                wp_enqueue_style( 'findco-vote-css' );
                wp_add_inline_style( 'findco-vote-css', $minifier->minify_css( $css ) );
            }

            // fetching content for JS
            $js = @file_get_contents( JAMM_PLUGIN_PATH . "public/js/vote.js" );

            if( $js ) {

                // enqueueing JS inline, better performance in general (debatable)
                wp_register_script( 'findco-vote-js', false, [ 'jquery' ] );
                wp_enqueue_script( 'findco-vote-js' );
                wp_localize_script( 'findco-vote-js', 'fvc_object', [ 
                    'ajax_url' => admin_url( 'admin-ajax.php' ), 
                    'nonce' => wp_create_nonce( JAMM_NONCE_KEY ) ] 
                );

                wp_add_inline_script( 'findco-vote-js', $minifier->minify_js( $js ) );
            }
        }
    }

    public function voteBtns( $content ) {

        // path of UI template
        $voteBtnsTpl = JAMM_PLUGIN_PATH . "includes/templates/voteBtns.php";

        // show voting buttons only on single post page
        if(is_single() 
            && !is_home() 
            && file_exists( $voteBtnsTpl ) 
        ) {
        
            // get settings options
            $args = get_option( 'findco_vote_options' );

            // start output buffering
            ob_start();
            include $voteBtnsTpl;
            $voteBtnsHtml = ob_get_contents();
            ob_end_clean();

            // append at the end of content
            $content .= $voteBtnsHtml;
        }

        return $content;
    }

    public function settingsMenu() {

        // adds a settings menu in WP Admin
        add_options_page( 
            __( 'Article Voting Settings', 'findco-vote' ), 
            __( 'Find.co Voting', 'findco-vote' ), 
            'manage_options', 
            'findco-vote-settings', 
            [ &$this, 'settingsPage' ]
        );
    }

    public function settingsPage() {

        // path to admin settings page UI
        $path = JAMM_PLUGIN_PATH . "includes/templates/adminSettings.php";

        // check if template file exists
        if( file_exists( $path ) ) {

            // get settings options from DB
            $data = get_option( 'findco_vote_options' );

            // verify nonce on submit
            if ( ! empty( $_POST['submit'] ) 
                && wp_verify_nonce( $_POST['_wpnonce'], 'findco-vote-settings-page' ) 
            ) 
            {
                // sanitize input data
                $data['fcv_feedback_text'] = ( 
                    !empty( $_POST['fcv_feedback_text'] ) ? 
                        sanitize_text_field( $_POST['fcv_feedback_text'] ) 
                        : $data['fcv_feedback_text'] 
                );

                $data['fcv_feedback_complete_text'] = ( 
                    !empty( $_POST['fcv_feedback_complete_text'] ) ? 
                        sanitize_text_field( $_POST['fcv_feedback_complete_text'] ) 
                        : $data['fcv_feedback_complete_text'] 
                );

                $data['fcv_btn_yes'] = ( 
                    !empty( $_POST['fcv_btn_yes'] ) ? 
                        sanitize_text_field( $_POST['fcv_btn_yes'] ) 
                        : $data['fcv_btn_yes'] 
                );

                $data['fcv_btn_no'] = ( 
                    !empty( $_POST['fcv_btn_no'] ) ? 
                        sanitize_text_field( $_POST['fcv_btn_no'] ) 
                        : $data['fcv_btn_no'] 
                );

                $data['fcv_delete_data'] = ( !empty( $_POST['fcv_delete_data'] ) ? "1" : "0" );

                // update settings in options table
                update_option( 'findco_vote_options', $data );

                // echo success notice message
                echo '<div class="notice notice-success"><p><b>' . __( 'Settings saved.', 'findco-vote' ). '</b></p></div>';
            }

            // load settings page template with data
            load_template( $path, true, $data );
        }
    }
    public function activatePlugin() {

        // if settings options not already set in table, add it
        if( empty( get_option( 'findco_vote_options' ) ) ) {

            // default settings options
            $data['fcv_feedback_text'] = "Was this article helpful?";
            $data['fcv_feedback_complete_text'] = "Thank you for your feedback";
            $data['fcv_btn_yes'] = "Yes";
            $data['fcv_btn_no'] = "No";
            $data['fcv_delete_data'] = "0";

            // create/update settings in options table on plugin activation
            update_option( 'findco_vote_options', $data );
        }
    }

    public static function uninstallPlugin() {

        // get settings options value
        $options = get_option( 'findco_vote_options' );

        // if user opted for data to be deleted on plugin deletion
        if( !empty( $options['fcv_delete_data'] ) && (int)$options['fcv_delete_data'] == 1 ) {

            // load $wpdb global object
            global $wpdb;

            // delete query and prepare statement
            $wpdb->query(
                $wpdb->prepare( "
                    DELETE FROM $wpdb->postmeta 
                    WHERE `meta_key` = %s
                ",
                [
                    'findco_votes'
                ] )
            );

            // delete settings options
            delete_option( 'findco_vote_options' );
        }
    }

    public function settingsLink( $links ) 
    {
        // generate settings page link
        $url = esc_url( add_query_arg(
            'page',
            'findco-vote-settings',
            get_admin_url() . 'admin.php'
        ) );
        
        $settings_link = "<a href='$url'>" . __( 'Settings', 'findco-vote' ) . '</a>';
        
        array_push(
            $links,
            $settings_link
        );

        return $links;
    }
}
