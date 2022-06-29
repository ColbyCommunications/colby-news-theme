import React from 'react';
import InsetAsideComponent from '../components/InsetAside';
import RawHTML from '../utilities/RawHTML';
import generate from '../components/content/ContentGenerator';

export default { title: 'Components/Inset Aside' };

export const InsetAside = (args) => (
  <RawHTML component={InsetAsideComponent(args)} />
);

InsetAside.args = {
  headline: 'Header for Inset Aside',
  imageSrc: generate.placeholderSrc(1600, 1200),
  wysiwyg: /* html */ `
		<p>Limited text styles. Aenean <strong>lacinia</strong> bibendum nulla sed consectetur. Fusce dapibus, tellus ac cursus <a href="#">commodo</a>, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
	`,
  links: [
    { url: '#', title: 'Optional Fancy Link 1' },
    { url: '#', title: 'Optional Fancy Link 2' },
  ],
};

InsetAside.decorators = [
  (story) => <div className="max-w-md m-10">{story()}</div>,
];
