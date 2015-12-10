<?php
/**
 * Class Alaa_FacebookConnect_Model_Session
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Model_Session extends Mage_Core_Model_Session
{
    /** alaa state and access token */
    const FBRLH_STATE           = 'FBRLH_state';
    const FACEBOOK_ACCESS_TOKEN = 'facebook_access_token';

    /**
     * set state as FBRLH_state
     * @return $this
     */
    public function setState()
    {
        $_SESSION[self::FBRLH_STATE] = $this->getData(self::FBRLH_STATE);

        return $this;
    }

    /**
     * @param $accessToken
     * @return $this
     */
    public function setAccessToken($accessToken)
    {
        $_SESSION[self::FACEBOOK_ACCESS_TOKEN] = $this->getCoreHelper()
            ->escapeHtml((string) $accessToken);

        return $this;
    }

    /**
     * @return Mage_Core_Helper_Data
     */
    public function getCoreHelper()
    {
        return Mage::helper('core');
    }
}