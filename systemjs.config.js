System.config({
  baseURL: "../../",
  defaultJSExtensions: true,
  transpiler: "babel",
  babelOptions: {
    "optional": [
      "runtime",
      "optimisation.modules.system"
    ]
  },
  paths: {
    "github:*": "jspm_packages/github/*",
    "npm:*": "jspm_packages/npm/*",
    "xecore:/*": "assets/core/*"
  },
  bundles: {
    "xecore:/xe-ui-component/js/xe-ui-component.bundle.js": [
      "assets/core/xe-ui-component/js/xe-ui-component.js",
      "npm:jquery@2.2.1.js",
      "npm:jquery@2.2.1/dist/jquery.js"
    ],
    "xecore:/settings/js/admin.bundle.js": [
      "assets/core/settings/js/admin.js",
      "github:twbs/bootstrap-sass@3.3.6/assets/javascripts/bootstrap.js",
      "npm:jquery@2.2.1.js",
      "npm:jquery@2.2.1/dist/jquery.js"
    ]
  },

  map: {
    "babel": "npm:babel-core@5.8.35",
    "babel-runtime": "npm:babel-runtime@5.8.35",
    "bootstrap-sass": "github:twbs/bootstrap-sass@3.3.6",
    "core-js": "npm:core-js@1.2.6",
    "jquery": "npm:jquery@2.2.1",
    "normalize.css": "github:necolas/normalize.css@3.0.3",
    "xe-admin": "xecore:/settings/js/admin",
    "xe-ui": "xecore:/xe-ui-component/js/xe-ui-component",
    "github:jspm/nodelibs-assert@0.1.0": {
      "assert": "npm:assert@1.3.0"
    },
    "github:jspm/nodelibs-path@0.1.0": {
      "path-browserify": "npm:path-browserify@0.0.0"
    },
    "github:jspm/nodelibs-process@0.1.2": {
      "process": "npm:process@0.11.2"
    },
    "github:jspm/nodelibs-util@0.1.0": {
      "util": "npm:util@0.10.3"
    },
    "github:necolas/normalize.css@3.0.3": {
      "css": "github:systemjs/plugin-css@0.1.20"
    },
    "npm:assert@1.3.0": {
      "util": "npm:util@0.10.3"
    },
    "npm:babel-runtime@5.8.35": {
      "process": "github:jspm/nodelibs-process@0.1.2"
    },
    "npm:core-js@1.2.6": {
      "fs": "github:jspm/nodelibs-fs@0.1.2",
      "path": "github:jspm/nodelibs-path@0.1.0",
      "process": "github:jspm/nodelibs-process@0.1.2",
      "systemjs-json": "github:systemjs/plugin-json@0.1.0"
    },
    "npm:inherits@2.0.1": {
      "util": "github:jspm/nodelibs-util@0.1.0"
    },
    "npm:path-browserify@0.0.0": {
      "process": "github:jspm/nodelibs-process@0.1.2"
    },
    "npm:process@0.11.2": {
      "assert": "github:jspm/nodelibs-assert@0.1.0"
    },
    "npm:util@0.10.3": {
      "inherits": "npm:inherits@2.0.1",
      "process": "github:jspm/nodelibs-process@0.1.2"
    }
  }
});
