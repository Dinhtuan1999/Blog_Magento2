<?php

namespace SmartOSC\Blog\Block\Frontend;

class Detail extends \Magento\Framework\View\Element\Template
{

    protected $blogFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \SmartOSC\Blog\Model\BlogFactory $blogFactory,
        array $data = []
    )
    {
        $this->blogFactory = $blogFactory;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Blog Detail'));
        if ($this->getBlog()) {
            return $this;
        }

    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getBlog()
    {
        $id = $this->getRequest()->getParam('id');

        $model = $this->blogFactory->create()->load($id)->getData();

        return $model;
    }
}
