<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sumup\Blog\Controller\Adminhtml\Page;

/**
 * Index action.
 */

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    protected $resultPageFactory;
    protected $blogFactory;
    protected $blogCollectionFactory;
    protected $blogResourceModelFactory;

    const ADMIN_RESOURCE = 'Sumup:page';

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        \Sumup\Blog\Model\BlogFactory $blogFactory,
        \Sumup\Blog\Model\ResourceModel\Blog\CollectionFactory $blogCollectionFactory,
        \Sumup\Blog\Model\ResourceModel\BlogFactory $blogResourceModelFactory
    )
    {
        $this->blogFactory = $blogFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->resultPageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__(' Blog Listing'));

        return $resultPage;
    }
}
