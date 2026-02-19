<template>
  <div>
    <!-- Results list -->
    <ul v-if="searchResults.length > 0">
      <li v-for="(story, index) in stories" :key="story.id">
        <a
          class="group block text-base-minus-2 space-y-1.5 hover:text-link-hover no-underline cursor-pointer"
          :href="story.externalUrl"
        >
          <div
            :class="[
              'post-list-item',
              'border-b',
              'border-gray-700',
              index !== 0 ? 'py-8' : 'pt-0 pb-8',
            ]"
          >
            <div class="space-y-2">
              <div
                class="grid gap-x-4 gap-y-2 media-coverage-item-grid--standard"
              >
                <div class="lg:self-center lg:mx-auto logo-wrapper">
                  <div class="lg:w-24">
                    <div>
                      <img :src="story.image" />
                    </div>
                  </div>
                </div>
                <div class="superhead-wrapper">
                  <div class="text-xs uppercase">
                    {{ story.mediaSource }}
                  </div>
                </div>
                <div class="space-y-1 title-wrapper lg:space-y-2">
                  <h3 class="leading-tight font-bold text-base mb-1.5">
                    {{ story.title }}
                  </h3>
                </div>
                <div class="blurb-wrapper">
                  <div class="text-base-minus-2 lg:text-base">
                    {{ story.excerpt }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
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
        <!-- Page Text -->
        <li class="w-32">
          <p :style="paginationText">
            Page {{ currentPage }} of {{ totalPages }}
          </p>
        </li>

        <!-- Arrows -->
        <li class="flex justify-center items-center">
          <!-- Previous -->
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

          <!-- Next -->
          <a
            href="#"
            :class="[currentPage === totalPages ? 'pointer-events-none' : '']"
            :style="{
              color: currentPage === totalPages ? '#8b8b8b' : 'black',
            }"
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

const props = defineProps({
  searchResults: { type: Array, required: true },
  currentPage: { type: Number, required: true },
  totalPages: { type: Number, required: true },
});

const stories = computed(() =>
  props.searchResults.map((doc) => ({
    id: doc.Fields.Id?.Value,
    title: doc.Fields.Title?.Value,
    excerpt: doc.Fields.Excerpt?.Value,
    externalUrl: doc.Fields['External Url']?.Value,
    primaryCategory: doc.Fields['Primary Category']?.Value,
    mediaSource: doc.Fields['Media Source']?.Value,
    image: doc.Fields['External Image']?.Value,
  }))
);

const emit = defineEmits(['change-page']);

const hover = ref(null);

const paginationText = {
  fontSize: '0.9rem',
};

// Scroll back to search box
const scrollToTop = () => {
  const element = document.getElementById('site-search-searchbox');
  if (element) {
    element.scrollIntoView({ behavior: 'smooth', block: 'end' });
  }
};

// Handle page click
const goToPage = (page) => {
  if (page < 1 || page > props.totalPages) return;

  emit('change-page', page);

  // wait a tick so results update first
  setTimeout(() => {
    scrollToTop();
  }, 50);
};
</script>
