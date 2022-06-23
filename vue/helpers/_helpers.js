/* eslint-disable import/prefer-default-export */
import _remove from 'lodash/remove';

export const fillTabs = (
  currentWindowWidth,
  tabDefs,
  currentTabs,
  dropdownTabs,
  windowPreviousWidth
) => {
  let newTabs = [];

  tabDefs.forEach((item, i) => {
    // current tab name
    let label = Object.keys(item)[0];

    // width of responsive dynamic dropdown
    let amt = 106;
    if (i === 0) {
      amt = 0;
    }
    // if window is smaller than the right edge of the tab
    // the 100 is an arbitrary number hack to get the tabs to sqiush a little before populating the dropdown
    // and to have some breathing room between Videos and Faculty Accomplishments
    if (currentWindowWidth - amt < item[label].right - 100 && i !== 0) {
      if (!dropdownTabs.includes(label)) {
        if (currentWindowWidth < windowPreviousWidth) {
          dropdownTabs.unshift(label);
        } else {
          dropdownTabs.push(label);
        }
        _remove(currentTabs, (tabname) => tabname === label);
      }
    } else {
      newTabs.push(label);
      _remove(dropdownTabs, (tabname) => tabname === label);
    }
  });

  return {
    tabNames: newTabs,
    dropdownTabs,
  };
};
