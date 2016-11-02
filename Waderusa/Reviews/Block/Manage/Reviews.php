<?php

class Waderusa_Reviews_Block_Manage_Reviews extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'manage_reviews';
        $this->_blockGroup = 'reviews';
        $this->_headerText = Mage::helper('reviews')->__('Customer Reviews Manager');
        parent::__construct();
        $this->setTemplate('waderusa/reviews/grid.phtml');
    }
	protected function _prepareLayout()
    {
        $addButtonBlock = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(
                array(
                     'label'   => Mage::helper('reviews')->__('Add Review'),
                     'onclick' => "setLocation('" . $this->getUrl('*/*/new') . "')",
                     'class'   => 'add',
                )
            )
        ;
        $this->setChild('add_new_button', $addButtonBlock);        
        $this->setChild('grid', $this->getLayout()->createBlock('reviews/manage_reviews_grid', 'reviews.grid'));
        return parent::_prepareLayout();
    }

    public function getAddNewButtonHtml()
    {
        return $this->getChildHtml('add_new_button');
    }

    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
}