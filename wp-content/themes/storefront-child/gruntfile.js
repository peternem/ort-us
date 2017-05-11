module.exports = function (grunt) {
    require('jit-grunt')(grunt);
    grunt.config('phplint', {
        options: {
            phpCmd: "/usr/bin/php",
            phpArgs: {
                '-lf': true
            }
        },
        all: {
            src: '<%= paths.php.files %>'
        }
    });
    grunt.initConfig({
        less: {
            development: {
                options: {
                    compress: false,
                    yuicompress: false,
                    optimization: null
                },
                files: {
                    "style.css": "style.less",
                    "css/ortlieb-styles.css": "less/ortlieb-styles.less"// destination file and source file

                }
            },
            production: {
                options: {
                    compress: true,
                    yuicompress: true,
                    optimization: null
                },
                files: {
                    "css/ortlieb-styles.min.css": "css/ortlieb-styles.css"// destination file and source file file and source file
                }
            }
        },
        watch: {
            s: {
                files: ['less/**/*.less', '*.less'], // which files to watch	
                tasks: ['less'],
                options: {
                    nospawn: true,
                    livereload: 12345,
                }
            },
            scripts: {
                files: ['js/**/*.js'],
                tasks: ['jshint'],
                options: {
                    spawn: false,
                },
            },
            phplint: {
                files: ['**/*.php'], // which files to watch,
                tasks: ['phplint'],
                options: {
                    spawn: false
                }
            },
        },
        jshint: {
            options: {
                reporter: require('jshint-stylish'),
                curly: true,
                eqeqeq: true,
                immed: true,
                latedef: true,
                newcap: false,
                noarg: true,
                sub: true,
                undef: true,
                unused: false,
                boss: true,
                eqnull: true,
                browser: true,
                globals: {
                    jQuery: true
                },
            },
            dev: {
                //src: ['js/**/*.js', '!js/vendor/**/*.js'],
               // tasks: ['jshint'],
            }
        },
        lesslint: {
            src: ['/less/**/*.less']
        },
        phplint: {
            options: {
                stdout: true,
                stderr: true,
                swapPath: '/tmp'
            },
            files: ['*.php', '**/*.php', '!node_modules/**/*.php'] // which files to watch
        },
    });

    grunt.loadNpmTasks('grunt-lesslint');
    grunt.loadNpmTasks('grunt-phplint');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('php', ['phplint']);
    grunt.registerTask('default', ['watch']);
};