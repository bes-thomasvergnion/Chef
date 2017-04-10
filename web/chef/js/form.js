$(document).ready(function() {

    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#tv_chefbundle_recipe_steps');
    var $container2 = $('div#tv_chefbundle_recipe_ingredients');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;
    var index2 = $container2.find(':input').length;

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#add_step').click(function(e) {
        addStep($container);

        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    $('#add_ingredient').click(function(e) {
        addIngredient($container2);

        e.preventDefault();
        return false;
    });

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
    if (index === 0) {
        addStep($container);
    } else {
        // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
        $container.children('div').each(function() {
            addDeleteLink($(this));
        });
    }
    
    if (index2 === 0) {
        addIngredient($container2);
    } else {
        $container2.children('div').each(function() {
            addDeleteLink2($(this));
        });
    }

    // La fonction qui ajoute un formulaire CategoryType
    function addStep($container) {
        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var template = $container.attr('data-prototype')
            .replace(/__name__label__/g, 'Etape n°' + (index+1))
            .replace(/__name__/g,        index)
        ;

        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);

        // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
        addDeleteLink($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;
    }
    
    function addIngredient($container2) {
        var template = $container2.attr('data-prototype')
            .replace(/__name__label__/g, 'Ingrédient n°' + (index2+1))
            .replace(/__name__/g,        index2)
        ;

        var $prototype2 = $(template);
        addDeleteLink2($prototype2);
        $container2.append($prototype2);
        index2++;
    }

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLink($prototype) {
        // Création du lien
        var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');

        // Ajout du lien
        $prototype.append($deleteLink);

        // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
        $deleteLink.click(function(e) {
            $prototype.remove();
            index--;
            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
    }

    function addDeleteLink2($prototype) {

        var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');

        $prototype.append($deleteLink);

        $deleteLink.click(function(e) {
            $prototype.remove();
            index2--;
            e.preventDefault();
            return false;
        });
    }
});
