/*$(document).ready(function() {
    var styles = {
        "width": $('#home-suggestions').width() * $('#home-types li').size()
    };
    $("#home-suggestions-content").css(styles);
    var styles = {
        "width": $('#home-suggestions').width()
    };
    $("#home-suggestions-content > li").css(styles);

    $('#home-types li').not('.desactivated').on('click', function() {
        $('#home-types li').removeClass('selected');
        $(this).addClass('selected');
        var translate = $('#home-suggestions').width() * $(this).index();
        var styles = {
            'transform': 'translate(-' + translate + 'px, 0px)',
            '-ms-transform': 'translate(-' + translate + 'px, 0px)',
            '-moz-transform': 'translate(-' + translate + 'px, 0px)'
        };
        //$("#home-suggestions-content").css(styles);
    });
 
    $( "#detail-tabs" ).tabs();
    $( "#gallery-tabs" ).tabs();
    
    
});
jQuery(document).ready(function($) {
  jQuery.rsCSS3Easing.easeOutBack = 'cubic-bezier(0.175, 0.885, 0.320, 1.275)';
  $('#home-suggestions').royalSlider({
    arrowsNav: true,
    arrowsNavAutoHide: false,
    keyboardNav:false,
    fadeinLoadedSlide: false,
    controlNavigationSpacing: 0,
    controlNavigation: 'bullets',
    imageScaleMode: 'none',
    imageAlignCenter:false,
    blockLoop: true,
    loop: true,
    allowCSS3: true, 
    autoHeight:true,
    numImagesToPreload: 6,
    transitionType: 'move',
    keyboardNavEnabled: true,
    block: {
      delay: 10
    }
    ,autoPlay: {
    		// autoplay options go gere
    		enabled: true,
    		pauseOnHover: true,
                delay:3000
    	}
  });
});
*/