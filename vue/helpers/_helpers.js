/* eslint-disable import/prefer-default-export */
import _remove from 'lodash/remove';

export const fillTabs = (width, currentTabs, currentDropDowntabs, tabDefs) => {
  let tabNames = currentTabs;
  let dropdownTabs = currentDropDowntabs;

  // if window smaller than width of ul on desktop
  if (width < 1066) {
    tabDefs.forEach((item, i) => {
      // current tab name
      let label = Object.keys(item)[0];

      // width of responsive dynamic dropdown
      let amt = 106;

      if (i === 0) {
        amt = 0;
      }

      // if window is smaller than the right edge of the tab
      if (width - amt < item[label].rect.right) {
        if (!dropdownTabs.includes(label) && tabNames.length !== 1) {
          dropdownTabs.splice(item.order, 0, label);
          _remove(tabNames, (tabname) => tabname === label);
        }
      } else {
        if (!tabNames.includes(label)) {
          tabNames.push(label);
        }
        _remove(dropdownTabs, (tabname) => tabname === label);
      }
    });
  } else {
    // reset default tab state
    tabNames = [
      'Stories',
      'Media Coverage',
      'Faculty Accomplishments',
      'Videos',
    ];
    dropdownTabs = [];
  }

  return {
    tabNames,
    dropdownTabs,
  };
};
