const defaultTheme = require('tailwindcss/defaultTheme');
const plugin = require('tailwindcss/plugin');
const selectorParser = require('postcss-selector-parser');

const remBase = 16;
const rem = (pixels) => `${pixels / remBase}rem`;

const colors = Object.assign({}, defaultTheme.colors, {
  current: 'currentColor',
  transparent: 'transparent',
  darken: {
    '10': 'rgba(0,0,0,0.1)',
    '20': 'rgba(0,0,0,0.2)',
    '30': 'rgba(0,0,0,0.3)',
    '40': 'rgba(0,0,0,0.4)',
    '50': 'rgba(0,0,0,0.5)',
    '60': 'rgba(0,0,0,0.6)',
    '70': 'rgba(0,0,0,0.7)',
    '80': 'rgba(0,0,0,0.8)',
    '90': 'rgba(0,0,0,0.9)',
  },
  lighten: {
    '10': 'rgba(255,255,255,0.1)',
    '20': 'rgba(255,255,255,0.2)',
    '30': 'rgba(255,255,255,0.3)',
    '40': 'rgba(255,255,255,0.4)',
    '50': 'rgba(255,255,255,0.5)',
    '60': 'rgba(255,255,255,0.6)',
    '70': 'rgba(255,255,255,0.7)',
    '80': 'rgba(255,255,255,0.8)',
    '90': 'rgba(255,255,255,0.9)',
  },
  red: {
    ...defaultTheme.colors.red,
    '700': '#A52423',
    '800': '#611317',
    '900': '#5F1215',
  },
  gray: {
    ...defaultTheme.colors.gray,
    DEFAULT: 'var(--color-secondary)',
    'light': 'var(--color-tertiary)',
    '200': '#ECECEC',
    '300': '#D8D8D8',
    '500': '#F0F0F0',
    '600': '#F2F2F2',
    '700': '#B9B9B9',
    '800': '#646464',
    '900': '#090B13',
  },
  hr: {
    DEFAULT: 'var(--color-hr)',
  },
});

colors.red.DEFAULT = colors.red['700'];
colors.green.DEFAULT = colors.green['500'];

colors.text = {
  DEFAULT: 'var(--color-text)',
  light: 'var(--color-text-light)',
};

colors.link = {
  light: 'var(--color-link-light)',
  DEFAULT: 'var(--color-link)',
  hover: 'var(--color-link-hover)',
};

colors.primary = {
  DEFAULT: 'var(--color-primary)',
};

colors.secondary = {
  DEFAULT: 'var(--color-secondary)',
};

colors.tertiary = {
  DEFAULT: 'var(--color-tertiary)',
};

module.exports = {
  mode: 'jit',
  purge: {
    content: [
      './js/*.js',
      // './**/components/**/*.twig',
      './**/components/**/*.js',
      './**/components/**/*.mdx',
      './**/*.php',
      './**/*.twig',
    ],
    options: {
      safelist: [
        'h-5',
        'w-5',
        /mb-4$/,
        /mb-8$/,
        /mb-16$/,
        /mb-20$/,
        /mb-30$/,
        /text-xl$/,
        /text-2xl$/,
        /text-3xl$/,
        /text-4xl$/,
        /text-5xl$/,
        /text-6xl$/,
        /text-8xl$/,
      ],
      variables: true,
    },
  },
  theme: {
    colors: colors,
    // fontSize: fontSizes,
    // fontFamily: fontFamilies,
    screens: {
      'print': { 'raw': 'print' },
      'sm-down': {
        max: rem(480 + 47),
      },
      xs: rem(360 + 48),
      'xs-only': {
        min: rem(360 + 48),
        max: rem(480 + 47),
      },
      sm: rem(480 + 48),
      'sm-only': {
        min: rem(480 + 47),
        max: rem(640 + 63),
      },
      'menu-sm': {
        max: rem(640 + 63),
      },
      'menu-md': rem(640 + 64),
      'menu-lg': rem(1120 + 64),
      md: rem(640 + 64),
      'md-only': {
        min: rem(640 + 64),
        max: rem(800 + 95),
      },
      lg: rem(800 + 96),
      'lg-only': {
        min: rem(800 + 96),
        max: rem(1008),
      },
      xl: rem(1009),
      'xl-only': {
        min: rem(1009),
        max: rem(1200 + 111),
      },
      '2xl': rem(1200 + 112),
      '3xl': rem(1440 + 112),
      '4xl': '150rem',
    },
    extend: {
      animation: (theme) => ({
        'opacity-in': `opacity-in ${theme('transitionDuration.700')}`,
        'opacity-out': `opacity-out ${theme('transitionDuration.700')}`,
      }),
      backgroundSize: {
        'fill-y': 'auto 100%',
        'fill-x': '100% auto',
      },
      boxShadow: {
        DEFAULT: '0px 2px 5px #00000008',
      },
      fontFamily: {
        sans: ['var(--font-sans)'],
        serif: ['var(--font-serif)'],
        display: ['var(--font-display)'],
        glyphs: ['Colby News Glyphs', 'Arial', 'sans-serif'],
      },
      fontSize: {
        inherit: 'inherit',
        xxs: ['var(--text-xxs)', 'var(--leading-xxs)'],
        xs: ['var(--text-xs)', 'var(--leading-xs)'],
        sm: ['var(--text-sm)', 'var(--leading-sm)'],
        md: ['var(--text-md)', 'var(--leading-md)'],
        base: ['var(--text-base)', 'var(--leading-base)'],
        lg: ['var(--text-lg)', 'var(--leading-lg)'],
        xl: ['var(--text-xl)', 'var(--leading-xl)'],
        '2xl': ['var(--text-2xl)', 'var(--leading-2xl)'],
        '3xl': ['var(--text-3xl)', 'var(--leading-3xl)'],
        '4xl': ['var(--text-4xl)', 'var(--leading-4xl)'],
        '5xl': ['var(--text-5xl)', 'var(--leading-5xl)'],
        '6xl': ['var(--text-6xl)', 'var(--leading-6xl)'],
        '7xl': ['var(--text-7xl)', 'var(--leading-7xl)'],
        '8xl': ['var(--text-8xl)', 'var(--leading-8xl)'],
        '9xl': ['var(--text-9xl)', 'var(--leading-9xl)'],
        'xxs-plus-1': [
          'calc(var(--text-xxs) + 0.0625rem)',
          'var(--leading-xxs)',
        ],
        'xs-plus-1': ['calc(var(--text-xs) + 0.0625rem)', 'var(--leading-xs)'],
        'sm-plus-1': ['calc(var(--text-sm) + 0.0625rem)', 'var(--leading-sm)'],
        'base-plus-1': [
          'calc(var(--text-base) + 0.0625rem)',
          'var(--leading-base)',
        ],
        'lg-plus-1': ['calc(var(--text-lg) + 0.0625rem)', 'var(--leading-lg)'],
        'xl-plus-1': ['calc(var(--text-xl) + 0.0625rem)', 'var(--leading-xl)'],
        '2xl-plus-1': [
          'calc(var(--text-2xl) + 0.0625rem)',
          'var(--leading-2xl)',
        ],
        '3xl-plus-1': [
          'calc(var(--text-3xl) + 0.0625rem)',
          'var(--leading-3xl)',
        ],
        '4xl-plus-1': [
          'calc(var(--text-4xl) + 0.0625rem)',
          'var(--leading-4xl)',
        ],
        '5xl-plus-1': [
          'calc(var(--text-5xl) + 0.0625rem)',
          'var(--leading-5xl)',
        ],
        '6xl-plus-1': [
          'calc(var(--text-6xl) + 0.0625rem)',
          'var(--leading-6xl)',
        ],
        '7xl-plus-1': [
          'calc(var(--text-7xl) + 0.0625rem)',
          'var(--leading-7xl)',
        ],
        '8xl-plus-1': [
          'calc(var(--text-8xl) + 0.0625rem)',
          'var(--leading-8xl)',
        ],
        '9xl-plus-1': [
          'calc(var(--text-9xl) + 0.0625rem)',
          'var(--leading-9xl)',
        ],
        'xxs-plus-2': [
          'calc(var(--text-xxs) + 0.125rem)',
          'var(--leading-xxs)',
        ],
        'xs-plus-2': ['calc(var(--text-xs) + 0.125rem)', 'var(--leading-xs)'],
        'sm-plus-2': ['calc(var(--text-sm) + 0.125rem)', 'var(--leading-sm)'],
        'base-plus-2': [
          'calc(var(--text-base) + 0.125rem)',
          'var(--leading-base)',
        ],
        'lg-plus-2': ['calc(var(--text-lg) + 0.125rem)', 'var(--leading-lg)'],
        'xl-plus-2': ['calc(var(--text-xl) + 0.125rem)', 'var(--leading-xl)'],
        '2xl-plus-2': [
          'calc(var(--text-2xl) + 0.125rem)',
          'var(--leading-2xl)',
        ],
        '3xl-plus-2': [
          'calc(var(--text-3xl) + 0.125rem)',
          'var(--leading-3xl)',
        ],
        '4xl-plus-2': [
          'calc(var(--text-4xl) + 0.125rem)',
          'var(--leading-4xl)',
        ],
        '5xl-plus-2': [
          'calc(var(--text-5xl) + 0.125rem)',
          'var(--leading-5xl)',
        ],
        '6xl-plus-2': [
          'calc(var(--text-6xl) + 0.125rem)',
          'var(--leading-6xl)',
        ],
        '7xl-plus-2': [
          'calc(var(--text-7xl) + 0.125rem)',
          'var(--leading-7xl)',
        ],
        '8xl-plus-2': [
          'calc(var(--text-8xl) + 0.125rem)',
          'var(--leading-8xl)',
        ],
        '9xl-plus-2': [
          'calc(var(--text-9xl) + 0.125rem)',
          'var(--leading-9xl)',
        ],
        'xxs-minus-1': [
          'calc(var(--text-xxs) - 0.0625rem)',
          'var(--leading-xxs)',
        ],
        'xs-minus-1': ['calc(var(--text-xs) - 0.0625rem)', 'var(--leading-xs)'],
        'sm-minus-1': ['calc(var(--text-sm) - 0.0625rem)', 'var(--leading-sm)'],
        'base-minus-1': [
          'calc(var(--text-base) - 0.0625rem)',
          'var(--leading-base)',
        ],
        'lg-minus-1': ['calc(var(--text-lg) - 0.0625rem)', 'var(--leading-lg)'],
        'xl-minus-1': ['calc(var(--text-xl) - 0.0625rem)', 'var(--leading-xl)'],
        '2xl-minus-1': [
          'calc(var(--text-2xl) - 0.0625rem)',
          'var(--leading-2xl)',
        ],
        '3xl-minus-1': [
          'calc(var(--text-3xl) - 0.0625rem)',
          'var(--leading-3xl)',
        ],
        '4xl-minus-1': [
          'calc(var(--text-4xl) - 0.0625rem)',
          'var(--leading-4xl)',
        ],
        '5xl-minus-1': [
          'calc(var(--text-5xl) - 0.0625rem)',
          'var(--leading-5xl)',
        ],
        '6xl-minus-1': [
          'calc(var(--text-6xl) - 0.0625rem)',
          'var(--leading-6xl)',
        ],
        '7xl-minus-1': [
          'calc(var(--text-7xl) - 0.0625rem)',
          'var(--leading-7xl)',
        ],
        '8xl-minus-1': [
          'calc(var(--text-8xl) - 0.0625rem)',
          'var(--leading-8xl)',
        ],
        '9xl-minus-1': [
          'calc(var(--text-9xl) - 0.0625rem)',
          'var(--leading-9xl)',
        ],
        'xxs-minus-2': [
          'calc(var(--text-xxs) - 0.125rem)',
          'var(--leading-xxs)',
        ],
        'xs-minus-2': ['calc(var(--text-xs) - 0.125rem)', 'var(--leading-xs)'],
        'sm-minus-2': ['calc(var(--text-sm) - 0.125rem)', 'var(--leading-sm)'],
        'base-minus-2': [
          'calc(var(--text-base) - 0.125rem)',
          'var(--leading-base)',
        ],
        'lg-minus-2': ['calc(var(--text-lg) - 0.125rem)', 'var(--leading-lg)'],
        'xl-minus-2': ['calc(var(--text-xl) - 0.125rem)', 'var(--leading-xl)'],
        '2xl-minus-2': [
          'calc(var(--text-2xl) - 0.125rem)',
          'var(--leading-2xl)',
        ],
        '3xl-minus-2': [
          'calc(var(--text-3xl) - 0.125rem)',
          'var(--leading-3xl)',
        ],
        '4xl-minus-2': [
          'calc(var(--text-4xl) - 0.125rem)',
          'var(--leading-4xl)',
        ],
        '5xl-minus-2': [
          'calc(var(--text-5xl) - 0.125rem)',
          'var(--leading-5xl)',
        ],
        '6xl-minus-2': [
          'calc(var(--text-6xl) - 0.125rem)',
          'var(--leading-6xl)',
        ],
        '7xl-minus-2': [
          'calc(var(--text-7xl) - 0.125rem)',
          'var(--leading-7xl)',
        ],
        '8xl-minus-2': [
          'calc(var(--text-8xl) - 0.125rem)',
          'var(--leading-8xl)',
        ],
        '9xl-minus-2': [
          'calc(var(--text-9xl) - 0.125rem)',
          'var(--leading-9xl)',
        ],
      },
      gridTemplateColumns: {
        'sidebar': '1fr max-content',
      },
      keyframes: {
        'opacity-in': {
          '0%': { '@apply opacity-0': '' },
          '100%': { '@apply opacity-100': '' },
        },
        'opacity-out': {
          '0%': { '@apply opacity-100': '' },
          '100%': { '@apply opacity-0': '' },
        },
      },
      lineHeight: {
        '0': '0',
        'display': 'var(--leading-display)',
        'xtight': 'var(--leading-xtight)',
      },
      maxHeight: {
        236: '59rem',
      },
      minHeight: (theme) => theme.spacing,
      maxWidth: {
        '1/4': '25%',
        '1/2': '50%',
        '3/4': '75%',
        '90': '22.5rem',
        '2400': '150rem',
        screen: '100vw',
      },
      opacity: {
        15: '0.15',
      },
      spacing: {
        '7_5': '1.875rem',
        15: '3.75rem',
        30: '7.5rem',
        90: '22.5rem',
        bleed: 'calc(50% - 50vw)',
        'container-gutter': 'var(--container-gutter)',
        'page-padding': 'var(--page-padding)',
      },
      transitionDuration: {
        DEFAULT: '250ms',
      },
      transitionProperty: {
        size: 'height, width',
        colors: `${defaultTheme.transitionProperty.colors}, background-size, text-decoration-color, box-shadow`,
      },
      zIndex: {
        100: '100',
        '-10': '-10',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('tailwindcss-interaction-variants'),
    require('@tailwindcss/aspect-ratio'),
    require('tailwindcss-pseudo-elements'),
    plugin(({ addUtilities, addVariant }) => {
      addUtilities({
        // TW uses 'content-' for `align-content` utilities, so just be careful to avoid name-conflicts: https://tailwindcss.com/docs/align-content
        '.content-empty': { content: '""' },
        '.content-none': { content: 'none' },
        '.content-pipe': { content: ['"|"', '"|" / ""'] },
        '.content-bullet': { content: ['"•"', '"•" / ""'] },
      });

      /* for targeting when element has `aria-hidden="true"` */
      addVariant('aria-hidden', ({ modifySelectors, separator }) => {
        return modifySelectors(({ selector }) => {
          return selectorParser((selectors) => {
            selectors.walkClasses((classNode) => {
              classNode.value = `aria-hidden${separator}${classNode.value}`;
              classNode.parent.insertBefore(
                classNode,
                selectorParser().astSync('[aria-hidden="true"]')
              );
            });
          }).processSync(selector);
        });
      });

      /* for targeting when element has `.stuck` class (works w/ StickyEvents in site-header.js) */
      addVariant('stuck', ({ modifySelectors, separator }) => {
        return modifySelectors(({ selector }) => {
          return selectorParser((selectors) => {
            selectors.walkClasses((classNode) => {
              classNode.value = `stuck${separator}${classNode.value}`;
              classNode.parent.insertBefore(
                classNode,
                selectorParser().astSync('.stuck')
              );
            });
          }).processSync(selector);
        });
      });

      /* for targeting when element has `.selected` class (see site-header.js and site-header.twig) */
      addVariant('selected', ({ modifySelectors, separator }) => {
        return modifySelectors(({ selector }) => {
          return selectorParser((selectors) => {
            selectors.walkClasses((classNode) => {
              classNode.value = `selected${separator}${classNode.value}`;
              classNode.parent.insertBefore(
                classNode,
                selectorParser().astSync('.selected')
              );
            });
          }).processSync(selector);
        });
      });

      /* `children:` for targeting all direct children of the element in question */
      addVariant('children', ({ modifySelectors, separator }) => {
        return modifySelectors(({ selector }) => {
          return selectorParser((selectors) => {
            selectors.walkClasses((classNode) => {
              classNode.value = `children${separator}${classNode.value}`;
              classNode.parent.insertAfter(
                classNode,
                selectorParser().astSync(' > *')
              );
            });
          }).processSync(selector);
        });
      });

      /* `descendants:` for targeting all descendants of the element in question (e.g., `descendants:h-full`) */
      addVariant('descendants', ({ modifySelectors, separator }) => {
        return modifySelectors(({ selector }) => {
          return selectorParser((selectors) => {
            selectors.walkClasses((classNode) => {
              classNode.value = `descendants${separator}${classNode.value}`;
              classNode.parent.insertAfter(
                classNode,
                selectorParser().astSync(' *')
              );
            });
          }).processSync(selector);
        });
      });

      /* `descendant-img:` for targeting all descendant-images of the element in question (e.g., `descendant-img:object-cover`) */
      addVariant('descendant-img', ({ modifySelectors, separator }) => {
        return modifySelectors(({ selector }) => {
          return selectorParser((selectors) => {
            selectors.walkClasses((classNode) => {
              classNode.value = `descendant-img${separator}${classNode.value}`;
              classNode.parent.insertAfter(
                classNode,
                selectorParser().astSync(' img')
              );
            });
          }).processSync(selector);
        });
      });

      /* `descendant-a:` for targeting all descendant anchors of the element in question (e.g., `descendant-a:text-lg`) */
      addVariant('descendant-a', ({ modifySelectors, separator }) => {
        return modifySelectors(({ selector }) => {
          return selectorParser((selectors) => {
            selectors.walkClasses((classNode) => {
              classNode.value = `descendant-a${separator}${classNode.value}`;
              classNode.parent.insertAfter(
                classNode,
                selectorParser().astSync(' a')
              );
            });
          }).processSync(selector);
        });
      });

      /* `descendant-figcaption:` for targeting all descendant figcaptions of the element in question (e.g., `descendant-figcaption:text-lg`) */
      addVariant('descendant-figcaption', ({ modifySelectors, separator }) => {
        return modifySelectors(({ selector }) => {
          return selectorParser((selectors) => {
            selectors.walkClasses((classNode) => {
              classNode.value = `descendant-figcaption${separator}${classNode.value}`;
              classNode.parent.insertAfter(
                classNode,
                selectorParser().astSync(' figcaption')
              );
            });
          }).processSync(selector);
        });
      });
    }),
  ],
  corePlugins: {
    container: false,
  },
};
