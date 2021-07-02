<?php

namespace SmartOSC\Blog\Model\ResourceModel\Blog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'id';

    protected function _construct()
    {
        // Model + Resource Model
        $this->_init('SmartOSC\Blog\Model\Blog', 'SmartOSC\Blog\Model\ResourceModel\Blog');
    }

}
