// Exact approved V6 theme; Tailwind 3.4.17 compiles this at build time.
const content = require('./tailwind.content.cjs');
module.exports = Object.assign({
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    spacing: {
                        'space-xs': '0.25rem',  /* 4px */
                        'space-sm': '0.5rem',   /* 8px */
                        'space-md': '1rem',     /* 16px */
                        'space-lg': '1.5rem',   /* 24px */
                        'space-xl': '2rem',     /* 32px */
                        'gutter': '1.5rem',     /* 24px */
                    },
                    fontSize: {
                        'headline-xl': ['2rem', { lineHeight: '2.5rem', fontWeight: '700', letterSpacing: '-0.02em' }],
                        'headline-lg': ['1.5rem', { lineHeight: '2rem', fontWeight: '700', letterSpacing: '-0.01em' }],
                        'headline-md': ['1.25rem', { lineHeight: '1.75rem', fontWeight: '700' }],
                        'headline-sm': ['1.125rem', { lineHeight: '1.5rem', fontWeight: '600' }],
                        'body-lg': ['1rem', { lineHeight: '1.5rem' }],
                        'body-md': ['0.875rem', { lineHeight: '1.25rem' }],
                        'body-sm': ['0.8125rem', { lineHeight: '1.125rem' }],
                        'label-lg': ['0.875rem', { lineHeight: '1.25rem', fontWeight: '600' }],
                        'label-md': ['0.75rem', { lineHeight: '1rem', fontWeight: '600' }],
                        'label-sm': ['0.6875rem', { lineHeight: '0.875rem', fontWeight: '600', letterSpacing: '0.04em' }],
                        'code-sm': ['0.75rem', { lineHeight: '1rem' }],
                    },
                    colors: {
                        primary: '#4C1D95',
                        'primary-hover': '#3B0764',
                        'primary-container': '#4C1D95',
                        'on-primary': '#FFFFFF',
                        secondary: '#D8B4FE',
                        'secondary-fixed': '#F3E8FF',
                        'secondary-container': '#E9D5FF',
                        'on-secondary': '#3B0764',
                        lavender: '#F3E8FF',
                        accent: '#E8C9A0',
                        'tertiary-fixed': '#E8C9A0',
                        cream: '#FDF6F0',
                        wheat: '#F5DEB3',
                        border: '#F5DEB3',
                        'border-subtle': 'rgba(245, 222, 179, 0.7)',
                        surface: '#FFFFFF',
                        'surface-container-lowest': '#FFFFFF',
                        'surface-container-low': '#FDF6F0',
                        'surface-container': '#F8F4EF',
                        'surface-container-high': '#F3E8FF',
                        'surface-container-highest': '#EFE9E1',
                        'on-surface': '#2E1065',
                        'on-surface-variant': '#6B7280',
                        'outline': '#94A3B8',
                        'outline-variant': '#E2E8F0',
                        error: '#DC2626',
                        'error-container': '#FEE2E2',
                        'on-error': '#FFFFFF',
                        'on-error-container': '#991B1B',
                        'inverse-surface': '#1E293B',
                        'inverse-on-surface': '#F8FAFC',
                    }
                }
            }
        }, { content });
