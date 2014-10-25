module.exports = function(grunt) {
 
  grunt.initConfig({
 


    cssmin:{
    compress: {
        files: {
          "css/bizvektor_common_min.css":[
            'css/bizvektor_common.css',
            'js/res-vektor/res-vektor.css',
            'js/flexslider/flexslider.css',
          ]
        }
      }
    },

    concat : {
      dist : {
        src : [
          'js/master.js',
          'js/res-vektor/res-vektor.js',
          'js/jquery.cookie.js',
          'js/jquery.flatheights.js'
        ],
          dest : 'js/biz-vektor.js'
        }
    },

    uglify: {
      dist: {
        src: "js/biz-vektor.js",
         dest: "js/biz-vektor-min.js"
      }
    },

    watch: {
      scripts_css_min: {
        files: ["css/*.css"],
        tasks: ['cssmin']
      },
      script_js: {
        files: ["js/*.js"],
        tasks: ['concat','uglify']
      }
    }

  });

  //使うプラグインの読み込み
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
};