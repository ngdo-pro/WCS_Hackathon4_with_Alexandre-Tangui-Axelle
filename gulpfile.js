var gulp    = require('gulp');
var concat  = require('gulp-concat');
var clean   = require('gulp-clean');
var uglify  = require('gulp-uglify');
var sass    = require('gulp-sass');

//paths is an object containing all paths of the assets
var paths = {
    vendorJs: [
        './app/Resources/front_end/vendors/vue/dist/vue.min.js',
        './app/Resources/front_end/vendors/jquery/dist/jquery.min.js',
        './app/Resources/front_end/vendors/materialize/dist/js/materialize.min.js'
    ],
    vendorCss: [
        './app/Resources/front_end/vendors/materialize/dist/css/materialize.min.css'
    ],
    fonts: [
        './app/Resources/front_end/vendors/materialize/dist/fonts/**/*'
    ],
    js: [
        './app/Resources/front_end/dev/js/*.js'
    ],
    sass: [
        './app/Resources/front_end/dev/sass/**/*.sass',
        './app/Resources/front_end/dev/sass/*.sass'
    ],
    images: [
        './app/Resources/front_end/dev/sass/media/images/*'
    ],
    videos: [
        './app/Resources/front_end/dev/sass/media/videos/*'
    ],
    dist: {
        js:         './web/assets/js',
        css:        './web/assets/css',
        fonts:      './web/assets/fonts',
        assets:     './web/assets',
        images:     './web/assets/media/images',
        video:      './web/assets/media/videos'
    }
};

//the "default" tasks runs all the tasks, allowing to only run "gulp" command.
gulp.task('default', ['vendors', 'src'], function(){

});

//the "vendor-js" task minify all the vendors' js files and concatenate them in /web/assets/js/vendor.js
gulp.task('vendor-js', function(){
    return gulp.src(paths.vendorJs)
        .pipe(uglify())
        .pipe(concat('vendor.js'))
        .pipe(gulp.dest(paths.dist.js))
});

//the "vendor-css" task minify all the vendors' css files and concatenate them in /web/assets/css/vendor.css
gulp.task('vendor-css', function(){
    return gulp.src(paths.vendorCss)
        .pipe(concat('vendor.css'))
        .pipe(gulp.dest(paths.dist.css))
});

//the "fonts" task only copy fonts to the /web/assets/fonts directory
gulp.task('fonts', function(){
    return gulp.src(paths.fonts)
        .pipe(gulp.dest(paths.dist.fonts))
});

//the "vendors" task regroup all vendors tasks
gulp.task('vendors', ['vendor-js', 'vendor-css', 'fonts'], function(){

});

//the "js" task minify the js files and concatenate them in /web/assets/js/app.js
gulp.task('js', function(){
    return gulp.src(paths.js)
        .pipe(uglify())
        .pipe(concat('app.js'))
        .pipe(gulp.dest(paths.dist.js))
});

//the "sass" task create a uniq, minified css file with all the compiled sass files and concatenate them in /web/assets/css/app.css
gulp.task('sass', function(){
    return gulp.src(paths.sass)
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(concat('app.css'))
        .pipe(gulp.dest(paths.dist.css))
});

//the "images" task moves images

gulp.task('images', function(){
    return gulp.src(paths.images)
        .pipe(gulp.dest(paths.dist.images))
});

//the "videos" task moves images

gulp.task('videos', function(){
    return gulp.src(paths.videos)
        .pipe(gulp.dest(paths.dist.videos))
});

//the "src" task regroup all the sources (made by us) tasks
gulp.task('src', ['js', 'sass', 'images'], function(){

});

//the "watch" file automatically runs other tasks on change on "watched" files
gulp.task('watch', function(){
    gulp.watch([paths.sass], ['sass'])
});

//the "clean" task delete the /web/assets directory
gulp.task('clean', function(){
    return gulp.src([paths.dist.assets], {read: false}).pipe(clean());
});