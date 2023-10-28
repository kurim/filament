/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./**/*.{html,js,twig,html.twig}",
      "./templates/**/*.{html,js,twig,html.twig}",
      ],
    theme: {
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
        backgroundImage: {
          'gradient-x-blue-500': 'linear-gradient(90deg, #0000FF, #00FFFF)',
        },
      },
    },
    plugins: []
  }