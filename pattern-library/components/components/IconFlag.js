import React from 'react';
import RawHTML from '../utilities/RawHTML';
import Icon from './Icon';

const IconFlag = (args) => {
  const Element = args.element ?? 'div';

  let { className } = args;
  className = typeof className === 'string' ? className : '';

  if (Array.isArray(args.classes)) {
    const classes = args.classes.join(' ');
    className += ` ${classes}`;
  }

  const defaultIcon = 'interface-page';

  const iconSrc = args.icon
    ? Icon({ icon: args.icon })
    : Icon({ icon: defaultIcon });

  const icon = <RawHTML component={iconSrc}></RawHTML>;

  const finalArgs = [];

  if (args.href) {
    finalArgs.href = args.href;
  }

  return (
    <Element {...finalArgs} className={`icon-flag ${className}`}>
      <div
        className={
          'icon-flag__icon ' + (args.iconClasses ? args.iconClasses : '')
        }
      >
        {icon}
      </div>
      <div
        className={
          'icon-flag__title ' + (args.titleClasses ? args.titleClasses : '')
        }
      >
        {args.title}
      </div>
      <div
        className={
          'icon-flag__content ' +
          (args.contentClasses ? args.contentClasses : '')
        }
      >
        {args.content}
      </div>
    </Element>
  );
};

export default IconFlag;
