/**
 * Created by gregoire on 31/08/2015.
 */

// fonction permettent un affichage dynamique des erreurs bootstrap
bootstrap_alert = function() {$(".has-feedback").each(function () {
    $(this).append('<span class="iconStatus glyphicon form-control-feedback" aria-hidden="true"></span>')
})};
bootstrap_alert.error = function(formgrput,message,trigger) {
    trigger = trigger || "focus, hover";
    $("#"+formgrput).addClass('has-error').removeClass('has-warning').removeClass('has-success').find('input, iframe, select').popover({
        trigger:trigger,
        html:true,
        container:"#"+formgrput,
        content:'<small>' + message + '</small>',
        placement:"bottom",
        template: '<div class="popover noselect popError" role="tooltip"><div class="arrow"></div><!--<h3 class="popover-title"></h3>--><div class="popover-content"></div></div>',
    }).popover('show');

    $("#"+formgrput+" > .iconStatus").addClass('glyphicon-remove').removeClass('glyphicon-ok');

    $("button[type=submit]").removeClass("btn-primary").removeClass("btn-warning").addClass("btn-danger");
};
bootstrap_alert.warning = function(formgrput,message,trigger) {

    // module popover bootstrap pour afficher les erreurs
    trigger = trigger || "focus, hover";
    $("#"+formgrput).addClass('has-warning').removeClass('has-error').removeClass('has-success').find('input, iframe, select').popover({
        trigger:trigger,
        html:true,
        container:"#"+formgrput,
        content:'<small>' + message + '</small>',
        placement:"bottom",
        template: '<div class="popover noselect popWarning" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    }).popover('show');

    // feedback bootstrap pour le groupe input
    $("#"+formgrput+" > .iconStatus").addClass('glyphicon-ok').removeClass('glyphicon-remove'); // glyphicon pour l'input

    // boutton submit
    $("button[type=submit]").removeClass("btn-primary").removeClass("btn-danger").addClass("btn-warning");
};
bootstrap_alert.reset = function(formgrput, all) {
    all = all || false;
    if(all === true) {
        $.each(formgrput, function (key, val) {
            $("#"+val).removeClass('has-error').removeClass('has-warning').removeClass('has-success').find('input, iframe, select').popover('destroy');
            $("#"+val+" > .iconStatus").removeClass('glyphicon-remove').removeClass('glyphicon-ok');
        });
    } else {
        $("#"+formgrput).removeClass('has-error').removeClass('has-warning').removeClass('has-success').find('input, iframe, select').popover('destroy');
        $("#"+formgrput+" > .iconStatus").removeClass('glyphicon-remove').removeClass('glyphicon-ok');
    }

    $("button[type=submit]").removeClass("btn-danger").removeClass("btn-warning").addClass("btn-primary");
};
