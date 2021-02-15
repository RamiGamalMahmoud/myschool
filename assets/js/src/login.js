export default (function () {
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
});