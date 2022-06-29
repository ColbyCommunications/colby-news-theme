import React from 'react';
import faker from 'faker';
import generate from './content/ContentGenerator';

const WPImage = (args) => {
  const alignmentClass = {
    left: 'alignleft',
    right: 'alignright',
    center: 'aligncenter',
    wide: 'alignwide',
    full: 'alignfull',
  };

  const align = args.align ? args.align : 'left';
  const dimensions = Array.isArray(args.dimensions)
    ? args.dimensions
    : generate.randomDimensions();

  return (
    <div className="wp-block-image wp-block" data-align={align}>
      <figure className={`${alignmentClass[align]}`}>
        <img
          className="wp-image"
          loading="lazy"
          src={generate.placeholderSrc(dimensions[0], dimensions[1])}
          alt={faker.lorem.sentence()}
          width={dimensions[0]}
          height={dimensions[1]}
        />
        <figcaption>{args.children}</figcaption>
      </figure>
    </div>
  );
};

export default WPImage;
