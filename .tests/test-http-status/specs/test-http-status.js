const sitemap = require('../sitemap.json');

// Generate the page tests out of the sitemap.
let pageTests = [];
sitemap.urls.forEach((url) => {
  pageTests['Page loads and has title tag: ' + url] = (browser) => {
    browser.url(url, (browser) => {
      browser.expect.title().to.contain(/[a-zA-Z]/);
    });

    // browser.findElement('meta[name="robots"]', (result) => {
    //   if (!result.getAttribute('content').includes('nofollow')) {
    //     browser.verify.elementPresent('link[rel="canonical"]', '`robots.txt` not set to `nofollow`, but no canonical link meta tag found.');
    //   }
    // });
  };
});

module.exports = Object.assign(
  {},
  {
    'Sitemap exists': (browser) => {
      browser.expect(sitemap.urls.length >= 1).to.be.true;
    },
  },
  pageTests
);
