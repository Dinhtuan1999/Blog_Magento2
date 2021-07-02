<?php

namespace Sumup\Blog\Controller\Adminhtml\Page;

use Magento\Backend\App\Action;
use Sumup\Blog\Model\BlogFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Sumup\Blog\Model\ResourceModel\Blog\CollectionFactory;

class Save extends Action
{
    private $resultRedirect;
    private $blogFactory;
    private $collection;

    public function __construct(
        Action\Context $context,
        BlogFactory $blogFactory,
        RedirectFactory $redirectFactory,
        CollectionFactory $collection
    )
    {
        parent::__construct($context);
        $this->blogFactory = $blogFactory;
        $this->resultRedirect = $redirectFactory;
        $this->collection = $collection;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['id']) ? $data['id'] : null;

//        var_dump($data['thumbnail'][0]['url']); die;

        if(!$id){
            $model = $this->collection->create()
                ->addFieldToFilter(['name','url_key'], [$data['name'],$data['url_key']]);
            if($model->getData()){
                $this->getMessageManager()->addErrorMessage(__('Save thất bại. Tiêu đề hoặc url key đã tồn tại'));
                return $this->resultRedirect->create()->setPath('blog/page/index');
            }
        }

        if(is_array($data['categories'])){
            $categories = implode (",", $data['categories']);
        }else{
            $categories = $data['categories'];
        }

        if($id) {
            $thumbnail = $this->blogFactory->create()->load($id)->getData('thumbnail');
        }else{

            $thumbnail = $data['thumbnail'][0]['url'];
        }
        $newData = [
            'name' => $data['name'],
            'status' => $data['status'],
            'description' => $data['description'],
            'short_description' => $data['short_description'],
            'url_key' => $data['url_key'],
            'publish_date_from' => $data['publish_date_from'],
            'publish_date_to' => $data['publish_date_to'],
            'tags' => $data['tags'],
            'product_ids' => $data['product_ids'],
            'categories'=> $categories,
            'thumbnail' => $thumbnail,
        ];

        $blog = $this->blogFactory->create();
        if ($id) {
            $blog->load($id);
            $this->getMessageManager()->addSuccessMessage(__('Edit thành công'));
        } else {
            $this->getMessageManager()->addSuccessMessage(__('Save thành công.'));
        }
        try{
            $blog->addData($newData);
            $blog->save();
            return $this->resultRedirect->create()->setPath('blog/page/index');
        }catch (\Exception $e){
            $this->getMessageManager()->addErrorMessage(__('Save thất bại.'));
        }
    }
}
