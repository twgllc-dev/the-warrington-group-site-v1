<?php
/**
 * Template: contact.php — Contact Us page.
 * Logic (validation, saving, email) lives in site/controllers/contact.php.
 * Styles: assets/css/templates/contact.css  |  JS: assets/js/templates/contact.js
 */
$directEmail = $site->homePage()->contact_email()->or('contactus@thewarringtongroup.com');
?>
<?php snippet('header') ?>

<div class="inquiry-page">

  <div class="inquiry-intro">
    <h1><?= $page->headline()->or("Let's talk")->esc() ?></h1>
    <p><?= $page->intro()->or('Tell us a little about what you have in mind and we will reply directly.')->esc() ?></p>
    <p class="inquiry-direct">
      Prefer email? <a href="mailto:<?= esc($directEmail, 'attr') ?>"><?= esc($directEmail) ?></a>
    </p>
  </div>

  <div class="inquiry-panel">
    <?php if ($sent): ?>

      <div class="inquiry-success" role="status">
        <h2><?= $page->success_heading()->or("Thanks, we've got it.")->esc() ?></h2>
        <p><?= $page->success_message()->or("We'll follow up at the email address you provided.")->esc() ?></p>
      </div>

    <?php else: ?>

      <form class="inquiry-form" method="post" action="<?= $page->url() ?>" data-once>

        <?php if (isset($errors['form'])): ?>
          <p class="inquiry-alert" role="alert"><?= esc($errors['form']) ?></p>
        <?php endif ?>

        <div class="inquiry-field<?= isset($errors['interest']) ? ' has-error' : '' ?>">
          <label for="interest">Interest type</label>
          <select id="interest" name="interest" required
                  <?= isset($errors['interest']) ? 'aria-invalid="true" aria-describedby="err-interest"' : '' ?>>
            <option value="" disabled <?= $form['interest'] === '' ? 'selected' : '' ?>>Select one</option>
            <?php foreach ($interests as $option): ?>
              <option value="<?= esc($option, 'attr') ?>" <?= $form['interest'] === $option ? 'selected' : '' ?>><?= esc($option) ?></option>
            <?php endforeach ?>
          </select>
          <?php if (isset($errors['interest'])): ?><p class="inquiry-error" id="err-interest"><?= esc($errors['interest']) ?></p><?php endif ?>
        </div>

        <div class="inquiry-row">
          <div class="inquiry-field<?= isset($errors['name']) ? ' has-error' : '' ?>">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= esc($form['name'], 'attr') ?>"
                   required maxlength="120" autocomplete="name"
                   <?= isset($errors['name']) ? 'aria-invalid="true" aria-describedby="err-name"' : '' ?>>
            <?php if (isset($errors['name'])): ?><p class="inquiry-error" id="err-name"><?= esc($errors['name']) ?></p><?php endif ?>
          </div>

          <div class="inquiry-field<?= isset($errors['email']) ? ' has-error' : '' ?>">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= esc($form['email'], 'attr') ?>"
                   required maxlength="200" autocomplete="email"
                   <?= isset($errors['email']) ? 'aria-invalid="true" aria-describedby="err-email"' : '' ?>>
            <?php if (isset($errors['email'])): ?><p class="inquiry-error" id="err-email"><?= esc($errors['email']) ?></p><?php endif ?>
          </div>
        </div>

        <div class="inquiry-field">
          <label for="company">Company or Organization <span class="inquiry-optional">(optional)</span></label>
          <input type="text" id="company" name="company" value="<?= esc($form['company'], 'attr') ?>"
                 maxlength="160" autocomplete="organization">
        </div>

        <div class="inquiry-field<?= isset($errors['message']) ? ' has-error' : '' ?>">
          <label for="message">How can we help you?</label>
          <textarea id="message" name="message" rows="5" required maxlength="5000"
                    <?= isset($errors['message']) ? 'aria-invalid="true" aria-describedby="err-message"' : '' ?>><?= esc($form['message']) ?></textarea>
          <?php if (isset($errors['message'])): ?><p class="inquiry-error" id="err-message"><?= esc($errors['message']) ?></p><?php endif ?>
        </div>

        <!-- Honeypot: hidden from people, irresistible to bots -->
        <div class="inquiry-hp" aria-hidden="true">
          <label for="website">Leave this field empty</label>
          <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
        </div>

        <input type="hidden" name="csrf" value="<?= csrf() ?>">

        <div class="inquiry-actions">
          <button type="submit" class="btn btn-primary">Send message</button>
          <p class="inquiry-note">We use your details only to respond to this message.</p>
        </div>
      </form>

    <?php endif ?>
  </div>

</div>

<?php snippet('footer') ?>
