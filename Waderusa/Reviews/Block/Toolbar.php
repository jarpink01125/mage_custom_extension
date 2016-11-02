<?php

class Waderusa_Reviews_Block_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar
{
	public function setCollection($collection)
    {
        parent::setCollection($collection);

        if ($this->getCurrentOrder() && $this->getCurrentDirection()) {
            $this->_collection->setOrder($this->getCurrentOrder(), $this->getCurrentDirection());
        }
        return $this;
    }

	public function getCurrentOrder()
    {
        $order = $this->getRequest()->getParam($this->getOrderVarName());

        if (!$order) {
            return $this->_orderField;
        }

        if (array_key_exists($order, $this->getAvailableOrders())) {
            return $order;
        }

        return $this->_orderField;
    }

    public function getCurrentMode()
    {
        return null;
    }

    public function getAvailableLimit()
    {
        return $this->getPost()->getAvailLimits();
    }

    public function setDefaultOrder($field)
    {
        $this->_orderField = $field;
    }

    public function getLimit()
    {
        return $this->getRequest()->getParam($this->getLimitVarName());
    }
}