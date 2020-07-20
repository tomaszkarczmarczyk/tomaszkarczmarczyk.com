const { src, dest, watch, lastRun, series, parallel } = require('gulp');
const { argv } = require('yargs');
const del = require('del');
const sourcemaps = require('gulp-sourcemaps');
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const rename = require('gulp-rename');
const gulpif = require('gulp-if');
const babel = require('gulp-babel');
const terser = require('gulp-terser-js');
const changed = require('gulp-changed');
const dependents = require('gulp-dependents');
const debug = require('gulp-debug');
const rsync = require('gulp-rsync');
const imagemin = require('gulp-imagemin');
const imageminJPG = require('imagemin-mozjpeg');
const imageminPNG = require('imagemin-pngquant');
const imageminWebP = require('imagemin-webp');
const imageminSVG = require('imagemin-svgo');
const info = require('./package.json');

const PRODUCTION = argv.production;

sass.compiler = require('node-sass');

const dirs = {
  src: 'src',
  dist: 'dist',
  dev: `/mnt/c/xampp/htdocs/blog/wp-content/themes/${info.name}`,
};

const files = {
  scss: '/**/*.scss',
  js: '/**/*.js',
  php: '/**/*.php',
  images: '/**/*.@(jpg|png)',
  svg: '/**/*.svg',
  others: '/**/*.css',
  all: '/**',
};

const rsyncConfig = {
  root: dirs.dist,
  destination: dirs.dev,
  incremental: true,
  compress: true,
  recursive: true,
  times: true,
  clean: true,
  silent: true,
};

const clean = () => {
  return del(dirs.dist);
};

const scss = () => {
  return src(`${dirs.src}${files.scss}`, { since: lastRun(scss) })
    .pipe(dependents())
    .pipe(debug({ title: 'Debug:' }))
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(sass({ outputStyle: PRODUCTION ? 'compressed' : 'expanded' }).on('error', sass.logError))
    .pipe(postcss())
    .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
    .pipe(
      rename(function (path) {
        path.dirname = path.dirname.replace('scss', 'css');
      })
    )
    .pipe(dest(dirs.dist));
};

const js = () => {
  return src(`${dirs.src}${files.js}`, { since: lastRun(js) })
    .pipe(changed(dirs.dist))
    .pipe(debug({ title: 'Debug:' }))
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(babel())
    .pipe(terser())
    .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
    .pipe(dest(dirs.dist));
};

const php = () => {
  return src(`${dirs.src}${files.php}`, { since: lastRun(php) })
    .pipe(changed(dirs.dist))
    .pipe(debug({ title: 'Debug:' }))
    .pipe(dest(dirs.dist));
};

const images = () => {
  return src(`${dirs.src}${files.images}`, { since: lastRun(images) })
    .pipe(changed(dirs.dist))
    .pipe(debug({ title: 'Debug:' }))
    .pipe(
      imagemin([imageminJPG({ quality: 75 }), imageminPNG({ speed: 1, strip: true, quality: [0.2, 0.3] })], {
        verbose: true,
      })
    )
    .pipe(dest(dirs.dist));
};

const webp = () => {
  return src(`${dirs.src}${files.images}`, { since: lastRun(webp) })
    .pipe(changed(dirs.dist, { extension: '.webp' }))
    .pipe(debug({ title: 'Debug:' }))
    .pipe(
      imagemin([imageminWebP({ method: 6, sns: 100 })], {
        verbose: true,
      })
    )
    .pipe(rename({ extname: '.webp' }))
    .pipe(dest(dirs.dist));
};

const svg = () => {
  return src(`${dirs.src}${files.svg}`, { since: lastRun(svg) })
    .pipe(changed(dirs.dist))
    .pipe(debug({ title: 'Debug:' }))
    .pipe(
      imagemin([imageminSVG()], {
        verbose: true,
      })
    )
    .pipe(dest(dirs.dist));
};

const copy = () => {
  return src(`${dirs.src}${files.others}`, { since: lastRun(copy) })
    .pipe(changed(dirs.dist))
    .pipe(debug({ title: 'Debug:' }))
    .pipe(dest(dirs.dist));
};

const deploy = () => {
  return src(`${dirs.dist}${files.all}`).pipe(rsync(rsyncConfig));
};

const watchFiles = (label, files, task) => {
  watch(files, { delay: 1000 }, task)
    .on('ready', () => {
      console.log(`${label} watcher is ready`);
    })
    .on('add', (path) => {
      console.log(`File "${path}" was added`);
    })
    .on('change', (path) => {
      console.log(`File "${path}" was changed`);
    })
    .on('unlink', (path) => {
      if (path.includes(dirs.src)) {
        const re = /\.(jpg|png)$/i;
        const file = path.replace(dirs.src, dirs.dist);

        del(file);
        console.log(`File "${file}" was deleted`);

        if (file.match(re)) {
          const webpIMG = file.replace(re, '.webp');
          del(webpIMG);
          console.log(`File "${webpIMG}" was deleted`);
        }
      }
    });
};

const watchForChanges = () => {
  watchFiles('SCSS', `${dirs.src}${files.scss}`, scss);
  watchFiles('JS', `${dirs.src}${files.js}`, js);
  watchFiles('PHP', `${dirs.src}${files.php}`, php);
  watchFiles('IMAGES', `${dirs.src}${files.images}`, series(images, webp));
  watchFiles('SVG', `${dirs.src}${files.svg}`, svg);
  watchFiles('COPY', `${dirs.src}${files.others}`, copy);
  watchFiles('DEPLOY', `${dirs.dist}${files.all}`, deploy);
};

exports.clean = clean;
exports.scss = scss;
exports.js = js;
exports.php = php;
exports.images = images;
exports.webp = webp;
exports.svg = svg;
exports.copy = copy;
exports.deploy = deploy;
exports.watch = watchForChanges;
exports.build = series(clean, parallel(scss, js, php, images, webp, svg, copy));
exports.default = series(clean, parallel(scss, js, php, images, webp, svg, copy), watchForChanges);
