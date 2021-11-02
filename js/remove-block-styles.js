wp.domReady(() => {
  // Remove (unregister) default block styles

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

  // Add (register) custom block styles

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
    label: 'Section Heading (Uppercase)',
    isDefault: false,
  });
  wp.blocks.registerBlockStyle('core/heading', {
    name: 'large-heading',
    label: 'Large Heading',
    isDefault: false,
  });

  // Limit options in the "embed" block to certain sources
  const allowedEmbedBlocks = ['vimeo', 'youtube'];
  wp.blocks.getBlockVariations('core/embed').forEach(function (blockVariation) {
    if (-1 === allowedEmbedBlocks.indexOf(blockVariation.name)) {
      wp.blocks.unregisterBlockVariation('core/embed', blockVariation.name);
    }
  });
});
