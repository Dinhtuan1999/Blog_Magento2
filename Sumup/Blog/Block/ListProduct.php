<?php
/**
 * Created By : Rohan Hapani
 */
namespace Sumup\Blog\Block;
class ListProduct extends \Magento\Framework\View\Element\Template
{
    protected $productFactory;
    protected $blogFactory;
    protected $productCollection;
    protected $_productRepository;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Model\ProductRepository         $productRepository
     * @param array                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection,
        \Sumup\Blog\Model\BlogFactory $blogFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $data = []
    ) {
        $this->productFactory = $productFactory;
        $this->productCollection = $productCollection;
        $this->blogFactory = $blogFactory;
        $this->_productRepository = $productRepository;
        parent::__construct($context, $data);
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        return $this;
    }

    public function getProducts(){
        $products = [];
        $id = $this->getRequest()->getParam('id');
        $blog = $this->blogFactory->create()->load($id)->getData();
        $pro_ids= explode (",", $blog['product_ids']);
        foreach ($pro_ids as $id){
            $pro = $this->_productRepository->getById($id);

            array_push($products,$pro);
        }

        return $products;
    }
}
