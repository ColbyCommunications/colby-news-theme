import React from 'react';
import IconList from './IconList';
import getRowSpacing from '../utilities/RowSpacing';

const backgroundColors = {
  white: 'bg-white',
  gold: 'bg-tertiary-light',
  burgundy: 'bg-primary-dark',
  gray: 'bg-gray-500',
};

const ContentSection = (args) => {
  let backgroundColor = args.backgroundColor;

  if (backgroundColor && backgroundColors[backgroundColor]) {
    backgroundColor = backgroundColors[backgroundColor];
  }

  let verticalPadding = '';

  if (backgroundColor) {
    verticalPadding = args.verticalPadding ? args.verticalPadding : 'lg';
    verticalPadding = getRowSpacing(verticalPadding, 'py');
  }

  let title = '';
  if (args.title) {
    const HeaderLevel = args.headerLevel ? args.headerLevel : 'h2';
    title = (
      <HeaderLevel className={`font-display text-4xl mb-3 text-heading`}>
        {args.title}
      </HeaderLevel>
    );
  }

  let headerLinksArray = Array.isArray(args.headerLinks)
    ? args.headerLinks
    : [];

  headerLinksArray = headerLinksArray
    .filter((linkItem) => {
      return linkItem.title || linkItem.url;
    })
    .map((link) => {
      return {
        content: <a href={link.url}>{link.title}</a>,
      };
    });

  const headerLinks =
    headerLinksArray.length > 0 ? (
      <IconList
        className={`flex flex-col fancy-link-list text-lg font-display`}
        itemClasses={`mb-2`}
        arrowList={true}
        items={headerLinksArray}
      ></IconList>
    ) : (
      ''
    );

  const headerBody = args.headerBody ? (
    <div className={`text-text text-base-plus-1 mb-2`}>{args.headerBody}</div>
  ) : (
    ''
  );

  let sectionHeader = '';
  let content = args.children;

  if (title || headerLinks || headerBody) {
    sectionHeader = (
      <header
        className={`${args.headerMargin ? args.headerMargin : 'mb-8'} ${
          args.headerClasses ? args.headerClasses : ''
        }`}
      >
        {title}
        {headerBody}
        {headerLinks}
      </header>
    );
  }

  sectionHeader = (
    <div className={`${args.grid ? 'container-grid' : ''}`}>
      {sectionHeader}
    </div>
  );

  content = (
    <div
      className={`${args.grid ? 'container-grid' : ''} ${
        args.fullWidth ? 'container-full' : ''
      }`}
    >
      {content}
    </div>
  );

  return (
    <section
      className={`${args.className} ${backgroundColor} ${verticalPadding} ${
        args.rowSpacing ? getRowSpacing(args.rowSpacing) : getRowSpacing('lg')
      }`}
    >
      {sectionHeader}
      {content}
    </section>
  );
};

export default ContentSection;
