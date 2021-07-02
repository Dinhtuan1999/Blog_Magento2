<?php

namespace SmartOSC\Blog\Controller\Adminhtml\Index;

class PostDataProcessor
{

    protected $messageManager;

    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
    }

    // Validate required columns
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'name' => __('Name'),
            'short_description' => __('Short Description'),
            'description' => __('Description'),
            'status' => __('Status'),
            'thumbnail' => __('Thumbnail'),
            'gallery' => __('Gallery'),
            'publish_date_form' => __('Publish Date Form'),
            'publish_date_to' => __('Publish Date To'),
            'categories' => __('Categories'),
            'tags' => __('Tags'),
            'url_key' => __('URL Key'),
            'product_id' => __('Prduct ID')
        ];
        $errorNo = true;

        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addError(
                    __('"%1" field is required', $requiredFields[$field])
                );
            }
        }
        return $errorNo;
    }
}
