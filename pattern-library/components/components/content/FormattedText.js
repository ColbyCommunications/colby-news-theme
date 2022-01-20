import faker from 'faker';
import generate from './ContentGenerator';
import RelatedStoriesTemplate from '../../twig/related-stories.twig';
import { RelatedStories } from '../../stories/RelatedStories.stories';

const randomRange = (min, max) => {
  const r = min + Math.random() * (max - min + 1);
  return Math.floor(r);
};

const phrasify = (wordList) => {
  const phrases = [];
  let remainingWords = [...wordList];
  let range = 0;

  while (remainingWords.length > 1) {
    range = randomRange(1, 4);
    phrases.push({
      text: remainingWords.slice(0, range).join(' '),
      element: false,
    });
    remainingWords = remainingWords.slice(range);
  }

  return phrases;
};

const randomUnformatted = (phraseItems, untested = false) => {
  const index = randomRange(0, phraseItems.length - 1);
  let newUntested = untested;

  if (
    untested === [] ||
    !phraseItems ||
    !(Array.isArray(phraseItems) && phraseItems.length)
  ) {
    return false;
  }

  if (untested === false && phraseItems.length) {
    newUntested = Array(phraseItems.length)
      .fill()
      .map((x, i) => i);
  }

  if (!phraseItems[index].element) {
    return index;
  }

  newUntested = newUntested.filter((value) => {
    return value !== index;
  });
  return randomUnformatted(phraseItems, newUntested);
};

const sprinkle = (bodyText, { elements = ['b', 'i'], href = '#' }) => {
  const words = bodyText.split(' ');
  const phrases = phrasify(words);
  let index;

  elements.forEach((element) => {
    index = randomUnformatted(phrases);
    if (index) {
      phrases[index].element = element;
    }
  });

  const wrappedPhrases = phrases.map(({ text, element }) => {
    if (element) {
      if (element === 'a') {
        return `<a href="${href}">${text}</a>`;
      }
      return `<${element}>${text}</${element}>`;
    }
    return text;
  });

  return wrappedPhrases.join(' ');
};

const capitalize = ([firstLetter, ...restOfWord]) =>
  firstLetter.toUpperCase() + restOfWord.join('');

const headline = (max = 10) =>
  capitalize(faker.lorem.words(randomRange(3, max)));

const paragraphs = (count = 1) => {
  let paragraphContents = ``;

  for (let i = 0; i < count; i += 1) {
    paragraphContents += `<p>${sprinkle(faker.lorem.paragraph(), {
      elements: ['b', 'i', 'a'],
    })}</p>`;
  }
  return paragraphContents;
};

// Generate a random statistic
// Each statistic will be a number, decorated with one
// of the items in the `decorators` array.
// If the decorator value is a string, it will be
// prepended to the number. If it is an array,
// the second value indicates the position of the
// character: 0 = prepend, 1 = append
const statistic = (args = {}) => {
  const decorators = args.decorators
    ? args.decorators
    : [['#', 0], ['$', 0], ['%', 1], ''];

  const value = faker.datatype.number({
    min: args.min ? args.min : 1,
    max: args.max ? args.max : 500,
  });
  const decorator = decorators[Math.floor(Math.random() * decorators.length)];

  if (typeof decorator === 'string') {
    return `${value}${decorator}`;
  }

  if (Array.isArray(decorator)) {
    if (decorator[1] === 1) {
      return `${value}${decorator[0]}`;
    }
    return `${decorator[0]}${value}`;
  }

  return value;
};

const listItems = ({
  count = 5,
  min = 2,
  max = 7,
  itemType = 'sentence',
  itemElement = 'li',
}) => {
  const items = [];
  const calculatedCount = count === 'random' ? randomRange(min, max) : count;

  for (let i = 0; i < calculatedCount; i += 1) {
    items.push(`<${itemElement}>${faker.lorem[itemType]()}</${itemElement}>`);
  }

  return items;
};

const list = ({
  type = 'ul',
  count = 5,
  itemType = 'sentence',
  min = 2,
  max = 7,
} = {}) => {
  const items = listItems({ count, itemType, min, max });

  return `<${type}>${items.join('')}</${type}>`;
};

const dl = ({ count = 3, itemType = 'sentence' }) => {
  const items = [];

  for (let i = 0; i < count; i += 1) {
    items.push(`
      <dt>${faker.lorem[itemType]()}</dt>
      ${listItems({ count, itemType, itemElement: 'dd' }).join(' ')}
    `);
  }

  return `<dl>${items.join('')}</dl>`;
};

const image = ({ width = 640, height = 480, align = 'right', caption }) => {
  const alignClass = `class="align${align}"`;
  const imageElement = `<img src="${generate.placeholderSrc(width, height)}" ${
    caption ? '' : alignClass
  } />`;

  if (caption) {
    return `<figure ${alignClass}>${imageElement}<figcaption>${caption}</figcaption></figure>`;
  }
  return imageElement;
};

export default () => {
  return `
    <h2>${headline()}</h2>

    ${image({ randomize: true, caption: faker.lorem.sentence() })}
    ${paragraphs(4)}

    <div class="w-max mx-auto md:float-left md:ml-0 md:mr-16">
      ${RelatedStoriesTemplate({
        ...RelatedStories.args,
        items: RelatedStories.args.items.slice(0, 3),
        float: true,
        hLevel: 3,
      })}
    </div>
    ${paragraphs(3)}

    <ul>
      <li>
        ${faker.lorem.paragraph()}
      </li>
      <li>
        ${faker.lorem.sentence()}
      </li>
      <li>
        ${faker.lorem.sentence()}
        ${list({ type: 'ul' })}
      </li>
      <li>
        ${faker.lorem.sentence()}
        ${list({ type: 'ul' })}
      </li>
    </ul>

    <ol>
      <li>
        ${faker.lorem.paragraph()}
      </li>
      <li>
        ${faker.lorem.sentence()}
      </li>
      <li>
        ${faker.lorem.sentence()}
        ${list({ type: 'ol' })}
      </li>
      <li>
        ${faker.lorem.sentence()}
        ${list({ type: 'ol' })}
      </li>
    </ol>

    <figure class="wp-block-pullquote">
      <blockquote>
          <p>“Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.”</p>
          <cite>Hannah Wolfe, assistant professor of computer science</cite>
      </blockquote>
    </figure>

    <h3>${headline()}</h3>
    ${image({ align: 'wide', randomize: true })}

    ${dl({})}
    ${paragraphs()}

    ${image({ align: 'left', randomize: true })}
    ${paragraphs(3)}

    <blockquote>${sprinkle(faker.lorem.paragraph(), {
      elements: ['b', 'i'],
    })}</blockquote>

    ${paragraphs()}

  <h2>${headline()}</h2>
  <h3>${headline()}</h3>
  <h4>${headline()}</h4>
  ${paragraphs()}
  ${image({ align: 'full', randomize: true })}
  ${paragraphs()}
  <h4>${headline()}</h4>
  ${paragraphs(2)}
  
  <h3>${headline()}</h3>
  ${paragraphs(2)}

  `;
};

export const TextUtilities = {
  randomRange,
  capitalize,
  image,
  headline,
  dl,
  list,
  paragraphs,
  statistic,
  listItems,
  sprinkle,
  faker,
};
