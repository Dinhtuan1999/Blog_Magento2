<?php
namespace Sumup\Blog\Model;

class Blog extends \Magento\Catalog\Model\AbstractModel
{

    protected function _construct()
    {
        $this->_init(\Sumup\Blog\Model\ResourceModel\Blog::class);
    }

}
