// require('dotenv').config({ path: '../../../../.env' });
const Dotenv = require('dotenv-webpack');
const tailwindcss = require('tailwindcss');
const postcssPresetEnv = require('postcss-preset-env');

const nodeEnv = process.env.NODE_ENV;

const mix = require('laravel-mix');
/**
 * Default paths, relative to /app/src:
 * {
 *   icons: "icons",
 *   scss: "scss",
 *   js: "js"
 * }
 *
 * To override or add path values, pass an object to `buildPaths()`
 * e.g. `require('./webpack-default.mix.js').buildPaths({ icons: "custom-icons", newPath: "new-directory" });`
 *
 * The following path names are reserved by the builder and cannot be overwritten:
 *   srcRoot, dist, images, fonts
 */
const assetPaths = require('./webpack-default.mix.js').buildPaths();

// const mix = require('./webpack-default.mix.js').defaultMix(assetPaths);
const spritePrefixer = require('./webpack-default.mix.js').spritePrefixer(
  assetPaths
);

mix
  .js(`./vue/main.js`, `assets/`)
  .vue({ version: 3 })
  .sass(`pattern-library/src/scss/tailwind.scss`, `assets/css/`)
  .options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.config.js'), postcssPresetEnv()],
  })
  .svgSprite(`pattern-library/src/icons/**/*.svg`, {
    output: {
      filename: `dist/icons/icon-sprites.svg`,
      svg4everybody: true,
    },
    sprite: {
      prefix: spritePrefixer,
      generate: {
        title: false,
      },
    },
  });
// .env(process.env.ENV_FILE);
mix.options({
  terser: {
    terserOptions: {
      mangle: true,
    },
  },
});

mix.webpackConfig({
  plugins: [
    new Dotenv({
      path: '../../../../.env',
    }),
  ],
});
