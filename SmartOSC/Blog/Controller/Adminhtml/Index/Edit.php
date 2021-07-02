<?php

namespace SmartOSC\Blog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'SmartOSC_Blog::save';

    protected $_coreRegistry;
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Load layout and set active menu
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('SmartOSC_Blog::blog');
        return $resultPage;
    }

    public function execute()
    {
        // Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('SmartOSC\Blog\Model\Blog');

        // Initial checking
        if ($id) {
            $model->load($id);

            // If cannot get ID of model, display error message and redirect to List page
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Blog no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        // Registry banner
        $this->_coreRegistry->register('smartosc_blog', $model);

        // Build form
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getImage() : __('Create Blog'));

        return $resultPage;
    }
}
