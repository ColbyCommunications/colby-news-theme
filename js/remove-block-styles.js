wp.domReady(() => {
  // image
  wp.blocks.unregisterBlockStyle('core/image', 'rounded');
  wp.blocks.unregisterBlockStyle('core/image', 'default');
  // quote
  wp.blocks.unregisterBlockStyle('core/quote', 'default');
  wp.blocks.unregisterBlockStyle('core/quote', 'large');
  // button
  // wp.blocks.unregisterBlockStyle('core/button', 'fill');
  // wp.blocks.unregisterBlockStyle('core/button', 'outline');
  // pullquote
  wp.blocks.unregisterBlockStyle('core/pullquote', 'default');
  wp.blocks.unregisterBlockStyle('core/pullquote', 'solid-color');
  // separator
  wp.blocks.unregisterBlockStyle('core/separator', 'default');
  wp.blocks.unregisterBlockStyle('core/separator', 'wide');
  wp.blocks.unregisterBlockStyle('core/separator', 'dots');
  // table
  wp.blocks.unregisterBlockStyle('core/table', 'regular');
  wp.blocks.unregisterBlockStyle('core/table', 'stripes');
  // social-links
  // wp.blocks.unregisterBlockStyle('core/social-links', 'default');
  wp.blocks.unregisterBlockStyle('core/social-links', 'pill-shape');
  wp.blocks.unregisterBlockStyle('core/social-links', 'logos-only');
  wp.blocks.registerBlockStyle('core/social-links', {
    name: 'logos-only',
    label: 'Logos Only',
    isDefault: true,
  });
  wp.blocks.registerBlockStyle('core/social-links', {
    name: 'large-icons',
    label: 'Logos Only (Large)',
    isDefault: false,
  });

  wp.blocks.registerBlockStyle('core/heading', {
    name: 'block-heading',
    label: 'Block Heading',
    isDefault: false,
  });

  // wp.blocks.getBlockTypes().forEach((block) => {
  //   if (Array.isArray(block['styles']) && block['styles'].length > 0) {
  //     console.log(
  //       block.name,
  //       block['styles'].map((style) => style.name)
  //     );
  //   }
  // });
});
