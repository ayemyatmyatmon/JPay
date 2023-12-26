module.exports = {
  darkMode: 'class',

    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
      "./node_modules/flowbite/**/*.js",

    ],
    theme: {
      extend: {
        active: ['bg-red-400'],
        spacing: {
          '128': '32rem',
        }
      }
      ,
    },
    plugins: [
      require('flowbite/plugin','preline/plugin'),

    ],
  }