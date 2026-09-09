<?php snippet('header') ?>

<section class="hero">
  <div class="hero-inner">
    <h1 class="hero-headline"><?= $page->hero_headline()->esc() ?></h1>
    <p class="hero-subheadline"><?= $page->hero_subheadline()->esc() ?></p>
    <div class="hero-actions">
      <?php if ($page->hero_cta_primary_label()->isNotEmpty()): ?>
      <a class="btn btn-primary" href="<?= $page->hero_cta_primary_link()->or('#contact')->esc() ?>">
        <?= $page->hero_cta_primary_label()->esc() ?>
      </a>
      <?php endif ?>
      <?php if ($page->hero_cta_secondary_label()->isNotEmpty()): ?>
      <a class="btn btn-secondary" href="<?= $page->hero_cta_secondary_link()->or('#approach')->esc() ?>">
        <?= $page->hero_cta_secondary_label()->esc() ?>
      </a>
      <?php endif ?>
    </div>
  </div>
</section>

<section id="services" class="services">
  <div class="section-head">
    <h2><?= $page->services_heading()->esc() ?></h2>
    <p><?= $page->services_intro()->esc() ?></p>
  </div>

  <div class="ledger">
    <?php foreach ($page->services()->toStructure() as $service): ?>
    <div class="ledger-row">
      <div class="ledger-name"><?= $service->name()->esc() ?></div>
      <div class="ledger-body">
        <p class="ledger-description"><?= $service->description()->esc() ?></p>
        <?php if ($service->capabilities()->isNotEmpty()): ?>
        <ul class="ledger-capabilities">
          <?php foreach ($service->capabilities()->split("\n") as $capability): ?>
          <li><?= esc($capability) ?></li>
          <?php endforeach ?>
        </ul>
        <?php endif ?>
      </div>
    </div>
    <?php endforeach ?>
  </div>
</section>

<section id="approach" class="approach">
  <div class="section-head">
    <h2><?= $page->approach_heading()->esc() ?></h2>
  </div>

  <ol class="steps">
    <?php $stepNumber = 0 ?>
    <?php foreach ($page->approach_steps()->toStructure() as $step): ?>
    <?php $stepNumber++ ?>
    <li class="step">
      <span class="step-index"><?= str_pad($stepNumber, 2, '0', STR_PAD_LEFT) ?></span>
      <div class="step-body">
        <h3><?= $step->title()->esc() ?></h3>
        <p><?= $step->description()->esc() ?></p>
      </div>
    </li>
    <?php endforeach ?>
  </ol>
</section>

<section id="about" class="about">
  <div class="about-text">
    <h2><?= $page->about_heading()->esc() ?></h2>
    <?= $page->about_text()->kirbytext() ?>
  </div>
  <?php if ($page->about_credentials()->isNotEmpty()): ?>
  <div class="about-credentials">
    <p><?= $page->about_credentials()->esc() ?></p>
  </div>
  <?php endif ?>
</section>

<section id="contact" class="contact">
  <img class="contact-mark" src="<?= url('assets/images/logo-mark-light.png') ?>" alt="" width="120" height="107">
  <div class="contact-inner">
    <h2><?= $page->contact_heading()->esc() ?></h2>
    <p><?= $page->contact_text()->esc() ?></p>
    <?php if ($page->contact_email()->isNotEmpty()): ?>
    <a class="btn btn-primary" href="mailto:<?= $page->contact_email()->esc() ?>">
      <?= $page->contact_email()->esc() ?>
    </a>
    <?php endif ?>
  </div>
</section>

<?php snippet('footer') ?>
