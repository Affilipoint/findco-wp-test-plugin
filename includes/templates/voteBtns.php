<div id="findco-vote">
    <span class="text"><?php _e( 'Was this article helpful?', 'findco-vote' );?></span>
    <div class="btns">
        <button type="button" id="up" class="up"><?php _e( 'Yes', 'findco-vote' );?></button>
        <button type="button" id="down" class="down"><?php _e( 'No', 'findco-vote' );?></button>
    </div>
</div>
<style>
#findco-vote {
    display: flex;
    align-items: center;
    gap: 15px;
}
#findco-vote button {
    border: 1px solid #ccc;
    background-color: #fff;
    color: #333;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: inherit;
}
#findco-vote button:hover {
    color: #fff;
}
#findco-vote button.up {
    background-image: url('<?php echo JAMM_PLUGIN_URL ?>public/images/thumb-up.svg');
    background-repeat: no-repeat;
    background-size: contain;
}
#findco-vote button.up:hover {
    background-color: green;
    border-color: green;
}
#findco-vote button.down:hover {
    background-color: red;
    border-color: red;
}
@media only screen and (max-width: 600px) {
    #findco-vote { 
        display: block; 
        text-align: center; 
    }
    #findco-vote .btns { 
        display: flex; 
        align-items: center; 
        gap: 10px; 
        justify-content: center; 
    }
    #findco-vote .btns button {
        margin-top: 10px;
        width: 100%;
        
    }
} 
</style>