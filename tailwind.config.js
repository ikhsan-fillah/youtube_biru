/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./index.php",
    "./includes/navbar.php",
    "./**/*.php",
    "./includes/**/*.php",
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        primary: "#FF6363",
        secondary: {
          100: "#E2E2D5",
          200: "#888883",
        },
        ytBlue: "#2563eb",
      },
    },
  },
  plugins: [],
};
