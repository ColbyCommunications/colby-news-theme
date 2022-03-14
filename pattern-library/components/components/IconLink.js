import React from 'react';
import IconFlag from './IconFlag';

const IconLink = (args) => {
  let { className } = args;
  className = typeof className === 'string' ? className : '';

  const { url } = args;

  if (Array.isArray(args.classes)) {
    const classes = args.classes.join(' ');
    className += ` ${classes}`;
  }

  let icon = args.icon ? args.icon : false;

  if (!icon && args.arrowLink) {
    icon = 'interface-angle-right-narrow';
    className += ' icon-flag-arrow';
  }

  return (
    <IconFlag
      element="a"
      href={url}
      {...args}
      icon={icon}
      className={`icon-link ${className}`}
    ></IconFlag>
  );
};

export default IconLink;
