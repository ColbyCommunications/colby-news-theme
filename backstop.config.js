module.exports = {
  id: 'backstop_default',
  viewports: [
    {
      label: 'phone',
      width: 320,
      height: 480,
    },
    {
      label: 'tablet',
      width: 1024,
      height: 768,
    },
    {
      label: 'desktop',
      width: 1440,
      height: 900,
    },
  ],
  onBeforeScript: 'puppet/onBefore.js',
  onReadyScript: 'puppet/onReady.js',
  scenarios: [
    {
      label: 'News Release Test Story',
      cookiePath: 'backstop_data/engine_scripts/cookies.json',
      url: 'https://news.lndo.site/story/news-release-test-story/',
      referenceUrl: '',
      readyEvent: '',
      readySelector: '',
      delay: 0,
      hideSelectors: [],
      removeSelectors: [],
      hoverSelector: '',
      clickSelector: '',
      postInteractionWait: 0,
      selectors: [],
      selectorExpansion: true,
      expect: 0,
      misMatchThreshold: 0.1,
      requireSameDimensions: true,
    },
  ],
  paths: {
    bitmaps_reference: `backstop_data/bitmaps_reference_${
      new Date().toISOString().split('T')[0]
    }`,
    bitmaps_test: 'backstop_data/bitmaps_test',
    engine_scripts: 'backstop_data/engine_scripts',
    html_report: 'backstop_data/html_report',
    ci_report: 'backstop_data/ci_report',
  },
  report: ['browser'],
  engine: 'puppeteer',
  engineOptions: {
    args: ['--no-sandbox'],
  },
  asyncCaptureLimit: 5,
  asyncCompareLimit: 50,
  debug: false,
  debugWindow: false,
};