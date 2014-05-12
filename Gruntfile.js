module.exports = function(grunt) {
 
  grunt.initConfig({
 
    uglify: {
      dist: {
        src: "js/biz-vektor.js",
         dest: "js/biz-vektor-min.js"
      }
    },

    concat : {
      dist : {
        src : [
          'js/master.js',
          'js/res-vektor/res-vektor.js',
          'js/jquery.cookie.js'
        ],
          dest : 'js/biz-vektor.js'
        }
    },
    watch: {
      dev: {
        files: ["js/*.js"],
        tasks: ['concat','uglify']
      }
    }
 
  });
 
  //使うプラグインの読み込み
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
 
};