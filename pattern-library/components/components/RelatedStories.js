import RelatedStoriesTemplate from '../twig/related-stories.twig';

const RelatedStories = (args) => {
  return RelatedStoriesTemplate({ ...args });
};

export default RelatedStories;