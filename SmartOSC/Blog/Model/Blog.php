<?php

namespace SmartOSC\Blog\Model;

class Blog extends \Magento\Framework\Model\AbstractModel
{

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    protected function _construct()
    {
        $this->_init('SmartOSC\Blog\Model\ResourceModel\Blog');
    }
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

}
