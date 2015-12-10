<?php
/**
 * Class Alaa_FacebookConnect_Model_User
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Model_User extends Mage_Core_Model_Abstract
{
    /** @var  Zend_Validate_EmailAddress $zendEmailValidator*/
    protected $zendEmailValidator;

    protected function _construct()
    {
        $this->_init('alaa_facebookconnect/user');
    }

    protected function _beforeSave()
    {
        parent::_beforeSave();

        $this->setData('store_id', $this->getMageApp()->getStore()->getId());
        $this->setData('is_active', 1);

        // only if user is new i.e does not have id yet
        if ($this->isObjectNew()) {
            $this->setData('created_at', $this->getDateModel()->timestamp());
        }
    }

    /** Serialise data and set it as extra
     * @param $data
     * @return $this
     */
    public function setExtra($data)
    {
        $serialisedData = serialize($this->detectExtra($data));
        $this->setData('extra', $serialisedData);

        return $this;
    }

    /**
     * @param $data
     * @return array
     */
    public function detectExtra($data)
    {
        $extra = array();
        $defaultProperties = $this->getPublicProfile()->getDefaultUserProperties();

        foreach ($data as $key => $value) {
            if (!in_array($key, $defaultProperties)) {
                $extra[$key] = $value;
            }
        }

        return $extra;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getExtra($key = '')
    {
        $extra =  unserialize($this->getData('extra'));

        return array_key_exists($key, $extra)? $extra[$key] : $extra;
    }

    /**
     * @return Mage_Core_Model_Date
     */
    public function getDateModel()
    {
        return Mage::getModel('core/date');
    }

    /**
     * @param array $data
     * @return bool
     */
    public function validateRequiredUserProperties($data)
    {
        $requiredData = $this->getPublicProfile()->getDefaultUserProperties();

        return array_intersect($requiredData, array_keys($data)) == $requiredData;
    }

    /**
     * @param $data
     * @return $this
     * @throws Exception
     */
    public function setRequiredProperties($data)
    {
        if (!$this->validateRequiredUserProperties($data)) {
            throw new \Exception('Required data is missing user properties.');
        }

        foreach ($this->getPublicProfile()->getDefaultUserProperties() as $property) {
            $key = $property;
            if ($key == 'id') {
                $key = 'user_' . $key;
            }

            $this->setData($key, $data[$property]);
        }

        return $this;
    }

    /**
     * @return Alaa_FacebookConnect_Model_Facebook_PublicProfile
     */
    public function getPublicProfile()
    {
        return Mage::getModel('alaa_facebookconnect/facebook_publicProfile');
    }

    /**
     * @return Mage_Core_Model_App
     */
    protected function getMageApp()
    {
        return Mage::app();
    }

    /**
     * @param $email
     * @return bool
     * @throws Exception
     */
    public function isEmailValid($email)
    {
        if (!$this->newZendEmailValidator()->isValid($email)) {
            throw new \Exception('Email Address is invalid');
        }

        return true;
    }

    /**
     * @return Zend_Validate_EmailAddress
     */
    protected function newZendEmailValidator()
    {
        if (is_null($this->zendEmailValidator)) {
            $this->zendEmailValidator = new Zend_Validate_EmailAddress();
        }

        return $this->zendEmailValidator;
    }

    /**
     * @param $email
     * @return $this
     * @throws Exception
     */
    public function loadByEmail($email)
    {
        if (!$this->isEmailValid($email)) {
            throw new \Exception('Invalid email address was provided.');
        }

        $this->_getResource()->loadByEmail($this, $email);
        return $this;
    }

    /**
     * @param int $fbId
     * @return $this
     * @throws Exception
     */
    public function loadByFacebookId($fbId)
    {
        if (!$fbId) {
            throw new \Exception('Alaa User ID must be provided.');
        }

        $this->_getResource()->loadByFacebookId($this, $fbId);
        return $this;
    }

    /**
     * @return Mage_Customer_Model_Customer
     * @throws Exception
     */
    public function createCustomer()
    {
        /** @var Mage_Customer_Model_Customer $customer */
        $customer = $this->getCustomerObject();

        if (!$customer->getId()) {
            try {
                $customer->setWebsiteId($this->getMageApp()->getWebsite()->getId())
                    ->setStore($this->getMageApp()->getStore($this->getData('store_id')))
                    ->setFirstname($this->getData('first_name'))
                    ->setLastname($this->getData('last_name'))
                    ->setEmail($this->getData('email'))
                    ->save();
            } catch (\Exception $e) {
                $this->logException($e);
                throw $e;
            }
        }

        return $customer;
    }

    /**
     * @return Mage_Customer_Model_Customer
     */
    protected function getCustomerModel()
    {
        return Mage::getModel("customer/customer");
    }

    /**
     * @param $e
     * @return $this
     */
    protected function logException($e)
    {
        Mage::logException($e);

        return $this;
    }

    /**
     * @return Mage_Customer_Model_Customer
     */
    public function getCustomerObject()
    {
        return $this->getCustomerModel()
            ->setWebsiteId($this->getMageApp()->getWebsite()->getId())
            ->setStore($this->getMageApp()->getStore($this->getData('store_id')))
            ->loadByEmail($this->getData('email'));
    }
}