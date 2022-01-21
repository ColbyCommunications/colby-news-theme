const setUpSlidingTeasers = () => {
  const slidingTeaserContainers = document.querySelectorAll(
    '.sliding-teasers-container'
  );

  slidingTeaserContainers.forEach((container) => {
    const slidingTeasers = container.querySelector('.sliding-teasers');
    const prevButton = container.querySelector('.sliding-teasers-prev');
    const nextButton = container.querySelector('.sliding-teasers-next');

    if (!slidingTeasers || !prevButton || !nextButton) return;

    const x = slidingTeasers.scrollWidth / slidingTeasers.children.length;

    prevButton.addEventListener('click', () => slidingTeasers.scrollBy(-x, 0));
    nextButton.addEventListener('click', () => slidingTeasers.scrollBy(x, 0));
  });
};

setUpSlidingTeasers();
