window.onload = function() {
    if ( window.jQuery ) {  
        // jQuery is loaded  
        jQuery( document ).on( 'click', '#findco-vote button', function( e ) {
            e.preventDefault();
            let pid = jQuery(this).attr('data-id');
            let vote = jQuery(this).attr('data-action');
            
            if( parseInt( pid ) > 0 && vote != "" ) {

                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : fvc_object.ajax_url,
                    data : { action: "vote_article", post_id : pid, vote: vote,  nonce: fvc_object.nonce },
                    success: function(response) {
                       if(response.result.type == "success") {
                          console.log(response);
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
}