<?php
namespace Sumup\Blog\Model\ResourceModel\Category;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Sumup\Blog\Model\Category as Model;
use Sumup\Blog\Model\ResourceModel\Category as ResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(Model::class,ResourceModel::class);
    }
}
