/**
 * Created by Grégoire on 06/08/2015.
 */
$(document).ready(function($){

    var form_firstname = 'form-firstname';
    var form_lastname = 'form-lastname';
    var form_email = 'form-email';
    var form_street = 'form-street';
    var form_city = 'form-city';
    var form_postalcode = 'form-postalcode';
    var form_phone = 'form-phone';
    var form_group = 'form-group';

    var firstname = $('#firstname');
    var lastname = $('#lastname');
    var email = $('#email');
    var street = $('#street');
    var city = $('#city');
    var postalcode = $('#postalCode');
    var phone = $('#phone');
    var group = $('#group');

    // verifications en direct
    firstname.bind("keyup", function () {
        bootstrap_alert.reset(form_firstname);
    });
    lastname.bind("keyup", function () {
        bootstrap_alert.reset(form_lastname);
    });
    email.bind("keyup", function () {
        bootstrap_alert.reset(form_email);
    });
    street.bind("keyup", function () {
        bootstrap_alert.reset(form_street);
    });
    city.bind("keyup", function () {
        bootstrap_alert.reset(form_city);
    });
    postalcode.bind("keyup", function () {
        bootstrap_alert.reset(form_postalcode);
    });
    phone.bind("keyup", function () {
        bootstrap_alert.reset(form_phone);
    });
    group.on('change', function () {
        bootstrap_alert.reset(form_group)
    });

    bootstrap_alert();
    $('#add_user').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        $form.find('button[type=submit]').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;&nbsp;&nbsp;Chargement ...');

        $.ajax($form.attr('action'), {data:  $form.serializeArray(),type: 'POST', dataType:'json'})
            .always(function (){
                $form.find('button[type=submit]').text('Enregistrer');
                //$form.find('#message').val('');
            })
            .done(function(data, textStatus, jqXHR){
                //alert(data["success"]);
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
            })
            .fail(function (jqXHR, textStatus){
                //alert(jqXHR.responseJSON['error']);
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
                }
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
