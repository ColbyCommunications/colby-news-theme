const puppeteer = require('puppeteer');
const percySnapshot = require('@percy/puppeteer');
const scrollToBottom = require('scroll-to-bottomjs');

(async () => {
  const browser = await puppeteer.launch({ headless: false });

  const scrollOptions = {
    frequency: 100,
    timing: 200, // milliseconds
  };

  // Test Page
  const testPage = await browser.newPage();
  await testPage.goto('https://news.lndo.site/story/news-release-test-story/');

  await testPage.evaluate(scrollToBottom, scrollOptions);

  await percySnapshot(testPage, 'Snapshot of test page', {
    percyCSS: `.relatedSection { display:none; } .highlightsSection { display: none; } .read-time { display: none; }`,
  });

  // Test Page 2
  const testPage2 = await browser.newPage();
  await testPage2.goto(
    'https://news.lndo.site/story/scholarship-stories-about-colby-faculty-in-2023/'
  );

  await testPage2.evaluate(scrollToBottom, scrollOptions);

  await percySnapshot(testPage2, 'Snapshot of test page 2', {
    percyCSS: `.relatedSection { display:none; } .highlightsSection { display: none; } .read-time { display: none; }`,
  });

  // Test Page 3
  const testPage3 = await browser.newPage();
  await testPage3.goto(
    'https://news.lndo.site/story/an-adrenaline-junkie-with-a-passion-for-filmmaking/'
  );

  await testPage3.evaluate(scrollToBottom, scrollOptions);

  await percySnapshot(testPage3, 'Snapshot of test page 3', {
    percyCSS: `.relatedSection { display:none; } .highlightsSection { display: none; } .read-time { display: none; }`,
  });

  // Main Menu
  const homePage = await browser.newPage();
  await homePage.goto('https://news.lndo.site/');

  await homePage.waitForSelector('.open-menu');
  await homePage.click('.open-menu');

  const mainMenuSelector = '#main-menu';
  await homePage.waitForSelector(mainMenuSelector);

  await percySnapshot(homePage, 'Snapshot of main menu', {
    scope: mainMenuSelector,
  });

  // Contact Page
  const contactPage = await browser.newPage();

  await contactPage.goto('https://news.lndo.site/contact/');

  await percySnapshot(contactPage, 'Snapshot of contact page');

  const resourcesPage = await browser.newPage();

  await resourcesPage.goto('https://news.lndo.site/resources-for-the-media/');

  await percySnapshot(resourcesPage, 'Snapshot of resources page');

  // Newsletter Page
  const newsletterPage = await browser.newPage();

  await newsletterPage.goto('https://news.lndo.site/newsletter/');

  await percySnapshot(newsletterPage, 'Snapshot of newsletter page');

  await browser.close();
})();
