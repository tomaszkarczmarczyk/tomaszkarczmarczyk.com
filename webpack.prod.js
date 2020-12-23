const TerserPlugin = require('terser-webpack-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const common = require('./webpack.common.js');
const { merge } = require('webpack-merge');

module.exports = merge(common, {
  mode: 'production',
  devtool: false,
  optimization: {
    minimizer: [new TerserPlugin(), new CssMinimizerPlugin()],
  },
});
