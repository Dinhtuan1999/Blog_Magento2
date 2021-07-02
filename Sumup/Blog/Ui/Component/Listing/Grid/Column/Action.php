<?php

namespace Sumup\Blog\Ui\Component\Listing\Grid\Column;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder;


class Action extends Column
{

    const BLOG_URL_PATH_EDIT = 'blog/page/edit';
    const BLOG_URL_PATH_DELETE = 'blog/page/delete';
    protected $urlBuilder;
    private $scopeUrlBuilder;
    private $editUrl;
    private $deleteUrl;
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,

        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::BLOG_URL_PATH_EDIT,
        $deleteUrl = self::BLOG_URL_PATH_DELETE,
        \Magento\Cms\ViewModel\Page\Grid\UrlBuilder $scopeUrlBuilder = null
    ) {
        $this->editUrl = $editUrl;
        $this->deleteUrl = $deleteUrl;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->scopeUrlBuilder = $scopeUrlBuilder ?: ObjectManager::getInstance()
            ->get(\Magento\Cms\ViewModel\Page\Grid\UrlBuilder::class);
    }

    public function prepareDataSource(array $dataSource)
    {
        $obj = \Magento\Framework\App\ObjectManager::getInstance();
        $store = $obj->create('\Magento\Store\Model\StoreManagerInterface');
        $url = $store->getStore()->getBaseUrl();
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['id']]),
                        'label' => __('Edit')
                    ],
                    'delete' => [
                        'href' => $this->urlBuilder->getUrl($this->deleteUrl, ['id' => $item['id']]),
                        'label' => __('Delete')
                    ],
                    'view' => [
                        'href' => $url.'/blog/detail?id='.$item["id"],
                        'label' => __('View')
                    ]
                ];
            }
        }

        return $dataSource;
    }
}
