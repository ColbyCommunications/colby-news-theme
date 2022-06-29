import insetAside from '../twig/inset-aside.twig';
import Image from './Image';
import LinkGroup from './LinkGroup';

const InsetAside = (args) => {
  return insetAside({
    ...args,
    image: args.imageSrc ? Image({ src: args.imageSrc }) : null,
    linkGroup: args.links
      ? LinkGroup({
          links: args.links,
          listClasses: 'fancy-link-list text-lg font-display',
        })
      : null,
  });
};

export default InsetAside;
