export default (function () {
  const loginContent = document.querySelector('.login-content');

  if (loginContent) {
    document.querySelector('.content').style.marginTop = '0';
    document.querySelector('header').style.display = 'none';
    let inputs = document.querySelectorAll('.login-form input:not(:last-child)');

    inputs.forEach((input) => {

      input.addEventListener('focus', () => {
        input.setAttribute('text-data', input.getAttribute('placeholder'));
        input.setAttribute('placeholder', '');
      });

      input.addEventListener('blur', () => {
        input.setAttribute('placeholder', input.getAttribute('text-data'));
      });
    });
  }
})();