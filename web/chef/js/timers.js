function get_elapsed_time_string(total_seconds) {
    function pretty_time_string(num) {
        return ( num < 10 ? "0" : "" ) + num;
    }	

    var hours = Math.floor(total_seconds / 3600);
    total_seconds = total_seconds % 3600;

    var minutes = Math.floor(total_seconds / 60);
    total_seconds = total_seconds % 60;

    var seconds = Math.floor(total_seconds);

    hours = pretty_time_string(hours);
    minutes = pretty_time_string(minutes);
    seconds = pretty_time_string(seconds);

    var currentTimeString = hours + ":" + minutes + ":" + seconds;

    return currentTimeString;
}

var isPaused = true;
//var timerLength = $(this).data('timer-seconds');


//console.log(timerLength);
//$('.timer').text(get_elapsed_time_string());

//var timer = setInterval(function() {
//    if (timerLength !== 0 && !isPaused){
//        --timerLength;
//        console.log(timerLength);
//        $('.timer.playing').text(get_elapsed_time_string(timerLength));
//    }
//}, 1000);

function launchTimer(){
    //console.log('se',seconds);
    timer = setInterval(function() {
        
            $('.btn-timer.played').each(function(){
                var seconds = $(this).next('p').attr('data-timer-seconds');
                console.log(seconds)
                if (!$(this).hasClass('paused') && seconds >0){
                    seconds--;
                    $(this).next('p')
                        .text(get_elapsed_time_string(seconds))
                        .attr('data-timer-seconds',seconds)

                    ;
            }
            })
        
        }, 1000);
}

$(function(){
    launchTimer();
    $('.btn-timer').each(function(){
           $(this).next('p').text(get_elapsed_time_string($(this).next('p').data('timer-seconds')));
    });
    $('.btn-timer').click(function(e) {

        $(this).next('.timer').toggleClass('playing');
        if ($(this).hasClass("paused")){
                $(this).removeClass("paused").addClass("played");
                $(this).removeClass("fa-play-circle").addClass("fa-pause-circle");
                e.preventDefault();
        }
        else if ($(this).hasClass("played")){
                $(this).removeClass("played").addClass("paused");
                $(this).removeClass("fa-pause-circle").addClass("fa-play-circle");
                e.preventDefault();
        }
        
    });
})