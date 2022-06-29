import React from 'react';
import faker from 'faker';
import RawHTML from '../utilities/RawHTML';
import AmbientVideoComponent from '../components/AmbientVideo';

export default { title: 'Components/Media/Ambient Video' };

export const AmbientVideo = (args) => {
  const ambientVideo = <AmbientVideoComponent {...args} />;
  return <RawHTML component={ambientVideo} />;
};

AmbientVideo.args = {
  video: 'https://vimeo.com/555898194',
  fallbackImage: faker.image.image(2400, 1350),
};
