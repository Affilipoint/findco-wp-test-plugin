<div class="wrap">
    <h1>
        <?php _e( 'Article Voting Settings', 'findco-vote' );?>
    </h1>
    <p>
        <?php _e ( 'Plugin related settings.', 'findco-vote' );?>
    </p>

    <form action="" method="post" role="form">
        <?php wp_nonce_field( 'findco-vote-settings-page' );?>
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">
                        <?php _e( 'Feedback text', 'findco-vote' );?>
                    </th>
                    <td>
                        <input 
                            name="fcv_feedback_text" 
                            id="fcv_feedback_text" 
                            type="text" 
                            value="<?php echo esc_attr( $args['fcv_feedback_text'] );?>" 
                            class="regular-text ltr" 
                            placeholder="<?php echo esc_attr( __( 'Was this article helpful?', 'findco-vote' ) );?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php _e( 'Voted Complete Feedback text', 'findco-vote' );?>
                    </th>
                    <td>
                        <input 
                            name="fcv_feedback_complete_text" 
                            id="fcv_feedback_complete_text" 
                            type="text" 
                            value="<?php echo esc_attr( $args['fcv_feedback_complete_text'] );?>" 
                            class="regular-text ltr" 
                            placeholder="<?php echo esc_attr( __( 'Thank you for your feedback', 'findco-vote' ) );?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php _e( 'Button Vote Up', 'findco-vote' );?>
                    </th>
                    <td>
                        <input 
                            name="fcv_btn_yes" 
                            id="fcv_btn_yes" 
                            type="text" 
                            value="<?php echo esc_attr( $args['fcv_btn_yes'] );?>" 
                            class="regular-text ltr" 
                            placeholder="<?php echo esc_attr( __( 'Yes', 'findco-vote' ) );?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php _e( 'Button Vote Down', 'findco-vote' );?>
                    </th>
                    <td>
                        <input 
                            name="fcv_btn_no" 
                            id="fcv_btn_no" 
                            type="text" 
                            value="<?php echo esc_attr( $args['fcv_btn_no'] );?>" 
                            class="regular-text ltr" 
                            placeholder="<?php echo esc_attr( __( 'No', 'findco-vote' ) );?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php _e( 'Delete voting data on uninstall?', 'findco-vote' );?>
                    </th>
                    <td>
                        <input 
                            type="checkbox" 
                            name="fcv_delete_data" 
                            id="fcv_delete_data" 
                            value="1" <?php echo $args['fcv_delete_data'] == 1 ? 'checked' : '';?> />
                    </td>
                </tr>
            </tbody>
        </table>

        <p class="submit">
            <input 
                type="submit" 
                name="submit" 
                id="submit" 
                class="button button-primary" 
                value="<?php echo esc_attr( 'Save Changes', 'findco-vote' );?>" />
        </p>

    </form>

</div>