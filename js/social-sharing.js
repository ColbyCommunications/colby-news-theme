const setUpSocialSharing = () => {
  // based on https://css-tricks.com/simple-social-sharing-links/

  const sendConversion = () => {
    var postId = document.querySelector('.post').getAttribute('data-post-id');
    window.aa('convertedObjectIDs', {
      userToken: window.colbyNews.algoliaUserToken,
      index: 'prod_news_searchable_posts',
      eventName: 'Article Conversion: Social',
      objectIDs: [postId+'-0'],
    });
  };

  const socialWindow = (url) => {
    sendConversion();

    const left = (screen.width - 570) / 2;
    const top = (screen.height - 570) / 2;
    const params = `menubar=no,toolbar=no,status=no,width=570,height=570,top=${top},left=${left}`;
    window.open(url, 'NewWindow', params);
  };

  const pageUrl = encodeURIComponent(document.URL);

  const titleTag = document.head.querySelector('title');
  const ogDescriptionMeta = document.head.querySelector(
    'meta[property="og:description"][content]'
  );

  const title = titleTag ? encodeURIComponent(titleTag.textContent) : '';
  const description = ogDescriptionMeta
    ? encodeURIComponent(ogDescriptionMeta.content)
    : '';

  document.querySelectorAll('.social-share').forEach((el) => {
    if (el.matches('.facebook')) {
      el.addEventListener('click', () =>
        socialWindow(`https://www.facebook.com/sharer.php?u=${pageUrl}`)
      );
    } else if (el.matches('.twitter')) {
      el.addEventListener('click', () =>
        socialWindow(
          `https://twitter.com/intent/tweet?url=${pageUrl}&text=${description}`
        )
      );
    } else if (el.matches('.linkedin')) {
      el.addEventListener('click', () =>
        socialWindow(
          `https://www.linkedin.com/shareArticle?mini=true&url=${pageUrl}`
        )
      );
    } else if (el.matches('.email')) {
      el.addEventListener('click', () => sendConversion());
      el.href = `mailto:?${`body=${pageUrl}${
        description ? `%0A%0A${description}` : ''
      }`}${title ? `&subject=${title}` : ''}`;
    }
  });
};

setUpSocialSharing();
