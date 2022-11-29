$(document).ready(function() {
    jQuery('#btn-add').click(function() {
        jQuery('#callMangaAjax').val("add");
    });
    $("#callMangaAjax").click(function(e){
        e.preventDefault();
        let uneUrl = 'http://localhost/hbela/ProjetMangas/public/callMangaAjax/' +
            $('#genre option:selected').val();
        $.ajax({
            type: 'GET',
            url : uneUrl,
            success: function (data) {
                $("#resultat").html(data);
            },
            error: function (data) {
                alet('erreur :'+'callMangaAjax/'+$('#genre option:selected'). val());
            }

        }
        );
    });
});
