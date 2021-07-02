<?php

namespace SmartOSC\Blog\Block\Blog;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;
use SmartOSC\Blog\Model\ResourceModel\Blog\Collection;

class BlogWidget extends Template implements BlockInterface
{

    protected $blogCollectionFactory;

    public function __construct(
        Template\Context $context,
        array $data,
        Collection $blogCollectionFactory)
    {
        $this->setTemplate('widget.phtml');
        $this->blogCollectionFactory = $blogCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Set data to View
     */
    protected function _beforeToHtml()
    {
        // Init collection
        $collection = $this->blogCollectionFactory;

        // Get enabled images
        $blogs = $collection->addFieldToFilter('status', ['eq' => true])->getData();

        // Set data
        $this->setData('blogs', $blogs);
        $this->setData('mediaURL', $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'blog/images/');

        // Return to View
        return parent::_beforeToHtml();
    }

}
