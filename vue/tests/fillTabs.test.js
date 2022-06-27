/* eslint-disable quote-props */
import { fillTabs } from '../helpers/_helpers.js';

// set up constants
const tabs = [
  {
    'Stories': {
      'x': 294.5,
      'y': 241,
      'width': 146.046875,
      'height': 38,
      'top': 241,
      'right': 440.546875,
      'bottom': 279,
      'left': 294.5,
    },
  },
  {
    'Media Coverage': {
      'x': 515.609375,
      'y': 241,
      'width': 231.2109375,
      'height': 38,
      'top': 241,
      'right': 746.8203125,
      'bottom': 279,
      'left': 515.609375,
    },
  },
  {
    'Faculty Accomplishments': {
      'x': 821.8828125,
      'y': 241,
      'width': 318.796875,
      'height': 38,
      'top': 241,
      'right': 1140.6796875,
      'bottom': 279,
      'left': 821.8828125,
    },
  },
  {
    'Videos': {
      'x': 1215.7421875,
      'y': 241,
      'width': 144.7421875,
      'height': 38,
      'top': 241,
      'right': 1360.484375,
      'bottom': 279,
      'left': 1215.7421875,
    },
  },
];

// tests
test('responsive search tabs: 900px (shrinking window)', () => {
  expect(
    fillTabs(
      900,
      tabs,
      ['Stories', 'Media Coverage', 'Faculty Accomplishments'],
      ['Videos'],
      930
    )
  ).toEqual({
    tabNames: ['Stories', 'Media Coverage'],
    dropdownTabs: ['Faculty Accomplishments', 'Videos'],
  });
});

test('responsive search tabs: 600px (shrinking window)', () => {
  expect(
    fillTabs(
      600,
      tabs,
      ['Stories', 'Media Coverage'],
      ['Faculty Accomplishments', 'Videos'],
      800
    )
  ).toEqual({
    tabNames: ['Stories'],
    dropdownTabs: ['Media Coverage', 'Faculty Accomplishments', 'Videos'],
  });
});

test('responsive search tabs: 400px (shrinking window)', () => {
  expect(
    fillTabs(
      400,
      tabs,
      ['Stories'],
      ['Media Coverage', 'Faculty Accomplishments', 'Videos'],
      500
    )
  ).toEqual({
    tabNames: ['Stories'],
    dropdownTabs: ['Media Coverage', 'Faculty Accomplishments', 'Videos'],
  });
});

test('responsive search tabs: 400px (static window)', () => {
  expect(
    fillTabs(
      400,
      tabs,
      ['Stories', 'Media Coverage', 'Faculty Accomplishments', 'Videos'],
      [],
      400
    )
  ).toEqual({
    tabNames: ['Stories'],
    dropdownTabs: ['Media Coverage', 'Faculty Accomplishments', 'Videos'],
  });
});

test('responsive search tabs: 600px (static window)', () => {
  expect(
    fillTabs(
      600,
      tabs,
      ['Stories', 'Media Coverage', 'Faculty Accomplishments', 'Videos'],
      [],
      600
    )
  ).toEqual({
    tabNames: ['Stories'],
    dropdownTabs: ['Media Coverage', 'Faculty Accomplishments', 'Videos'],
  });
});
