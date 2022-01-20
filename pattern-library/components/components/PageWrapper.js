import React from 'react';
// import Image from './Image';
import SiteHeader from './SiteHeader';
import SiteFooter from './SiteFooter';
import defaultMenus from '../_data/default-menus';
// import headerLogo from '!!raw-loader!/app/dist/images/header_logo.svg';

const PageWrapper = (args) => {
  // const footerLogo = {
  //   src: '/images/header_logo.svg',
  //   alt: 'Colby News',
  // };
  // const siteFooterContent = () => ({
  //   location: {
  //     title: 'Colby College',
  //     address: '1000 Some Rd',
  //     address_2: 'Colby, US 10000',
  //   },
  //   bottomLinks: defaultMenus.footerUtilityLinks,
  //   contact: {
  //     title: 'Contact Admissions',
  //     phone: '979-555-1000',
  //     email: 'info@colby.edu',
  //     links: defaultMenus.footerContactLinks,
  //   },
  //   homeLink: defaultMenus.homeLink.url,
  //   socialLinks: defaultMenus.socialLinks,
  //   utilityLinks: defaultMenus.footerUtilityLinks,
  //   quickLinksTitle: defaultMenus.quickLinksTitle,
  //   quickLinks: defaultMenus.quickLinks,
  //   footerContactLinks: defaultMenus.footerContactLinks,
  //   accreditationsTitle: defaultMenus.accreditationsTitle,
  //   accreditations: defaultMenus.accreditations,
  //   copyright: `©%year% Colby College`,
  //   footerLogo: Image(footerLogo),
  // });

  let mainContent = args.children;

  return (
    <>
      <SiteHeader
        {...defaultMenus}
        // globalAlert={false}
        // headerLogo={headerLogo}
        // searchButton={{
        //   icon: 'interface-search',
        //   hiddenText: 'Submit search',
        //   size: 5,
        // }}
        // searchToggle={{
        //   off: {
        //     icon: 'interface-search',
        //     hiddenText: 'Show search field',
        //     size: 5,
        //   },
        //   on: {
        //     icon: 'interface-times',
        //     hiddenText: 'Hide search field',
        //     size: 5,
        //   },
        // }}
      ></SiteHeader>
      <article className="post">{mainContent}</article>
      <SiteFooter></SiteFooter>
    </>
  );
};

export default PageWrapper;
