const path = require('path');

module.exports = {
  entry: './assets/js/app.js',
  output: {
    path: path.join(__dirname, 'public/js'),
    filename: 'app.js'
  },
  mode: 'development'
}