import figureTemplate from '../../twig/figure.twig';
import Image from '../Image';
import EmbeddedVideo from './EmbeddedVideo';
import VideoPreview from './VideoPreview';

const mediaType = (mediaTypeName) => {
  if (mediaTypeName === 'video') {
    return EmbeddedVideo;
  }
  if (mediaTypeName === 'video-preview') {
    return VideoPreview;
  }
  return Image;
};

const Figure = (args) => {
  let { media } = args;
  media = media ?? {};
  let { classes } = media;
  classes = classes ?? [];

  media.stretch = args.stretch;
  media.classes = [
    ...new Set([
      ...classes,
      ...(args.mediaType === 'video-preview' ? [] : ['h-full', 'w-full']),
    ]),
  ];
  media.src = args.mediaSrc;
  media.alt = args.mediaAlt ? args.mediaAlt : '';
  media.iconSize = args.iconSize;
  media.videoLink = args.videoLink;
  media.element = args.element;

  return figureTemplate({
    ...args,
    isResponsiveEmbed: args.mediaType === 'video',
    media: mediaType(args.mediaType)(media),
  });
};

export default Figure;
