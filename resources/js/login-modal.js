const dialog = document.querySelector('#login-modal');

if (dialog && typeof dialog.showModal === 'function') {
  let trigger;
  let previousOverflow;

  document.querySelectorAll('[data-login-open]').forEach((link) => {
    link.addEventListener('click', (event) => {
      if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

      event.preventDefault();
      if (dialog.open) return;

      trigger = link;
      previousOverflow = document.documentElement.style.overflow;
      dialog.showModal();
      document.documentElement.style.overflow = 'hidden';
      dialog.querySelector('[name="username"]').focus();
    });
  });

  dialog.querySelector('[data-login-close]').addEventListener('click', () => dialog.close());

  let backdropPressed = false;
  dialog.addEventListener('pointerdown', (event) => {
    backdropPressed = event.target === dialog;
  });
  dialog.addEventListener('click', (event) => {
    if (backdropPressed && event.target === dialog) dialog.close();
    backdropPressed = false;
  });

  dialog.addEventListener('close', () => {
    document.documentElement.style.overflow = previousOverflow;
    trigger?.focus();
  });
}
