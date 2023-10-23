<div id="findco-vote">
    <span class="text">
        <span id="new-vote">
            <?php echo !empty( $args['fcv_feedback_text'] ) ? $args['fcv_feedback_text'] : 'Was this article helpful?';?>
        </span>
        <span id="voted" style="display: none;">
            <?php echo !empty( $args['fcv_feedback_complete_text'] ) ? $args['fcv_feedback_complete_text'] : 'Thank you for your feedback';?>
        </span>
    </span>
    <div class="btns">
        <button type="button" id="up" class="up" data-id="<?php the_ID();?>" data-action="up">
            <div>
                <span class="bg"></span>
                <span id="vote-up-label"><?php echo !empty( $args['fcv_btn_yes'] ) ? $args['fcv_btn_yes'] : 'Yes';?></span>
            </div>
        </button>
        <button type="button" id="down" class="down" data-id="<?php the_ID();?>" data-action="down">
            <div>
                <span class="bg"></span>
                <span id="vote-down-label"><?php echo !empty( $args['fcv_btn_no'] ) ? $args['fcv_btn_no'] : 'No';?></span>
            </div>
        </button>
    </div>
</div>