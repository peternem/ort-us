jQuery(document).ready(function() {
	jQuery('#slides').maximage({
    fillElement: '#wrapper',
    cycleOptions: {
      speed: 2000,
      timeout: 8000
    }
  });

  // Poor man's BigTarget
//	jQuery('#teaser_boxes .box').on('click', function(e){
//    e.preventDefault();
//    window.location = $(e.delegateTarget).find('a').attr('href');
//  });
});

