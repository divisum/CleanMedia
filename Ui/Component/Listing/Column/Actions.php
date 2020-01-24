<?php

namespace Cap\CleanMedia\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Actions constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare actions column links
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $title = $item['basename'];
                $item[$this->getData('name')]['delete'] = [
                    'href' => $this->urlBuilder->getUrl(
                        'cleanmedia/index/delete',
                        ['id' => $item['path']]
                    ),
                    'label' => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete %1', $title),
                        'message' => __('Are you sure you wan\'t to delete a %1 record?', $title),
                    ],
                    'hidden' => false,
                ];
                $item[$this->getData('name')]['download'] = [
                    'href' => $this->urlBuilder->getUrl(
                        'cleanmedia/index/download',
                        ['id' => $item['relativePath']]
                    ),
                    'label' => __('Download'),
                    'hidden' => false,
                ];
            }
        }

        return $dataSource;
    }
}