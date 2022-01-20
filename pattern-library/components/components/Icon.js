import iconTemplate from '../twig/icon.twig';

export default (args) => {
  if (args.icon.indexOf('<svg') === 0) {
    return args.icon;
  }

  const icon = iconTemplate({
    ...args,
    width: args.width ?? args.size,
    height: args.height ?? args.size,
  });

  return icon;
};
