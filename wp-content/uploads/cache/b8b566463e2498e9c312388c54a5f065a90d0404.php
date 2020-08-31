<footer class="footer">

  <div class="footer-top">

    <div class="footer-top__inner">

      <div class="footer-logo-menu-container">
        <div class="footer-logo-container">
          <?php echo e(\App\sage(\BladeSvg\SvgFactory::class)->svg('footer-logo', 'footer-logo logo-white')) ?>
        </div>
        <div class="footer-menu-container">
          <ul class="menu-top">
            <li class="menu-top-item"><a href="/play" class="menu-item-link">play</a></li>
            <li class="menu-top-item"><a href="/training" class="menu-item-link">training</a></li>
            <li class="menu-top-item"><a href="#" class="menu-item-link">events</a></li>
            <li class="menu-top-item"><a href="#" class="menu-item-link">partner</a></li>
            <li class="menu-top-item"><a href="#" class="menu-item-link">shop</a></li>
          </ul>
          <ul class="menu-bottom">
            <li class="menu-bottom-item"><a href="#" class="menu-item-link">teams</a></li>
            <li class="menu-bottom-item"><a href="#" class="menu-item-link">staff</a></li>
            <li class="menu-bottom-item"><a href="#" class="menu-item-link">resources</a></li>
            <li class="menu-bottom-item"><a href="#" class="menu-item-link">become a coach</a></li>
            <li class="menu-bottom-item"><a href="#" class="menu-item-link">blog</a></li>
          </ul>
        </div>


      </div>
      <div class="footer-subscribe-container">
        <div class="footer-subscribe-form">
          <form class="footer-form">
            <input type="text" placeholder="Sign Up For Our Newsletter">
            <input type="submit" value="Let's Go">
          </form>
        </div>
        <div class="footer-social-container">
          <?php echo e(\App\sage(\BladeSvg\SvgFactory::class)->svg('instagram', 'instagram footer-social-icon')) ?>
          <?php echo e(\App\sage(\BladeSvg\SvgFactory::class)->svg('facebook-square', 'facebook footer-social-icon')) ?>
        </div>
      </div>

    </div>

  </div>

  <div class="footer-bottom">
    <p class="copyright">&copy Club One <?php echo date('Y'); ?> | <a href="#" class="privacy">Privacy Policy</a> | Site by <a href="https://monomythstudio.com/" target="_blank" class="monomyth-link">Monomyth Studio</a></p>
  </div>

</footer>
