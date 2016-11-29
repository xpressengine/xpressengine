if (!!ruleSet) {
  require('validator').setRules(ruleSet.ruleName, ruleSet.rules);
}
