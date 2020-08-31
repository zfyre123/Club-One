

<section class="hero--home yellow-col-image-text">
  <div class="hero__inner">
    
    <div class="inner__content-container">
      <div class="hero__image-container">
        <img src="<?= App\asset_path('images/home-hero-player.png'); ?>" alt="hero image" class="hero-image">
      </div>
      <div class="hero__content-container">
        <div class="content__inner">
          <h1 class="hero__title p-nova-bold text-4xl xl:text-6xl">At Club One Volleyball, we’re winning on and off the court.</h1>
          <p class="hero__copy text-lg p-nova">From serving aces to serving the local community, we train athletes to compete with character.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="home-hero-callout round-border-shadow">
    <div class="callout-content">
      <h3 class="callout-content__title text-1xl text-co_blue p-nova-bold">Volleyball Offerings</h3>
      <p class="callout-content__copy text-co_navy p-nova text-base">You want it, we’ve got it: competitive teams, rec leagues, beginner clinics, private lessons, special events, and more. Explore our programs to find the best fit for your athlete.</p>
    </div>
    <div class="callout-icons p-nova-bold">
      <div class="icon-container">
        <div class="icon-inner">
          <?php echo e(\App\sage(\BladeSvg\SvgFactory::class)->svg('indoor-icon', 'hero-callout-icon indoor-icon')) ?>
        </div>
        <div class="text">
          <span class="icon-text uppercase text-co_blue">in-door</span>
        </div>
      </div>
      <div class="icon-container outdoor-icon-container">
        <div class="icon-inner outdoor">
          <?php echo e(\App\sage(\BladeSvg\SvgFactory::class)->svg('outdoor-icon', 'hero-callout-icon outdoor-icon')) ?>
        </div>
        <div class="text">
          <span class="icon-text uppercase text-co_blue">beach</span>
        </div>
      </div>
      <div class="icon-container">
        <div class="icon-inner">
          <?php echo e(\App\sage(\BladeSvg\SvgFactory::class)->svg('training-icon', 'hero-callout-icon training-icon')) ?>
        </div>
        <div class="text">
          <span class="icon-text uppercase text-co_blue">training</span>
        </div>
      </div>
    </div>
  </div>

</section>