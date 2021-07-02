<?php
/**
 * Created By : Rohan Hapani
 */
namespace Sumup\Blog\Block;
class Demo extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $blogFactory;
    protected $blogCollection;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Model\ProductRepository         $productRepository
     * @param array                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Sumup\Blog\Model\BlogFactory $blogFactory,
        \Sumup\Blog\Model\ResourceModel\Blog\CollectionFactory $blogCollection,
        array $data = []
    ) {
        $this->blogFactory = $blogFactory;
        $this->blogCollection = $blogCollection;
        parent::__construct($context, $data);
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('My Blog'));
        if ($this->getBlogCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'custom.history.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $this->getBlogCollection()
                );
            $this->setChild('pager', $pager);
            $this->getBlogCollection()->load();
        }
        return $this;
    }
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    public function getBlogCollection()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $collection = $this->blogCollection->create()
            ->addFieldToFilter('status',['eq' => 1])
            ->addFieldToFilter('publish_date_from',['lteq' => date('Y-m-d H:i:s')])
            ->addFieldToFilter('publish_date_to',['gteq' => date('Y-m-d H:i:s')])
        ;
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }
}
