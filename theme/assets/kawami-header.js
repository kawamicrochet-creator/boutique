// Kawami — minimal progressive enhancement (dropdown works via CSS :hover already;
// this just handles keyboard/touch access for the "Boutique" dropdown, plus the
// mobile hamburger toggle).
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.k-drop').forEach((drop) => {
    const trigger = drop.querySelector('a');
    if (!trigger) return;
    trigger.addEventListener('click', (e) => {
      if (window.matchMedia('(hover: none)').matches) {
        const menu = drop.querySelector('.k-drop__menu');
        if (menu && menu.style.display !== 'flex') {
          e.preventDefault();
          menu.style.display = 'flex';
        }
      }
    });
  });

  const toggle = document.querySelector('.k-mobile-toggle');
  const mobileNav = document.getElementById('kawami-mobile-nav');
  if (toggle && mobileNav) {
    toggle.addEventListener('click', () => {
      const isOpen = mobileNav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }
});
