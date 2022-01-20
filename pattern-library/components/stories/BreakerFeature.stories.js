import React from 'react';
import RawHTML from '../utilities/RawHTML';
import faker from 'faker';
import Image from '../components/Image';
import BreakerFeatureTemplate from '../twig/breaker-feature.twig';

export default {
  title: 'Components/Breaker Feature',
};

export const BreakerFeature = (args) => (
  <RawHTML componentFunction={BreakerFeatureTemplate} {...args} />
);

BreakerFeature.args = {
  image: Image({ src: faker.image.image(1366, 501) }),
  superhead: { url: '#', title: 'Artificial Intelligence' },
  headline: 'Predicting Atmospheric Change More Efficiently',
  description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
  link: { href: '#', title: 'Learn more about Artificial Intelligence at Colby' },
};

BreakerFeature.decorators = [Story => <div className="container"><Story /></div>];