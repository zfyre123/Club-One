(function($) {

	$(document).ready(function() {

		let sidebar = {
			open: false
		};

    // Open the side nav
    $('#side-nav-button').on('click', function(e) {
      $('#sidebar-offcanvas-menu').addClass('open');
    });

    // Close the side nav
    $('#sidebar-menu-toggle').on('click', function(e) {

			if (sidebar.open) {
				$('#sidebar-offcanvas-menu')
	        .removeClass('open')
	        .addClass('closing');

				sidebar.open = false;
			} else {
				$('#sidebar-offcanvas-menu').addClass('open')

					sidebar.open = true;
			}


    });

    // Add animation event listener to remove closing class after closing animation is finished.
    $('#sidebar-offcanvas-menu').on('animationend', function(e) {
      if ($(this).hasClass('closing')) {
        $(this).removeClass('closing');
      }
    });

    // Open sub nav in side nav
    $('[data-toggle=dropdown]').on('click', function(e) {
      $(this).siblings('.dropdown-menu').addClass('open');
    });

		// Close the sub nav
		$('.dropdown-back').on('click', function(e) {

			$(this).closest('.dropdown-menu')
				.on('animationend', function(e) {
					if ($(this).hasClass('closing')) {
						$(this).removeClass('closing');
					}
				}).removeClass('open')
				.addClass('closing');
		});

		// Open nav search
		$("#nav-search-open").on('click', function(e) {

			$("#header").addClass('searching');

			$("#nav-search-input").focus();
		});

		// Close nav search
		$("#nav-search-close").on('click', function(e) {

			$("#header").removeClass('searching');
		});

    // Hamburger menu animation from https://codepen.io/husnimun/pen/pJvEeL
    // $('.hamburger-menu').on('click', function() {
    $('#sidebar-menu-toggle, #side-nav-button').on('click', function() {
  		$('.bar').toggleClass('animate');
	  });

		$(window).on('resize', handleNavigationResize);
		handleNavigationResize();

		function handleNavigationResize(e) {
			let navHeight = $('#menu-main').outerHeight();

			$('.dropdown-menu').height(navHeight);
		}

  });

})( jQuery );