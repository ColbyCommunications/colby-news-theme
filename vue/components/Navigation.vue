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
              transitionProperty: 'transform, top',
              transitionDuration: '0.2s',
              position: 'relative',
              top: this.dropdownOpen ? '0px' : '0px',
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

import { fillTabs } from '../helpers/_helpers';

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
          [this.tabNames[i]]: {
            rect: item.getBoundingClientRect(),
            order: i,
          },
        });
      });

      console.log(this.tabs);
    },
    responsiveTabs(e) {
      let tabs = fillTabs(
        window.innerWidth,
        this.tabNames,
        this.dropdownTabs,
        this.tabs
      );

      this.tabNames = tabs.tabNames;
      this.dropdownTabs = tabs.dropdownTabs;
    },
  },
};
</script>
