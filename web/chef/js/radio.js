$(document).ready(function(){   
    $('.btn-video').click(function(e){
        $(this).removeAttr('checked');
        $('.box-video').removeClass('disable');
        $('.box-video').addClass('active');
        $('.box-img').removeClass('active');
        $('.box-img').addClass('disable');
        e.preventDefault();
    });
    
    $('.btn-img').click(function(e){
        $('.box-img').removeClass('disable');
        $('.box-img').addClass('active');
        $('.box-video').removeClass('active');
        $('.box-video').addClass('disable');
        e.preventDefault();
    });
});
