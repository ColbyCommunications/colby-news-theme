import Image from './Image';
import quoteTemplate from '../twig/quote-text.twig';

const Quote = (args) => {
  let attribution = '';

  let image = '';

  if (args.image && args.image.src) {
    image = Image({
      src: args.image.src,
      alt: '',
      classes: ['object-cover', 'w-full', 'h-full', 'inset-0'],
    });
  }

  if (args.attribution) {
    if (args.attribution.name) {
      attribution += `<div class="font-bold uppercase">${args.attribution.name}</div>`;
    }

    if (args.attribution.description) {
      attribution += `<div>${args.attribution.description}</div>`;
    }
  }

  return quoteTemplate({
    ...args,
    attribution,
    image,
  });
};

export default Quote;
