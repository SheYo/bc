jQuery(document).on('ready', function(){
  /* Classy Student Steps Start */
  jQuery('.js-student-step').each(function(index){
    var iClass = jQuery(this).find('p').html();
    var icon = document.createElement("i");
    jQuery(icon).addClass(iClass);
    jQuery(this).find('p').html(icon);
  });
  /* Classy Student Steps End */

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
      }
    }

    grid.isotope({ filter: '.ab-filter-financial-aid' });

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

  /* Event Carousel Start */
  jQuery('.owl-carousel').owlCarousel({
    items: 5,
    loop: true,
    nav: false,
    dots: true,
    autoplay: true,
    autoplayTimeout: 4000,
    navText: [
      '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
      '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
    ],
    margin: 15,
    responsive: {
      0: {
        items: 1,
        margin: 0
      },
      767: {
        items: 3,
        nav: true,
        dots: false
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
    var newsListItems = jQuery(this).find('ul > li');

    if(newsListItems.length > 3) {
      newsListItems.slice(-newsListItems.length + 3).remove();
    }

    jQuery(this).append('<center><a href="#" class="recent-news-more-news">More News</a></center>');
  });
  /* Homepage Recent News End */

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
      if(active) {
        imgDiv.fadeOut(400, function(){
          jQuery(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down').hide();
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

  /* Homepage Latest News Start */
  jQuery('.recent-content-view-list-wrapper').each(function(index){
    /* Wrap a in span */
    var text = jQuery(this).find('.views-field-view-node a').html();
    var textSpan = document.createElement("span");
    jQuery(textSpan).html(text).addClass('view-read-more-span');
    jQuery(this).find('.views-field-view-node a').html(textSpan);

    /* Create icon and wrap in span */
    var iconSpan = document.createElement("span");
    var icon = document.createElement("i");
    jQuery(iconSpan).html(jQuery(icon).addClass('fa fa-angle-right')).addClass('view-icon-span');
    jQuery(this).find('.views-field-view-node a').prepend(iconSpan);


    /* Add Images */
    jQuery(this).children('li:eq(0)').after('<li class="img-test"><img src="themes/custom/bethelks/placeholder.png"></li>');
    jQuery(this).children('li:eq(2)').after('<li class="img-test"><img src="themes/custom/bethelks/placeholder.png"></li>');
    jQuery(this).children('li:last-child').after('<li class="img-test"><img src="themes/custom/bethelks/placeholder.png"></li>');
  });
  /* Homepage Latest News End */

  /* Homepage Prefooter Social Media Icons Start */
  jQuery('.homePreFooter ul li').each(function(index){
    var iClass = jQuery(this).find('a').html();
    var icon = document.createElement('i');
    jQuery(icon).addClass(iClass);
    jQuery(this).find('a').html(icon);
  });
  /* Homepage Prefooter Social Media Icons End */



  //layout
  setTimeout(function(){
    grid.isotope({filter: '.ab-filter-financial-aid'});
  }, 2000);
});
