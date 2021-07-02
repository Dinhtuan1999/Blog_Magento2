<?php
namespace SmartOSC\Blog\Controller\Adminhtml\Index;


use Magento\Backend\App\Action;

class Index extends Action
{
    const ADMIN_RESOURCE = 'SmartOSC_Blog::blog_manager';

    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        // Load layout and set active menu
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('SmartOSC_Blog::blog_manager');
        $resultPage->getConfig()->getTitle()->prepend(__('Blog manager'));

        return $resultPage;
    }
}
