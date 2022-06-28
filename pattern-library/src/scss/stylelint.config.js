module.exports = {
  extends: 'stylelint-config-wordpress',
  plugins: ['stylelint-scss'],
  rules: {
    'at-rule-no-unknown': null,
    'scss/at-rule-no-unknown': [
      true,
      {
        ignoreAtRules: [
          'tailwind',
          'apply',
          'variants',
          'responsive',
          'screen',
          'layer',
        ],
      },
    ],
    'block-no-empty': [
      true,
      {
        severity: 'warning',
      },
    ],
    'declaration-block-trailing-semicolon': null,
    'declaration-property-unit-whitelist': null,
    'declaration-property-unit-allowed-list': [
      {
        'line-height': ['rem'],
      },
    ],
    'font-weight-notation': null,
    'function-url-quotes': [
      'never',
      {
        severity: 'warning',
      },
    ],
    'max-line-length': null,
    'no-descending-specificity': null,
    'no-duplicate-selectors': null,
    'no-empty-source': null,
    'selector-class-pattern': [
      '^[a-z]+((-|__)[a-z]+)*',
      {
        message:
          'Selector should use lowercase and separate words with hyphens or double underscores (selector-class-pattern)',
      },
    ],
  },
  ignoreFiles: [
    '**/node_modules/*',
    '**/vendor/*',
    '**/assets/**/*.css',
    '**/wp-includes/**/*.css',
  ],
};
