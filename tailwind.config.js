/** @type {import('tailwindcss').Config} */
module.exports = {
  corePlugins: {
    preflight: false,
  },
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./vendor/vildanbina/livewire-tabs/resources/views/*.blade.php",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
