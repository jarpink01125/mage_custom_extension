<?php

class Waderusa_Reviews_Block_Manage_Reviews_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'reviews';
        $this->_controller = 'manage_reviews';

        $this->_updateButton('save', 'label', Mage::helper('reviews')->__('Save Review'));
        $this->_updateButton('delete', 'label', Mage::helper('reviews')->__('Delete Review'));

        $this->_addButton(
            'saveandcontinue',
            array(
                 'label'   => Mage::helper('adminhtml')->__('Save And Continue Edit'),
                 'onclick' => 'saveAndContinueEdit()',
                 'class'   => 'save',
            ),
            -100
        );

        $this->_formScripts[]
            = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('review_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'review_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'review_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('reviews_data') && Mage::registry('reviews_data')->getId()) {
            return Mage::helper('reviews')->__(
                "Edit Review '%s'", $this->escapeHtml(Mage::registry('reviews_data')->getTitle())
            );
        } else {
            return Mage::helper('reviews')->__('Add Review');
        }
    }
}