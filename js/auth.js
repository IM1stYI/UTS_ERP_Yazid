/* Penjaga login: halaman disembunyikan sampai sesi PHP terverifikasi. */
(function () {
  document.documentElement.style.visibility = 'hidden';
  window.erpAuthReady = fetch('api/api.php?r=me', { credentials: 'same-origin' })
    .then(function (r) { return r.ok ? r.json() : null; })
    .catch(function () { return null; })
    .then(function (d) {
      if (d && d.ok && d.user) {
        window.__erpUser = d.user;
        document.documentElement.style.visibility = '';
        return d.user;
      }
      location.replace('login.php');
      return null;
    });
})();
