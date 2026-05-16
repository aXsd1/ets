/* =========================================================
   ETS - Hamburger Menü JS (mobile-menu.js)
   Bu dosyayı </body>'den önce ekleyin:
   <script src="src/js/mobile-menu.js"></script>
   NOT: script.js zaten bu işlevi yapıyorsa bu dosyaya gerek yok.
   ========================================================= */

(function () {
  const toggle = document.querySelector('.menu-toggle');
  const navMenu = document.querySelector('.nav-menu');

  if (!toggle || !navMenu) return;

  // Menüyü aç/kapat
  toggle.addEventListener('click', function () {
    const isOpen = navMenu.classList.toggle('active');
    toggle.classList.toggle('active', isOpen);
    toggle.setAttribute('aria-expanded', isOpen);
  });

  // Menü linkine tıklayınca kapat
  navMenu.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      navMenu.classList.remove('active');
      toggle.classList.remove('active');
      toggle.setAttribute('aria-expanded', 'false');
    });
  });

  // Menü dışına tıklayınca kapat
  document.addEventListener('click', function (e) {
    if (!toggle.contains(e.target) && !navMenu.contains(e.target)) {
      navMenu.classList.remove('active');
      toggle.classList.remove('active');
      toggle.setAttribute('aria-expanded', 'false');
    }
  });
})();