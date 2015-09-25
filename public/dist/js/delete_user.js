/**
 * Created by gregoire on 16/09/2015.
 */
$(document).ready(function($){
    $('.btn-danger').on('click', function(e){
        e.preventDefault();
        var $a = $(this);
        var url = $a.attr('href');
        var user = $a.data('user');

        swal({
            title: "Supprimer " + user + " ?",
            text: "Vous ne pourrez plus revenir en arrière !",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OUI, avec plaisir !",
            closeOnConfirm: false
        },
        function(){
            $.ajax(url, {type: 'GET'})
                .always(function () {

                })
                .done(function(data, textStatus, jqXHR){
                    $a.parents('tr').fadeOut();
                    swal("Supprimé !", "L'utilisateur " + user + " à bien été supprimé", "success");
                })
                .fail(function () {

                })
        });
    })
});