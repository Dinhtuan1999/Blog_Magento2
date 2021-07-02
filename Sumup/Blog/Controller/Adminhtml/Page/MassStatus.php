<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sumup\Blog\Controller\Adminhtml\Page;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Catalog\Controller\Adminhtml\Product;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Sumup\Blog\Model\ResourceModel\Blog\CollectionFactory;

/**
 * Updates status for a batch of products.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MassStatus extends Action implements HttpPostActionInterface
{
    /**
     * @var \Magento\Catalog\Model\Indexer\Product\Price\Processor
     */
    protected $_productPriceIndexerProcessor;

    /**
     * MassActions filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Action
     */
    private $blogAction;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param Builder $productBuilder
     * @param \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Catalog\Model\Product\Action $productAction
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Product\Builder $productBuilder,
        \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Magento\Catalog\Model\Product\Action $blogAction = null
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->blogAction = $blogAction ?: ObjectManager::getInstance()
            ->get(\Magento\Catalog\Model\Product\Action::class);
        parent::__construct($context, $productBuilder);
    }

    /**
     * Validate batch of products before theirs status will be set
     *
     * @param array $blogIds
     * @param int $status
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function _validateMassStatus(array $blogIds, $status)
    {
        if ($status == \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED) {
            if (!$this->_objectManager->create(\Magento\Catalog\Model\Product::class)->isProductsHasSku($blogIds)) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Please make sure to define SKU values for all processed products.')
                );
            }
        }
    }

    /**
     * Update product(s) status action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $blogIds = $collection->getAllIds();
        $requestStoreId = $storeId = $this->getRequest()->getParam('store', null);
        $filterRequest = $this->getRequest()->getParam('filters', null);
        $status = (int) $this->getRequest()->getParam('status');

        if($status == 1) {
            foreach ($collection as $blog) {
                $blog->setData('status',0);
                $blog->save();
            }
        }else{
            foreach ($collection as $blog) {
                $blog->setData('status',1);
                $blog->save();
            }
        }



        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('blog/page/index', ['store' => $requestStoreId]);
    }
}
