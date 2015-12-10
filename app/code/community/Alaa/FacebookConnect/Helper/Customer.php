<?php
/**
 * Class Alaa_FacebookConnect_Helper_Customer
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Helper_Customer extends Mage_Core_Helper_Abstract
{
    /**
     * @param Mage_Customer_Model_Customer $customer
     * @return bool
     * @throws Exception
     */
    public function isCustomerFacebookUser(Mage_Customer_Model_Customer $customer)
    {
        $customerEmail = $customer->getData('email');
        $facebookUser = $this->getFacebookUser()->setData('store_id', $customer->getStoreId());
        $facebookUser->loadByEmail($customerEmail);

        return (bool) $facebookUser->getId() &&
                $customer->getStoreId() == $facebookUser->getData('store_id');
    }

    /**
     * @return Alaa_FacebookConnect_Model_User
     */
    protected function getFacebookUser()
    {
        return Mage::getModel('alaa_facebookconnect/user');
    }
}