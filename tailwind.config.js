/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "selector",
  content: [
    "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
    "./assets/**/*.js",
    "./assets/custom/*.css",
    "./templates/**/*.html.twig",
    "./src/Twig/Components/*.php",
    "./src/Twig/**/*.php",
  ],
  theme: {
    fontFamily: {
      sans: ['Myriad','BlinkMacSystemFont','Aptos','Inter','ui-sans-serif','system-ui','-apple-system','Segoe UI','Roboto','Helvetica Neue','Arial','Noto Sans','sans-serif','Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol','Noto Color Emoji'],
    },
    extend: {
      animation: {
        gradient: 'gradient 3s linear infinite',
      },
      keyframes: {
        gradient: {
          '0%': { backgroundPosition: '0% 50%' },
          '100%': { backgroundPosition: '100% 50%' },
        },
      },      
      spacing: {
        1.5: "0.375rem",
        5.5: "1.375rem",
        7.5: "1.875rem",
      },
    },
    backgroundImage: {
      "gradient-x-blue-500": "linear-gradient(90deg, #0000FF, #00FFFF)",
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/container-queries'),
  ],
}
