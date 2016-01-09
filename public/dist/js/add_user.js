/**
 * Created by Grégoire on 06/08/2015.
 */
$(document).ready(function($){

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

    /**
     * function de vérification with bind
     * @param form_group_id
     * @param opt
     */
    var liveVerification = function (form_group_id, opt) {
        opt = opt || {event:"keyup"};
        $("#"+form_group_id+" > input").bind(opt.event, function () {
            bootstrap_alert.reset(form_group_id);
        });
    };

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

    // verifications en direct
    liveVerification(form_group_id.firstname);
    liveVerification(form_group_id.lastname);
    liveVerification(form_group_id.email);
    liveVerification(form_group_id.street);
    liveVerification(form_group_id.city);
    liveVerification(form_group_id.postalCode);
    liveVerification(form_group_id.phone);
    liveVerification(form_group_id.group, {event:"change"});

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
                /*var responseText = jQuery.parseJSON(jqXHR.responseText);
                console.log(responseText);
                if(jqXHR.responseJSON['errors']['firstname'] != null)
                {
                    bootstrap_alert.error(form_firstname, jqXHR.responseJSON['errors']['firstname']);
                }else{bootstrap_alert.reset(form_firstname);}
                if(jqXHR.responseJSON['errors']['lastname'] != null)
                {
                    bootstrap_alert.error(form_lastname, jqXHR.responseJSON['errors']['lastname']);
                }else{bootstrap_alert.reset(form_lastname);}
                if(jqXHR.responseJSON['errors']['email'] != null)
                {
                    bootstrap_alert.error(form_email, jqXHR.responseJSON['errors']['email']);
                }else{bootstrap_alert.reset(form_email);}
                if(jqXHR.responseJSON['errors']['street'] != null)
                {
                    bootstrap_alert.error(form_street, jqXHR.responseJSON['errors']['street']);
                }else{bootstrap_alert.reset(form_street);}
                if(jqXHR.responseJSON['errors']['city'] != null)
                {
                    bootstrap_alert.error(form_city, jqXHR.responseJSON['errors']['city']);
                }else{bootstrap_alert.reset(form_city);}
                if(jqXHR.responseJSON['errors']['postalCode'] != null)
                {
                    bootstrap_alert.error(form_postalcode, jqXHR.responseJSON['errors']['postalCode']);
                }else{bootstrap_alert.reset(form_postalcode);}
                if(jqXHR.responseJSON['errors']['phone'] != null)
                {
                    bootstrap_alert.error(form_phone, jqXHR.responseJSON['errors']['phone']);
                }else{bootstrap_alert.reset(form_phone);}
                if(jqXHR.responseJSON['errors']['group'] != null)
                {
                    bootstrap_alert.error(form_group, jqXHR.responseJSON['errors']['group']);
                }*/
            })
    }).on("reset", function () { // reset le formulaire
        bootstrap_alert.reset(form_group_id, true)
    });
});
