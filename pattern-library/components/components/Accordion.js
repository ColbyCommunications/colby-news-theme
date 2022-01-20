/* eslint-disable react/no-unknown-property */
/* eslint-disable jsx-a11y/no-noninteractive-element-to-interactive-role */
// This is for demonstration purposes only. Real accordions on the
// WordPress site will be generated by a plugin.

import React from 'react';

const Accordion = () => {
  return (
    <div className="prose nc-accordion">
      <div
        className="wp-block-pb-accordion-item c-accordion__item js-accordion-item"
        data-initially-open="false"
        data-click-to-close="true"
        data-auto-close="true"
        data-scroll="false"
        data-scroll-offset="0"
      >
        <h2
          id="at-2860"
          className="c-accordion__title js-accordion-controller"
          role="button"
          aria-controls="ac-2860"
          aria-expanded="false"
        >
          Professional Affiliations
        </h2>
        <div id="ac-2860" className="c-accordion__content" hidden="hidden">
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Exercitationem sint fugiat, ad autem repellendus aliquid cupiditate?
            Iusto itaque, nesciunt adipisci, voluptates veritatis architecto
            maiores sint assumenda autem officia quasi perspiciatis.
          </p>
        </div>
      </div>
      <div
        className="wp-block-pb-accordion-item c-accordion__item js-accordion-item is-open"
        data-initially-open="true"
        data-click-to-close="true"
        data-auto-close="true"
        data-scroll="false"
        data-scroll-offset="0"
      >
        <h2
          id="at-2861"
          className="c-accordion__title js-accordion-controller"
          role="button"
          aria-controls="ac-2861"
          aria-expanded="false"
        >
          Selected Publications
        </h2>
        <div id="ac-2861" className="c-accordion__content">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa
            repellendus velit nesciunt totam est incidunt, optio placeat nemo
            ipsum, quasi, perferendis temporibus ab! Molestiae sint similique
            magni quos, perspiciatis voluptates.
          </p>
          <ul>
            <li>Lorem ipsum dolor sit amet</li>
            <li>Consectetur adipisicing elit</li>
            <li>Sed illum, nemo soluta perferendis dicta corrupti</li>
            <li>
              Culpa incidunt blanditiis sunt sit assumenda totam iure excepturi
            </li>
            <li>Omnis veniam animi cupiditate. Placeat, reprehenderit</li>
          </ul>
        </div>
      </div>
      <div
        className="wp-block-pb-accordion-item c-accordion__item js-accordion-item"
        data-initially-open="false"
        data-click-to-close="true"
        data-auto-close="true"
        data-scroll="false"
        data-scroll-offset="0"
      >
        <h2
          id="at-2862"
          className="c-accordion__title js-accordion-controller"
          role="button"
          aria-controls="ac-2862"
          aria-expanded="false"
        >
          Honors &amp; Awards
        </h2>
        <div id="ac-2862" className="c-accordion__content" hidden="hidden">
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt a illo
            laboriosam ducimus quaerat voluptas odio eaque rem quia at, vel
            doloribus, reiciendis est, repellendus fuga laudantium placeat id
            ea!
          </p>
        </div>
      </div>
      <div
        className="wp-block-pb-accordion-item c-accordion__item js-accordion-item"
        data-initially-open="false"
        data-click-to-close="true"
        data-auto-close="true"
        data-scroll="false"
        data-scroll-offset="0"
      >
        <h2
          id="at-2862"
          className="c-accordion__title js-accordion-controller"
          role="button"
          aria-controls="ac-2862"
          aria-expanded="false"
        >
          Featured Research Guides
        </h2>
        <div id="ac-2862" className="c-accordion__content" hidden="hidden">
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt a illo
            laboriosam ducimus quaerat voluptas odio eaque rem quia at, vel
            doloribus, reiciendis est, repellendus fuga laudantium placeat id
            ea!
          </p>
        </div>
      </div>
      <div
        className="wp-block-pb-accordion-item c-accordion__item js-accordion-item"
        data-initially-open="false"
        data-click-to-close="true"
        data-auto-close="true"
        data-scroll="false"
        data-scroll-offset="0"
      >
        <h2
          id="at-2862"
          className="c-accordion__title js-accordion-controller"
          role="button"
          aria-controls="ac-2862"
          aria-expanded="false"
        >
          Another Section
        </h2>
        <div id="ac-2862" className="c-accordion__content" hidden="hidden">
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt a illo
            laboriosam ducimus quaerat voluptas odio eaque rem quia at, vel
            doloribus, reiciendis est, repellendus fuga laudantium placeat id
            ea!
          </p>
        </div>
      </div>
      <div
        className="wp-block-pb-accordion-item c-accordion__item js-accordion-item"
        data-initially-open="false"
        data-click-to-close="true"
        data-auto-close="true"
        data-scroll="false"
        data-scroll-offset="0"
      >
        <h2
          id="at-2862"
          className="c-accordion__title js-accordion-controller"
          role="button"
          aria-controls="ac-2862"
          aria-expanded="false"
        >
          Yet Another Section
        </h2>
        <div id="ac-2862" className="c-accordion__content" hidden="hidden">
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt a illo
            laboriosam ducimus quaerat voluptas odio eaque rem quia at, vel
            doloribus, reiciendis est, repellendus fuga laudantium placeat id
            ea!
          </p>
        </div>
      </div>
    </div>
  );
};

export default Accordion;