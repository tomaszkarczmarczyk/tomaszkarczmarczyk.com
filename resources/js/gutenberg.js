import '../scss/gutenberg.scss';

const {
  blocks: { getBlockTypes, registerBlockStyle, unregisterBlockStyle },
  hooks: { addFilter },
  richText: { unregisterFormatType },
  i18n: { __ },
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

  registerBlockStyle('core/quote', {
    name: 'warning',
    label: __('Warning', 'tokk'),
    isDefault: false,
  });

  registerBlockStyle('core/quote', {
    name: 'danger',
    label: __('Danger', 'tokk'),
    isDefault: false,
  });

  console.log(wp.data.select('core/rich-text').getFormatTypes());

  getBlockTypes().forEach((blockType) => {
    console.log(blockType.name);
  });
});
