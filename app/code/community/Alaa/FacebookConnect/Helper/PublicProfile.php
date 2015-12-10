<?php
/**
 * Class Alaa_FacebookConnect_Helper_Alaa
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Helper_PublicProfile extends Mage_Core_Helper_Abstract
{
    /** @var  string $loginUrl */
    protected $loginUrl;

    /**
     * @return string
     */
    public function getFacebookLoginUrl()
    {
        if (!$this->loginUrl) {
            $this->loginUrl = $this->getFacebookFactory()->getFacebookLoginUrl();
        }
        return $this->loginUrl;
    }

    /**
     * @return Alaa_FacebookConnect_Model_Facebook_factory
     */
    public function getFacebookFactory()
    {
        return Mage::getModel('alaa_facebookconnect/facebook_factory');
    }
}