<?php
/**
 * Created by PhpStorm.
 * User: ashish
 * Date: 5/5/16
 * Time: 5:55 PM
 */

namespace CzoneTech\AjaxifiedCatalog\Plugin\Category;


use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\Page;

class View
{
    protected $_resultJsonFactory;

    public function __construct(JsonFactory $resultJsonFactory){
        $this->_resultJsonFactory = $resultJsonFactory;
    }

    public function aroundExecute(\Magento\Catalog\Controller\Category\View $subject, \Closure
    $method){
        $response = $method();
        if($response instanceof Page){
            if($subject->getRequest()->getParam('ajax') == 1){
                $content = $response->getLayout()->getBlock('category.products')->toHtml();
                return $this->_resultJsonFactory->create()->setData(['success' => true, 'html' => $content]);
            }
        }
        return $response;
    }
}