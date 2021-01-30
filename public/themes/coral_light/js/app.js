function toggleScreenSpinner($status = true)
{
    if($status === true){
        $('.screen-spinner').fadeIn();
    }else {
        $('.screen-spinner').fadeOut();
    }
}
$('.pagination').addClass('uk-pagination').addClass('uk-flex-center');

$('.top-menu-login').click(function () {
    UIkit.modal('#login-modal').show();
});
function enableLoadingSpinner($status = true) {
    if($status === true){
        $('.loading-screen-spinner').fadeIn();
    } else{
        $('.loading-screen-spinner').fadeOut();
    }
}

// play marker audio auto
function playMarkerFirstMedia(event){
    $('.audio-file').each(function(){
        this.pause(); // Stop playing
        this.currentTime = 0; // Reset time
    });
    var marker = $(event).closest('.pb-hotspot-marker');
    var audio = marker.find('.audio-file')[0];
    audio.play();
}