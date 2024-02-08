const puppeteer = require('puppeteer');
const percySnapshot = require('@percy/puppeteer');
const scrollToBottom = require('scroll-to-bottomjs');

(async () => {
  const browser = await puppeteer.launch({ headless: false });

  // Test Page
  const testPage = await browser.newPage();
  await testPage.goto('https://news.lndo.site/story/news-release-test-story/');

  const scrollOptions = {
    frequency: 100,
    timing: 200, // milliseconds
  };
  await testPage.evaluate(scrollToBottom, scrollOptions);

  await percySnapshot(testPage, 'Snapshot of test page', {
    percyCSS: `.relatedSection { display:none; } .highlightsSection { display: none; }`,
  });

  // Main Menu
  const homePage = await browser.newPage();
  await homePage.goto('https://news.lndo.site/');

  // Wait for the element you want to click to be ready
  await homePage.waitForSelector('.open-menu');

  // Click the element
  await homePage.click('.open-menu');

  const mainMenuSelector = '#main-menu';
  await homePage.waitForSelector(mainMenuSelector);

  // Take a snapshot after clicking on the second page
  await percySnapshot(homePage, 'Snapshot of main menu', {
    scope: mainMenuSelector,
  });

  // Contact Page
  const contactPage = await browser.newPage();

  await contactPage.goto('https://news.lndo.site/contact/');

  await percySnapshot(contactPage, 'Snapshot of contact page');

  // Resources Page
  const resourcesPage = await browser.newPage();

  await resourcesPage.goto('https://news.lndo.site/resources-for-the-media/');

  await percySnapshot(resourcesPage, 'Snapshot of resources page');

  // Newsletter Page
  const newsletterPage = await browser.newPage();

  await newsletterPage.goto('https://news.lndo.site/newsletter/');

  await percySnapshot(newsletterPage, 'Snapshot of newsletter page');

  await browser.close();
})();
