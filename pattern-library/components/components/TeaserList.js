import teaserList from '../twig/teaser-list.twig';
import paginationTemplate from '../twig/pagination.twig';
import StoryTeaser from './StoryTeaser';

const TeaserList = (args) => {
  let teasers;
  if (args.teasers && Array.isArray(args.teasers)) {
    const teasersTemp = args.teasers;
    if (args.featuredStory) {
      teasersTemp[0].featuredStory = true;
    }
    teasers = teasersTemp.map((teaserArgs) => StoryTeaser({ ...teaserArgs }));
  } else {
    teasers = false;
  }
  const pagination = paginationTemplate({ pagination: args.pagination });

  return teaserList({ ...args, teasers, pagination });
};

export default TeaserList;
