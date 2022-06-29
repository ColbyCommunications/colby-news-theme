// srcsetArray should be in the following format:
//    [
//        [url, size],
//        [url, size],
//        [url, size],
//    ]
const buildSrcset = (srcsetList) => {
  if (typeof srcsetList === 'string') {
    return `srcset="${srcsetList}"`;
  }
  if (Array.isArray(srcsetList)) {
    const srcsetStringList = srcsetList.map((set) => set.join(' '));
    return `srcset="${srcsetStringList.join(',\n')}"`;
  }
  return false;
};

// sizesArray should be in the following format:
//    [
//        [media condition, size],
//        [media condition, size],
//        [media condition, size],
//    ]
const buildSizes = (sizeList) => {
  if (typeof sizeList === 'string') {
    return `srcset="${sizeList}"`;
  }
  if (Array.isArray(sizeList)) {
    const sizeStringList = sizeList.map((set) => set.join(' '));
    return `size="${sizeStringList.join(',\n')}"`;
  }
  return false;
};

const Image = (args) => {
  if (!args.src) {
    return '';
  }

  const srcset = buildSrcset(args.srcset);
  const sizes = buildSizes(args.sizes);

  return `<img 
    ${args.id ? `id="${args.id}"` : ''}
    class="
      ${args.classes ? args.classes.join(' ') : ''}
      ${args.fit ?? ''}
      ${args.pin ?? 'object-top'}"
    src="${args.src}"
    alt="${args.alt}"

    ${args.height ? `height="${args.height}"` : ''}
    ${args.width ? `width="${args.width}"` : ''}
    ${srcset || ''}
    ${sizes || ''}
    />`;
};

export default Image;
