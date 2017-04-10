
$( "form[name=tv_chefbundle_search]" ).submit(function(e) {
    e.preventDefault();
    $('#recipes-container').html('<img class="loading" src="' + url + '">');
    var form = this;
    var FD  = new FormData(form);

    var oReq2 = new XMLHttpRequest();
    oReq2.timeout = 10000;

    oReq2.addEventListener("load", function(event) {
        $('#recipes-container').html(event.target.responseText);
    });

    // We define what will happen in case of error
    oReq2.addEventListener("error", function(event) {
        console.log(event.target); 
    console.log('Oups! Something goes wrong.');
    });

    console.log($(form).attr('action'));

    oReq2.open("post",  $(form).attr('action'));
    oReq2.send(FD);

});