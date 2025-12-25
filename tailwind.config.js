/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: ['class'],
    safelist: [
        'dark',
        {
            pattern:
                /!?(bg-(white|black|slate|violet|fuchsia|red|green|blue|gray|yellow|indigo|purple|pink|teal|cyan|lime|amber|orange|rose)(-(50|[1-9]00))?)/,
            variants: ['hover', 'focus', 'group-hover'],
        },
        {
            pattern:
                /!?(text-(white|black|slate|violet|fuchsia|red|green|blue|gray|yellow|indigo|purple|pink|teal|cyan|lime|amber|orange|rose)(-(50|[1-9]00))?)/,
            variants: ['hover', 'focus', 'group-hover'],
        },
    ],
    prefix: '',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.{ts,tsx,vue}',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './resources/**/*.ts',
    ],

    theme: {
        container: {
            center: true,
            padding: '2rem',
            screens: {
                '2xl': '1400px',
            },
        },
        // Default Tailwind color palette with custom DEFAULT shades
        // Bare utilities like bg-red or text-blue will map to the 300 shade of that color
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: colors.black,
            white: colors.white,
            slate: { DEFAULT: colors.slate[400], ...colors.slate },
            gray: { DEFAULT: colors.gray[400], ...colors.gray },
            zinc: { DEFAULT: colors.zinc[400], ...colors.zinc },
            neutral: { DEFAULT: colors.neutral[400], ...colors.neutral },
            stone: { DEFAULT: colors.stone[400], ...colors.stone },
            red: { DEFAULT: colors.red[400], ...colors.red },
            orange: { DEFAULT: colors.orange[400], ...colors.orange },
            amber: { DEFAULT: colors.amber[400], ...colors.amber },
            yellow: { DEFAULT: colors.yellow[400], ...colors.yellow },
            lime: { DEFAULT: colors.lime[400], ...colors.lime },
            green: { DEFAULT: colors.green[400], ...colors.green },
            emerald: { DEFAULT: colors.emerald[400], ...colors.emerald },
            teal: { DEFAULT: colors.teal[400], ...colors.teal },
            cyan: { DEFAULT: colors.cyan[400], ...colors.cyan },
            sky: { DEFAULT: colors.sky[400], ...colors.sky },
            blue: { DEFAULT: colors.blue[400], ...colors.blue },
            indigo: { DEFAULT: colors.indigo[400], ...colors.indigo },
            violet: { DEFAULT: colors.violet[400], ...colors.violet },
            purple: { DEFAULT: colors.purple[400], ...colors.purple },
            fuchsia: { DEFAULT: colors.fuchsia[400], ...colors.fuchsia },
            pink: { DEFAULT: colors.pink[400], ...colors.pink },
            rose: { DEFAULT: colors.rose[400], ...colors.rose },
        },
        extend: {
            colors: {
                border: 'hsl(var(--border))',
                input: 'hsl(var(--input))',
                ring: 'hsl(var(--ring))',
                background: 'hsl(var(--background))',
                foreground: 'hsl(var(--foreground))',
                primary: {
                    DEFAULT: 'hsl(var(--primary))',
                    foreground: 'hsl(var(--primary-foreground))',
                },
                secondary: {
                    DEFAULT: 'hsl(var(--secondary))',
                    foreground: 'hsl(var(--secondary-foreground))',
                },
                destructive: {
                    DEFAULT: 'hsl(var(--destructive))',
                    foreground: 'hsl(var(--destructive-foreground))',
                },
                muted: {
                    DEFAULT: 'hsl(var(--muted))',
                    foreground: 'hsl(var(--muted-foreground))',
                },
                accent: {
                    DEFAULT: 'hsl(var(--accent))',
                    foreground: 'hsl(var(--accent-foreground))',
                },
                popover: {
                    DEFAULT: 'hsl(var(--popover))',
                    foreground: 'hsl(var(--popover-foreground))',
                },
                card: {
                    DEFAULT: 'hsl(var(--card))',
                    foreground: 'hsl(var(--card-foreground))',
                },
                chart: {
                    1: 'hsl(var(--chart-1))',
                    2: 'hsl(var(--chart-2))',
                    3: 'hsl(var(--chart-3))',
                    4: 'hsl(var(--chart-4))',
                    5: 'hsl(var(--chart-5))',
                },
            },
            borderRadius: {
                xl: 'calc(var(--radius) + 4px)',
                lg: 'var(--radius)',
                md: 'calc(var(--radius) - 2px)',
                sm: 'calc(var(--radius) - 4px)',
            },
            keyframes: {
                'accordion-down': {
                    from: {
                        height: 0,
                    },
                    to: {
                        height: 'var(--radix-accordion-content-height)',
                    },
                },
                'accordion-up': {
                    from: {
                        height: 'var(--radix-accordion-content-height)',
                    },
                    to: {
                        height: 0,
                    },
                },
                'collapsible-down': {
                    from: {
                        height: 0,
                    },
                    to: {
                        height: 'var(--radix-collapsible-content-height)',
                    },
                },
                'collapsible-up': {
                    from: {
                        height: 'var(--radix-collapsible-content-height)',
                    },
                    to: {
                        height: 0,
                    },
                },
            },
            animation: {
                'accordion-down': 'accordion-down 0.2s ease-out',
                'accordion-up': 'accordion-up 0.2s ease-out',
                'collapsible-down': 'collapsible-down 0.2s ease-in-out',
                'collapsible-up': 'collapsible-up 0.2s ease-in-out',
            },
        },
    },
    plugins: [animate, require('tailwindcss-animate')],
};
