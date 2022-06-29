import backgroundImageTemplate from '../../twig/background-image.twig';
import Image from '../Image';

const imageSizeClasses = (size = 'cover') => {
  const sizeClasses = {
    full: ['w-full', 'h-full', 'max-w-none', 'max-h-none'],
    native: ['w-full', 'h-full', 'object-none'],
  };

  sizeClasses.cover = [...sizeClasses.full, 'object-cover'];
  sizeClasses.contain = [...sizeClasses.full, 'object-contain'];

  if (Object.prototype.hasOwnProperty.call(sizeClasses, size)) {
    return sizeClasses[size];
  }

  if (Array.isArray(size)) {
    return size;
  }

  if (typeof size === 'string') {
    return size.split(' ');
  }

  return '';
};

export default (args) => {
  return backgroundImageTemplate({
    ...args,
    backgroundImage: Image({
      src: args.backgroundSrc,
      classes: imageSizeClasses(args.size),
      pin: args.pin,
    }),
    alt: '',
  });
};
