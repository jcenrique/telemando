/** @type {import('tailwindcss').Config} */
module.exports = {
  // corePlugins: {
  //   preflight: false,
  // },
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  // mode: "jit",
  //   purge: [
       
  //       "./vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php",
  //   ],

}
