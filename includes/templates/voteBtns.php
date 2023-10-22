<div id="findco-vote">
    <span class="text">
        <span id="new-vote"><?php _e( 'Was this article helpful?', 'findco-vote' );?></span>
        <span id="voted" style="display: none;"><?php _e( 'Thank you for your feedback', 'findco-vote' );?></span>

    </span>
    <div class="btns">
        <button type="button" id="up" class="up" data-id="<?php the_ID();?>" data-action="up">
            <div>
                <span class="bg"></span>
                <span id="vote-up-label"><?php _e( 'Yes', 'findco-vote' );?></span>
            </div>
        </button>
        <button type="button" id="down" class="down" data-id="<?php the_ID();?>" data-action="down">
            <div>
                <span class="bg"></span>
                <span id="vote-down-label"><?php _e( 'No', 'findco-vote' );?></span>
            </div>
        </button>
    </div>
</div>