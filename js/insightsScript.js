var ALGOLIA_INSIGHTS_SRC =
  'https://cdn.jsdelivr.net/npm/search-insights@2.0.2/dist/search-insights.iife.min.js';

!(function (e, a, t, n, s, i, c) {
  (e.AlgoliaAnalyticsObject = s),
    (e[s] =
      e[s] ||
      function () {
        (e[s].queue = e[s].queue || []).push(arguments);
      }),
    (i = a.createElement(t)),
    (c = a.getElementsByTagName(t)[0]),
    (i.async = 1),
    (i.src = n),
    c.parentNode.insertBefore(i, c);
})(window, document, 'script', ALGOLIA_INSIGHTS_SRC, 'aa');
