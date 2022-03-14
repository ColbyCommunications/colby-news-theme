const tailwindcss = require('tailwindcss');
const postcssPresetEnv = require('postcss-preset-env');


const nodeEnv = process.env.NODE_ENV;
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

const mix = require('./webpack-default.mix.js').defaultMix(assetPaths);
const spritePrefixer = require('./webpack-default.mix.js').spritePrefixer(
  assetPaths
);

/**
 * Begin custom Mix steps
 */

mix
  .then(() => {
    console.log(`NODE_ENV = ${nodeEnv}`);
  })
  .sass(
    `${assetPaths.srcRoot}/${assetPaths.scss}/tailwind.scss`,
    `${assetPaths.dist}/css/`
  )
  .options({
    processCssUrls: false,
    postCss: [
      tailwindcss('./tailwind.config.js'),
      postcssPresetEnv()
    ],
  })
  // .js(`${assetPaths.srcRoot}/index.js`, `${assetPaths.dist}/`)
  .svgSprite(`${assetPaths.srcRoot}/${assetPaths.icons}/**/*.svg`, {
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

