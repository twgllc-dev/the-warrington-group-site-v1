<?php
/**
 * Template: coming-soon.php
 *
 * Temporary "coming soon" landing page for thewarringtongroup.com.
 * To activate: rename content/home/home.txt -> content/home/coming-soon.txt
 * (Kirby derives the template from the .txt filename, not the folder name,
 * so this swaps the template without touching the Home page's real content.)
 *
 * To restore the real homepage later: rename it back to home.txt.
 */

// Launch date for the countdown. Edit the date/time/timezone as needed.
$launchDate = '2026-10-01T00:00:00-04:00'; // Oct 1, 2026, America/New_York
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>The Warrington Group, LLC — Site Updates in Progress</title>
  <meta name="description" content="The Warrington Group, LLC website is currently undergoing updates. We'll be back online soon.">
  <meta name="robots" content="noindex, follow">
  <link rel="icon" href="<?= url('assets/images/favicon.png') ?>">

  <style>
    :root {
      --twg-black: #060606;
      --twg-black-soft: #121212;
      --twg-gold: #d4af37;
      --twg-gold-light: #f1d98b;
      --twg-gold-dim: #8a6d1f;
      --twg-white: #f5f1e6;
    }

    * { box-sizing: border-box; }

    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
    }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Helvetica Neue', Arial, sans-serif;
      color: var(--twg-white);
      background: radial-gradient(circle at 50% 20%, #1c1a12 0%, var(--twg-black) 55%),
                  linear-gradient(160deg, #000000 0%, #14110a 35%, #3a2e0f 70%, #d4af37 140%);
      background-blend-mode: normal;
      overflow-x: hidden;
      position: relative;
    }

    /* subtle animated gold shimmer overlay */
    body::before {
      content: "";
      position: fixed;
      inset: 0;
      background: linear-gradient(120deg, transparent 20%, rgba(212, 175, 55, 0.06) 45%, transparent 70%);
      background-size: 200% 200%;
      animation: shimmer 12s ease-in-out infinite;
      pointer-events: none;
    }

    @keyframes shimmer {
      0%   { background-position: 0% 0%; }
      50%  { background-position: 100% 100%; }
      100% { background-position: 0% 0%; }
    }

    .wrap {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 720px;
      padding: 48px 32px;
      text-align: center;
    }

    .logo {
      max-width: 260px;
      width: 60%;
      height: auto;
      margin: 0 auto 32px;
      display: block;
      filter: drop-shadow(0 0 18px rgba(212, 175, 55, 0.25));
    }

    .eyebrow {
      letter-spacing: 0.35em;
      text-transform: uppercase;
      font-size: 12px;
      color: var(--twg-gold);
      margin: 0 0 18px;
    }

    h1 {
      font-family: Georgia, 'Times New Roman', serif;
      font-weight: 400;
      font-size: clamp(28px, 5vw, 44px);
      line-height: 1.2;
      margin: 0 0 18px;
      background: linear-gradient(90deg, var(--twg-gold-light), var(--twg-gold) 50%, var(--twg-gold-dim));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    p.lede {
      font-size: 16px;
      line-height: 1.7;
      color: rgba(245, 241, 230, 0.85);
      max-width: 520px;
      margin: 0 auto 36px;
    }

    .divider {
      width: 64px;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--twg-gold), transparent);
      margin: 0 auto 32px;
    }

    /* Countdown */
    .countdown {
      display: flex;
      justify-content: center;
      gap: 16px;
      margin: 0 auto 40px;
      flex-wrap: wrap;
    }

    .countdown .unit {
      min-width: 76px;
      padding: 14px 10px;
      border: 1px solid rgba(212, 175, 55, 0.35);
      border-radius: 8px;
      background: rgba(212, 175, 55, 0.04);
      backdrop-filter: blur(2px);
    }

    .countdown .num {
      display: block;
      font-family: Georgia, serif;
      font-size: 30px;
      color: var(--twg-gold-light);
      line-height: 1;
    }

    .countdown .label {
      display: block;
      margin-top: 6px;
      font-size: 10px;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: rgba(245, 241, 230, 0.6);
    }

    .launch-note {
      font-size: 13px;
      color: rgba(245, 241, 230, 0.55);
      margin: 0 0 40px;
    }

    /* Stay in contact button */
    .btn-gold {
      display: inline-block;
      padding: 14px 36px;
      border-radius: 999px;
      border: 1px solid var(--twg-gold);
      color: var(--twg-black);
      background: linear-gradient(90deg, var(--twg-gold-light), var(--twg-gold));
      font-size: 14px;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .btn-gold:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(212, 175, 55, 0.35);
    }

    footer.contact-footer {
      margin-top: 36px;
      font-size: 12px;
      color: rgba(245, 241, 230, 0.45);
    }

    footer.contact-footer a {
      color: rgba(245, 241, 230, 0.7);
      text-decoration: none;
    }

    /* Modal */
    .modal-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.75);
      z-index: 10;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .modal-backdrop.open {
      display: flex;
    }

    .modal {
      width: 100%;
      max-width: 480px;
      max-height: 90vh;
      overflow-y: auto;
      background: linear-gradient(160deg, #0d0b06, #1a1710);
      border: 1px solid rgba(212, 175, 55, 0.35);
      border-radius: 12px;
      padding: 32px;
      text-align: left;
      position: relative;
    }

    .modal h2 {
      font-family: Georgia, serif;
      font-weight: 400;
      font-size: 22px;
      color: var(--twg-gold-light);
      margin: 0 0 8px;
    }

    .modal p.modal-sub {
      font-size: 13px;
      color: rgba(245, 241, 230, 0.6);
      margin: 0 0 24px;
    }

    .modal-close {
      position: absolute;
      top: 16px;
      right: 16px;
      background: none;
      border: none;
      color: rgba(245, 241, 230, 0.6);
      font-size: 20px;
      line-height: 1;
      cursor: pointer;
    }

    .modal-close:hover { color: var(--twg-gold); }

    .field-row {
      display: flex;
      gap: 12px;
      margin-bottom: 14px;
    }

    .field-row .field { flex: 1; }

    .field { margin-bottom: 14px; }

    .field label {
      display: block;
      font-size: 11px;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: rgba(245, 241, 230, 0.55);
      margin-bottom: 6px;
    }

    .field input,
    .field textarea {
      width: 100%;
      padding: 10px 12px;
      border-radius: 6px;
      border: 1px solid rgba(212, 175, 55, 0.25);
      background: rgba(255, 255, 255, 0.03);
      color: var(--twg-white);
      font-size: 14px;
      font-family: inherit;
    }

    .field input:focus,
    .field textarea:focus {
      outline: none;
      border-color: var(--twg-gold);
    }

    .field textarea {
      resize: vertical;
      min-height: 80px;
    }

    /* honeypot field - hidden from real users */
    .hp-field {
      position: absolute;
      left: -9999px;
      top: -9999px;
      opacity: 0;
      pointer-events: none;
    }

    .form-msg {
      font-size: 13px;
      margin-bottom: 14px;
      padding: 10px 12px;
      border-radius: 6px;
      display: none;
    }

    .form-msg.show { display: block; }

    .form-msg.success {
      background: rgba(120, 200, 120, 0.12);
      border: 1px solid rgba(120, 200, 120, 0.4);
      color: #b6e6b6;
    }

    .form-msg.error {
      background: rgba(200, 90, 90, 0.12);
      border: 1px solid rgba(200, 90, 90, 0.4);
      color: #f0b6b6;
    }

    .modal-submit {
      width: 100%;
      margin-top: 6px;
    }

    @media (max-width: 480px) {
      .field-row { flex-direction: column; gap: 0; }
      .countdown .unit { min-width: 62px; padding: 10px 6px; }
      .countdown .num { font-size: 22px; }
    }
  </style>
</head>
<body>

  <div class="wrap">
    <img class="logo" src="<?= url('assets/images/twg-logo-black-bg.png') ?>" alt="The Warrington Group, LLC">

    <p class="eyebrow">The Warrington Group, LLC</p>
    <h1>Our website is undergoing updates</h1>
    <div class="divider"></div>
    <p class="lede">
      We're refining our online experience to better reflect the data engineering,
      infrastructure, and analytics consulting services we provide. Thank you for
      your patience — the new site is on its way.
    </p>

    <div class="countdown" id="countdown" aria-live="polite">
      <div class="unit"><span class="num" id="cd-days">00</span><span class="label">Days</span></div>
      <div class="unit"><span class="num" id="cd-hours">00</span><span class="label">Hours</span></div>
      <div class="unit"><span class="num" id="cd-mins">00</span><span class="label">Minutes</span></div>
      <div class="unit"><span class="num" id="cd-secs">00</span><span class="label">Seconds</span></div>
    </div>

    <p class="launch-note">New website launching October 1</p>

    <button class="btn-gold" id="open-contact-modal" type="button">Stay in Contact</button>

    <footer class="contact-footer">
      <p>In the meantime, reach us directly — <a href="mailto:info@thewarringtongroup.com">info@thewarringtongroup.com</a></p>
    </footer>
  </div>

  <!-- Stay in Contact Modal -->
  <div class="modal-backdrop" id="contact-modal-backdrop">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="contact-modal-title">
      <button class="modal-close" id="close-contact-modal" aria-label="Close">&times;</button>
      <h2 id="contact-modal-title">Stay in Contact</h2>
      <p class="modal-sub">Leave your details and we'll reach out as soon as the new site is live.</p>

      <div class="form-msg" id="form-msg"></div>

      <form id="contact-form" novalidate>
        <div class="field-row">
          <div class="field">
            <label for="firstname">First Name</label>
            <input type="text" id="firstname" name="firstname" required autocomplete="given-name">
          </div>
          <div class="field">
            <label for="lastname">Last Name</label>
            <input type="text" id="lastname" name="lastname" required autocomplete="family-name">
          </div>
        </div>

        <div class="field">
          <label for="business">Business / Organization Name</label>
          <input type="text" id="business" name="business" autocomplete="organization">
        </div>

        <div class="field-row">
          <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autocomplete="email">
          </div>
          <div class="field">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" autocomplete="tel">
          </div>
        </div>

        <div class="field">
          <label for="details">Additional Details</label>
          <textarea id="details" name="details" placeholder="Tell us a bit about what you're looking for..."></textarea>
        </div>

        <!-- honeypot field: bots tend to fill every input, real users never see this -->
        <div class="field hp-field" aria-hidden="true">
          <label for="website">Leave this field empty</label>
          <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
        </div>

        <input type="hidden" name="csrf" value="<?= csrf() ?>">

        <button type="submit" class="btn-gold modal-submit" id="submit-contact">Send</button>
      </form>
    </div>
  </div>

  <script>
    (function () {
      // ----- Countdown -----
      var launchDate = new Date("<?= $launchDate ?>").getTime();

      function updateCountdown() {
        var now = new Date().getTime();
        var distance = launchDate - now;

        if (distance < 0) {
          document.getElementById('cd-days').textContent = '00';
          document.getElementById('cd-hours').textContent = '00';
          document.getElementById('cd-mins').textContent = '00';
          document.getElementById('cd-secs').textContent = '00';
          return;
        }

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var mins = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var secs = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('cd-days').textContent = String(days).padStart(2, '0');
        document.getElementById('cd-hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('cd-mins').textContent = String(mins).padStart(2, '0');
        document.getElementById('cd-secs').textContent = String(secs).padStart(2, '0');
      }

      updateCountdown();
      setInterval(updateCountdown, 1000);

      // ----- Modal open/close -----
      var backdrop = document.getElementById('contact-modal-backdrop');
      var openBtn = document.getElementById('open-contact-modal');
      var closeBtn = document.getElementById('close-contact-modal');

      openBtn.addEventListener('click', function () {
        backdrop.classList.add('open');
      });

      closeBtn.addEventListener('click', function () {
        backdrop.classList.remove('open');
      });

      backdrop.addEventListener('click', function (e) {
        if (e.target === backdrop) backdrop.classList.remove('open');
      });

      // ----- Form submit -----
      var form = document.getElementById('contact-form');
      var msg = document.getElementById('form-msg');
      var submitBtn = document.getElementById('submit-contact');

      form.addEventListener('submit', function (e) {
        e.preventDefault();

        msg.className = 'form-msg';
        msg.textContent = '';

        var formData = new FormData(form);

        // client-side honeypot check
        if (formData.get('website')) {
          return; // silently drop likely-bot submissions
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';

        fetch('<?= url('stay-in-contact') ?>', {
          method: 'POST',
          body: formData,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
          .then(function (res) { return res.json(); })
          .then(function (data) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Send';

            if (data.status === 'ok') {
              msg.className = 'form-msg success show';
              msg.textContent = "Thank you — we'll be in touch soon.";
              form.reset();
              setTimeout(function () {
                backdrop.classList.remove('open');
                msg.className = 'form-msg';
              }, 2500);
            } else {
              msg.className = 'form-msg error show';
              msg.textContent = data.message || 'Something went wrong. Please try again.';
            }
          })
          .catch(function () {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Send';
            msg.className = 'form-msg error show';
            msg.textContent = 'Something went wrong. Please try again, or email us directly.';
          });
      });
    })();
  </script>

</body>
</html>
