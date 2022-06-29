import React from 'react';
import Table from '../components/Table';
import '../components/content/wp-theme-css.css';

export default {
  title: 'Components/Tables/Table',
  component: Table,
  parameters: {
    docs: {
      source: {
        type: 'dynamic',
      },
    },
  },
};

export const TableDemo = (args) => <Table {...args} />;

TableDemo.args = {
  rowCount: 5,
  colCount: 5,
  hasHeader: true,
  hasFooter: true,
  style: 'regular',
};

TableDemo.argTypes = {
  style: {
    name: 'Table Style',
    options: ['regular', 'stripes'],
    control: {
      type: 'inline-radio',
    },
  },
};

// TableDemo.decorators = [
//   (Story) => (
//     <>
//       <RawHTML componentFunction={WPCSS} />
//       <div className="container mx-auto px-container">
//         <Story />
//       </div>
//     </>
//   ),
// ];
