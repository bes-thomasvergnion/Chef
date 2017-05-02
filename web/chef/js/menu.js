$(document).ready(function(){
    $('#user_name').click(function(e){
        $('.menu_connexion').toggleClass('active');
        e.preventDefault();
    });
});
$(document).mouseup(function (e){
    var container = $(".active");
    if (container.has(e.target).length === 0)
        container.removeClass('active');
    e.preventDefault();
});