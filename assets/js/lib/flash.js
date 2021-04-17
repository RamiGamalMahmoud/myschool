export default function flash(
  element,
  repeate,
  callback = null,
  colors = ['transparent', 'red', 'transparent']
) {
  let duration = 400;
  for (let i = 1; i <= repeate; i++) {
    setTimeout(() => {
      element.style.backgroundColor = colors[i % 2];
    }, duration * i);
  }

  setTimeout(() => {
    element.style.backgroundColor = colors[2];
    if (callback !== null) {
      callback();
    }
  }, duration * (repeate + 1));
}