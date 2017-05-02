$(document).ready(function(){
    $('#btn-recipes').click(function(e){
        $('.my-recipes').toggleClass('active');
        e.preventDefault();
    });
});
