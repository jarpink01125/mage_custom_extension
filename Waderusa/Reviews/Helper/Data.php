<?php

class Waderusa_Reviews_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getCustomerName()
    {
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        return trim("{$customer->getFirstname()} {$customer->getLastname()}");
    }
    /**
     * Recursively searches and replaces all occurrences of search in subject values
     * replaced with the given replace value
     *
     * @param string $search The value being searched for
     * @param string $replace The replacement value
     * @param array $subject Subject for being searched and replaced on
     * @return array Array with processed values
     */
    public function recursiveReplace($search, $replace, $subject)
    {
        if (!is_array($subject)) {
            return $subject;
        }

        foreach ($subject as $key => $value) {
            if (is_string($value)) {
                $subject[$key] = str_replace($search, $replace, $value);
            } elseif (is_array($value)) {
                $subject[$key] = self::recursiveReplace($search, $replace, $value);
            }
        }

        return $subject;
    }
}
