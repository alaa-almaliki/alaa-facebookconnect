<?php
/**
 * Class Alaa_FacebookConnect_Helper_Data
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Helper_Data extends Mage_Core_Helper_Abstract
{
    const FACEBOOK_CALLBACK_LOGIN_URL = 'alaa_facebookconnect/index/callbackLoginUrl';
    /**
     * @return bool
     */
    public function isFacebookActive()
    {
        return $this->getConfigSingleton()->isActive();
    }

    /**
     * @return string
     */
    public function getUserProperties()
    {
        return $this->getConfigSingleton()->getUserProperties();
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return explode(',', $this->getConfigSingleton()->getPermissions());
    }

    /**
     * @return array
     */
    public function getFacebookConfigs()
    {
        $config = $this->getConfigSingleton();
        $facebookConfigs = array(
            'app_id' => $config->getApiId(),
            'app_secret' => $config->getApiSecret(),
            'default_graph_version' => $config->getDefaultGraphVersion(),
        );

        return $facebookConfigs;
    }

    /**
     * @return string
     */
    public function getCallbackLoginUrl()
    {
        return $this->getUrlModel()->getUrl(self::FACEBOOK_CALLBACK_LOGIN_URL);
    }

    /**
     * @return Alaa_FacebookConnect_Model_Config
     */
    public function getConfigSingleton()
    {
        return Mage::getSingleton('alaa_facebookconnect/config');
    }

    /**
     * @return Mage_Core_Model_Url
     */
    public function getUrlModel()
    {
        return Mage::getSingleton('core/url');
    }
}