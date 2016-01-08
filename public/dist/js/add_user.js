/**
 * Created by Grégoire on 06/08/2015.
 */
$(document).ready(function($){

    var champs = ['firstname', 'lastname', 'email', 'stree', 'city', 'postalcode', 'phone', 'group'];
    var champs_json = {
        'firstname' : $('#firstname'),
        'lastname': $('#lastname'),
        'email' : $('#email'),
        'street' : $('#street'),
        'city' : $('#city'),
        'postalcode' : $('#postalCode'),
        'phone' : $('#phone'),
        'group' : $('#group')
    };


    //initiation variable FORM_GROUP_ID
    var form_firstname = 'form-firstname';
    var form_lastname = 'form-lastname';
    var form_email = 'form-email';
    var form_street = 'form-street';
    var form_city = 'form-city';
    var form_postalcode = 'form-postalcode';
    var form_phone = 'form-phone';
    var form_group = 'form-group';

    //initiation variable selector INPUT
    var firstname = champs_json.firstname;
    var lastname = champs_json.lastname;
    var email = champs_json.email;
    var street = champs_json.street;
    var city = champs_json.city;
    var postalcode = champs_json.postalcode;
    var phone = champs_json.phone;
    var group = champs_json.group;

    /**
     * function de vérification with bind
     * @param selector
     * @param form_group_id
     * @param opt
     */
    var liveVerification = function (selector, form_group_id, opt) {
        opt = opt || {event:"keyup"};
        selector.bind(opt.event, function () {
            bootstrap_alert.reset(form_group_id);
        });
    };

    var jsonFeedback = function (errors_tab, form_group_id) {
        if(errors_tab != null)
        {
            bootstrap_alert.error(form_group_id, errors_tab);
        }else{bootstrap_alert.reset(form_group_id);}
    };

    // verifications en direct
    liveVerification(firstname,form_firstname);
    liveVerification(lastname, form_lastname);
    liveVerification(email, form_email);
    liveVerification(street, form_street);
    liveVerification(city, form_city);
    liveVerification(postalcode, form_postalcode);
    liveVerification(phone, form_phone, {event:"keyup"});
    liveVerification(group, form_group, {event:"change"});

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
                    var errors = data['errors'];
                    jsonFeedback(errors['firstname'], form_firstname);
                    jsonFeedback(errors['lastname'], form_lastname);
                    jsonFeedback(errors['email'], form_email);
                    jsonFeedback(errors['street'], form_street);
                    jsonFeedback(errors['city'], form_city);
                    jsonFeedback(errors['postalCode'], form_postalcode);
                    jsonFeedback(errors['phone'], form_phone);
                    jsonFeedback(errors['group'], form_group);

                    //var errr = "";
                    //$.each(data['errors'], function (key, val) {
                    //    errr += val + '\n';
                    //});
                    //alert(errr);
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
        bootstrap_alert.reset(form_firstname);
        bootstrap_alert.reset(form_lastname);
        bootstrap_alert.reset(form_email);
        bootstrap_alert.reset(form_street);
        bootstrap_alert.reset(form_city);
        bootstrap_alert.reset(form_postalcode);
        bootstrap_alert.reset(form_phone);
        bootstrap_alert.reset(form_group);
    });
});
