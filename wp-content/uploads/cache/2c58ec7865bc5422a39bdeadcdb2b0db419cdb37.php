<section class="training-hero">

  <div class="training-hero--red hero--red-curve">
    <h1 class="training-hero-text">Training</h1>
    <div class="training--red__content">
      <h1 class="training__hero-title">Volleyball Training</h1>
    </div>
  </div>

  <div class="training-hero__image-container">
    <img src="<?= App\asset_path('images/training-hero-player.png'); ?>" alt="training page hero player image" class="training-hero__player">
  </div>

  <div class="training-hero--blue">
    <div class="training--blue__content">
      <?php echo e(\App\sage(\BladeSvg\SvgFactory::class)->svg('training-icon', 'training-icon')) ?>
      <h2 class="training--blue__title">Training Options</h2>
      <p class="training--blue__copy">Beyond team practices and competition, we offer a variety of ways for you to grow your volleyball skills and learn from our experienced coaches. Volleyball training opportunities are available in-season and out-of-season for Beginner, Experienced, and Select athletes.</p>
    </div>
  </div>

</section>

<section class="types-of-training types-of-training--top">

  <div class="image-content-block block__training-type image--left">
    <div class="image-content-block__inner">

      <div class="block__image-container">
        <img src="<?= App\asset_path('images/training-block-1.jpg'); ?>" alt="image for training block" class="block-image round-border-shadow">
      </div>

      <div class="block__content-container">
        <h3 class="content-title">One U</h3>
        <h4 class="content-subtitle">Learn The Game</h4>
        <p class="content-copy">Serve, pass, set, hit—learn how to play volleyball with One U, the early skills development branch of Club One and One Beach! We offer One U camps and clinics throughout the year for Beginner athletes ages 12 and under. One U coaches teach proper technique, introduce fun game play, and help young volleyball players fall in love with the sport.</p>
        <a href="#" class="content-button btn btn-yellow">Learn More</a>
      </div>

    </div>
  </div>

  <div class="image-content-block block__training-type image--right">
    <div class="image-content-block__inner">

      <div class="block__image-container">
      <img src="<?= App\asset_path('images/training-block-2.jpg'); ?>" alt="image for training block" class="block-image round-border-shadow">
    </div>

    <div class="block__content-container">
      <h3 class="content-title">One U</h3>
      <h4 class="content-subtitle">Learn The Game</h4>
      <p class="content-copy">Serve, pass, set, hit—learn how to play volleyball with One U, the early skills development branch of Club One and One Beach! We offer One U camps and clinics throughout the year for Beginner athletes ages 12 and under. One U coaches teach proper technique, introduce fun game play, and help young volleyball players fall in love with the sport.</p>
      <a href="#" class="content-button btn btn-yellow">Learn More</a>
    </div>

    </div>
  </div>

</section>

<section class="block__bg-image-text" style="background-image:url('<?= App\asset_path('images/training-section-bg.jpg'); ?>');">
  <h1 class="section-text">We are one.</h1>
</section>

<section class="types-of-training types-of-training--bottom">

  <div class="image-content-block block__training-type image--left">
    <div class="image-content-block__inner">

      <div class="block__image-container">
        <img src="<?= App\asset_path('images/training-block-3.jpg'); ?>" alt="image for training block" class="block-image round-border-shadow">
      </div>

      <div class="block__content-container">
        <h3 class="content-title">One U</h3>
        <h4 class="content-subtitle">Learn The Game</h4>
        <p class="content-copy">Serve, pass, set, hit—learn how to play volleyball with One U, the early skills development branch of Club One and One Beach! We offer One U camps and clinics throughout the year for Beginner athletes ages 12 and under. One U coaches teach proper technique, introduce fun game play, and help young volleyball players fall in love with the sport.</p>
        <a href="#" class="content-button btn btn-yellow">Learn More</a>
      </div>

    </div>
  </div>

  <div class="image-content-block block__training-type image--right">
    <div class="image-content-block__inner">

      <div class="block__image-container">
        <img src="<?= App\asset_path('images/training-block-4.jpg'); ?>" alt="image for training block" class="block-image round-border-shadow">
      </div>

      <div class="block__content-container">
        <h3 class="content-title">One U</h3>
        <h4 class="content-subtitle">Learn The Game</h4>
        <p class="content-copy">Serve, pass, set, hit—learn how to play volleyball with One U, the early skills development branch of Club One and One Beach! We offer One U camps and clinics throughout the year for Beginner athletes ages 12 and under. One U coaches teach proper technique, introduce fun game play, and help young volleyball players fall in love with the sport.</p>
        <a href="#" class="content-button btn btn-yellow">Learn More</a>
      </div>

    </div>
  </div>

</section>

<section class="training__callout">

  <div class="image-content-callout callout--content-blue callout--image-right page-section-callout">
    <div class="image-container round-border-shadow" style="background-image:url('<?= App\asset_path('images/test-image.jpg'); ?>');">
      <img src="<?= App\asset_path('images/test-image.jpg'); ?>" alt="callout image">
    </div>
    <div class="content-container round-border-shadow">
      <div class="content-inner">
        <h3 class="callout__title p-nova-bold">Our Facility</h3>
        <p class="callout__copy p-nova text-center">Club One indoor athletes train at Court One Athletics in Tempe, Arizona. The space touts 45,000 square-feet of solid maple flooring with nine volleyball courts. We’re privileged to practice on one of best flooring systems in the country, made with a one-inch foam subfloor that allows for softer landings and fewer injuries.</p>
        <p class="callout-address text-white p-nova">Court One Athletics<br>9100 South McKemy Street<br>Tempe, AZ 85284</p>
      </div>
    </div>
  </div>

</section>

<section class="calendar-section">
  <h1 class="text-4xl">Calendar Section</h1>
</section>

<?php echo $__env->make('static-partials.static-blocks.faq-section', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<section class="color-content-blocks">

  <div class="single-color-content-block block--yellow">
    <h3 class="color-block-title">Become A Coach</h3>
    <p class="color-block-copy">With your volleyball experience and our unparalleled culture, we can build strong, selfless athletes together. Complete a Coach Application today and let us know why you want to join the Club One/One Beach family.</p>
    <a href="#" class="color-block-button btn">Learn More</a>
  </div>

  <div class="single-color-content-block block--blue">
    <h3 class="color-block-title">Learn About Competitive Programs</h3>
    <p class="color-block-copy">Reach the next level of your game. Tryout for a Rec or Club team and watch your skills grow in practice and at tournaments over the course of a season.</p>
    <a href="#" class="color-block-button btn">Learn More</a>
  </div>

</section>