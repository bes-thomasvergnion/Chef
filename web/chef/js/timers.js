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

var elapsed_seconds = 20;
var isPaused = true;

var timer = setInterval(function() {
	if (elapsed_seconds != 0 && !isPaused){
		--elapsed_seconds;
		console.log(elapsed_seconds);
		$('.timer.playing').text(get_elapsed_time_string(elapsed_seconds));
	}
}, 1000);

$('.btn-timer').click(function(e) {
	$(this).next('.timer').toggleClass('playing');
	if ($(this).hasClass("paused")){
		$(this).removeClass("paused").addClass("played");
		$(this).removeClass("fa-play-circle").addClass("fa-pause-circle");
		e.preventDefault();

  		isPaused = false;
	}
	else if ($(this).hasClass("played")){
		$(this).removeClass("played").addClass("paused");
		$(this).removeClass("fa-pause-circle").addClass("fa-play-circle");
		e.preventDefault();
		isPaused = true;
	}
	
});