const buildButtons = (buttons, count = false, classes = null) => {
  let styledButtons = buttons;
  if (classes) {
    styledButtons = buttons.map((button) => {
      return {
        ...button,
        classes,
      };
    });
  }

  if (count === 0) {
    return [];
  }

  if (!count) {
    return styledButtons;
  }

  return styledButtons.slice(0, count);
};

export const extraLongButtons = (count = false, classes = null) => {
  return buildButtons(
    [
      {
        title: `<div>Funding for Experiences</div><div class="font-normal text-lg">Research, internships, global experiences</div>`,
        url: '#funding',
      },
      {
        title: 'Application Requirements',
        url: '#application-requirements',
      },
      {
        title: 'Further Button Title',
        url: '#further',
      },
      {
        title: 'Longest Button Title of Them All',
        url: '#longest',
      },
    ],
    count,
    classes
  );
};

export const longButtons = (count = false, classes = null) => {
  return buildButtons(
    [
      {
        title: 'All Dates and Deadlines',
        url: '#dates-and-deadlines',
      },
      {
        title: 'Application Requirements',
        url: '#application-requirements',
      },
      {
        title: 'Further Button Title',
        url: '#further',
      },
      {
        title: 'Longest Button Title of Them All',
        url: '#longest',
      },
      {
        title: 'More and More Buttons',
        url: '#more',
      },
    ],
    count,
    classes
  );
};

export const shortButtons = (count = false, classes = null) => {
  return buildButtons(
    [
      {
        title: 'Connect',
        url: '#connect',
      },
      {
        title: 'Visit',
        url: '#visit',
      },
      {
        title: 'Apply',
        url: '#apply',
      },
      {
        title: 'Two Words',
        url: '#two-words',
      },
      {
        title: 'Expertise',
        url: '#expertise',
      },
    ],
    count,
    classes
  );
};
