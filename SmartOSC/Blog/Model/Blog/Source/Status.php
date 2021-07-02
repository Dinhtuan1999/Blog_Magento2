<?php

namespace SmartOSC\Blog\Model\Blog\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{

    protected $blog;

    public function __construct(\SmartOSC\Blog\Model\Blog $blog)
    {
        $this->blog = $blog;
    }

    /**
     * Get status options
     */
    public function toOptionArray()
    {
        $availableOptions = $this->blog->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
