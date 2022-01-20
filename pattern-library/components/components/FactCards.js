import factCardsTemplate from '../twig/fact-cards.twig';
import Image from './Image';

const FactCards = (args) => {
  const bgSrc = 'images/leaf_background_grey.svg';

  const backgroundImage = bgSrc
    ? Image({
        src: bgSrc,
        alt: '',
        fit: 'object-cover',
        pin: 'object-right-top',
        classes: ['min-w-full', 'min-h-full'],
      })
    : false;

  return factCardsTemplate({ ...args, backgroundImage });
};

export default FactCards;
