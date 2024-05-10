const { src, dest, watch, series, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss')
const sourcemaps = require('gulp-sourcemaps')
const cssnano = require('cssnano');
const concat = require('gulp-concat');
const terser = require('gulp-terser-js');
const rename = require('gulp-rename');
const imagemin = require('gulp-imagemin'); 
const notify = require('gulp-notify');
const cache = require('gulp-cache');
const clean = require('gulp-clean');
const webp = require('gulp-webp');

const paths = {
    scss: 'src/sass/**/*.scss',
    js: 'src/js/**/*.js',
    imagenes: 'assets/common/images/images/**/*'
};


function css() {
    return src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('src/css'));
}

function javascript() {
    return src(paths.js)
      .pipe(sourcemaps.init())
      .pipe(concat('app.js'))
      .pipe(terser())
      .pipe(sourcemaps.write('.'))
      .pipe(rename({ suffix: '.min' }))
      .pipe(dest('./src/min-js')) 
}


const imageminOptions = {
    optimizationLevel: 10,
    progressive: true,
    interlaced: true,
   
};

const webpOptions = {
    quality: 60, 
    // Agregar otras opciones de WebP si es necesario
};

function imagenes() {
    return src(paths.imagenes)
        .pipe(cache(imagemin(imageminOptions)))
        .pipe(dest('assets/common/images/images-min'))
        .pipe(notify({ message: 'Imagen Completada' }));
}

function versionWebp() {
    return src(paths.imagenes)
        .pipe(webp(webpOptions))
        .pipe(dest('assets/common/images/images-webp'))
        .pipe(notify({ message: 'Imagen Completada' }));
}



function watchArchivos() {
    watch(paths.scss, css);
    watch(paths.js, javascript);
    watch(paths.imagenes, imagenes);
    watch(paths.imagenes, versionWebp);
}

exports.css = css;
exports.watchArchivos = watchArchivos;
exports.default = parallel(css, javascript, imagenes, versionWebp, watchArchivos); 