jQuery(document).on('ready', function(){
  /* Classy Student Steps Start */
  jQuery('.js-student-step').each(function(index){
    var iClass = jQuery(this).find('p').find('a').html();
    var icon = document.createElement("i");
    jQuery(icon).addClass(iClass);
    jQuery(this).find('p').find('a').html(icon);
  });
  /* Classy Student Steps End */

  /* Header Eyecatcher Responsive Homepage Start */
  if(jQuery(window).width() <= 991) {
    var headerEyecatcher = jQuery('.header-eyecatcher');
    headerEyecatcher.addClass('header-eyecatcher-image');
    headerEyecatcher.addClass('header-eyecatcher-image-default');
    headerEyecatcher.html('<div class="row d-flex justify-content-start align-items-end"><div class="col-12 mb-5"><img class="img-fluid" src="themes/custom/bethelks/images/connectToPurpose.png" alt="Connect To Purpose"></div></div>');
  }
  else {
    var headerEyecatcher = jQuery('.header-eyecatcher');
    headerEyecatcher.html('<div class="header-eyecatcher-video"><video autoplay loop muted><source src="themes/custom/bethelks/VideoHeader.mp4" type="video/mp4"></video></div>');
  }

  if(jQuery('.header-eyecatcher').find('video').length) {
    jQuery('.header-eyecatcher').find('video').on('click', function(e){
      e.preventDefault();
      if(jQuery(this).get(0).paused) {
        jQuery(this).get(0).play();
      }
      else {
        jQuery(this).get(0).pause();
      }
    });
  }
  /* Header Eyecatcher Responsive Homepage End */

  /* Event Carousel Start */
  jQuery('.owl-carousel').owlCarousel({
    items: 6,
    loop: true,
    nav: false,
    dots: false,
    autoplay: true,
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
    navText: [
      '<',
      '>'
    ],
    margin: 0,
    responsive: {
      0: {
        items: 1,
        margin: 0,
        nav: true,
        dots: false,
        autoplayHoverPause: false
      },
      767: {
        items: 3,
        nav: true,
        dots: false,
        autoplayHoverPause: false
      },
      991: {
        items: 4
      },
      1199: {
        items: 5
      }
    }
  });
  /* Event Carousel End */

  /* Homepage Recent News Start */
  jQuery('.js-home-recent-news').each(function(index){
    var overlayColors = ['#9b9740', '#de413a', '#3c8e96', '#7a7a7a'];

    //jQuery(this).append('<center><a href="#" class="recent-news-more-news">More News</a></center>');

    jQuery(this).find('.homepage-featured-news-view').each(function(i){
      if(i == 1) {
        jQuery(this).find('.featured-news-tb-wrapper').addClass('order-12');
        jQuery(this).find('.featured-news-img-wrapper').addClass('order-1');
      }

      jQuery(this).find('.featured-news-tb-wrapper').css('background-color', overlayColors[Math.floor(Math.random()*overlayColors.length)]);
    });
  });
  /* Homepage Recent News End */

  /* All Aboard Bethel Start */
  var categories = ["introduction", "admissions", "financial-aid", "student-experience", "careers"];
  var videos = [
    [
      categories[0],
      [
        "dDg_Pj97qPQ"
      ]
    ],
    [
      categories[1],
      [
        "-_bnjCLYwEU",
        "yXMv2f16974",
        "o7_09j3O_h8",
        "bWP1pLFWW_s",
        "9eeIZ3zPQu0",
        "cmCZHO8mAAU",
        "pWf-P2RK40g",
        "iQdH79N-KRk",
        "0YHv8lF2Vx0",
        "I8HCZ_SIZb8",
        "Vw8D1Vflj6w",
        "51keumHEL4o",
        "iMwcjz0baPU",
        "MP10T2G_A3g",
        "IvVI3mBcDp4",
        "WaUbevaV4cI"
      ]
    ],
    [
      categories[2],
      [
        "n8CUC1ArPm0",
        "iB-Rfmq98iU",
        "ms5kXbvYE48",
        "hjQOZ3o6pQM"
      ]
    ],
    [
      categories[3],
      [
        "lIkLrW29L-s",
        "IOJAIoUpes0",
        "mef20IwgLDY",
        "4wwLRxLNIvU",
        "qvvSulomSV0",
        "4eGFaG8CDxw",
        "lfylpPWvsic",
        "U43fHXhLCDs",
        "QubBtdqepoI",
        "E1cGE79-xrE",
        "CItcAz93Ne8",
        "v7qP0z1XcgY",
        "IVer64Dd6u0",
        "P9olS0b6gww"
      ]
    ],
    [
      categories[4],
      [
        "fOCVBjoG9Jo",
        "sDhq_tfCIlk"
      ]
    ]
  ];

  /* Videos Array Schema */
  /*
    var videos = [
      [videoCategory, [videoId, videoId, ...]],
      [videoCategory, [videoId, videoId, ...]],
      ...
    ];
  */

  if(jQuery('.all-aboard-content').length) {
    var grid = jQuery('.all-aboard-content > div');

    grid.isotope({
      itemSelector:'.all-aboard-video',
      layoutMode:'fitRows'
    });

    for(var i = 0; i < videos.length; i++) {
      var currentCategory = videos[i][0];
      for(var x = 0; x < videos[i][1].length; x++) {
        var currentVideoId = videos[i][1][x];

        var colWrapper = document.createElement('div');
        var thumbnail = document.createElement('img');
        var controls = document.createElement('ul');
        var titleDescOverlay = document.createElement('div');

        var overlayColors = ['#eeb111', '#9b9740', '#de413a', '#3c8e96', '#7a7a7a'];

        jQuery.ajax({
          'async': false,
          'global': false,
          'url': 'https://www.googleapis.com/youtube/v3/videos?id=' + currentVideoId + '&key=AIzaSyCPquSRxqsHEuRpI9-mYMYfQcv_dpM2_0E&part=snippet',
          'dataType': "json",
          'success': function(data) {
            jQuery(titleDescOverlay).html('<h3>' + data.items[0].snippet.title + '</h3>');
            jQuery(thumbnail).attr('src', data.items[0].snippet.thumbnails.maxres.url);
            jQuery(controls).attr('data', data.items[0].snippet.title);
          },
          'error': function(err) {
            jQuery(titleDescOverlay).html('<h3>Error</h3>');
          }
        });

        jQuery(thumbnail).addClass('all-aboard-img img-fluid');
        jQuery(titleDescOverlay).addClass('all-aboard-title-desc-overlay d-flex justify-content-center align-items-center').css('background-color', overlayColors[Math.floor(Math.random()*overlayColors.length)]);
        jQuery(controls).addClass('all-aboard-video-controls').html('<li data="' + currentVideoId + '" class="all-aboard-video-controls-view"><i class="fa fa-eye" aria-hidden="true"></i></li>');
        jQuery(controls).append('<li class="all-aboard-video-controls-link"><a target="_blank" href="https://www.youtube.com/watch?v=' + currentVideoId + '"><i class="fa fa-link" aria-hidden="true"></i></a></li>');
        jQuery(colWrapper).addClass('col-12 col-md-6 col-lg-4 col-xl-3 all-aboard-video').addClass('ab-filter-' + currentCategory).html(thumbnail).append(controls).append(titleDescOverlay);
        grid.append(colWrapper).isotope('appended', colWrapper);
        grid.isotope({ filter: '.ab-filter-financial-aid' });
      }
    }

    jQuery('.all-aboard-video').hover(function(){
      jQuery(this).find('.all-aboard-video-controls').fadeIn();
    }, function(){
      jQuery(this).find('.all-aboard-video-controls').fadeOut();
    });

    jQuery('.all-aboard-video-controls .all-aboard-video-controls-view').on('click', function(e){
      e.preventDefault();
      var title = jQuery(this).parent().attr('data');

      jQuery('#all-aboard-viewbox').find('.modal-body').html('<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' + jQuery(this).attr('data') + '" allowfullscreen></iframe></div>');
      jQuery('#all-aboard-viewbox').find('.modal-header h5').text(title);
      jQuery("#all-aboard-viewbox").modal();
    });

    jQuery('.all-aboard-video').on('click', function(e) {
      e.preventDefault();
      var title = jQuery(this).find('.all-aboard-video-controls').attr('data');
      var loc = jQuery(this).find('.all-aboard-video-controls-view').attr('data');

      jQuery('#all-aboard-viewbox').find('.modal-body').html('<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' + loc + '" allowfullscreen></iframe></div>');
      jQuery('#all-aboard-viewbox').find('.modal-header h5').text(title);
      jQuery("#all-aboard-viewbox").modal();
    });

    jQuery('.all-aboard-controls button').on('click', function(e){
      e.preventDefault();

      jQuery('.all-aboard-controls button').each(function(index) {
        if(jQuery(this).hasClass('active-filter')) jQuery(this).removeClass('active-filter');
      });
      jQuery(this).addClass('active-filter');

      var selector = jQuery(this).attr('data-filter');
      grid.isotope({
        filter: selector,
        animationOptions: {
          duration: 750,
          easing: "linear",
          queue: false
        }
      });
    });
  }
  /* All Aboard Bethel End */

  /* Homepage Location Map Start */
  jQuery('.js-location-map').each(function(index){
    var active = false;
    var imgDiv = jQuery(this).find('img').parent().parent().parent();
    imgDiv.html('<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3140.7915447772607!2d-97.34600988455563!3d38.07523550258839!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87bb135af58a1f63%3A0xca6979b523a4e897!2sBethel+College!5e0!3m2!1sen!2sus!4v1504209031579" width="100%" height="400px" frameborder="0" style="border:0" allowfullscreen></iframe>');

    imgDiv.hide();
    jQuery(this).find('h2').parent().append('<i class="fa fa-angle-down"></i>');

    jQuery(this).find('h2').parent().hover(function(e){
      if(!active) jQuery(this).find('i').fadeIn();
    }, function(e){
      if(!active) jQuery(this).find('i').fadeOut();
    });

    jQuery(this).find('h2').parent().on('click', function(){
      var _this = this; //this scope
      if(active) {
        imgDiv.fadeOut(400, function(){
          jQuery(_this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down').hide();
        });
      }
      else {
        imgDiv.fadeIn();
        jQuery(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up').show();
      }

      active = !active;
    });
  });
  /* Homepage Location Map End */

  /* Homepage Prefooter Social Media Icons Start */
  jQuery('.homePreFooter ul li').each(function(index){
    var iClass = jQuery(this).find('a').html();
    var icon = document.createElement('i');
    jQuery(icon).addClass(iClass);
    jQuery(this).find('a').html(icon);
  });
  /* Homepage Prefooter Social Media Icons End */

  /* Recent Headlines Homepage Footer Start */
  jQuery('.js-recent-headlines-homepage-footer').each(function(i){
    jQuery(this).find('img').addClass('img-fluid rounded-circle');
  });
  /* Recent Headlines Homepage Footer End */

  // Fixes layout issue in chrome
  setTimeout(function(){
    grid.isotope({filter: '.ab-filter-financial-aid'});
  }, 1250);
});
