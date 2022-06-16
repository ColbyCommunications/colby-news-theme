<template>
  <nav>
    <ul class="Tabs">
      <li
        v-for="(tabName, index) in this.tabNames"
        :key="index"
        class="text-lg Tabs__tab Tab py-1 px-10"
        :class="{ 'activeTab': currentTab === tabName }"
        ref="items"
      >
        <button @click="$emit('nav-click', tabName)">{{ tabName }}</button>
      </li>
      <li v-if="this.dropdownTabs.length" class="px-5">
        <button @click="toggleDropdown" class="whitespace-nowrap">
          More
          <span
            class="material-icons-sharp text-base align-middle"
            :style="{
              transform: this.dropdownOpen ? 'rotate(90deg)' : 'rotate(0deg)',
              transitionProperty: 'transform',
              transitionDuration: '0.2s',
            }"
            >pending</span
          >
        </button>
        <ul
          :class="[
            this.dropdownOpen ? 'block' : 'hidden',
            'absolute',
            'border',
            'bg-white',
            'dynamic-responsive-dropdown',
          ]"
          style="padding: 10px; top: 39px; right: 0"
        >
          <li
            v-for="(dropdownTab, indexDropdown) in this.dropdownTabs"
            :key="indexDropdown"
            :class="{ 'active': currentTab === dropdownTab }"
          >
            <a
              @click="$emit('nav-click', dropdownTab)"
              class="cursor-pointer inline-block w-full"
              >{{ dropdownTab }}</a
            >
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</template>
<script>
import _debounce from 'lodash/debounce';
import _remove from 'lodash/remove';

export default {
  props: ['currentTab'],
  data() {
    return {
      tabNames: [
        'Stories',
        'Media Coverage',
        'Faculty Accomplishments',
        'Videos',
      ],
      tabs: [],
      dropdownTabs: [],
      dropdownOpen: false,
    };
  },
  created() {
    window.addEventListener('resize', _debounce(this.responsiveTabs, 100));
  },
  destroyed() {
    window.removeEventListener('resize', _debounce(this.responsiveTabs, 100));
  },
  mounted() {
    this.calculateTabs();
    this.responsiveTabs();
  },
  methods: {
    toggleDropdown() {
      this.dropdownOpen = !this.dropdownOpen;
    },
    calculateTabs() {
      this.$refs.items.forEach((item, i) => {
        this.tabs.push({
          [this.tabNames[i]]: item.getBoundingClientRect(),
        });
      });
    },
    responsiveTabs(e) {
      let newTabs = [];

      // if window smaller than width of ul on desktop
      if (window.innerWidth < 1066) {
        this.tabs.forEach((item, i) => {
          // current tab name
          let label = Object.keys(item)[0];

          // width of responsive dynamic dropdown
          let amt = 106;

          if (i === 0) {
            amt = 0;
          }

          // if window is smaller than the right edge of the tab
          if (window.innerWidth - amt < item[label].right) {
            if (!this.dropdownTabs.includes(label)) {
              this.dropdownTabs.push(label);
              _remove(this.tabNames, (tabname) => tabname === label);
            }
          } else {
            newTabs.push(label);
            _remove(this.dropdownTabs, (tabname) => tabname === label);
          }

          this.tabNames = newTabs;
        });
      } else {
        // reset default tab state
        this.tabNames = [
          'Stories',
          'Media Coverage',
          'Faculty Accomplishments',
          'Videos',
        ];
        this.dropdownTabs = [];
      }
    },
  },
};
</script>
