import React from 'react';

const Button = (args) => {
  const Element = args.element ?? 'a';

  let { className } = args;
  className = typeof className === 'string' ? className : '';

  const { url } = args;

  if (Array.isArray(args.classes)) {
    const classes = args.classes.join(' ');
    className += ` ${classes}`;
  }

  return (
    <Element href={url} {...args} className={`btn ${className}`}>
      <div className="button-content">{args.children}</div>
    </Element>
  );
};

export default Button;
