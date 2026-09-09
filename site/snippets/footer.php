<?php
/*
  Snippets are a great way to store code snippets for reuse
  or to keep your templates clean.

  This footer snippet is reused in all templates.

  More about snippets:
  https://getkirby.com/docs/guide/templates/snippets
*/
?>
  </main>

  <?php $home = $site->homePage() ?>
  <footer class="site-footer">
    <div class="site-footer-brand">
      <img class="site-footer-mark" src="<?= url('assets/images/logo-mark-dark.png') ?>" alt="" width="28" height="25">
      <div>
        <p class="site-footer-name"><?= $site->title()->esc() ?></p>
        <p class="site-footer-location">Washington, D.C.</p>
      </div>
    </div>
    <nav class="site-footer-links">
      <a href="<?= $home->url() ?>#services">Services</a>
      <a href="<?= $home->url() ?>#approach">Approach</a>
      <a href="<?= $home->url() ?>#about">About</a>
      <a href="<?= $home->url() ?>#contact">Contact</a>
    </nav>
    <p class="site-footer-copyright">&copy; <?= date('Y') ?> <?= $site->title()->esc() ?></p>
  </footer>

  <?= js([
    'assets/js/prism.js',
    'assets/js/lightbox.js',
    'assets/js/index.js',
    '@auto'
  ]) ?>

</body>
</html>
