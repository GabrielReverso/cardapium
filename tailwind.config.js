/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./public/index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        cardapiumPrimary: "#033043",
        cardapiumSecondary: "#0A7273",
        cardapiumComponent: "#FDA521",
        cardapiumComponentHover: "#db901e",
        cardapiumText: "#2c3e50"
      }
    },
  },
  plugins: [],
}

