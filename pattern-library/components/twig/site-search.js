const setUpSiteSearch = () => {
  const { algoliasearch, instantsearch } = window;

  if (!algoliasearch || !instantsearch) return;

  const siteSearchSearchbox = document.getElementById('site-search-searchbox');
  const siteSearchAnnouncer = document.getElementById('site-search-announcer');
  const siteSearchHitsHeading = document.getElementById(
    'site-search-hits-heading'
  );
  const siteSearchHitsContainer = document.getElementById(
    'site-search-hits-container'
  );

  if (
    !siteSearchSearchbox ||
    !siteSearchAnnouncer ||
    !siteSearchHitsHeading ||
    !siteSearchHitsContainer
  )
    return;

  let searchInput, oldSearchTerm;

  // just used to compensate for bug causing `transformItems` to run twice: https://github.com/algolia/instantsearch.js/issues/4819
  let bool = true;

  const searchClient = algoliasearch(
    '2XJQHYFX2S',
    '31a9a9bb15c777d88d51896a5ba9ecca'
  );

  const search = instantsearch({
    indexName: 'crawler_colby-news', // case-sensitive
    searchClient,
    searchFunction: (helper) => helper.state.query && helper.search(),
  });

  search.addWidgets([
    instantsearch.widgets.searchBox({
      container: '#site-search-searchbox',
      searchAsYouType: false,
      placeholder: 'Start typing to search',
      showReset: false,
      showLoadingIndicator: false,
      templates: {
        submit: 'Search',
      },
    }),

    instantsearch.widgets.infiniteHits({
      container: '#site-search-hits',

      /*
        This method should really "just" be for transforming the search-results array
        before displaying them, but we also use this as a "hook" to run some code
        that makes the search more accessible:

        A) we move focus to:
          1) the last old search-result if there is one
          2) siteSearchHitsHeading otherwise (for new search);
        B) we announce the search-results situation to screen-readers.
      */
      transformItems: (items) => {
        // compensate for bug causing this method to run twice every time:
        bool = !bool;

        // every other time ("bad" ones), just return the items
        if (bool) return items;

        // every other time ("good" ones), do everything

        /*
          Transform items (`url` and `title` are required, and only show articles).
          Client handling this on server-side anyway, but this is a low-cost a failsafe.
        */
        const finalItems = items.filter(
          (item) => item.url && item.title && item.type === 'article'
        );

        // handle focus (determining what needs it, then apply it)
        searchInput = searchInput || siteSearchSearchbox.querySelector('input');
        const searchTerm = searchInput.value;
        const isNewSearch = searchTerm !== oldSearchTerm;
        oldSearchTerm = searchTerm;

        const resultsList = siteSearchHitsContainer.querySelector('ol');

        let lastOldResultLink;

        if (!isNewSearch && resultsList) {
          const lastOldResult = resultsList.lastChild;
          if (lastOldResult) {
            const a = lastOldResult.querySelector('a');
            if (a) lastOldResultLink = a;
          }
        }

        if (lastOldResultLink) {
          lastOldResultLink.focus();
        } else {
          siteSearchHitsHeading.focus();
        }

        // announce new text (element has `aria-live="polite"`)
        siteSearchAnnouncer.innerText = finalItems.length
          ? `Showing ${finalItems.length} new result${
              finalItems.length > 1 ? 's' : ''
            } for ${searchTerm}.`
          : `No results found for ${searchTerm}.`;

        // return transformed items
        return finalItems;
      },

      templates: {
        // related to `teaser.twig`;
        item: (item) => /* html */ `
          <a href="${item.url}" class="group block text-base-minus-2 space-y-2">
            ${
              item.image
                ? /* html */ `
              <div class="aspect-w-5 aspect-h-3">
                <img class="object-cover" src="${item.image}" alt="" />
              </div>
            `
                : ''
            }
            <div class="space-y-[.1rem]">
              ${
                item.primaryCategory
                  ? /* html */ `<div class="uppercase text-sm sm:text-xs">${item.primaryCategory}</div>`
                  : ''
              }
              <div class="group-hover:text-link-hover transition-colors font-bold text-base-minus-1 sm:text-sm-plus-1">${
                item.title
              }</div>
            </div>
          </a>
        `,
      },
    }),
  ]);

  search.start();
};

if (!window.STORYBOOK_ENV) setUpSiteSearch();

export default setUpSiteSearch;
