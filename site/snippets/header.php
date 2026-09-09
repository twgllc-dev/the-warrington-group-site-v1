<?php
/*
  Snippets are a great way to store code snippets for reuse
  or to keep your templates clean.

  This header snippet is reused in all templates.
  It fetches information from the `site.txt` content file
  and contains the site navigation.

  More about snippets:
  https://getkirby.com/docs/guide/templates/snippets
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <?php $isHome = $page->isHomePage() ?>

  <title><?= $isHome
    ? $site->title()->esc() . ' — ' . $site->tagline()->or('Analytics, digital & automation consulting')->esc()
    : $site->title()->esc() . ' | ' . $page->title()->esc()
  ?></title>

  <?php if ($isHome && $page->hero_subheadline()->isNotEmpty()): ?>
  <meta name="description" content="<?= $page->hero_subheadline()->esc() ?>">
  <?php endif ?>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&family=Newsreader:ital,wght@0,400;0,500;0,600;1,400&family=Poiret+One&display=swap" rel="stylesheet">

  <?php
  /*
    Stylesheets can be included using the `css()` helper.
    Kirby also provides the `js()` helper to include script file.
    More Kirby helpers: https://getkirby.com/docs/reference/templates/helpers
  */
  ?>
  <?= css([
    'assets/css/prism.css',
    'assets/css/lightbox.css',
    'assets/css/index.css',
    'assets/css/home.css',
    '@auto'
  ]) ?>

  <?php
  /*
    The `url()` helper is a great way to create reliable
    absolute URLs in Kirby that always start with the
    base URL of your site.
  */
  ?>
  <link rel="shortcut icon" type="image/x-icon" href="<?= url('favicon.ico') ?>">
</head>
<body>

  <header class="header">
    <?php
    /*
      We use `$site->url()` to create a link back to the homepage
      for the logo and `$site->title()` as a temporary logo. You
      probably want to replace this with an SVG.
    */
    ?>
    <a class="logo" href="<?= $site->url() ?>">
      <img class="logo-mark" src="<?= url('assets/images/logo-mark-dark.png') ?>" alt="" width="40" height="36">
      <span class="logo-word">the warrington group</span>
    </a>

    <?php
    /*
      This is a single-page marketing site for now, so the nav
      points to sections on the homepage rather than separate
      pages. The photography/notes/about starter pages are still
      in the repo but are not part of this nav yet.
    */
    $home = $site->homePage();
    ?>
    <nav class="menu">
      <a href="<?= $home->url() ?>#services">Services</a>
      <a href="<?= $home->url() ?>#approach">Approach</a>
      <a href="<?= $home->url() ?>#about">About</a>
      <a class="menu-cta" href="<?= $home->url() ?>#contact">Contact</a>
    </nav>
  </header>

  <main class="main">
