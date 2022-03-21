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
    indexName: 'wp_searchable_posts', // case-sensitive
    searchClient,
    searchFunction: (helper) => helper.state.query && helper.search(),
  });

  const insightsMiddleware = instantsearch.middlewares.createInsightsMiddleware(
    {
      insightsClient: window.aa,
    }
  );

  search.use(insightsMiddleware);

  window.aa('setUserToken', 'user-1');

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
          This would really be better handled at the search stage (I think with the
          `configure` widget), so that the number of returned results is consistent,
          but I believe that will require some back-end work in Algolia. Probably
          not a big deal (since ~zero results will be missing a title or url, and
          almost all will be articles anyway), but worth discussing with the client.
          See:
          https://www.algolia.com/doc/api-reference/widgets/configure/js/#options
          https://www.algolia.com/doc/api-reference/search-api-parameters/
          https://www.algolia.com/doc/api-reference/api-parameters/filters/
          https://www.algolia.com/doc/guides/managing-results/refine-results/faceting/how-to/declaring-attributes-for-faceting/
        */
        const finalItems = items.filter(
          (item) =>
            item.permalink && item.post_title && item.post_type === 'post'
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
        // note: there's no provided alt-text for the images, so using `alt=""` for now
        item(item, bindEvent) {
          /* html */
          return `
          <a href="${item.permalink}" ${bindEvent(
            'click',
            item,
            'Search Result Clicked'
          )} class="group block text-base-minus-2 space-y-1.5">
            ${
              item.images.thumbnail
                ? /* html */ `
              <div class="aspect-w-3 aspect-h-2">
                <img class="object-cover" src="${item.images.thumbnail.url}" alt="" />
              </div>
            `
                : ''
            }
            <div class="group-hover:text-link-hover transition-colors font-bold text-base-minus-1 sm:text-sm-plus-1">${
              item.post_title
            } </div>
          </a> 
        `;
        },
      },
    }),
  ]);

  search.start();
};

setUpSiteSearch();
