<?php

class Waderusa_Reviews_Manage_ReviewsController extends Mage_Adminhtml_Controller_Action
{
	public function preDispatch()
    {
        parent::preDispatch();
    }
    protected function _initAction()
    {
        $this
            ->loadLayout()
            ->_setActiveMenu('customer/reviews');
        return $this;
    }
	public function indexAction()
    {
        $this->_title($this->__('Customer Reviews'));
        $this
            ->_initAction()
            ->renderLayout()
        ;
    }
    public function newAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('reviews/reviews')->load($id);

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('reviews_data', $model);

        $this->loadLayout();
        $this->_setActiveMenu('customer/reviews');
        $this->_title($this->__('Add new review'));

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        
        $this
            ->_addContent($this->getLayout()->createBlock('reviews/manage_reviews_edit'))
            ->_addLeft($this->getLayout()->createBlock('reviews/manage_reviews_edit_tabs'))
        ;
        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        $this->renderLayout();
    }
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('reviews/reviews');
            if($this->getRequest()->getParam('id')){
                //$model->load($this->getRequest()->getParam('id'));
                $model->setData($data)
                      ->setId($this->getRequest()->getParam('id'));
            }else{
                $model->setData($data);
            }

            try {
                
                if($this->getRequest()->getParam('id')){
                    $model->setUpdateTime(Mage::getModel('core/date')->gmtDate());
                }else{
                    $model->setCreatedTime(Mage::getModel('core/date')->gmtDate());
                }

                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('reviews')->__('Review was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('reviews')->__('Unable to find review to save'));
        $this->_redirect('*/*/');
    }
    public function editAction(){
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('reviews/reviews')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('reviews_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('customer/reviews');
            $this->_title($this->__('Edit review'));
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this
                ->_addContent($this->getLayout()->createBlock('reviews/manage_reviews_edit'))
                ->_addLeft($this->getLayout()->createBlock('reviews/manage_reviews_edit_tabs'))
            ;
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('reviews')->__('Review does not exist'));
            $this->_redirect('*/*/');
        }
    }
    protected function _reviewDelete($reviewId)
    {
        $model = Mage::getModel('reviews/reviews')->load($reviewId);
        $model->delete();
    }
    public function deleteAction()
    {
        $reviewId = (int)$this->getRequest()->getParam('id');
        if ($reviewId) {
            try {
                $this->_reviewDelete($reviewId);
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Review was successfully deleted')
                );
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $reviewIds = $this->getRequest()->getParam('reviews');
        if (!is_array($reviewIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select review(s)'));
        } else {
            try {
                foreach ($reviewIds as $reviewId) {
                    $this->_reviewDelete($reviewId);
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($reviewIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    public function massStatusAction()
    {
        $reviewIds = $this->getRequest()->getParam('reviews');
        if (!is_array($reviewIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select post(s)'));
        } else {
            try {

                foreach ($reviewIds as $reviewId) {
                    $reviews = Mage::getModel('reviews/reviews')
                        ->load($reviewId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save()
                    ;
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($reviewIds))
                );
            } catch (Exception $e) {

                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}