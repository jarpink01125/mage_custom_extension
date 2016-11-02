<?php

class Waderusa_Reviews_IndexController extends Mage_Core_Controller_Front_Action
{
    public function preDispatch()
    {
        parent::preDispatch();
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('root')->setTemplate("page/2columns-right.phtml");
        $this->renderLayout();
    }
    public function saveAction(){
        //$data = $this->unserializeForm($this->getRequest()->getPost('data'));
        if($this->getRequest()->getPost('data')){
            $data = json_decode($this->getRequest()->getPost('data'), true);
            $model = Mage::getModel('reviews/reviews');
            $model->setRatings($data[0]['value']);
            $model->setTitle($data[2]['value']);
            $model->setComment($data[4]['value']);
            $model->setNickname($data[3]['value']);
            $model->setStatus(1);

            try {

                $model->setCreatedTime(Mage::getModel('core/date')->gmtDate());
                $model->save();
                
                $jsonData = json_encode('success');
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody($jsonData);
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
    }
    public function unserializeForm($str) {
        $strArray = explode("&", $str);
        foreach($strArray as $item) {
            $array = explode("=", $item);
            $returndata[] = array($array[0]=>$array[1]);
        }
        return $returndata;
    }
}