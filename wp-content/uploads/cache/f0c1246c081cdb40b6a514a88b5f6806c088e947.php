<div class="mobile-menu-container hidden">

  <div class="menu-header">

    <div class="logo-container">
      <?php echo e(\App\sage(\BladeSvg\SvgFactory::class)->svg('logo-dark', 'logo-dark mobile-menu-logo')) ?>
    </div>
    <div class="close-container" id="close">
      <a href="#" class="close-button"></a>
    </div>

  </div>

  <div class="mobile-menu__content-container">

    <ul class="mobile-menu">
      <li class="header-menu__item"><a href="/play" class="header-menu__link">play</a></li>
      <li class="header-menu__item"><a href="#" class="header-menu__link">training</a></li>
      <li class="header-menu__item"><a href="#" class="header-menu__link">events</a></li>
      <li class="header-menu__item"><a href="#" class="header-menu__link">partner</a></li>
      <li class="header-menu__item"><a href="#" class="header-menu__link">shop</a></li>
    </ul>

    <div class="mobile-inner-menu round-border-shadow">
      <ul class="inner-menu">
        <li class="inner-menu__item"><a href="#" class="header-menu__link">teams</a></li>
        <li class="inner-menu__item"><a href="#" class="header-menu__link">staff</a></li>
        <li class="inner-menu__item"><a href="#" class="header-menu__link">resources</a></li>
        <li class="inner-menu__item"><a href="#" class="header-menu__link">blog</a></li>
        <li class="inner-menu__item"><a href="#" class="header-menu__link">become a coach</a></li>
      </ul>
      <div class="mobile-social-menu">
        <?php echo e(\App\sage(\BladeSvg\SvgFactory::class)->svg('instagram', 'instagram footer-social-icon')) ?>
        <?php echo e(\App\sage(\BladeSvg\SvgFactory::class)->svg('facebook-square', 'facebook footer-social-icon')) ?>
      </div>
    </div>

  </div>

</div>
