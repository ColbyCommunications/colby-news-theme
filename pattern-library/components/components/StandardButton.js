import React from 'react';
import Button from './Button';

const colorClasses = {
  default: '',
  light: 'btn-light',
};

const StandardButton = (args) => {
  const classes = args.classes ?? [
    'btn',
    args.display ? args.display : 'inline-block',
    args.color ? colorClasses[args.color] : colorClasses.secondary,
    args.padding ? args.padding : 'btn-p',
    args.textStyle ? args.textStyle : '',
  ];

  return <Button classes={classes} {...args} />;
};

export default StandardButton;
