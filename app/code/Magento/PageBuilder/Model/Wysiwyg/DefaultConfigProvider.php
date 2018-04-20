<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\PageBuilder\Model\Wysiwyg;

/**
 * This DefaultConfigProvider overrides existing configuration provided from the cms module
 */
class DefaultConfigProvider implements \Magento\Framework\Data\Wysiwyg\ConfigProviderInterface
{
    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    private $assetRepo;

    /**
     * @var array
     */
    private $additionalSettings;

    /**
     * @param \Magento\Framework\View\Asset\Repository $assetRepo
     * @param array $additionalSettings
     */
    public function __construct(
        \Magento\Framework\View\Asset\Repository $assetRepo,
        array $additionalSettings
    ) {
        $this->assetRepo = $assetRepo;
        $this->additionalSettings = $additionalSettings;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig($config): \Magento\Framework\DataObject
    {
        $config->addData([
            'tinymce4' => [
                'toolbar' => 'undo redo | styleselect | fontsizeselect | forecolor backcolor | bold italic underline' .
                ' | alignleft aligncenter alignright | numlist bullist | link image table charmap | widgets variables',
                'plugins' => implode(
                    ' ',
                    [
                        'advlist',
                        'autolink',
                        'lists',
                        'link',
                        'charmap',
                        'media',
                        'noneditable',
                        'table',
                        'contextmenu',
                        'paste',
                        'code',
                        'help',
                        'table',
                        'textcolor',
                        'image'
                    ]
                ),
                'content_css' => [
                    $this->assetRepo->getUrl('mage/adminhtml/wysiwyg/tiny_mce/themes/ui.css'),
                    $this->assetRepo->getUrl('Magento_PageBuilder/css/source/wysiwyg/tinymce.css')
                ]
            ],
            'settings' => $this->additionalSettings
        ]);
        return $config;
    }
}
