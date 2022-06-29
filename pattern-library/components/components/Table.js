import React from 'react';
import { TextUtilities } from './content/FormattedText';

const tableValues = ({ count = 5 } = {}) =>
  Array.from({ length: count }, () => TextUtilities.headline());

const TableCell = (args) => {
  const { headerCell, children } = args;

  if (headerCell) {
    return <th>{children}</th>;
  }

  return <td>{children}</td>;
};

const TableRow = ({
  header = false,
  count = 5,
  values = false,
  cellKeyPrefix = 'cellKey',
} = {}) => {
  const cellValues = values || tableValues({ header, count });
  return (
    <tr>
      {cellValues.map((value) => {
        return (
          <TableCell headerCell={header} key={`${cellKeyPrefix}-${value}`}>
            {value}
          </TableCell>
        );
      })}
    </tr>
  );
};

const TableHeader = (args) => {
  if (args.hasHeader) {
    return (
      <thead>
        <TableRow header {...args} />
      </thead>
    );
  }

  return '';
};

const TableFooter = (args) => {
  if (args.hasFooter) {
    return (
      <tfoot>
        <TableRow {...args} />
      </tfoot>
    );
  }

  return '';
};

const TableRows = (args) => {
  const { rowCount, colCount } = args;
  return Array.from({ length: rowCount }, (v, i) => (
    <TableRow count={colCount} key={i} />
  ));
};

const Table = ({
  rowCount = 5,
  colCount = 5,
  hasHeader = true,
  hasFooter = true,
  style = 'regular',
} = {}) => {
  const headerValues =
    !(hasHeader || hasFooter) || tableValues({ count: colCount });

  return (
    <figure className={`wp-block-table is-style-${style}`}>
      <table>
        <TableHeader
          values={headerValues}
          hasHeader={hasHeader}
          colCount={colCount}
        />

        <tbody>
          <TableRows rowCount={rowCount} colCount={colCount} />
        </tbody>

        <TableFooter
          values={headerValues}
          hasFooter={hasFooter}
          colCount={colCount}
        />
      </table>
    </figure>
  );
};

export default Table;
