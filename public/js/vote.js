window.onload = function() {
    if ( window.jQuery ) {  
        
        checkVote();
        
        // jQuery is loaded  
        jQuery( document ).on( 'click', '#findco-vote button', function( e ) {
            e.preventDefault();          
            const pid = jQuery(this).attr('data-id');
            const vote = jQuery(this).attr('data-action');
            const helpful = jQuery('#new-vote');
            const msg = jQuery('#voted');  

            if( parseInt( pid ) > 0 && vote != "" ) {

                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : fvc_object.ajax_url,
                    data : { action: "vote_article", post_id : pid, vote: vote,  nonce: fvc_object.nonce },
                    success: function(response) {
                       if(response.result.type == "success") {
                            const total = parseInt(response.result.votes_count);
                            const up = parseInt(response.result.votes_up);
                            const down = parseInt(response.result.votes_down);
                            const vup = ( total > 0  ? Math.round( (100 / total) * up ) : 100 );
                            const vdown = (100-vup);
                            helpful.hide();
                            msg.show();
                            jQuery('#up, #down').removeClass('voted');
                            jQuery('#'+vote).addClass('voted');
                            jQuery('#vote-up-label').html(vup+'%');
                            jQuery('#vote-down-label').html(vdown+'%');
                            response.result.percentageUp = vup;
                            response.result.percentageDown = vdown;
                            response.result.userVoted = vote;
                            sessionStorage.setItem("vote-"+pid, JSON.stringify(response.result));
                       }
                       else {
                          alert("Your vote could not be added")
                       }
                    }
                 });
            }
        });
    } 
    else {
        let elem = document.querySelector( '#findco-vote' );
        if( elem ) {
            elem.style.display = 'none';
        }

    }

    function checkVote() {
        let elem = jQuery('#up');
        if( elem.length > 0 ) {
            let pid = elem.attr('data-id');
            if( parseInt(pid) > 0 ) {
                let vote = JSON.parse(sessionStorage.getItem('vote-'+pid));
                if( vote ) { 
                    jQuery('#new-vote').hide();
                    jQuery('#voted').show();
                    jQuery('#up, #down').removeClass('voted');
                    jQuery('#'+vote.userVoted).addClass('voted');
                    jQuery('#vote-up-label').html(vote.percentageUp+'%');
                    jQuery('#vote-down-label').html(vote.percentageDown+'%');
                    jQuery('#up, #down').attr('disabled', 'disabled');
                }
            }
        }
    }
}