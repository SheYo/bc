jQuery(document).on('ready', function(){
  /* Navigation Start */
  if(jQuery(window).width() > 991) {
    jQuery('ul.navbar-nav li.dropdown').hover(function() {
      jQuery(this).find('.dropdown-menu:lt(1)').stop(true, true).delay(100).fadeIn(250);
    }, function() {
      jQuery(this).find('.dropdown-menu:lt(1)').stop(true, true).delay(100).fadeOut(250);
    });

    jQuery('ul.navbar-nav li.dropdown ul.dropdown-menu li.dropdown-submenu').hover(function() {
      var parentNumber = jQuery(this).index();
      var topOffset = (parentNumber * 45) - 4;
      jQuery(this).find('.dropdown-menu:lt(1)').css('top', topOffset + 'px');

      var uppermostIndex = jQuery(this).closest('.dropdown').index();
      if((uppermostIndex+1) >= (jQuery('.dropdown').size()-1)) {
        jQuery(this).find('.dropdown-menu:lt(1)').css('left', '-200px');
      }

      jQuery(this).find('.dropdown-menu:lt(1)').stop(true, true).delay(100).fadeIn(250);
    }, function() {
      jQuery(this).find('.dropdown-menu:lt(1)').stop(true, true).delay(100).fadeOut(250);
    });

    // Override jQuery/Bootstrap e.preventDefault on dropdowns
    jQuery('.dropdown > .nav-link').on('click', function(e){
      window.location = jQuery(this).attr('href');
    });
  }
  else {
    jQuery('ul.navbar-nav li.dropdown a.nav-link').on('click', function(e){
      if(jQuery(this).parent('li').find('.dropdown-menu').length && !jQuery(this).parent('li').find('.dropdown-menu').is(":visible")) {
        e.preventDefault();
        jQuery(this).parent('li').find('.dropdown-menu').stop(true, true).show();
      }
      else if(jQuery(this).parent().parent('.navbar-nav').length) {
        e.preventDefault();
        jQuery(this).parent('li').find('.dropdown-menu').stop(true, true).hide();
      }
    });
  }

  jQuery('ul.navbar-nav li.dropdown ul.dropdown-menu').each(function(i){
    var liCount = jQuery(this).find('li').length;

    if(!jQuery(this).find('li.dropdown-submenu').length && !jQuery(this).parent('li.dropdown-submenu').length && liCount > 6) {
      var colCount = Math.floor(liCount / 6);
      var liRemainder = liCount % 6;

      if((liCount % 6) > 0) colCount += 1;

      jQuery(this).addClass('separate_nav_cols');
      jQuery(this).css('-moz-column-count', colCount).css('-webkit-column-count', colCount).css('column-count', colCount).css('left', '-' + ((colCount - 1) * 200) + 'px');
    }
  });
  /* Navigation End */

  /* rightSidebar Start */
  jQuery('.rightSidebar-hook').each(function(index){
    jQuery(this).prepend('<div class="d-flex align-items-center justify-content-center innerStudentSteps"></div>');
    jQuery(this).find('.innerStudentSteps').html(`<a class="d-flex align-items-center justify-content-center" href="http://bc-test.com/form/inquire"><i class="fa fa-info-circle"></i></a>
        <a class="d-flex align-items-center justify-content-center" href="http://bc-test.com/form/visit"><i class="fa fa-map-marker"></i></a>
        <a class="d-flex align-items-center justify-content-center" href="http://bc-test.com/form/application"><i class="fa fa-check"></i></a>`);
  });
  /* rightSidebar End */

  /* Back to Top Button Functionality Start */
  jQuery(document).scroll(function() {
    if(jQuery(document).scrollTop() >= 700) {
      jQuery('.js-scroll-to-top').fadeIn();

      jQuery('.js-scroll-to-top').on('click', function(e) {
        e.preventDefault();
        jQuery('html, body').stop(true, false).animate({ scrollTop: 0 }, 1000);
        return false;
      });
    }
    else {
      if(jQuery('.js-scroll-to-top').css('display') != 'none') {
        jQuery('.js-scroll-to-top').fadeOut();
      }
    }
  });
  /* Back to Top Button Functionality End */

  /* Responsive Image (Classy Paragraphs) Start */
  jQuery('.js-resp-image').each(function(index){
    jQuery(this).find('img').addClass('img-fluid');
  });
  /* Responsive Image (Classy Paragraphs) End */

  /* Parallax (Classy Paragraphs) Start */
  jQuery('.js-parallax-img').each(function(index){
    var imgSrc = jQuery(this).find('img').attr('src');

    jQuery(this).parallax({imageSrc: imgSrc});

    jQuery(this).find('img').remove();
  });
  /* Parallax (Classy Paragraphs) End */

  /* Accordion Start */
  if(jQuery('.paragraph--type--bp-accordion a[data-toggle="collapse"]').length) {
    jQuery('.paragraph--type--bp-accordion a[data-toggle="collapse"]').on('click', function(){
        jQuery(this).toggleClass('opened');
    });
  }
  /* Accordion End */

  /* Video within Content Start */
  jQuery('.articleOrPageContent iframe').each(function(index){
    if(jQuery(this).parent().is('p')) {
      jQuery(this).unwrap();
    }
    jQuery(this).wrap('<div class="d-flex align-items-center justify-content-center articleOrPageVideo"></div>');
  });
  /* Video within Content End */

  /* preFooter Recent News Start */
  jQuery('.preFooter-recentNews').each(function(index){
    var items = jQuery(this).find('.views-row');

    items.each(function(i){
      var href = jQuery(this).find('a').attr('href');
      jQuery(this).find('.views-field-view-node').remove();

      jQuery(this).find('.views-field-created').prepend('<i class="fa fa-clock-o"></i>');

      var anchor = document.createElement('a');
      jQuery(anchor).attr('href', href);
      jQuery(anchor).html(jQuery(this).html());
      jQuery(this).html(anchor);
    });
  });
  /* preFooter Recent News End */
});
