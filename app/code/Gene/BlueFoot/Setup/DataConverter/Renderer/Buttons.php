<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Gene\BlueFoot\Setup\DataConverter\Renderer;

use Gene\BlueFoot\Setup\DataConverter\RendererInterface;
use Gene\BlueFoot\Setup\DataConverter\EavAttributeLoaderInterface;
use Gene\BlueFoot\Setup\DataConverter\StyleExtractorInterface;

/**
 * Render buttons to PageBuilder format
 */
class Buttons implements RendererInterface
{
    /**
     * @var StyleExtractorInterface
     */
    private $styleExtractor;

    /**
     * @var EavAttributeLoaderInterface
     */
    private $eavAttributeLoader;

    public function __construct(
        StyleExtractorInterface $styleExtractor,
        EavAttributeLoaderInterface $eavAttributeLoader
    ) {
        $this->styleExtractor = $styleExtractor;
        $this->eavAttributeLoader = $eavAttributeLoader;
    }

    /**
     * {@inheritdoc}
     */
    public function render(array $itemData, array $additionalData = [])
    {
        $eavData = $this->eavAttributeLoader->load($itemData);

        $rootElementAttributes = [
            'data-role' => 'buttons',
            'class' => $eavData['css_classes'] ?? ''
        ];

        $style = $this->styleExtractor->extractStyle($itemData['formData']);
        if ($style) {
            $rootElementAttributes['style'] = $style;
        }

        $rootElementHtml = '<div';
        foreach ($rootElementAttributes as $attributeName => $attributeValue) {
            $rootElementHtml .= $attributeValue ? " $attributeName=\"$attributeValue\"" : '';
        }
        $rootElementHtml .= '>' . (isset($additionalData['children']) ? $additionalData['children'] : '') . '</div>';

        return $rootElementHtml;
    }
}
