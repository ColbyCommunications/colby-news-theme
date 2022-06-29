import React from 'react';
import Icon from './Icon';
import IconFlag from './IconFlag';

const IconList = (args) => {
  let { className } = args;
  className = typeof className === 'string' ? className : '';

  let defaultIcon = 'alert';
  let iconSize = '20';

  if (args.arrowList) {
    defaultIcon = 'interface-angle-right-narrow';
    className += ' icon-flag-arrow';
  } else {
    iconSize = args.iconSize ? args.iconSize : iconSize;
  }

  const icon = args.icon
    ? Icon({ icon: args.icon })
    : Icon({ icon: defaultIcon });

  const listItems = [];
  for (const itemProps of args.items) {
    let itemIcon = icon;
    if (itemProps.icon) {
      itemIcon = Icon({ icon: itemProps.icon, size: iconSize });
    }
    listItems.push(
      <li key={itemProps.title}>
        <IconFlag
          element="div"
          title={itemProps.title}
          content={itemProps.content}
          className={args.itemClasses ? args.itemClasses : ''}
          icon={itemIcon}
          iconClasses={args.iconClasses ? args.iconClasses : ''}
        ></IconFlag>
      </li>
    );
  }

  return (
    <div>
      <ul role="list" className={'icon-flag-list ' + className}>
        {listItems}
      </ul>
    </div>
  );
};

export default IconList;
