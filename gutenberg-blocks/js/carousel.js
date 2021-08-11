const initCarousel = (slickArgs) => {
  const iconUrl = `${wpTheme.template_directory_uri}/assets/icons/icon-sprites.svg`; // eslint-disable-line no-undef
  const $carousel = jQuery('.slick-carousel');

  const arrowClasses = `w-10 h-10
												transform
												group-hover:scale-150
												transition-transform
												fill-current`;
  const buttonClasses = 'text-white group';
  const navArrow = (icon) => `<svg class="${arrowClasses}">
										<use xlink:href="${iconUrl}#${icon}"></use>
										</svg>`;

  $carousel.slick({
    ...slickArgs,
    dots: true,
    nextArrow: `<button class="slick-next ${buttonClasses}">${navArrow(
      'interface-arrow-right-short'
    )}<span class="sr-only">Next</span></button>`,
    prevArrow: `<button class="slick-prev ${buttonClasses}">${navArrow(
      'interface-arrow-left-short'
    )}<span class="sr-only">Next</span></button>`,
    customPaging(slider, i) {
      return jQuery(
        '<button class="block bg-primary-dark hocus:bg-blue-200 w-4 h-4 rounded-full transition-colors ease-in" type="button" />'
      ).html(`<span class="sr-only">Slide ${i + 1}</span>`);
    },
  });
};

jQuery('document').ready(() => {
  initCarousel();
});
