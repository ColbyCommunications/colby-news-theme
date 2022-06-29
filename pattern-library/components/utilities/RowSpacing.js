const getRowSpacing = (amountName, dimension = 'mb', screen = '') => {
  const spacing = {
    default: {
      none: '0',
      // eslint-disable-next-line quote-props
      '0': '0',
      min: '4',
      sm: '4',
      md: '8',
      lg: '8',
      xl: '8',
    },
    sm: {
      sm: '8',
      xl: '14',
    },
    md: {
      md: '8',
      lg: '14',
      xl: '24',
    },
    lg: {
      // xl: '14',
    },
    xl: {
      // xl: '40',
    },
  };

  if (screen && spacing.amountName && spacing.amountName.screen) {
    return dimension + '-' + spacing.amountName.screen;
  }

  let classes = Object.entries(spacing).map((entry) => {
    let screenSize, amounts;
    [screenSize, amounts] = entry;
    let prefix = '';

    if (amounts[amountName]) {
      prefix = screenSize === 'default' ? '' : `${screenSize}:`;
      return `${prefix + dimension}-${amounts[amountName]}`;
    }

    return false;
  });

  classes = classes.filter((item) => item);

  return classes.join(' ');
};

export default getRowSpacing;
