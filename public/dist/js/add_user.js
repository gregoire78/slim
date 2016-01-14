/**
 * Created by Grégoire on 06/08/2015.
 */
$(document).ready(function($){
    $(":input").inputmask();  //static mask

    var form_group_id = {
        'firstname' : 'form-firstname',
        'lastname' : 'form-lastname',
        'email' : 'form-email',
        'street' : 'form-street',
        'city' : 'form-city',
        'postalCode' : 'form-postalcode',
        'phone' : 'form-phone',
        'group' : 'form-group'
    };

    // verifications en direct
    $(".form-control").on("change keyup", function (e) {
        //console.log(e.target.id, e.target.parentElement.id);
        bootstrap_alert.reset(e.target.parentElement.id);
    });

    /**
     * fonction affichage des erreurs json AJAX
     * utlise bootstrapfeed_back.js
     * @param message
     * @param form_group_id
     */
    var jsonFeedback = function (message, form_group_id) {
        if(message != null)
        {
            bootstrap_alert.error(form_group_id, message);
        }else{bootstrap_alert.reset(form_group_id);}
    };

    bootstrap_alert();
    $('#add_user').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        $form.find('button[type=submit]').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;&nbsp;&nbsp;Chargement ...');

        $.ajax({data:  $form.serializeArray(),type: 'POST', dataType:'json',cache : false})
            .always(function (){
                $form.find('button[type=submit]').text('Enregistrer');
                //$form.find('#message').val('');
            })
            .done(function(data, textStatus, jqXHR){
                console.log(jQuery.parseJSON(jqXHR.responseText));
                if(data['errors'] != undefined) {
                    $.each(data['errors'], function (key, val) {
                        jsonFeedback(val, form_group_id[key]);
                    });
                }
                else
                {
                    var type;
                    var title;
                    if(data["success"] != undefined){ type = 'success'; title = data["success"] }
                    else if(data["info"] != undefined){ type = 'info'; title = data["info"] }
                    swal({
                            //title: "Good Job !",
                            title: title,
                            type: type,
                            showCancelButton: false,
                            confirmButtonClass: "btn-default",
                            confirmButtonText: "Ok",
                            closeOnConfirm: true
                        },
                        function(){
                            if(data["urlRedirect"] != undefined) {
                                window.location.href = data["urlRedirect"];
                            }
                        });
                    /*setTimeout(function(){
                     swal.close();
                     if(data["urlRedirect"] != undefined) {
                     window.location.href = data["urlRedirect"];
                     }}, 5000);*/
                }
            })
            .fail(function (jqXHR, textStatus){
                //alert(jqXHR.responseJSON['error']);
                console.log(jqXHR);
            })
    }).on("reset", function () { // reset le formulaire
        bootstrap_alert.reset(form_group_id, true)
    });
});
