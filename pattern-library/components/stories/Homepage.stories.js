import React from 'react';
import RawHTML from '../utilities/RawHTML';
import HomepageTemplate from '../twig/homepage-demo.twig';
import { SiteHeader } from './SiteHeader.stories';
import SiteHeaderComponent from '../components/SiteHeader';
import StoryHeaderComponent from '../components/StoryHeader';
import { SlidingTeasers } from './SlidingTeasers.stories';
import SlidingTeasersTemplate from '../twig/sliding-teasers.twig';
import { VideoList } from './VideoList.stories';
import TeaserPairWithSlidingTeasersTemplate from '../twig/teaser-pair-with-sliding-teasers.twig';
import { BreakerFeature } from './BreakerFeature.stories';
import BreakerFeatureTemplate from '../twig/breaker-feature.twig';
import { MediaCoverageAndEvents } from './MediaCoverageAndEvents.stories';
import MediaCoverageAndEventsTemplate from '../twig/media-coverage-and-events.twig';
import { EditorsPicks } from './EditorsPicks.stories';
import { SiteFooter } from './SiteFooter.stories';
import SiteFooterComponent from '../components/SiteFooter';

export default {
  title: 'Page Demos/Homepage',
};

export const Homepage = (args) => {
  args.pageHeader = StoryHeaderComponent({
    element: 'div',
    orientation: args.heroOrientation,
    title: `Something Doesn't Compute`,
    primaryCategory: { title: 'Aritifical Intelligence', url: '#' },
    summary: `Using art and computer science, Hannah Wolfe reveals tech's shortcomings.`,
    link: { title: 'Read More', url: '#'}
  });

  return  (
    <RawHTML componentFunction={HomepageTemplate} {...args} />
  );
};

Homepage.args = {
  // control
  heroOrientation: 'portrait',

  // props
  siteHeader: SiteHeaderComponent(SiteHeader.args),
  latest: SlidingTeasersTemplate({ ...SlidingTeasers.args, headline: 'Latest' }),
  followCTA: /* html */ `<div class="border-t border-b border-black py-10">PLACEHOLDER FOR SUBSCRIBE CTA (WILL BE GENERATED IN GUTENBERG?)</div>`,
  videos: TeaserPairWithSlidingTeasersTemplate(VideoList.args),
  breakerFeature1: BreakerFeatureTemplate(BreakerFeature.args),
  mediaCoverageAndEvents: MediaCoverageAndEventsTemplate(MediaCoverageAndEvents.args),
  breakerFeature2: BreakerFeatureTemplate({
    ...BreakerFeature.args,
    superhead: { url: '#', title: 'Access and Opportunity' },
    headline: 'When the world calls. We Answer.',
    link: { url: '#', title: 'Learn more about Pay It Northward' }
  }),
  editorsPicks: TeaserPairWithSlidingTeasersTemplate(EditorsPicks.args),
  siteFooter: SiteFooterComponent(SiteFooter.args)
};

Homepage.argTypes = {
  heroOrientation: {
    options: ['landscape', 'portrait'],
    control: {
      type: 'inline-radio'
    }
  }
};