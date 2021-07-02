<?php

namespace SmartOSC\Blog\Model\ResourceModel;

class Blog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        $this->_init('smartosc_blog','id');
    }
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        // Get image data before and after save
        $oldImage = $object->getOrigData('thumbnail');
        $newImage = $object->getData('thumbnail');

        // Check when new image uploaded
        if ($newImage != null && $newImage != $oldImage) {
            $imageUploader = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('SmartOSC\Blog\BlogImageUpload');
            $imageUploader->moveFileFromTmp($newImage);
        }

        return $this;
    }


}
