document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('figure.wp-block-embed').forEach(function (figure) {
    const iframe = figure.querySelector('iframe');
    const caption = figure.querySelector('figcaption');
    if (!iframe || !caption) return;
    if (!iframe.getAttribute('title')) {
      const text = caption.textContent.trim();
      if (text.length) {
        iframe.setAttribute('title', text);
      }
    }
  });
});
