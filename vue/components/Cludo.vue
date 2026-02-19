<template>
  <div class="relative z-0 w-full site-main print:static">
    <div
      style="
        margin-left: auto;
        margin-right: auto;
        max-width: calc(var(--max-content-width) + var(--page-padding));
        padding-right: var(--page-padding);
        padding-left: var(--page-padding);
      "
    >
      <!-- Search box -->
      <CludoSearchInput @search="handleSearch" />

      <div
        class="mb-12 rounded-lg bg-gray-200 p-4 text-sm font-medium text-gray-700"
        role="region"
        aria-label="Query Suggestions"
      >
        Query Suggestions
      </div>

      <!-- Tab navigation -->
      <CludoNavigation :currentTab="currentTab" @nav-click="changeTab" />

      <!-- Tabs -->
      <CludoStoriesTab
        v-if="currentTab === 'Stories'"
        :searchResults="searchResults"
        :currentPage="currentPage"
        :totalPages="totalPages"
        :currentTab="currentTab"
        @change-page="handlePageChange"
        @update:selected-categories="handleSelectedCategories"
      />

      <CludoMediaTab
        v-if="currentTab === 'Media Coverage'"
        :searchResults="searchResults"
        :currentPage="currentPage"
        :totalPages="totalPages"
        @change-page="handlePageChange"
      />

      <CludoFacultyAccomplishmentsTab
        v-if="currentTab === 'Faculty Accomplishments'"
        :searchResults="searchResults"
        :currentPage="currentPage"
        :totalPages="totalPages"
        @change-page="handlePageChange"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import CludoSearchInput from './CludoSearchInput.vue';
import CludoNavigation from './CludoNavigation.vue';
import CludoStoriesTab from './tabs/CludoStoriesTab.vue';
import CludoMediaTab from './tabs/CludoMediaTab.vue';
import CludoFacultyAccomplishmentsTab from './tabs/CludoFacultyAccomplishmentsTab.vue';

const searchResults = ref([]);
const currentTab = ref('Stories');
const currentPage = ref(1);
const totalPages = ref(1);
const currentQuery = ref('*');
const selectedCategories = ref([]);

let controller = null;

// ---------- TAB FILTER MAP ----------
const tabFilters = {
  Stories: { 'Post Type': ['post'] },
  'Media Coverage': {
    'Post Type': ['external_post'],
    'Story Type': ['Media Coverage'],
  },
  'Faculty Accomplishments': {
    'Post Type': ['external_post'],
    'Story Type': ['Faculty Accomplishments'],
  },
  Videos: { 'Post Type': ['video'] },
};

// ---------- BASE64 ----------
function base64EncodeUnicode(str) {
  const bytes = new TextEncoder().encode(str);
  let binary = '';
  bytes.forEach((b) => (binary += String.fromCharCode(b)));
  return btoa(binary);
}

// ---------- SEARCH ----------
const search = async (query = '*', page = 1) => {
  const { customerId, engineId } = window.ColbyCludoConfig.settings;

  if (controller) controller.abort();
  controller = new AbortController();

  const rawValue = `${customerId}:${engineId}:SearchKey`;
  const encodedValue = base64EncodeUnicode(rawValue);
  const authHeader = `SiteKey ${encodedValue}`;

  const url = `https://api-us1.cludo.com/api/v3/${customerId}/${engineId}/autocomplete`;

  const filter = tabFilters[currentTab.value] || {};
  const perPage = 5;

  const requestBody = {
    ResponseType: 'JsonObject',
    Template: 'SearchContent',
    text: query,
    query,
    operator: 'and',
    page,
    perPage,
    filters: filter,
    postFiltersOperator: 'or',
    enableFacetFiltering: true,
    postFilters: {}, // initialize
  };

  // Apply category filters if any
  if (selectedCategories.value.length > 0) {
    requestBody.postFilters.Category = selectedCategories.value;
  }

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        Authorization: authHeader,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(requestBody),
      signal: controller.signal,
    });

    if (!response.ok) throw new Error(`Error: ${response.status}`);

    const data = await response.json();

    searchResults.value = data.Results || [];
    totalPages.value = Math.max(
      1,
      Math.ceil((data.TotalResults || 0) / perPage)
    );
    currentPage.value = page;

    console.log('Cludo search success:', {
      query,
      tab: currentTab.value,
      page,
      totalPages: totalPages.value,
      count: searchResults.value.length,
      filtersApplied: selectedCategories.value,
    });
  } catch (err) {
    if (err.name !== 'AbortError') console.error('Cludo search error:', err);
  }
};

// ---------- INPUT HANDLER ----------
const handleSearch = (query) => {
  currentQuery.value = query;
  search(query, 1); // reset to page 1
};

// ---------- PAGE CHANGE ----------
const handlePageChange = (newPage) => {
  if (newPage >= 1 && newPage <= totalPages.value) {
    search(currentQuery.value, newPage);
  }
};

// ---------- INITIAL LOAD ----------
onMounted(() => {
  search('*', 1);
});

// ---------- TAB CHANGE ----------
watch(currentTab, () => {
  search(currentQuery.value, 1); // reset page to 1 for new tab
});

// ---------- NAV ----------
const changeTab = (tabName) => {
  currentTab.value = tabName;
};

// ---------- FILTER HANDLER ----------
const handleSelectedCategories = (categories) => {
  selectedCategories.value = categories;
  search(currentQuery.value, 1);
};
</script>
