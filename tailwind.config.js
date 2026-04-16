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
        skyNavy: {
          900: '#050C16', // Paling gelap (Background Utama)
          800: '#0A192F', // Agak terang (Background Section)
          700: '#112240', // Warna Card
        },
        skyGold: {
          DEFAULT: '#FACC15', // Kuning/Emas Utama
          hover: '#EAB308',   // Kuning/Emas saat di-hover
        }
      },
      fontFamily: {
        poppins: ['Poppins', 'sans-serif'],
      }
    },
  },
  plugins: [],
}