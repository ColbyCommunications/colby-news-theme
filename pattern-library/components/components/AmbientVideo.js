import ambientVideo from '../twig/ambient-video.twig';
import Image from './Image';

const AmbientVideo = (args) => {
  const iconNames = args.icon ? args.icon : {};
  let fallbackImage = '';

  iconNames.play = iconNames.play ? iconNames.play : 'interface-play';
  iconNames.pause = iconNames.pause ? iconNames.pause : 'interface-pause';

  if (args.fallbackImage) {
    fallbackImage = Image({
      src: args.fallbackImage,
      alt: '',
      fit: 'object-cover',
      classes: ['w-full', 'h-full'],
    });
  }

  return ambientVideo({ ...args, icon: iconNames, fallbackImage });
};

export default AmbientVideo;
