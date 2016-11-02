<?php

class Waderusa_Reviews_Block_Manage_Reviews_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('reviews_form', array('legend' => Mage::helper('reviews')->__('Review information')));

        $fieldset->addField(
            'title',
            'text',
            array(
                 'label'    => Mage::helper('reviews')->__('Summary'),
                 'class'    => 'required-entry',
                 'required' => true,
                 'name'     => 'title',
            )
        );

        $fieldset->addField('nickname','text', array(
            'label' => Mage::helper('reviews')->__('Customer Name'),
            'name' => 'nickname',
        ));
        
        $fieldset->addField(
            'status',
            'select',
            array(
                 'label'              => Mage::helper('reviews')->__('Status'),
                 'name'               => 'status',
                 'style'  => 'width:110px;',
                 'values'             => array(
                     array(
                         'value' => 1,
                         'label' => Mage::helper('reviews')->__('Pending'),
                     ),
                     array(
                         'value' => 2,
                         'label' => Mage::helper('reviews')->__('Approved'),
                     ),
                     array(
                         'value' => 3,
                         'label' => Mage::helper('reviews')->__('Not Approved'),
                     ),
                 ),
                 'after_element_html' => '<span class="hint" style="font-size: 11px;color: #777;">'
                     . Mage::helper('reviews')->__(
                         "&nbsp;Approved review can only display on the reviews page"
                     )
                     . '</span>',
            )
        );

        $fieldset->addField('stars', 'note', array(
            'label'     => Mage::helper('reviews')->__('Site Rating'),
            'required'  => true,
            'text'      => '<div id="rating_detail">'
                           . $this->getLayout()->createBlock('adminhtml/template')->setTemplate('waderusa/reviews/rating.phtml')->toHtml()
                           . '</div>',
        ));
        try {
            $config = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
            $config->setData(
                Mage::helper('reviews')->recursiveReplace(
                    '/waderusa_admin/',
                    '/' . (string)Mage::app()->getConfig()->getNode('admin/routers/adminhtml/args/frontName') . '/',
                    $config->getData()
                )
            );
        } catch (Exception $ex) {
            $config = null;
        }
        $fieldset->addField(
            'comment',
            'editor',
            array(
                 'name'   => 'comment',
                 'label'  => Mage::helper('reviews')->__('Comment'),
                 'title'  => Mage::helper('reviews')->__('Comment'),
                 'style'  => 'width:700px; height:200px;',
                 'config' => $config,
            )
        );

        if (Mage::getSingleton('adminhtml/session')->getReviewsData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getReviewsData());
            Mage::getSingleton('adminhtml/session')->getReviewsData(null);
        } elseif (Mage::registry('reviews_data')) {
            $form->setValues(Mage::registry('reviews_data')->getData());
        }

        return parent::_prepareForm();
    }
}