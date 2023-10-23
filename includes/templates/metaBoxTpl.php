<div>
    <?php _e( sprintf( '<strong>%s</strong> helpful', number_format( $args['votes_up'] ), 'findco-vote' ) );?>
</div>
<div>
    <?php _e( sprintf( '<strong>%s</strong> not helpful', number_format( $args['votes_down'] ), 'findco-vote' ) );?>
</div>
<div>
    <?php _e( sprintf( '<strong>%s</strong> total votes', number_format( $args['votes_count'] ), 'findco-vote' ) );?>
</div>
