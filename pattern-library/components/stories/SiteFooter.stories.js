import React from 'react';
import SiteFooterComponent from '../components/SiteFooter';
import RawHTML from '../utilities/RawHTML';
import defaultMenus from '../_data/default-menus';

export default {
  title: 'Components/Navigation/Site Footer',
};

const siteFooterContent = () => ({
  socialLinks: defaultMenus.socialLinks,
});

export const SiteFooter = (args) => (
  <RawHTML componentFunction={SiteFooterComponent} {...args} />
);

SiteFooter.args = siteFooterContent();
SiteFooter.argTypes = {};
