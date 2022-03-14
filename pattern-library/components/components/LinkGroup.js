import React from 'react';
import { renderToString } from 'react-dom/server';
import Button from './Button';
import linkGroupTemplate from '../twig/link-group.twig';
import IconList from './IconList';

const LinkGroup = (args) => {
  let button = '';
  let linkGroup = '';

  const classes = args.className ? args.className : '';

  let buttonClasses = Array.isArray(args.buttonClasses)
    ? args.buttonClasses.join(' ')
    : args.buttonClasses;
  if (typeof buttonClasses !== 'string') {
    buttonClasses = '';
  }
  let groupClasses = Array.isArray(args.groupClasses)
    ? args.groupClasses.join(' ')
    : args.groupClasses;
  if (typeof groupClasses !== 'string') {
    groupClasses = '';
  }

  // if (args.textColorScheme === 'light') {
  //     buttonClasses += ' text-text-light hocus:bg-gold';
  //     classes += ' text-text-light';
  // }

  if (args.button && (args.button.title || args.button.url)) {
    button = (
      <Button
        className={`flex-shrink-0 max-w-full ${
          args.align === 'center' ? 'md:ml-4' : ''
        } mb-4 last:mb-0 {buttonClasses}`}
        url={args.button.url}
      >
        {args.button.title}
      </Button>
    );
  }

  const linkJustify = args.align === 'center' ? 'md:justify-center' : '';

  if (args.links && Array.isArray(args.links)) {
    let linkClasses = args.linkClasses ? args.linkClasses : '';

    const links = args.links
      .filter((linkItem) => {
        return linkItem.title || linkItem.url;
      })
      .map((link) => {
        return {
          content: (
            <a href={link.url} className={linkClasses}>
              {link.title}
            </a>
          ),
        };
      });

    const linkList = (
      <IconList
        className={`${
          args.listDisplay ? args.listDisplay : 'flex flex-col'
        } ${linkJustify} ${args.listClasses}`}
        itemClasses={`mb-2`}
        arrowList={true}
        items={links}
      ></IconList>
    );

    if (links.length) {
      linkGroup = `<div class="flex flex-col items-start last:mb-0 ${groupClasses}">
                ${renderToString(button)}
                ${renderToString(linkList)}
            </div>`;
    }
  } else if (button) {
    linkGroup = `<div class="flex flex-col items-start ${groupClasses}">
            ${renderToString(button)}
        </div>`;
  }

  return linkGroupTemplate({
    ...args,
    className: classes,
    linkList: linkGroup,
  });
  // return (
  //     <div className={`link-group ${args.className ?? '' }`}>
  //         {linkList}
  //     </div>
  // );
};

export default LinkGroup;
