var liste = function(requete, reponse){
    var motcle = $('#tv_chefbundle_search_value').val();
    var DATA = 'motcle=' + motcle;
    $.ajax({
        type:"POST",
        url : path,
        dataType : 'json',
        data : DATA,

        success : function(donnee){
            reponse($.map(donnee, function(objet){
                return objet;
            }));
        }
    });
}    

$('#tv_chefbundle_search_value').autocomplete({
    source : liste,
    minLength : 2
});
