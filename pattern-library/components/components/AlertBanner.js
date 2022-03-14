import React from 'react';
import IconFlag from './IconFlag';

const AlertBanner = (args) => {
  const defaultIcon = `interface-exclamation-triangle`;

  let title = args.title;
  let iconClasses = '';

  if (args.url) {
    iconClasses = 'text-link';
  }

  if (args.url) {
    title = (
      <a href={args.url} className={``}>
        {title}
      </a>
    );
  }

  let content = (
    <IconFlag
      title={title}
      iconClasses={iconClasses}
      icon={args.icon ? args.icon : defaultIcon}
    ></IconFlag>
  );

  return <aside className={`alert-banner`}>{content}</aside>;
};

export default AlertBanner;
