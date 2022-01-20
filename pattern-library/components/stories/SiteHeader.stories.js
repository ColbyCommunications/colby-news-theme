import React from 'react';
import SiteHeaderComponent from '../components/SiteHeader';
import RawHTML from '../utilities/RawHTML';
import headerLogo from '!!raw-loader!/app/dist/images/header_logo.svg';
import { SiteFooter } from './SiteFooter.stories';
import SiteFooterComponent from '../components/SiteFooter';

export default {
  title: 'Components/Navigation/Site Header',
};

const defaultAlert = {
  title: 'This is a global alert',
  url: '#',
};

export const SiteHeader = (args) => (
  <RawHTML
    componentFunction={SiteHeaderComponent}
    {...args}
    headerLogo={headerLogo}
    globalAlert={args.globalAlert ? defaultAlert : false}
  />
);

SiteHeader.args = {
  globalAlert: false,
  featuredTopicLinks: [
    'Access and Opportunity', 'Alumni', 'Announcements', 'Arts', 'Artificial Intelligence',
    'Campus and Community', 'Environment and Climate', 'Humanities', 'Interdisciplinary Studies',
    'Media Coverage', 'Natural Sciences', 'Social Sciences'
  ].map(title => ({ title, url: '#' })),
  additionalLinks: [
    'Athletic News', 'Colby Magazine', 'Contact', 'Events', 'Faculty Accomplishments', 'Resources for the Media'
  ].map(title => ({ title, url: '#' })),
  emailSignupForm: '[[ email signup form here ]]',
  modalSiteFooter: SiteFooterComponent(SiteFooter.args) // identical to "real" Site Footer
};