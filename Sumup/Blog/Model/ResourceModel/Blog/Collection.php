<?php
namespace Sumup\Blog\Model\ResourceModel\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Sumup\Blog\Model\Blog as Model;
use Sumup\Blog\Model\ResourceModel\Blog as ResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(Model::class,ResourceModel::class);
    }
}
