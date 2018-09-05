export const xeSetupOptions = {
  baseURL: 'http://localhost',
  userToken: 'SsrUXiMPYZSafKaBKGZlSUG7EAoISPhIYxDCtkVT',
  loginUserId: 'b1925974-ed15-4a9f-9c52-95b2dc44859b', // @deprecated
  useXeSpinner: true, // @deprecated
  locale: 'ko',
  defaultLocale: 'en',
  fixedPrefix: 'plugin',
  settingsPrefix: 'settings',
  routes: {
    'manage.dynamicField.index': {
      'uri': 'settings/dynamicField',
      'methods': ['GET', 'HEAD'],
      'params': []
    },
    'manage.dynamicField.update': {
      'uri': 'settings/dynamicField/update',
      'methods': ['POST'],
      'params': []
    }
  },
  ruleSet: [{
    'ruleName': 'board',
    'rules': {
      'title': 'Required',
      'slug': 'Required',
      'content': 'Required',
      'asefsaef_num': 'numeric'
    }
  }],
  translation: {
    locales: [
      { code: 'ko', nativeName: '한국어' },
      { code: 'en', nativeName: 'English' }
    ]
  }
}

export const xeLegacySetupOptions = {
  baseURL: 'http://localhost',
  userToken: 'SsrUXiMPYZSafKaBKGZlSUG7EAoISPhIYxDCtkVT',
  loginUserId: 'b1925974-ed15-4a9f-9c52-95b2dc44859b', // @deprecated
  useXeSpinner: true, // @deprecated
  locale: 'ko',
  defaultLocale: 'en',
  fixedPrefix: 'plugin',
  settingsPrefix: 'settings',
  translation: {
    locales: ['ko', 'en']
  }
}
