import dateFormat from 'dateformat';
import storyTeaserTemplate from '../twig/story-teaser.twig';
import Image from './Image';

const StoryTeaser = (args) => {
  const storyArgs = args;

  const imageDimensions = args.featuredStory
    ? { width: 600, height: 400 }
    : { width: 390, height: 260 };

  storyArgs.date = dateFormat(args.date, 'mmmm d, yyyy');
  storyArgs.image = Image({
    ...args.image,
    ...imageDimensions,
    classes: ['w-full', 'h-auto'],
  });

  return storyTeaserTemplate({ ...storyArgs });
};

export default StoryTeaser;
