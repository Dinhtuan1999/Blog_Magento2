<?php
namespace SmartOSC\Blog\Block\Frontend;

class Index extends \Magento\Framework\View\Element\Template
{

    protected $blogFactory;
    protected $blogCollection;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \SmartOSC\Blog\Model\Blog $blogFactory,
        \SmartOSC\Blog\Model\ResourceModel\Blog\Collection $blogCollection,
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
        $collection = $this->blogCollection->addFieldToFilter('status',['eq' => 1])
        ;
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }
}
