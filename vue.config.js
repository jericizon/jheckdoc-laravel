const path = require('path');

module.exports = {
  css: {
    extract: true,
  },
  pluginOptions: {
    'style-resources-loader': {
      preProcessor: 'scss',
      patterns: [
        // only include less file with variables and mixins
        // not those that will generate actual css
      ],
    },
  },
  configureWebpack: {
    plugins: [],
  },
  lintOnSave: false,
  chainWebpack: (config) => {
    if (config.plugins.has('extract-css')) {
      const extractCSSPlugin = config.plugin('extract-css');
      extractCSSPlugin && extractCSSPlugin.tap(() => [{
        filename: 'css/[name].css',
        chunkFilename: 'css/[name].css',
      }]);
    }
  },
  configureWebpack: {
    output: {
      filename: 'js/[name].js',
      chunkFilename: 'js/[name].js',
    },
  },
};
