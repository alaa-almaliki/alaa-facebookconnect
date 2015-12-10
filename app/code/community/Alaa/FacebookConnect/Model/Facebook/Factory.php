<?php
use Facebook\Facebook;

/**
 * Class Alaa_FacebookConnect_Model_Alaa_Factory
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Model_Facebook_Factory
{
    /** @var  Facebook/Facebook $fb */
    protected $fb;

    /**
     * @return Facebook|Facebook
     */
    public function getFacebook()
    {
        if (!$this->getHelper()->isFacebookActive()) {
            return null;
        }

        if($this->fb === null) {
            try {
                $this->fb = new Facebook($this->getHelper()->getFacebookConfigs());
            } catch (Exception $e) {
                Mage::logException($e);
            }

        }

        return $this->fb;
    }

    /**
     * @return string
     */
    public function getFacebookLoginUrl()
    {
        if (is_null($this->getFacebook())) {
            return $this->getUrl('alaa_facebookconnect/index/comingSoon');
        }

        $fb             = $this->getFacebook();
        $helper         = $fb->getRedirectLoginHelper();
        $loginUrl       = $helper->getLoginUrl(
            $this->getHelper()->getCallbackLoginUrl(),
            $this->getHelper()->getPermissions()
        );

        return $loginUrl;
    }

    /**
     * @return Alaa_FacebookConnect_Helper_Data
     */
    public function getHelper()
    {
        return Mage::helper('alaa_facebookconnect');
    }

    /**
     * @param string $segment
     * @return string
     */
    public function getUrl($segment)
    {
        return Mage::getUrl($segment);
    }
}