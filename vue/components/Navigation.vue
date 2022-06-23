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
            'z-10',
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
import _remove from 'lodash/remove';
import { fillTabs } from '../helpers/_helpers.js';

export default {
  props: ['currentTab'],
  data() {
    return {
      windowPreviousWidth: 0,
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
    window.addEventListener('resize', this.responsiveTabs);
  },
  destroyed() {
    window.removeEventListener('resize', this.responsiveTabs);
  },
  mounted() {
    this.windowPreviousWidth = window.innerWidth;
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
      // let newTabs = [];

      // if window smaller than width of ul on desktop
      if (window.innerWidth < 1066) {
        let tabs = fillTabs(
          window.innerWidth,
          this.tabs,
          this.tabNames,
          this.dropdownTabs,
          this.windowPreviousWidth
        );

        this.tabNames = tabs.tabNames;
        this.dropdownTabs.tabs.dropdownTabs;
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

      this.windowPreviousWidth = window.innerWidth;
    },
  },
};
</script>
