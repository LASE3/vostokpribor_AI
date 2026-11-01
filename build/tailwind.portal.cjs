// Exact approved V6 theme; Tailwind 3.4.17 compiles this at build time.
const content = require('./tailwind.content.cjs');
module.exports = Object.assign({
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['IBM Plex Mono', 'monospace'],
                    },
                    colors: {
                        brand: {
                            purple: '#4C1D95',
                            lilac: '#D8B4FE',
                            lavender: '#F3E8FF',
                            rosegold: '#E8C9A0',
                            cream: '#FDF6F0',
                            wheat: '#F5DEB3',
                            bg: '#EAF4FF',
                            bgSub: '#DCEEFF',
                        }
                    }
                }
            }
        }, { content });
