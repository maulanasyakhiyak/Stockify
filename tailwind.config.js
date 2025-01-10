module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        extend: {
            colors: {
                keyframes: {
                    fadeIn: {
                        '0%': { opacity: '0', transform: 'scale(0.95)' },
                        '100%': { opacity: '1', transform: 'scale(1)' },
                    },
                    fadeOut: {
                        '0%': { opacity: '1', transform: 'scale(1)' },
                        '100%': { opacity: '0', transform: 'scale(0.95)' },
                    },
                },
                animation: {
                    fadeIn: 'fadeIn 0.3s ease-out forwards',
                    fadeOut: 'fadeOut 0.3s ease-out forwards',
                },
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                    950: '#172554',
                }
            },
        },
    },
    plugins: [
        require('flowbite/plugin')({
            datatables: true,
        }),
        require('flowbite/plugin'),
        function ({ addUtilities }) {
            addUtilities({
              '.scrollbar-hidden': {
                'scrollbar-width': 'none',  // Untuk Firefox
                '-ms-overflow-style': 'none',  // Untuk Internet Explorer
              },
              '.scrollbar-hidden::-webkit-scrollbar': {
                display: 'none',  // Untuk Chrome, Safari, dan Edge
              },
            })
          }
    ],
}

