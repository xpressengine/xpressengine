/* */ 
var MetaMatchers = require('MetaMatchers');
describe('ReactClassEquivalence', function() {
  beforeEach(function() {
    this.addMatchers(MetaMatchers);
  });
  var es6 = () => require('./ReactES6Class-test');
  var coffee = () => require('./ReactCoffeeScriptClass-test.coffee');
  var ts = () => require('./ReactTypeScriptClass-test.ts');
  it('tests the same thing for es6 classes and CoffeeScript', function() {
    expect(coffee).toEqualSpecsIn(es6);
  });
  it('tests the same thing for es6 classes and TypeScript', function() {
    expect(ts).toEqualSpecsIn(es6);
  });
});
