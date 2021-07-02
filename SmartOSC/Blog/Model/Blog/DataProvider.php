<?php

namespace SmartOSC\Blog\Model\Blog;

use  \SmartOSC\Blog\Model\ResourceModel\Blog\Collection;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{

    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $blogFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $blogFactory;
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     */
    public function getData()
    {
        // Get items
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();


        foreach ($items as $blog) {
            $data = $blog->getData();
            $thumbnail = $data['thumbnail'];
            if ($thumbnail && is_string($thumbnail)) {
                $data['images'][0]['name'] = $thumbnail;
                $data['images'][0]['url'] = $this->storeManager->getStore()
                        ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
                    . 'blog/images/' . $thumbnail;
            }

            $this->loadedData[$blog->getId()] = $data;
        }

        $data = $this->dataPersistor->get('smartosc_blog');
        if (!empty($data)) {
            $blog = $this->collection->getNewEmptyItem();
            $blog->setData($data);
            $this->loadedData[$blog->getId()] = $blog->getData();
            $this->dataPersistor->clear('smartosc_blog');
        }

        return $this->loadedData;
    }
}
