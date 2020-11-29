const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = {
  context: path.resolve(__dirname, 'resources', 'js'),
  entry: {
    main: './index.js',
    gutenberg: './gutenberg.js',
  },
  plugins: [
    new CleanWebpackPlugin(),
    new MiniCssExtractPlugin({
      filename: 'css/[name].css',
    }),
  ],
  output: {
    filename: 'js/[name].js',
    path: path.resolve(__dirname, 'assets'),
  },
  module: {
    rules: [
      {
        test: /\.scss$/i,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              importLoaders: 2,
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  'postcss-preset-env',
                  'postcss-combine-media-query',
                  'postcss-combine-duplicated-selectors',
                ],
              },
            },
          },
          {
            loader: 'sass-loader',
            options: {
              implementation: require('node-sass'),
              sassOptions: {
                outputStyle: 'expanded',
              },
            },
          },
        ],
      },
      {
        test: /\.js$/i,
        use: [
          {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env'],
            },
          },
        ],
      },
      {
        test: /\.(jpe?g|png|svg)$/i,
        use: [
          {
            loader: 'file-loader',
            options: {
              name(resourcePath) {
                const dir = path.extname(resourcePath) === '.svg' ? 'svg' : 'images';
                return `${dir}/[name].[ext]`;
              },
            },
          },
          {
            loader: 'img-loader',
            options: {
              plugins: [
                require('imagemin-mozjpeg')(),
                require('imagemin-pngquant')(),
                require('imagemin-svgo')(),
              ],
            },
          },
        ],
      },
    ],
  },
};
