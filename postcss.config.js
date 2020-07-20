module.exports = {
  plugins: [
    require('autoprefixer'),
    require('postcss-sort-media-queries'),
    require('postcss-combine-duplicated-selectors'),
  ],
};
