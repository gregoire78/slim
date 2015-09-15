/**
 * Created by gregoire on 14/09/2015.
 */
$(document).ready(function($){
    $('.table > tbody > tr').click(function() {
        if(this.id){
            window.location.href = url[this.id]
        }
    });
});
