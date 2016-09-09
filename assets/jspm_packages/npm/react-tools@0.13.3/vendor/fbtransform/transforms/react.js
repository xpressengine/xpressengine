/* */ 
(function(process) {
  'use strict';
  var Syntax = require('jstransform').Syntax;
  var utils = require('jstransform/src/utils');
  var renderJSXExpressionContainer = require('./jsx').renderJSXExpressionContainer;
  var renderJSXLiteral = require('./jsx').renderJSXLiteral;
  var quoteAttrName = require('./jsx').quoteAttrName;
  var trimLeft = require('./jsx').trimLeft;
  var reNonWhiteParen = /([^\s\(\)])/g;
  function stripNonWhiteParen(value) {
    return value.replace(reNonWhiteParen, '');
  }
  var tagConvention = /^[a-z]|\-/;
  function isTagName(name) {
    return tagConvention.test(name);
  }
  function visitReactTag(traverse, object, path, state) {
    var openingElement = object.openingElement;
    var nameObject = openingElement.name;
    var attributesObject = openingElement.attributes;
    utils.catchup(openingElement.range[0], state, trimLeft);
    if (nameObject.type === Syntax.JSXNamespacedName && nameObject.namespace) {
      throw new Error('Namespace tags are not supported. ReactJSX is not XML.');
    }
    utils.append('React.createElement(', state);
    if (nameObject.type === Syntax.JSXIdentifier && isTagName(nameObject.name)) {
      utils.append('"' + nameObject.name + '"', state);
      utils.move(nameObject.range[1], state);
    } else {
      utils.move(nameObject.range[0], state);
      utils.catchup(nameObject.range[1], state);
    }
    utils.append(', ', state);
    var hasAttributes = attributesObject.length;
    var hasAtLeastOneSpreadProperty = attributesObject.some(function(attr) {
      return attr.type === Syntax.JSXSpreadAttribute;
    });
    if (hasAtLeastOneSpreadProperty) {
      utils.append('React.__spread({', state);
    } else if (hasAttributes) {
      utils.append('{', state);
    } else {
      utils.append('null', state);
    }
    var previousWasSpread = false;
    attributesObject.forEach(function(attr, index) {
      var isLast = index === attributesObject.length - 1;
      if (attr.type === Syntax.JSXSpreadAttribute) {
        if (!previousWasSpread) {
          utils.append('}, ', state);
        }
        utils.catchup(attr.range[0], state, stripNonWhiteParen);
        utils.move(attr.range[0] + 1, state);
        utils.catchup(attr.argument.range[0], state, stripNonWhiteParen);
        traverse(attr.argument, path, state);
        utils.catchup(attr.argument.range[1], state);
        utils.catchup(attr.range[1] - 1, state, stripNonWhiteParen);
        if (!isLast) {
          utils.append(', ', state);
        }
        utils.move(attr.range[1], state);
        previousWasSpread = true;
        return;
      }
      if (!isLast) {
        isLast = attributesObject[index + 1].type === Syntax.JSXSpreadAttribute;
      }
      if (attr.name.namespace) {
        throw new Error('Namespace attributes are not supported. ReactJSX is not XML.');
      }
      var name = attr.name.name;
      utils.catchup(attr.range[0], state, trimLeft);
      if (previousWasSpread) {
        utils.append('{', state);
      }
      utils.append(quoteAttrName(name), state);
      utils.append(': ', state);
      if (!attr.value) {
        state.g.buffer += 'true';
        state.g.position = attr.name.range[1];
        if (!isLast) {
          utils.append(', ', state);
        }
      } else {
        utils.move(attr.name.range[1], state);
        utils.catchupNewlines(attr.value.range[0], state);
        if (attr.value.type === Syntax.Literal) {
          renderJSXLiteral(attr.value, isLast, state);
        } else {
          renderJSXExpressionContainer(traverse, attr.value, isLast, path, state);
        }
      }
      utils.catchup(attr.range[1], state, trimLeft);
      previousWasSpread = false;
    });
    if (!openingElement.selfClosing) {
      utils.catchup(openingElement.range[1] - 1, state, trimLeft);
      utils.move(openingElement.range[1], state);
    }
    if (hasAttributes && !previousWasSpread) {
      utils.append('}', state);
    }
    if (hasAtLeastOneSpreadProperty) {
      utils.append(')', state);
    }
    var childrenToRender = object.children.filter(function(child) {
      return !(child.type === Syntax.Literal && typeof child.value === 'string' && child.value.match(/^[ \t]*[\r\n][ \t\r\n]*$/));
    });
    if (childrenToRender.length > 0) {
      var lastRenderableIndex;
      childrenToRender.forEach(function(child, index) {
        if (child.type !== Syntax.JSXExpressionContainer || child.expression.type !== Syntax.JSXEmptyExpression) {
          lastRenderableIndex = index;
        }
      });
      if (lastRenderableIndex !== undefined) {
        utils.append(', ', state);
      }
      childrenToRender.forEach(function(child, index) {
        utils.catchup(child.range[0], state, trimLeft);
        var isLast = index >= lastRenderableIndex;
        if (child.type === Syntax.Literal) {
          renderJSXLiteral(child, isLast, state);
        } else if (child.type === Syntax.JSXExpressionContainer) {
          renderJSXExpressionContainer(traverse, child, isLast, path, state);
        } else {
          traverse(child, path, state);
          if (!isLast) {
            utils.append(', ', state);
          }
        }
        utils.catchup(child.range[1], state, trimLeft);
      });
    }
    if (openingElement.selfClosing) {
      utils.catchup(openingElement.range[1] - 2, state, trimLeft);
      utils.move(openingElement.range[1], state);
    } else {
      utils.catchup(object.closingElement.range[0], state, trimLeft);
      utils.move(object.closingElement.range[1], state);
    }
    utils.append(')', state);
    return false;
  }
  visitReactTag.test = function(object, path, state) {
    return object.type === Syntax.JSXElement;
  };
  exports.visitorList = [visitReactTag];
})(require('process'));
