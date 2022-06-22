<template>
  <div
    v-if="store.menuOpen"
    id="main-menu"
    aria-hidden="false"
    class="fixed inset-0 z-50 hidden overflow-y-auto bg-white animate-opacity-in aria-hidden:animate-opacity-out !block"
  >
    <div
      role="dialog"
      aria-modal="true"
      aria-label="Main Menu"
      style="position: relative"
    >
      <div
        class="sticky-events--sentinel sticky-events--sentinel-top"
        style="
          left: 0px;
          position: relative;
          right: 0px;
          visibility: hidden;
          top: calc(0px);
        "
      ></div>
      <header
        class="sticky top-0 z-20 transition-colors bg-white site-header stuck:border-b stuck:border-black stuck:border-opacity-10 stuck:shadow"
        style="position: sticky"
      >
        <div class="container">
          <div class="flex justify-between items-center py-5">
            <a href="/" aria-label="Home">
              <svg
                class="h-[1.0625rem] sm:h-[1.625rem]"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 918.78 129.832"
              >
                <path
                  d="M582.7,7.611H559.406l-33.925,56.3-35.392-56.3H465.883l48.228,72.8v49.329H535.2V80.6ZM439.623,97.1c0,8.435-4.585,15.22-17.971,15.22H384.426V76.378H420c13.57,0,19.622,6.418,19.622,16.321Zm-.55-52.63c0,9.719-6.235,16.321-19.622,16.321H384.426V25.4H421.1c13.386,0,17.971,6.785,17.971,15.22ZM461.445,98.2V93.249c0-11.737-6.968-22.739-23.656-25.49,14.487-2.751,21.822-12.47,21.822-26.223V38.6c0-18.521-12.1-30.991-39.426-30.991H363.154v122.13H421.1c27.14,0,40.343-12.653,40.343-31.541M347.313,129.741V111.4h-70.6V7.611H255.624v122.13ZM217.85,82.063c0,18.154-11.736,33.191-34.108,33.191s-34.109-15.037-34.109-33.191V55.106c0-18.154,11.737-33.008,34.109-33.008S217.85,36.952,217.85,55.106Zm21.272-.184V55.289c0-27.69-19.988-51.529-55.38-51.529S128.361,27.6,128.361,55.289v26.59c0,27.507,19.989,51.713,55.381,51.713s55.38-24.206,55.38-51.713M115.27,36.585C108.852,20.081,89.6,3.76,63.19,3.76,26.882,3.76,5.61,28.333,5.61,58.04V80.045c0,29.341,20.171,53.547,56.847,53.547,27.69,0,45.661-16.321,52.813-33.192L97.849,92.515c-5.868,13.2-17.421,22.739-34.292,22.739-23.839,0-36.675-14.67-36.675-34.475V57.307c0-20.355,12.469-35.209,35.942-35.209,17.6,0,28.79,10.819,34.658,22.372Z"
                  transform="translate(-5.61 -3.76)"
                ></path>
                <path
                  d="M657.24,45.715h11.39v83.748H658.319l-55.991-64.5v64.5h-11.27V45.715h9.711l56.471,65.047Z"
                  transform="translate(-5.61 -3.76)"
                ></path>
                <path
                  d="M689.011,45.715h47.478V56.386H701V81.923h34.291V92.655H701v26.017h36.629v10.671H689.011Z"
                  transform="translate(-5.61 -3.76)"
                ></path>
                <path
                  d="M859.533,45.715H871.49l-33.859,84.107H835l-27.382-68.1-27.666,68.1h-2.574L743.62,45.715H755.7l23.079,57.73,23.233-57.73h11.334l23.343,57.73Z"
                  transform="translate(-5.61 -3.76)"
                ></path>
                <path
                  d="M902.09,94.373l-9.113-5.535q-8.573-5.235-12.2-10.3a19.509,19.509,0,0,1-3.627-11.66q0-9.891,6.864-16.066t17.835-6.175a33.747,33.747,0,0,1,19.244,5.89V64.134q-9.054-8.706-19.484-8.707a16.13,16.13,0,0,0-9.652,2.717,8.245,8.245,0,0,0-3.776,6.956,10.716,10.716,0,0,0,2.782,7.047,34.993,34.993,0,0,0,8.947,6.9l9.157,5.418q15.322,9.153,15.322,23.3,0,10.071-6.744,16.365t-17.535,6.3a36.831,36.831,0,0,1-22.6-7.629V107.567q9.711,12.3,22.481,12.3a14.117,14.117,0,0,0,9.381-3.136,9.827,9.827,0,0,0,3.747-7.855Q913.12,101.235,902.09,94.373Z"
                  transform="translate(-5.61 -3.76)"
                ></path>
              </svg>
            </a>
            <div class="space-x-1 js-focus-visible">
              <div class="inline-block cursor-pointer open-menu-wrapper">
                <button
                  class="open-menu bg-white p-2 rounded-lg group transition-colors selected:bg-black selected:bg-opacity-[7%] disabled:pointer-events-none selected"
                  aria-label="Open menu (modal)"
                  disabled=""
                >
                  <svg
                    class="w-6 h-6 group-hover:scale-125 transform transition-transform"
                    aria-hidden="true"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path d="M 0 11 L 0 13 L 24 13 L 24 11 L 0 11 Z"></path>
                    <path d="M 0 18 L 0 20 L 24 20 L 24 18 L 0 18 Z"></path>
                    <path d="M 0 4 L 0 6 L 24 6 L 24 4 L 0 4 Z"></path>
                  </svg>
                </button>
              </div>
              <div class="inline-block cursor-pointer open-search-wrapper">
                <button
                  class="open-search bg-white p-2 rounded-lg group transition-colors selected:bg-black selected:bg-opacity-[7%]"
                  aria-label="Open search (modal)"
                  @click="openSearch"
                >
                  <svg
                    class="w-6 h-6 group-hover:scale-125 transform transition-transform"
                    aria-hidden="true"
                    viewBox="0 0 50 50"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z"
                    ></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </header>
      <div class="focus-target-ancestor js-focus-visible">
        <div
          class="fixed z-10 w-full mt-px pointer-events-none md:mt-10"
          style="top: var(--header-height)"
        >
          <div class="container text-right">
            <button
              class="p-2 transition-colors bg-white rounded-lg pointer-events-auto close-modal bg-opacity-90 hover:bg-opacity-100 group disabled:pointer-events-none"
              id="close-menu"
              aria-label="Close modal"
              @click="closeMenu"
            >
              <svg
                class="w-6 h-6 transition-transform transform group-hover:scale-125"
                aria-hidden="true"
                viewBox="0 0 50 50"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M 7.71875 6.28125 L 6.28125 7.71875 L 23.5625 25 L 6.28125 42.28125 L 7.71875 43.71875 L 25 26.4375 L 42.28125 43.71875 L 43.71875 42.28125 L 26.4375 25 L 43.71875 7.71875 L 42.28125 6.28125 L 25 23.5625 Z"
                ></path>
              </svg>
            </button>
          </div>
        </div>
        <div
          class="flex flex-col justify-between"
          style="min-height: calc(100vh - var(--header-height))"
        >
          <div class="pt-2 md:pt-12">
            <div class="container">
              <div class="grid gap-10 md:grid-cols-2">
                <ol class="space-y-1 text-base sm:text-xl">
                  <li>
                    <a
                      href="https://news-2-0-l5zba3i-4nvswumupeimi.us-4.platformsh.site/story/category/access-and-opportunity/"
                      >Access and Opportunity</a
                    >
                  </li>
                  <li>
                    <a
                      href="https://news-2-0-l5zba3i-4nvswumupeimi.us-4.platformsh.site/story/category/alumni/"
                      >Alumni</a
                    >
                  </li>
                  <li>
                    <a
                      href="https://news-2-0-l5zba3i-4nvswumupeimi.us-4.platformsh.site/story/category/announcements/"
                      >Announcements</a
                    >
                  </li>
                  <li>
                    <a
                      href="https://news-2-0-l5zba3i-4nvswumupeimi.us-4.platformsh.site/story/category/artificial-intelligence/"
                      >Artificial Intelligence</a
                    >
                  </li>
                  <li>
                    <a
                      href="https://news-2-0-l5zba3i-4nvswumupeimi.us-4.platformsh.site/story/category/arts/"
                      >Arts</a
                    >
                  </li>
                  <li>
                    <a
                      href="https://news-2-0-l5zba3i-4nvswumupeimi.us-4.platformsh.site/story/category/campus-and-community/"
                      >Campus and Community</a
                    >
                  </li>
                  <li>
                    <a
                      href="https://news-2-0-l5zba3i-4nvswumupeimi.us-4.platformsh.site/story/category/environment-and-climate/"
                      >Environment and Climate</a
                    >
                  </li>
                  <li>
                    <a
                      href="https://news-2-0-l5zba3i-4nvswumupeimi.us-4.platformsh.site/story/category/humanities/"
                      >Humanities</a
                    >
                  </li>
                  <li>
                    <a
                      href="https://news-2-0-l5zba3i-4nvswumupeimi.us-4.platformsh.site/story/category/interdisciplinary-studies/"
                      >Interdisciplinary Studies</a
                    >
                  </li>
                  <li>
                    <a
                      href="https://news-2-0-l5zba3i-4nvswumupeimi.us-4.platformsh.site/story/category/natural-sciences/"
                      >Natural Sciences</a
                    >
                  </li>
                  <li>
                    <a
                      href="https://news-2-0-l5zba3i-4nvswumupeimi.us-4.platformsh.site/story/category/social-sciences/"
                      >Social Sciences</a
                    >
                  </li>
                </ol>
                <div
                  class="contents md:flex md:flex-col md:space-y-10 md:justify-between"
                >
                  <ol class="space-y-1 text-sm-plus-1 sm:text-lg">
                    <li>
                      <a href="https://colbyathletics.com/">Athletics News</a>
                    </li>
                    <li><a href="/colby-magazine/">Colby Magazine</a></li>
                    <li><a href="/contact/">Contact</a></li>
                    <li><a href="https://events.colby.edu/">Events</a></li>
                    <li>
                      <a href="/external/faculty-accomplishments/"
                        >Faculty Accomplishments</a
                      >
                    </li>
                    <li>
                      <a href="/resources-for-the-media/"
                        >Resources for the Media</a
                      >
                    </li>
                  </ol>
                  <div class="site-header-widgets">
                    <div>
                      <p>
                        Sign up for weekly emails to get the latest from Colby
                        Magazine
                      </p>
                    </div>
                    <div>
                      <div class="wp-container-1 wp-block-buttons">
                        <div class="wp-block-button">
                          <a class="wp-block-button__link" href="/newsletter"
                            >Subscribe</a
                          >
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div>
            <footer
              class="container my-10 overflow-hidden sm:mt-20 lg:mt-24 lg:mb-16 xl:mt-28"
            >
              <div class="flex flex-wrap items-center justify-between -m-1">
                <a
                  class="pr-4 m-1"
                  href="https://www.colby.edu"
                  aria-label="Colby College Home"
                >
                  <svg
                    aria-hidden="true"
                    class="h-8 text-black transition-opacity fill-current sm:h-12 hover:opacity-50"
                    viewBox="0 0 157.25 79.713"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M62.077,28.636c-9.407,0-16.439,7.157-16.439,16.812,0,.05.006.1.007.148l0,0a5.771,5.771,0,0,1-.508,2.534c-3.651,7.391-9.292,11.092-16.86,11.092-10.929,0-18.467-10.108-18.467-25.487,0-13.141,6.266-23.072,17.958-23.072,8.394,0,13.394,4.2,15.764,13.861h1.441V9.23H43.617a2.652,2.652,0,0,1-2.629,1.608c-2.885,0-7.46-2.143-13.557-2.143C12.938,8.7,2.352,20.675,2.352,36.954c0,17.077,12.2,25.486,23.887,25.486,9.054,0,16.576-4.815,19.953-12.551A15.988,15.988,0,0,0,62.077,62.17c9.4,0,16.434-7.154,16.434-16.722C78.511,35.793,71.48,28.636,62.077,28.636Zm0,31.745c-6.947,0-10.17-6.8-10.17-14.933,0-9.123,3.817-15.022,10.17-15.022,6.949,0,10.169,7.062,10.169,15.022C72.246,53.133,69.195,60.381,62.077,60.381ZM89.3,55.193V5.029H87.856L77.52,6.106V7.621h1.952c3.13,0,4.065,1.249,4.065,4.293V53.67c0,4.652-.935,5.99-3.982,5.99H78.03v1.526H94.717V59.66h-.76C90.313,59.66,89.3,58.592,89.3,55.193Zm25.788-26.557A13.773,13.773,0,0,0,105,33.374V5.029h-1.44L93.906,6.106V7.621c4.828,0,5.332.63,5.332,5.453V60.557a53.262,53.262,0,0,0,9.323.988c15.417,0,20.417-9.93,20.417-17.439C128.978,35.429,122.883,28.636,115.086,28.636Zm-5,31.3c-4.152,0-5.084-1.967-5.084-6.172V35.7c2.375-3.131,4.659-4.473,7.713-4.473,4.578,0,10,4.568,10,13.589C122.715,55.637,116.694,59.934,110.086,59.934Zm38.922-30.318V31.14c3.3.175,3.563,2.234,2.378,5.991L146.128,53.85l-7.2-17.881c-1.1-2.687-.169-4.473,2.115-4.829V29.616h-14.4V31.14c3.471.085,4.579,1.07,6.1,4.739l10.767,26.2L139.6,73.52c-2.679,7.179-7.558,4.966-8.744,4.429l-.276,6.43a3.958,3.958,0,0,0,2.056.363c3.64,0,5.78-1.56,8.155-8.89l11.941-37.29c1.7-5.28,3.648-7.422,6.869-7.422V29.616Z"
                      transform="translate(-2.352 -5.029)"
                    ></path>
                  </svg>
                </a>
                <div class="m-1">
                  <div class="p-1 -m-1 overflow-hidden">
                    <div>
                      <ul
                        class="wp-container-2 wp-block-social-links is-style-logos-only"
                      >
                        <li
                          class="wp-social-link wp-social-link-facebook wp-block-social-link"
                        >
                          <a
                            href="https://facebook.com/colbycollege"
                            aria-label="Facebook: https://facebook.com/colbycollege"
                            class="wp-block-social-link-anchor"
                          >
                            <svg
                              width="24"
                              height="24"
                              viewBox="0 0 24 24"
                              version="1.1"
                              xmlns="http://www.w3.org/2000/svg"
                              role="img"
                              aria-hidden="true"
                              focusable="false"
                            >
                              <path
                                d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"
                              ></path></svg
                          ></a>
                        </li>

                        <li
                          class="wp-social-link wp-social-link-instagram wp-block-social-link"
                        >
                          <a
                            href="https://instagram.com/colbycollege/"
                            aria-label="Instagram: https://instagram.com/colbycollege/"
                            class="wp-block-social-link-anchor"
                          >
                            <svg
                              width="24"
                              height="24"
                              viewBox="0 0 24 24"
                              version="1.1"
                              xmlns="http://www.w3.org/2000/svg"
                              role="img"
                              aria-hidden="true"
                              focusable="false"
                            >
                              <path
                                d="M12,4.622c2.403,0,2.688,0.009,3.637,0.052c0.877,0.04,1.354,0.187,1.671,0.31c0.42,0.163,0.72,0.358,1.035,0.673 c0.315,0.315,0.51,0.615,0.673,1.035c0.123,0.317,0.27,0.794,0.31,1.671c0.043,0.949,0.052,1.234,0.052,3.637 s-0.009,2.688-0.052,3.637c-0.04,0.877-0.187,1.354-0.31,1.671c-0.163,0.42-0.358,0.72-0.673,1.035 c-0.315,0.315-0.615,0.51-1.035,0.673c-0.317,0.123-0.794,0.27-1.671,0.31c-0.949,0.043-1.233,0.052-3.637,0.052 s-2.688-0.009-3.637-0.052c-0.877-0.04-1.354-0.187-1.671-0.31c-0.42-0.163-0.72-0.358-1.035-0.673 c-0.315-0.315-0.51-0.615-0.673-1.035c-0.123-0.317-0.27-0.794-0.31-1.671C4.631,14.688,4.622,14.403,4.622,12 s0.009-2.688,0.052-3.637c0.04-0.877,0.187-1.354,0.31-1.671c0.163-0.42,0.358-0.72,0.673-1.035 c0.315-0.315,0.615-0.51,1.035-0.673c0.317-0.123,0.794-0.27,1.671-0.31C9.312,4.631,9.597,4.622,12,4.622 M12,3 C9.556,3,9.249,3.01,8.289,3.054C7.331,3.098,6.677,3.25,6.105,3.472C5.513,3.702,5.011,4.01,4.511,4.511 c-0.5,0.5-0.808,1.002-1.038,1.594C3.25,6.677,3.098,7.331,3.054,8.289C3.01,9.249,3,9.556,3,12c0,2.444,0.01,2.751,0.054,3.711 c0.044,0.958,0.196,1.612,0.418,2.185c0.23,0.592,0.538,1.094,1.038,1.594c0.5,0.5,1.002,0.808,1.594,1.038 c0.572,0.222,1.227,0.375,2.185,0.418C9.249,20.99,9.556,21,12,21s2.751-0.01,3.711-0.054c0.958-0.044,1.612-0.196,2.185-0.418 c0.592-0.23,1.094-0.538,1.594-1.038c0.5-0.5,0.808-1.002,1.038-1.594c0.222-0.572,0.375-1.227,0.418-2.185 C20.99,14.751,21,14.444,21,12s-0.01-2.751-0.054-3.711c-0.044-0.958-0.196-1.612-0.418-2.185c-0.23-0.592-0.538-1.094-1.038-1.594 c-0.5-0.5-1.002-0.808-1.594-1.038c-0.572-0.222-1.227-0.375-2.185-0.418C14.751,3.01,14.444,3,12,3L12,3z M12,7.378 c-2.552,0-4.622,2.069-4.622,4.622S9.448,16.622,12,16.622s4.622-2.069,4.622-4.622S14.552,7.378,12,7.378z M12,15 c-1.657,0-3-1.343-3-3s1.343-3,3-3s3,1.343,3,3S13.657,15,12,15z M16.804,6.116c-0.596,0-1.08,0.484-1.08,1.08 s0.484,1.08,1.08,1.08c0.596,0,1.08-0.484,1.08-1.08S17.401,6.116,16.804,6.116z"
                              ></path></svg
                          ></a>
                        </li>

                        <li
                          class="wp-social-link wp-social-link-twitter wp-block-social-link"
                        >
                          <a
                            href="https://twitter.com/colbycollege"
                            aria-label="Twitter: https://twitter.com/colbycollege"
                            class="wp-block-social-link-anchor"
                          >
                            <svg
                              width="24"
                              height="24"
                              viewBox="0 0 24 24"
                              version="1.1"
                              xmlns="http://www.w3.org/2000/svg"
                              role="img"
                              aria-hidden="true"
                              focusable="false"
                            >
                              <path
                                d="M22.23,5.924c-0.736,0.326-1.527,0.547-2.357,0.646c0.847-0.508,1.498-1.312,1.804-2.27 c-0.793,0.47-1.671,0.812-2.606,0.996C18.324,4.498,17.257,4,16.077,4c-2.266,0-4.103,1.837-4.103,4.103 c0,0.322,0.036,0.635,0.106,0.935C8.67,8.867,5.647,7.234,3.623,4.751C3.27,5.357,3.067,6.062,3.067,6.814 c0,1.424,0.724,2.679,1.825,3.415c-0.673-0.021-1.305-0.206-1.859-0.513c0,0.017,0,0.034,0,0.052c0,1.988,1.414,3.647,3.292,4.023 c-0.344,0.094-0.707,0.144-1.081,0.144c-0.264,0-0.521-0.026-0.772-0.074c0.522,1.63,2.038,2.816,3.833,2.85 c-1.404,1.1-3.174,1.756-5.096,1.756c-0.331,0-0.658-0.019-0.979-0.057c1.816,1.164,3.973,1.843,6.29,1.843 c7.547,0,11.675-6.252,11.675-11.675c0-0.178-0.004-0.355-0.012-0.531C20.985,7.47,21.68,6.747,22.23,5.924z"
                              ></path></svg
                          ></a>
                        </li>

                        <li
                          class="wp-social-link wp-social-link-linkedin wp-block-social-link"
                        >
                          <a
                            href="https://linkedin.com/school/colby-college/"
                            aria-label="LinkedIn: https://linkedin.com/school/colby-college/"
                            class="wp-block-social-link-anchor"
                          >
                            <svg
                              width="24"
                              height="24"
                              viewBox="0 0 24 24"
                              version="1.1"
                              xmlns="http://www.w3.org/2000/svg"
                              role="img"
                              aria-hidden="true"
                              focusable="false"
                            >
                              <path
                                d="M19.7,3H4.3C3.582,3,3,3.582,3,4.3v15.4C3,20.418,3.582,21,4.3,21h15.4c0.718,0,1.3-0.582,1.3-1.3V4.3 C21,3.582,20.418,3,19.7,3z M8.339,18.338H5.667v-8.59h2.672V18.338z M7.004,8.574c-0.857,0-1.549-0.694-1.549-1.548 c0-0.855,0.691-1.548,1.549-1.548c0.854,0,1.547,0.694,1.547,1.548C8.551,7.881,7.858,8.574,7.004,8.574z M18.339,18.338h-2.669 v-4.177c0-0.996-0.017-2.278-1.387-2.278c-1.389,0-1.601,1.086-1.601,2.206v4.249h-2.667v-8.59h2.559v1.174h0.037 c0.356-0.675,1.227-1.387,2.526-1.387c2.703,0,3.203,1.779,3.203,4.092V18.338z"
                              ></path></svg
                          ></a>
                        </li>

                        <li
                          class="wp-social-link wp-social-link-youtube wp-block-social-link"
                        >
                          <a
                            href="https://youtube.com/colbycollege"
                            aria-label="YouTube: https://youtube.com/colbycollege"
                            class="wp-block-social-link-anchor"
                          >
                            <svg
                              width="24"
                              height="24"
                              viewBox="0 0 24 24"
                              version="1.1"
                              xmlns="http://www.w3.org/2000/svg"
                              role="img"
                              aria-hidden="true"
                              focusable="false"
                            >
                              <path
                                d="M21.8,8.001c0,0-0.195-1.378-0.795-1.985c-0.76-0.797-1.613-0.801-2.004-0.847c-2.799-0.202-6.997-0.202-6.997-0.202 h-0.009c0,0-4.198,0-6.997,0.202C4.608,5.216,3.756,5.22,2.995,6.016C2.395,6.623,2.2,8.001,2.2,8.001S2,9.62,2,11.238v1.517 c0,1.618,0.2,3.237,0.2,3.237s0.195,1.378,0.795,1.985c0.761,0.797,1.76,0.771,2.205,0.855c1.6,0.153,6.8,0.201,6.8,0.201 s4.203-0.006,7.001-0.209c0.391-0.047,1.243-0.051,2.004-0.847c0.6-0.607,0.795-1.985,0.795-1.985s0.2-1.618,0.2-3.237v-1.517 C22,9.62,21.8,8.001,21.8,8.001z M9.935,14.594l-0.001-5.62l5.404,2.82L9.935,14.594z"
                              ></path></svg
                          ></a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </footer>
          </div>
        </div>
      </div>
      <div
        class="sticky-events--sentinel sticky-events--sentinel-bottom"
        style="
          left: 0px;
          position: absolute;
          right: 0px;
          visibility: hidden;
          bottom: 0px;
          height: 0px;
        "
      ></div>
    </div>
  </div>
</template>
<script>
import { useMainStore } from '../stores/main';
import Algolia from './Algolia.vue';

export default {
  setup() {
    const store = useMainStore();
    return {
      store,
    };
  },
  methods: {
    closeMenu() {
      this.store.closeMenu();
    },
    openSearch() {
      this.store.closeMenu();
      this.store.openSearch();
    },
  },
  components: {
    Algolia,
  },
};
</script>
