/* eslint-disable quote-props */
import { fillTabs } from '../helpers/_helpers.js';

// set up constants
const tabs = [
  {
    'Stories': {
      'rect': {
        'x': 294.5,
        'y': 241,
        'width': 146.046875,
        'height': 38,
        'top': 241,
        'right': 440.546875,
        'bottom': 279,
        'left': 294.5,
      },
      'order': 0,
    },
  },
  {
    'Media Coverage': {
      'rect': {
        'x': 515.609375,
        'y': 241,
        'width': 231.2109375,
        'height': 38,
        'top': 241,
        'right': 746.8203125,
        'bottom': 279,
        'left': 515.609375,
      },
      'order': 1,
    },
  },
  {
    'Faculty Accomplishments': {
      'rect': {
        'x': 821.8828125,
        'y': 241,
        'width': 318.796875,
        'height': 38,
        'top': 241,
        'right': 1140.6796875,
        'bottom': 279,
        'left': 821.8828125,
      },
      'order': 2,
    },
  },
  {
    'Videos': {
      'rect': {
        'x': 1215.7421875,
        'y': 241,
        'width': 144.7421875,
        'height': 38,
        'top': 241,
        'right': 1360.484375,
        'bottom': 279,
        'left': 1215.7421875,
      },
      'order': 3,
    },
  },
];

// tests
test('responsive search tabs: 900px', () => {
  expect(
    fillTabs(
      900,
      ['Stories', 'Media Coverage'],
      ['Faculty Accomplishments', 'Videos'],
      tabs
    )
  ).toEqual({
    tabNames: ['Stories', 'Media Coverage'],
    dropdownTabs: ['Faculty Accomplishments', 'Videos'],
  });
});

test('responsive search tabs: 600px', () => {
  expect(
    fillTabs(
      600,
      ['Stories'],
      ['Media Coverage', 'Faculty Accomplishments', 'Videos'],
      tabs
    )
  ).toEqual({
    tabNames: ['Stories'],
    dropdownTabs: ['Media Coverage', 'Faculty Accomplishments', 'Videos'],
  });
});

test('responsive search tabs: 400px', () => {
  expect(
    fillTabs(
      400,
      ['Stories'],
      ['Media Coverage', 'Faculty Accomplishments', 'Videos'],
      tabs
    )
  ).toEqual({
    tabNames: ['Stories'],
    dropdownTabs: ['Media Coverage', 'Faculty Accomplishments', 'Videos'],
  });
});
