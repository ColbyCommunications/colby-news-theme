<template>
  <div>
    <CludoStoriesFilterSection
      :currentTab="currentTab"
      @update:selected-categories="$emit('update:selected-categories', $event)"
    />

    <!-- Results list -->
    <ul v-if="searchResults.length > 0">
      <li v-for="(story, index) in stories" :key="story.id">
        <div
          class="flex flex-col md:flex-row pb-8 mb-12 border-b border-gray-700"
          role="region"
          aria-label="Search Result"
        >
          <!-- IMAGE COLUMN -->
          <div
            class="w-full md:w-1/4 !m-0 !p-0 transition ease-in-out duration-300"
            :class="{ 'brightness-90': hover === story.id }"
          >
            <a :href="story.url">
              <div
                class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500 text-sm"
                @mouseover="hover = story.id"
                @focus="hover = story.id"
                @mouseleave="hover = null"
                @blur="hover = null"
              >
                <img
                  v-if="story.image"
                  :src="story.image"
                  :alt="story.imageAlt || 'Story image'"
                  class="w-full h-full object-cover"
                />
                <span v-else class="material-icons-sharp text-4xl">
                  image
                </span>
              </div>
            </a>
          </div>

          <!-- TEXT COLUMN -->
          <div class="w-full md:w-3/4 md:ml-4">
            <a
              v-if="story.primaryCategory"
              class="font-sans text-xs mb-1.5 uppercase hover:text-link-hover no-underline"
              :href="`/story/category/${story.primaryCategory.replace(
                /\s+/g,
                '-'
              )}`"
            >
              {{ story.primaryCategory }}
            </a>

            <a
              :href="story.url"
              class="no-underline"
              :class="{ 'text-link-hover': hover === story.id }"
              @mouseover="hover = story.id"
              @focus="hover = story.id"
              @mouseleave="hover = null"
              @blur="hover = null"
            >
              <h2 class="font-bold text-base mb-1.5">
                {{ story.title }}
              </h2>
              <p class="font-sans text-base">
                {{ story.summary }}
              </p>
            </a>
          </div>
        </div>
      </li>
    </ul>

    <!-- No results -->
    <div v-else class="text-center text-gray-500 py-4">No stories found.</div>

    <!-- Pagination -->
    <div
      v-if="totalPages > 1"
      role="region"
      aria-label="Pagination"
      class="mt-6"
    >
      <ul class="flex flex-row items-center justify-end">
        <li class="w-32">
          <p :style="paginationText">
            Page {{ currentPage }} of {{ totalPages }}
          </p>
        </li>

        <li class="flex justify-center items-center">
          <a
            href="#"
            :class="[currentPage === 1 ? 'pointer-events-none' : '', 'mr-2']"
            :style="{ color: currentPage === 1 ? '#8b8b8b' : 'black' }"
            @click.prevent="goToPage(currentPage - 1)"
          >
            <span
              :class="[
                'material-icons-sharp',
                currentPage === 1
                  ? 'text-black text-xl leading-none border border-black rounded'
                  : 'text-white text-xl leading-none border border-black rounded bg-black hover:text-black hover:bg-white',
              ]"
            >
              chevron_left
            </span>
          </a>

          <a
            href="#"
            :class="[currentPage === totalPages ? 'pointer-events-none' : '']"
            :style="{ color: currentPage === totalPages ? '#8b8b8b' : 'black' }"
            @click.prevent="goToPage(currentPage + 1)"
          >
            <span
              :class="[
                'material-icons-sharp',
                currentPage === totalPages
                  ? 'text-black text-xl leading-none border border-black rounded'
                  : 'text-white text-xl leading-none border border-black rounded bg-black hover:text-black hover:bg-white',
              ]"
            >
              chevron_right
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import CludoStoriesFilterSection from '../CludoStoriesFilterSection.vue';

const props = defineProps({
  searchResults: { type: Array, required: true },
  currentPage: { type: Number, required: true },
  totalPages: { type: Number, required: true },
  currentTab: { type: String, required: true },
});

// computed stories mapping
const stories = computed(() =>
  props.searchResults.map((doc) => ({
    id: doc.Fields.Id?.Value,
    title: doc.Fields.Title?.Value,
    summary: doc.Fields['Summary']?.Value,
    url: doc.Fields.Url?.Value,
    primaryCategory: doc.Fields['Category']?.Value,
    image: doc.Fields['Image Data']?.Values[0],
    imageAlt: doc.Fields['Image Data']?.Values[1],
  }))
);

// now include the emitted events
const emit = defineEmits(['change-page', 'update:selected-categories']);

const hover = ref(null);
const paginationText = { fontSize: '0.9rem' };

const scrollToTop = () => {
  const element = document.getElementById('site-search-searchbox');
  if (element) element.scrollIntoView({ behavior: 'smooth', block: 'end' });
};

const goToPage = (page) => {
  if (page < 1 || page > props.totalPages) return;
  emit('change-page', page);
  setTimeout(scrollToTop, 50);
};
</script>
