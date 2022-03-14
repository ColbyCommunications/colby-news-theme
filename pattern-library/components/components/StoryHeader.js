import storyHeaderTemplate from '../twig/story-header.twig';
import socialSharingTemplate from '../twig/social-sharing.twig';
import Figure from './media/Figure';
import faker from 'faker';

const StoryHeader = (args) => {
  const figure = Figure({
    mediaType: (args.video && args.orientation === 'landscape') ? 'video' : 'image',
    mediaSrc: (() => {
      if (args.orientation === 'portrait') return faker.image.image(1200, 1600);
      if (args.video) return 'https://www.youtube.com/embed/tO01J-M3g0U?feature=oembed';
      return  faker.image.image(1600, 1000);
    })(),
    captionClasses: ['text-sm'],
  });

  return storyHeaderTemplate({
    ...args,
    figure,
    shareButtons: socialSharingTemplate(),
  });
};

export default StoryHeader;
