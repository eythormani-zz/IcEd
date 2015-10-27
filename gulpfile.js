// development stage build system.

  // syncs the site once files are changed

  var gulp         = require('gulp');
  // used for compileing scss and sass into css
  var sass         = require('gulp-ruby-sass');
  var watch        = require('gulp-watch');
  // handles prefixes for all things css like a champ
  // var prefix       = require('gulp-autoprefixer');
  // Brings js files into one
  var concat = require('gulp-concat');
  // create event for sass to css compileation, auto prefixer runs to make sure
  // to add sass files to the project, INCLUDE THEM IN MAIN.SASS.


  gulp.task('sass', function () {
      return sass('./_precompiled/styles/main.scss')
         // .pipe(prefix(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], { cascade: true }))
         .pipe(gulp.dest('_site/assets/style'));
 });

  // for use with javascript. if you want a file linked to html, add it to this array of js files.
  // the order within the array defines where in line it will be linked to html.(it wont really get linked but it workes the same)
  gulp.task('scripts', function() {
    return gulp.src(['./_precompiled/scripts/javascripts/jquery.js','./_precompiled/scripts/javascripts/jquery.js', './_precompiled/scripts/javascripts/main.js'])
      .pipe(concat('main.js'))
      .pipe(gulp.dest('./_site/assets/js/'));
  });


  //create a function for watch that runs sass anytime the sass file changes
  gulp.task('watch', function () {
      gulp.watch('_precompiled/styles/*.scss', ['sass']);
      gulp.watch('./_precompiled/scripts/javascripts/*.js',['scripts']);
  });

  //  Default task, running just `gulp` will compile the sass,
  //launch default as watch
  gulp.task('default', ['sass','watch','scripts']);
