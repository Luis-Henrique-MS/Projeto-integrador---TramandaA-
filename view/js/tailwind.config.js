module.exports = {
  content: {
    files: ["./**/*.html"],
    safelist: [
      'bg-[rgb(250,250,248)]',
      'bg-[rgb(240,253,244)]',
      'bg-[rgb(26,26,26)]',
      'text-[56px]',
      'text-[24px]',
      'text-[19px]',
      'text-[17px]',
      'text-[16px]'
    ]
  },
  theme: {
    extend: {
      fontFamily: {
        display: ['"Playfair Display"', 'serif'],
        sans: ['"DM Sans"', 'sans-serif']
      },
      colors: {
        emerald: {
          50: '#ecfdf5',
          100: '#d1fae5',
          500: '#10B981'
        }
      }
    }
  },
  plugins: []
}
