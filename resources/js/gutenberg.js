const {
  blocks: { getBlockTypes, unregisterBlockStyle },
  hooks: { addFilter },
  richText: { unregisterFormatType },
  domReady,
} = wp;

addFilter('blocks.registerBlockType', 'tokk/block-filters', (settings, name) => {
  const addSupports = (supports) => ({
    ...settings,
    supports: { ...settings.supports, ...supports },
  });

  if (name === 'core/heading') {
    return addSupports({ className: true });
  }

  if (name === 'core/paragraph') {
    return addSupports({ className: true });
  }

  if (name === 'core/list') {
    return addSupports({ className: true });
  }

  return settings;
});

domReady(() => {
  unregisterBlockStyle('core/image', 'rounded');
  unregisterBlockStyle('core/quote', 'large');
  unregisterBlockStyle('core/separator', 'wide');
  unregisterBlockStyle('core/separator', 'dots');

  unregisterFormatType('core/image');

  getBlockTypes().forEach((blockType) => {
    console.log(blockType.name);
  });
});
