import React from 'react';
import ContentSection from './ContentSection';

const PageSection = (args) => {
  return (
    <ContentSection
      {...args}
      grid={!args.hasSidebar}
      className={`${args.className} ${
        args.fullWidth ? 'container-full container-wrapper' : ''
      }`}
    >
      {args.children}
    </ContentSection>
  );
};

export default PageSection;
