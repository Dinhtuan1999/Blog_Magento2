<?php
namespace Sumup\Blog\Model;

class Category extends \Magento\Catalog\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Sumup\Blog\Model\ResourceModel\Category::class);
    }
}
