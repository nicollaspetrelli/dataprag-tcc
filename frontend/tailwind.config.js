module.exports = {
  darkMode: "class",
  content: [
    "./src/**/*.{js,jsx,ts,tsx}",
  ],
  safelist: [
    'text-orange-500',
    'dark:text-orange-100',
    'bg-orange-100',
    'dark:bg-orange-500',
    'text-blue-500',
    'dark:text-blue-100',
    'bg-blue-100',
    'dark:bg-blue-500',
    'text-green-500',
    'dark:text-green-100',
    'bg-green-100',
    'dark:bg-green-500',
  ],
  theme: {
    fontFamily: {
      'sans': ["Inter", "system-ui"]
    },
    extend: {
      colors: {
        'astro': {
          900: '#121317',
          800: '#1a1c23',
          700: '#24262d',
          500: '#383a3d',
          200: '#4c4f52',
          100: '#9e9e9e',
          50: '#d6d6d6',
        },
        'jett': {
          300: '#fafafa',
          200: '#d5d6d7',
          400: '#e5e7eb',
        },
        'skye': {
          800: '#205c3b',
          700: '#2d8053',
          600: '#38a169',
        }
      }
    },
  },
  plugins: [],
}
