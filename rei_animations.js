//Using Jquery to animate Form Details by boxes.


// animated.fadetoggle.
// 1.fadetoggle
// animated.toggleclass animated
// 1.toggleclass animated
document.addEventListener('DOMContentLoaded', function() {
    changeDraw('#details_1', '.detail-draw');
},false);

$( ".detail-draw" ).click(function() {
    changeDraw('#details_1', '.detail-draw');
});

$( ".fabric-draw, .next_1" ).click(function() {
    changeDraw('#fabric_2', '.fabric-draw');
});

$( ".hem-draw, .next_2" ).click(function() {
    changeDraw('#hem_3', '.hem-draw');
});

$( ".drive-draw, .next_3" ).click(function() {
    changeDraw('#drive_4', '.drive-draw');
});

$( ".valance-draw, .next_4" ).click(function() {
    changeDraw('#valance_5', '.valance-draw');  
});

$( ".mount-draw, .next_5" ).click(function() {
    changeDraw('#mount_6', '.mount-draw');    
});

$( ".adv-draw, .next_6" ).click(function() {
    changeDraw('#sg_adv_7', '.adv-draw');    
});




function changeDraw(id, draw){
    $( ".animated" ).fadeToggle( "fast", "linear" );
    $( id ).fadeToggle( "fast", "linear" );

    $('.animated').toggleClass('animated');
    $( id ).toggleClass('animated');

    $('.summary-active').toggleClass('summary-active');
    $(draw +' > .summary-label').toggleClass('summary-active');

    // alert('In ' +id +' draw');
}