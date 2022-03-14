import videoPreviewTemplate from '../../twig/video-preview.twig';
import Icon from '../Icon';

export default (args) =>
  videoPreviewTemplate({
    ...args,
    icon: Icon({
      icon: args.icon ?? 'interface-play-circle',
      size: args.iconSize ?? 40,
      hiddenText: args.iconHiddenText,
    }),
    imageOpacity: args.imageOpacity ?? 100,
    imageHoverOpacity: args.imageHoverOpacity ?? 80,
  });

// 'group-hover:opacity-80'
// 'opacity-100'
