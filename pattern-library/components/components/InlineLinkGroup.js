import React from 'react';
import LinkGroup from './LinkGroup';

const InlineLinkGroup = (args) => {
  return (
    <LinkGroup
      listDisplay={`flex gap-8`}
      listClasses={`list-none fancy-link-list text-xl font-display font-light mb-8`}
      links={args.links}
    ></LinkGroup>
  );
};

export default InlineLinkGroup;
