<template>
  <nav>
    <ul
      class="Tabs flex relative justify-between bg-white m-0 list-none border-b border-black border-solid"
    >
      <li
        v-for="(tabName, index) in tabNames"
        ref="items"
        :key="index"
        :class="[
          currentTab === tabName ? 'border-b-2 border-black' : '',
          'text-lg',
          'py-1',
          'px-10',
        ]"
        style="padding: 0 2rem 0.5rem 2rem"
      >
        <button class="whitespace-nowrap" @click="$emit('nav-click', tabName)">
          {{ tabName }}
        </button>
      </li>
      <li v-if="dropdownTabs.length" class="px-5">
        <button class="whitespace-nowrap" @click="toggleDropdown">
          More
          <span
            class="material-icons-sharp text-base align-middle"
            :style="{
              transform: dropdownOpen ? 'rotate(90deg)' : 'rotate(0deg)',
              transitionProperty: 'transform, top',
              transitionDuration: '0.2s',
              position: 'relative',
              top: dropdownOpen ? '0px' : '0px',
            }"
            >pending</span
          >
        </button>
        <ul
          :class="[
            dropdownOpen ? 'block' : 'hidden',
            'absolute',
            'border',
            'bg-white',
            'dynamic-responsive-dropdown',
            'z-10',
          ]"
          style="padding: 10px; top: 39px; right: 0"
        >
          <li
            v-for="(dropdownTab, indexDropdown) in dropdownTabs"
            :key="indexDropdown"
            :class="{ 'active': currentTab === dropdownTab }"
          >
            <a
              class="cursor-pointer inline-block w-full"
              @keyup.enter="$emit('nav-click', dropdownTab)"
              @click="$emit('nav-click', dropdownTab)"
              >{{ dropdownTab }}</a
            >
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</template>
<script>
import { fillTabs } from '../helpers/_helpers.js';

export default {
  props: {
    currentTab: { type: String, required: true },
  },
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
  unmounted() {
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
    responsiveTabs() {
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
        this.dropdownTabs = tabs.dropdownTabs;
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
