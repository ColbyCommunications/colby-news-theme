# QA and Launch Checklist

## Pre-Launch - DNS / Domain / Infrastructure
- [ ] Verify the domain records are accessible at registrar if DNS servers need to change.
- [ ] Determine authoritative DNS servers and if lead-time is needed for changes to be enacted.
- [ ] Change TTL to something short - 300-900s, at least a week out
- [ ] Determine if there is an internal DNS server on internal network.
- [ ] Add prod domain to live environment, get it verified so SSL is ready
- [ ] Post-launch maintenance - determine who will be responsible for applying post-launch security updates
- [ ] Post-launch maintenance - if NewCity not doing post-launch maint/ad-hoc, does our codebase/processes jive with internal processes on the client side?

## Pre-Launch - Standards and Validation
- [ ] Create a representative list of URLs to be tested
    - https://1.example.com/
    - https://2.example.com/
- [ ] Test representative list of URLs with WAVE against WCAG 2.1 AA, including contrast checks
- [ ] Test representative list of URLs for colorblindness-related issues
- [ ] Test representative list of URLs with a keyboard, testing logical ordering, non-disappearing indicator
- [ ] Run a full-site scan for accessibility - WGAG AA 2.1
- [ ] Provide list of inaccessible PDF/Docx files to content creators
- [ ] Verify visible skip-to-main-content navigation?
- [ ] Run a screenreader (Apple Voiceover / Chromevox) across representative URLs
- [ ] HTML validation - check for unclosed tags
- [ ] JavaScript - check for errors, unnecessary console logging

## Pre-Launch - SEO and Metrics
- [ ] Verify robots.txt rejects search engines during development phase
- [x] Is there a standard SEO plugin installed? Yoast
- [ ] Verify page titles are in title tag and that each page title is unique
- [ ] Check for out-of-order headers, empty headers
- [ ] Verify that content creators have ability to edit metadata
- [x] Is there a 404 page for invalid URLs?  
- [ ] Does 404 page actually return a 404 error code?  Check via curl -I
- [ ] Run a full-site 404 scan
- [ ] Get 301 redirect list and use CMS plugin to set up in bulk Redirection
- [ ] 301 redirect the www version of the site to the non-www (or reverse)
- [ ] 301 redirect non-https to https
- [ ] Remove trailing slashes from URLs
- [ ] Set up Google Tag Manager
- [ ] Verify that any goals that need to be set up have been
- [ ] Verify Google Analytics appropriate profiles and filters are applied, excluding client and NC IPs.
- [ ] Create a Google XML site map for content Yoast
- [ ] Check the H1s associated with each template

## Pre-Launch - Legal
- [ ] Copyright - Does one exist? Is it updated reasonably?
- [ ] Terms and Conditions, if applicable.
- [ ] Privacy Policies, if applicable.

## Pre-Launch - Functional and Content Testing
- [ ] Change site email
- [ ] Ensure email sending from website uses either an SMTP acct or a sending service (if doing form handling)
- [ ] Get a design / UX review
- [ ] Make sure CMS is performing adequate image compression and enforcing maximum dimensions
- [ ] Change site's regional settings (time zone, etc)
- [ ] Check email addresses on all public-facing forms
- [ ] Collect “before” screenshots
- [x] Ensure there is a bug-reporting strategy in place
- [x] Is there a plan for dev, test, and production environments?
- [ ] Perform responsive testing - verify using most recent version of browsers (esp Chrome)
- [ ] Scan for spelling errors
- [x] If applicable, is there an emergency banner implemented?
- [ ] Test all forms.  Ensure they also save their data somewhere, send to thank you page.
- [ ] Consider a spam prevention strategy for forms
- [ ] Double-check that there aren't forms in existing site that still need to be created or integrated
- [ ] Create favicons at appropriate sizes for device spectrum.
- [ ] Check for hard-coded links to staging domain
- [ ] Ensure there is no test content on site.
- [ ] Remove all test accounts.
- [ ] Verify that a print stylesheet has been created and works for important areas.
- [ ] Check search functionality (including relevance of results) - core search or Relevanssi

## Pre-Launch - Security/Risk
- [ ] Modify robots.txt to add any needed exclusions.  
- [ ] Monitoring - set up Pingdom
- [x] Verify user registration turned off?  
- [x] Commenting appropriately turned on or off?  
- [ ] Check to see if we need to Wordpress - replace all `composer update` in pipeline with `composer install`

## Pre-Launch - Performance
- [ ] Check for giant images - implement image resizing if needed
- [ ] Check for unnecessary png files where jpegs would be appropriate
- [ ] Check for pages with a total asset weight of 3 megs or more
- [ ] CDN - enable for domain prior to launch
- [ ] Run thru webpagetest.org / Google PageSpeed Insights (esp Core Web Vitals)
- [ ] Check that main stylesheet file is not > 1 MB

## Launch Day
- [ ] Planning - is there a rollback strategy in case site needs to be reverted quickly?
- [ ] Planning - consider setting previous server to answer to an alternate URL for quick rollbacks.
- [ ] Enable object caching
- [ ] Coordinate changing DNS to point to new environment.
- [ ] Update sitemap base URL, if applicable
- [ ] Generate an XML Sitemap w/ new URLs and submit it to Google.
- [ ] Verify robots.txt allows indexing
- [ ] Update robots.txt on previous site to reject search engines
- [ ] Make sure search function is reindexed on production URL if needed.
- [ ] Rebuild permalinks (Settings->Permalinks->Save Changes)
- [ ] Do we need to run wp search-replace 'live-url' 'real-url'? (do a dry run first)
- [ ] If using Timber, lock composer dependency versions in composer.json

## Day after launch
- [ ] Change TTL back to original settings if needed.
- [ ] Check analytics for problems, popular pages etc. and adjust as necessary.
