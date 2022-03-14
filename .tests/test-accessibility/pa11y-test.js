import fs from 'fs';
import junit from 'pa11y-reporter-junit';
import pa11y from 'pa11y';
import { createRequire } from 'module';

const require = createRequire(import.meta.url);
const arrayOfSitemapItems = require('./sitemap.json');


(async function pa11yList() {
  const junitResults = [];
  
  console.log(`Testing URL 1 of ${arrayOfSitemapItems['urls'].length}: ${arrayOfSitemapItems['urls'][0]}`);
  await arrayOfSitemapItems['urls'].reduce(async (promise, item, index) => {
    await promise;
    await pa11y(item, {
      standard: "WCAG2AA",
      level: "error",
      chromeLaunchConfig: {
        args: [
            "--no-sandbox",
            "--disable-setuid-sandbox"
        ]
      },
      defaults: {
        timeout: 5000,
        threshold: 29,
      }
    }).then(results => {
      // Returns a string with the results formatted as JUnit XML
      if (results.type === 'error') {
        process.exitCode = 1;
      }
      const junitItem = junit.results(results);
      fs.writeFile('./results-pa11y.xml', junitItem, err => {
        if (err) {
          console.error(err);
          process.exitCode = 1;
          return;
        }
        console.log(`Testing URL ${index + 1} of ${arrayOfSitemapItems['urls'].length}: ${item}`);
      });
      });
  })
})();