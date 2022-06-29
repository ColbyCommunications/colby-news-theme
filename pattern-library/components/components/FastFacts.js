import fastFactsTemplate from '../twig/fast-facts.twig';

const themeSettingOptions = {
  red: {
    text: 'theme-dark',
    bgColor: 'bg-primary-light',
  },
  gold: {
    text: 'theme-dark',
    bgColor: 'bg-tertiary-dark',
  },
};

const FastFacts = (args) => {
  const theme = args.backgroundColor ? args.backgroundColor : 'red';

  return fastFactsTemplate({
    ...args,
    themeClasses: `${themeSettingOptions[theme].text} ${themeSettingOptions[theme].bgColor}`,
  });
};

export default FastFacts;
