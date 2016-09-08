/* */ 
(function(process) {
  "use strict";
  var transform = require('jstransform').transform;
  var typesSyntax = require('jstransform/visitors/type-syntax');
  var visitors = require('./visitors');
  function transformAll(source, options, excludes) {
    excludes = excludes || [];
    source = transform(typesSyntax.visitorList, source, options).code;
    var visitorsList = visitors.getAllVisitors(excludes.concat('typechecker'));
    source = transform(visitorsList, source, options);
    if (excludes.indexOf('typechecks') == -1 && /@typechecks/.test(source.code)) {
      source = transform(visitors.transformVisitors.typechecker, source.code, options);
    }
    return source;
  }
  function runCli(argv) {
    var options = {};
    for (var optName in argv) {
      if (optName === '_' || optName === '$0') {
        continue;
      }
      options[optName] = optimist.argv[optName];
    }
    if (options.help) {
      optimist.showHelp();
      process.exit(0);
    }
    var excludes = options.excludes;
    delete options.excludes;
    var source = '';
    process.stdin.resume();
    process.stdin.setEncoding('utf8');
    process.stdin.on('data', function(chunk) {
      source += chunk;
    });
    process.stdin.on('end', function() {
      try {
        source = transformAll(source, options, excludes);
      } catch (e) {
        console.error(e.stack);
        process.exit(1);
      }
      process.stdout.write(source.code);
    });
  }
  if (require.main === module) {
    var optimist = require('optimist');
    optimist = optimist.usage('Usage: $0 [options]').default('exclude', []).boolean('help').alias('h', 'help').boolean('minify').describe('minify', 'Best-effort minification of the output source (when possible)').describe('exclude', 'A list of transformNames to exclude');
    runCli(optimist.argv);
  } else {
    exports.transformAll = transformAll;
  }
})(require('process'));
