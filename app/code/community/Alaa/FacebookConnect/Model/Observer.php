<?php
/**
 * Class Alaa_FacebookConnect_Model_Observer
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Model_Observer
{
    /**
     * @param Varien_Event_Observer $observer
     * @throws Exception
     */
    public function loadFacebook(Varien_Event_Observer $observer)
    {
        Alaa_FacebookConnect_Model_Autoloader::load();
    }

    /**
     * creates a customer from facebook user
     * @param Varien_Event_Observer $observer
     * @throws Exception
     */
    public function registerCustomer(Varien_Event_Observer $observer)
    {
        /** @var Alaa_FacebookConnect_Model_User $model */
        $model = $observer->getObject();
        if ($model instanceof Alaa_FacebookConnect_Model_User) {
            $customer = null;
            if ($model->isObjectNew()) {
                $customer = $model->createCustomer();
            }

            if ($customer instanceof Mage_Customer_Model_Customer && $customer->getId()) {
                $this->login($customer);
            }
        }
    }

    /**
     * login facebook user as a customer.
     * @param Varien_Event_Observer $observer
     */
    public function loginCustomer(Varien_Event_Observer $observer)
    {
        $controller = $observer->getControllerAction();
        if ($controller->getFullActionName() == 'customer_account_index') {
            $userId = $this->getMageApp()->getRequest()->getParam('user_id');
            if ($userId) {
                /** @var Alaa_FacebookConnect_Model_User $user */
                $user = $this->getFacebookUser()->load($userId);
                if ($user->getId()) {
                    $this->login($user->getCustomerObject());
                }
            }
        }
    }

    /**
     * @param Mage_Customer_Model_Customer $customer
     */
    public function login(Mage_Customer_Model_Customer $customer)
    {
        $this->getCustomerSession()->setCustomerAsLoggedIn($customer);
        $this->getCustomerSession()->loginById($customer->getId());

        if ($this->getCustomerSession()->isLoggedIn()) {
            $this->getCustomerSession()->setAfterAuthUrl($this->getUrl('customer/account'));
        }
    }

    /**
     * @return Alaa_FacebookConnect_Model_User
     */
    public function getFacebookUser()
    {
        return Mage::getModel('alaa_facebookconnect/user');
    }

    /**
     * @return Mage_Core_Model_App
     */
    public function getMageApp()
    {
        return Mage::app();
    }

    /**
     * @return Alaa_Facebookconnect_Helper_Data
     */
    public function getFacebookHelper()
    {
        return Mage::helper('alaa_facebookconnect');
    }

    /**
     * @return Mage_Customer_Model_Session
     */
    protected function getCustomerSession()
    {
        return Mage::getSingleton('customer/session');
    }

    /**
     * @param string $segment
     * @return string
     */
    protected function getUrl($segment)
    {
        return Mage::getUrl($segment);
    }

    /**
     * @return Alaa_FacebookConnect_Model_Session
     */
    public function getFacebookSession()
    {
        return Mage::getSingleton('alaa_facebookconnect/session');
    }

    /**
     * @return Mage_Core_Model_Session
     */
    protected function getCoreSession()
    {
        return Mage::getSingleton('core/session');
    }
}