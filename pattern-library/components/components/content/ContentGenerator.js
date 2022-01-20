import faker from 'faker';
import Image from '../Image';
import { TextUtilities } from './FormattedText';

const iconChoices = [
  'ap.svg',
  'basketball.svg',
  'class.svg',
  'degrees.svg',
  'idea.svg',
  'microscope.svg',
  'mountain.svg',
];

const unitChoices = ['thousand', 'million', 'billion', 'people', 'or more'];

const addRandomly = (object, key, value, probability = 0.33) => {
  if (Math.random() < probability) {
    object[key] = value;
  }

  return object;
};

const fact = (hasIcon) => {
  const iconFilename =
    iconChoices[Math.floor(Math.random() * iconChoices.length)];
  const fact = {
    title: TextUtilities.statistic(),
    body: TextUtilities.headline(4),
  };

  if (Math.random() < 0.33) {
    fact.units = unitChoices[Math.floor(Math.random() * unitChoices.length)];
  }

  if (hasIcon) {
    fact.icon = Image({
      src: `images/${iconFilename}`,
      alt: '',
      width: 80,
      height: 80,
      pin: 'object-bottom',
    });
  }

  return fact;
};

const facts = (factCount = 4, hasIcon = false) => {
  const facts = [...new Array(factCount)].map(() => fact(hasIcon));

  return facts;
};

const link = (args = {}) => {
  return {
    title: TextUtilities.headline(7),
    url: faker.internet.url(),
    classes: args.classes ? args.classes : '',
    external: args.external ? args.external : false,
  };
};

const links = (linkCount = 5, args = {}) => {
  if (Array.isArray(linkCount)) {
    const linkArray = linkCount.map((item) => {
      let newLink = item;

      if (typeof item === 'string') {
        newLink = {
          title: item,
          url: `#${item.replace(/[\W_]+/g, '-')}`,
        };
      } else if (typeof item === 'object' && item.title) {
        if (!item.url) {
          newLink.url = `#${item.title.replace(/[\W_]+/g, '-')}`;
        }
      }

      if (args.external) {
        if (args.external === true) {
          newLink.external = true;
        } else if (!isNaN(args.external)) {
          newLink = addRandomly(newLink, 'external', true, args.external);
        }
      }

      return newLink;
    });

    return linkArray;
  }
  const generatedArray = Array.from({ length: linkCount }, () => {
    let external = false;
    if (args.external) {
      if (args.external === true) {
        external = true;
      } else if (!isNaN(args.external)) {
        external = Math.random() < args.external;
      }
    }
    return link({ external: external });
  });

  return generatedArray;
};
const randomDimensions = (args = {}) => {
  const defaultMin = 768;
  const defaultMax = 1024;

  let minW, minH, maxW, maxH;

  maxW = args.maxW ? args.maxW : defaultMax;
  maxH = args.maxH ? args.maxH : defaultMax;

  if (args.maxW) {
    if (!args.minW) {
      minW = defaultMin > args.maxW ? args.maxW : defaultMin;
    } else {
      if (args.minW > args.maxW) {
        minW = args.maxW;
      } else {
        minW = args.minW;
      }
    }
  } else {
    minW = args.minW ? args.minW : defaultMin;
  }

  if (args.maxH) {
    if (!args.minH) {
      minH = defaultMin > args.maxH ? args.maxH : defaultMin;
    } else {
      if (args.minH > args.maxH) {
        minH = args.maxH;
      } else {
        minH = args.minH;
      }
    }
  } else {
    minH = args.minH ? args.minH : defaultMin;
  }

  console.log(`minW: ${minW}, maxW: ${maxW}`);
  console.log(`minH: ${minH}, maxH: ${maxH}`);

  const width = args.w ? args.w : faker.datatype.number(minW, maxW);
  const height = args.h ? args.h : faker.datatype.number(minH, maxH);

  return [width, height];
};

const placeholderSrc = (width, height, photo = false) => {
  if (photo) {
    return faker.image.image(width, height);
  }
  return `https://fakeimg.pl/${width}x${height}`;
};

export default {
  fact,
  facts,
  link,
  links,
  randomDimensions,
  placeholderSrc,
};
