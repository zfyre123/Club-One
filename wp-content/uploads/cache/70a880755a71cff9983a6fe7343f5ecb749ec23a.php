<header class="header page-header absolute top-0 w-full z-10">

  <div class="header-inner">

    <div class="logo-container">
      <a href="/" class="home-link">
        <?php echo e(\App\sage(\BladeSvg\SvgFactory::class)->svg('logo-dark', 'logo-dark header-logo header-logo-dark')) ?>
        <?php echo e(\App\sage(\BladeSvg\SvgFactory::class)->svg('logo-white', 'logo-white header-logo header-logo-white')) ?>
      </a>
    </div>

    <div class="header__menu-container">

      <ul class="header-menu">
        <li class="header-menu__item"><a href="/play" class="header-menu__link">play</a></li>
        <li class="header-menu__item"><a href="/training" class="header-menu__link">training</a></li>
        <li class="header-menu__item"><a href="#" class="header-menu__link">events</a></li>
        <li class="header-menu__item"><a href="#" class="header-menu__link">partner</a></li>
        <li class="header-menu__item"><a href="#" class="header-menu__link">shop</a></li>
        <li class="header-menu__item"><a href="#" class="header-menu__link">more <?php echo e(\App\sage(\BladeSvg\SvgFactory::class)->svg('menu-dots', 'menu-dots')) ?></a></li>
      </ul>

      <div class="mobile-menu-click" id="menu_click">
        <div class="menu-line line-full"></div>
        <div class="menu-line line-half"></div>
        <div class="menu-line line-full"></div>
      </div>

    </div>

  </div>

  <?php echo $__env->make('partials.mobile-menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</header>
