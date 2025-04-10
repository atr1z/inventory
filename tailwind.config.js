/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Material Design color palette
        primary: {
          50: '#e3f2fd',
          100: '#bbdefb',
          200: '#90caf9',
          300: '#64b5f6',
          400: '#42a5f5',
          500: '#2196f3', // Primary color
          600: '#1e88e5',
          700: '#1976d2',
          800: '#1565c0',
          900: '#0d47a1',
        },
        secondary: {
          50: '#fce4ec',
          100: '#f8bbd0',
          200: '#f48fb1',
          300: '#f06292',
          400: '#ec407a',
          500: '#e91e63', // Secondary color
          600: '#d81b60',
          700: '#c2185b',
          800: '#ad1457',
          900: '#880e4f',
        },
        error: {
          50: '#ffebee',
          100: '#ffcdd2',
          200: '#ef9a9a',
          300: '#e57373',
          400: '#ef5350',
          500: '#f44336', // Error color
          600: '#e53935',
          700: '#d32f2f',
          800: '#c62828',
          900: '#b71c1c',
        },
        warning: {
          50: '#fff8e1',
          100: '#ffecb3',
          200: '#ffe082',
          300: '#ffd54f',
          400: '#ffca28',
          500: '#ffc107', // Warning color
          600: '#ffb300',
          700: '#ffa000',
          800: '#ff8f00',
          900: '#ff6f00',
        },
        success: {
          50: '#e8f5e9',
          100: '#c8e6c9',
          200: '#a5d6a7',
          300: '#81c784',
          400: '#66bb6a',
          500: '#4caf50', // Success color
          600: '#43a047',
          700: '#388e3c',
          800: '#2e7d32',
          900: '#1b5e20',
        },
        gray: {
          50: '#fafafa',
          100: '#f5f5f5',
          200: '#eeeeee',
          300: '#e0e0e0',
          400: '#bdbdbd',
          500: '#9e9e9e', // Gray color
          600: '#757575',
          700: '#616161',
          800: '#424242',
          900: '#212121',
        },
      },
      fontFamily: {
        sans: ['Roboto', 'sans-serif'],
      },
      boxShadow: {
        // Material Design elevation levels
        'md-1': '0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24)',
        'md-2': '0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23)',
        'md-3': '0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23)',
        'md-4': '0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22)',
        'md-5': '0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22)',
      },
    },
  },
  plugins: [],
}
