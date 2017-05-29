$(function(){   
    $( "form[name=tv_chefbundle_filter]" )
        .submit(function(e) {
            e.preventDefault();
            $('#recipes-container').html('<img class="loading" src="' + url + '">');
            var form = this;
            var FD  = new FormData(form);
            
            var oReq2 = new XMLHttpRequest();
            oReq2.timeout = 10000;

            oReq2.addEventListener("load", function(event) {
                $('#recipes-container').html(event.target.responseText);
                listenPagination();
            });

            // We define what will happen in case of error
            oReq2.addEventListener("error", function(event) {
                console.log(event.target); 
                console.log('Oups! Something goes wrong.');
            });

            oReq2.open("post",  $(form).attr('data-action'));
            oReq2.send(FD);

        })
        .trigger('submit')
        .find('select').on('change',function(){
            $(this).closest('form').trigger('submit');
        })
    ;
});

function listenPagination(){
    $('.pagination a').on('click',function(e){
        e.preventDefault();
        
        var page = $(this).text();
        var action =$( "form[name=tv_chefbundle_filter]" )
            .attr('action') + '?page='+page;
        $( "form[name=tv_chefbundle_filter]" )
            .attr('data-action',action)
            .trigger('submit');
        
    });
}