/*jshint -W106 */
/*jshint node:true, browser:false */

"use strict";

var path = require("path");
var findup = require("findup-sync");


module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON("zeroclipboard.jquery.json"),

    banner:
      "/*!\n" +
      " * <%= pkg.title || pkg.name %>\n" +
      " * <%= pkg.description %>\n" +
      " * Copyright (c) <%= grunt.template.today('yyyy') %> <%= _.pluck(pkg.contributors, 'name').join(', ') %>\n" +
      " * Licensed <%= _.pluck(pkg.licenses, 'type').join(', ') %>\n" +
      " * <%= pkg.homepage %>\n" +
      " * v<%= pkg.version %>\n" +
      " */\n",

    zeroclipboardPath: path.dirname(findup("package.json", { cwd: path.dirname(require.resolve("zeroclipboard")) })),


    // Task configuration.
    jshint: {
      options: {
        jshintrc: true
      },
      prebuild: {
        src: [
          "Gruntfile.js",
          "src/**/*.js",
          "!src/start.js",
          "!src/end.js",
          "test/**/*.js"
        ]
      },
      postbuild: {
        src: ["<%= concat.dist.dest %>"]
      }
    },
    clean: {
      files: ["dist/**/*", "!dist/**/.jshintrc"]
    },
    concat: {
      options: {
        stripBanners: true,
        process: function(src, filepath) {
          return filepath === "src/start.js" ?
            src :
            src.replace(/(^|\n)[ \t]*('use strict'|"use strict");?\s*/g, "$1");
        }
      },
      dist: {
        src: [
          "src/start.js",
          "<%= zeroclipboardPath %>/dist/ZeroClipboard.Core.js",
          "src/jquery.<%= pkg.name %>.js",
          "src/end.js"
        ],
        dest: "dist/jquery.<%= pkg.name %>.js"
      }
    },
    copy: {
      swf: {
        src: ["<%= zeroclipboardPath %>/dist/ZeroClipboard.swf"],
        dest: "dist/ZeroClipboard.swf"
      }
    },
    uglify: {
      options: {
        report: "min"
      },
      js: {
        options: {
          banner: "<%= banner %>",
          preserveComments: function(node, comment) {
            return comment &&
              comment.type === "comment2" &&
              /^(!|\*|\*!)\r?\n/.test(comment.value);
          },
          beautify: {
            beautify: true,
            // `indent_level` requires jshint -W106
            indent_level: 2
          },
          mangle: false,
          compress: false
        },
        src: "<%= concat.dist.dest %>",
        dest: "<%= concat.dist.dest %>"
      },
      minjs: {
        options: {
          preserveComments: function(node, comment) {
            return comment &&
              comment.type === "comment2" &&
              /^(!|\*!)\r?\n/.test(comment.value);
          }
        },
        src: "<%= concat.dist.dest %>",
        dest: "dist/jquery.<%= pkg.name %>.min.js"
      }
    },
    connect: {
      server: {
        options: {
          port: 7320  // "ZERO"
        }
      }
    },
    qunit: {
      file: ["test/jquery.<%= pkg.name %>.html"],
      http: {
        options: {
          urls: [
            /*"1.0", "1.0.1", "1.0.2", "1.0.3", "1.0.4",*/
            /*"1.1", "1.1.1", "1.1.2", "1.1.3", "1.1.4",*/
            /*"1.2", "1.2.1", "1.2.2", "1.2.3", "1.2.4", "1.2.5", "1.2.6",*/
            /*"1.3", "1.3.1", "1.3.2",*/
            /*"1.4", "1.4.1", "1.4.2", "1.4.3", "1.4.4",*/
            /*"1.5", "1.5.1", "1.5.2",*/
            /*"1.6", "1.6.1", "1.6.2", "1.6.3", "1.6.4",*/
            "1.7", "1.7.1", "1.7.2",
            "1.8.0", "1.8.1", "1.8.2", "1.8.3",
            "1.9.0", "1.9.1",
            "1.10.0", "1.10.1", "1.10.2",
            "1.11.0", "1.11.1",
            "git1",
            "2.0.0", "2.0.1", "2.0.2", "2.0.3",
            "2.1.0", "2.1.1",
            "git2"
          ].map(function(jqVersion) {
            return "http://localhost:<%= connect.server.options.port %>/test/jquery.<%= pkg.name %>.html?jquery=" + jqVersion;
          })
        }
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks("grunt-contrib-clean");
  grunt.loadNpmTasks("grunt-contrib-concat");
  grunt.loadNpmTasks("grunt-contrib-connect");
  grunt.loadNpmTasks("grunt-contrib-copy");
  grunt.loadNpmTasks("grunt-contrib-jshint");
  grunt.loadNpmTasks("grunt-contrib-qunit");
  grunt.loadNpmTasks("grunt-contrib-uglify");

  // Custom task chains.
  grunt.registerTask("build",   ["jshint:prebuild", "clean", "concat", "jshint:postbuild", "copy", "uglify"]);
  grunt.registerTask("travis",  ["jshint:prebuild", "clean", "concat", "jshint:postbuild", "connect", "qunit"]);

  // Default task.
  grunt.registerTask("default", ["build", "connect", "qunit"]);

};
