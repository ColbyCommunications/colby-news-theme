module.exports = {
  env: {
    browser: true,
    es2021: true,
  },
  extends: [
    'eslint:recommended',
    'plugin:import/errors',
    'plugin:react/recommended',
    'plugin:jsx-a11y/recommended',
    'prettier',
  ],
  globals: {
    wp: true,
    Cookies: true,
    Vimeo: true,
    jQuery: true,
    react: true,
    faker: true,
    acf: true,
    require: true,
  },
  parserOptions: {
    ecmaVersion: 12,
    sourceType: 'module',
    ecmaFeatures: {
      jsx: true,
    },
  },
  rules: {
    'react/prop-types': 0,
    'react/jsx-uses-react': 1,
    'react/jsx-uses-vars': 1,
    'no-console': 0,
    'jsx-a11y/no-redundant-roles': [
      'error',
      {
        ul: ['list'],
      },
    ],
    'react-hooks/rules-of-hooks': 'error',
    'react-hooks/exhaustive-deps': 'warn',
    'import/prefer-default-export': 1,
    'import/no-unresolved': 0,
    'import/no-absolute-path': 0,
    'quote-props': ['error', 'as-needed'],
  },
  plugins: ['prettier', 'react', 'import', 'jsx-a11y', 'react-hooks'],
};