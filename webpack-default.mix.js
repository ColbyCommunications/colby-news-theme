const mix = require('laravel-mix');
const glob = require('glob');
const tailwindcss = require('tailwindcss');
require('mix-env-file');
require('laravel-mix-polyfill');
require('@ayctor/laravel-mix-svg-sprite');
require('laravel-mix-string-replace');
require('laravel-mix-copy-watched');

exports.buildPaths = (overrides = {}) => {
  const defaultPaths = {
    icons: 'icons',
    scss: 'scss',
    js: 'js',
    vue: 'vue',
  };

  const fixedPaths = {
    srcRoot: 'pattern-library/src',
    dist: 'assets',
    fonts: 'fonts',
    images: 'images',
  };

  const newPaths = Object.assign(defaultPaths, overrides);
  return Object.assign(newPaths, fixedPaths);
};

exports.spritePrefixer = (paths) => (fullPath) => {
  const iconRoot = paths.icons ? paths.icons : paths.srcRoot;

  const pathParts = fullPath.split('/');
  const rootIndex = pathParts.lastIndexOf(iconRoot);

  const prefixes = pathParts.slice(rootIndex + 1, -1);

  if (!prefixes.length) {
    return '';
  }

  return prefixes.join('-') + '-';
};

exports.defaultMix = (paths) => {
  return mix
    .env(process.env.ENV_FILE)
    .extract()
    .copyDirectoryWatched(
      `${paths.srcRoot}/${paths.images}`,
      `${paths.dist}/images`
    )
    .copyDirectoryWatched(
      `${paths.srcRoot}/${paths.fonts}`,
      `${paths.dist}/fonts`
    );
  // .polyfill({
  //   enabled: false,
  //   useBuiltIns: "usage",
  //   targets: false,
  // });
};
