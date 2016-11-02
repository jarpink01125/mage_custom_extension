<?php

class Waderusa_Reviews_Block_Manage_Reviews_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('reviews_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('reviews')->__('Review Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_section',
            array(
                 'label'   => Mage::helper('reviews')->__('Review Information'),
                 'title'   => Mage::helper('reviews')->__('Review Information'),
                 'content' => $this->getLayout()->createBlock('reviews/manage_reviews_edit_tab_form')->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }
}