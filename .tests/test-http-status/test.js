import puppeteer from 'puppeteer';
import test from 'ava';
import fs from 'fs';

let sitemap = JSON.parse(fs.readFileSync('sitemap.json'));
let opts = JSON.parse(fs.readFileSync('opts.json'));

let browser, page;

test.before(async (t) => {
  browser = await puppeteer.launch(opts);
  page = await browser.newPage();
});

test.after((t) => {
  browser.close();
});

sitemap.urls.forEach((url) => {
  test.serial(url + ' is not a 500', async (t) => {
    let response = await page.goto(url);
    t.false(response.status() == 500);
  });
});

test('more than one URL', (t) => {
  if (sitemap.urls.length > 1) {
    t.pass('sitemap has more than 1 URL');
  }
});
