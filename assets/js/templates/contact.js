// Contact form: prevent double submits once the browser says the form is valid.
(function () {
  var form = document.querySelector('form[data-once]');
  if (!form) return;
  var button = form.querySelector('button[type="submit"]');

  form.addEventListener('submit', function () {
    if (!form.checkValidity()) return;
    button.disabled = true;
    button.textContent = 'Sending…';
  });

  // Back button restores the page from cache with the button still disabled.
  window.addEventListener('pageshow', function (e) {
    if (e.persisted) {
      button.disabled = false;
      button.textContent = 'Send message';
    }
  });
})();
