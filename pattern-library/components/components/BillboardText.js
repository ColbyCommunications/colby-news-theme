import LinkGroup from './LinkGroup';
import billBoardTextTemplate from '../twig/billboard-text.twig';

const BillboardText = (args) => {
  const HeadingElement = args.headingElement ?? 'h2';

  const alignments = {
    left: 'text-left',
    center: 'text-center',
  };

  const align = args.align ? alignments[args.align] : alignments.center;

  let linkGroup = '';

  if (args.button || args.links) {
    let groupClasses = '';
    linkGroup = LinkGroup({
      ...args,
      align,
      listClasses:
        'billboard__link-list fancy-link-list text-xl font-display font-light',
      groupClasses:
        groupClasses + (args.align === ' center' ? ' md:justify-center' : ''),
    });
  }

  let headingClasses = Array.isArray(args.headingClasses)
    ? args.headingClasses.join(' ')
    : args.headingClasses;
  if (typeof headingClasses !== 'string') {
    headingClasses = '';
  }

  const headingFont = args.headingFont ? args.headingFont : 'font-display';
  let fontSize = args.headingFontSize
    ? args.headingFontSize
    : 'leading-none sm:leading-none md:leading-none text-3xl sm:text-4xl md:text-5xl';

  return billBoardTextTemplate({
    ...args,
    align,
    fontSize,
    headingColor: args.headingColor ? args.headingColor : 'text-heading',
    headingFont,
    headingClasses,
    showHR: args.showHR,
    hrColor: args.hrColor,
    linkGroup,
    HeadingElement,
  });
};

export default BillboardText;
