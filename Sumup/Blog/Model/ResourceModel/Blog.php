<?php
namespace Sumup\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Blog extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('blogs','id');
    }
}
