import React from 'react';

const FancyLink = (args) => {
  let arrowColorClass = '';
  if (args.arrowColor === 'dark') {
    arrowColorClass = 'link-arrow-dark';
  } else if (args.arrowColor === 'light') {
    arrowColorClass = 'link-arrow-light';
  }
  return (
    <a
      href={args.url}
      className={`link-arrow ${arrowColorClass} text-color-link uppercase font-semibold tracking-wider ${
        args.className ?? ''
      }`}
    >
      {args.children}
    </a>
  );
};

export default FancyLink;
