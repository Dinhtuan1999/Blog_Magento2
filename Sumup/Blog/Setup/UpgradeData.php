<?php
namespace Sumup\Blog\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if ($context->getVersion()
            && version_compare($context->getVersion(), '2.0.2') < 0
        ) {
            $table = $setup->getTable('blog_categories');
            $setup->getConnection()
                ->insertForce($table, ['name' => 'news']);
            $setup->getConnection()
                ->insertForce($table, ['name' => 'sports']);

        }
        $setup->endSetup();
    }
}
