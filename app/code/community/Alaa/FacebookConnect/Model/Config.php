<?php
/**
 * Class Alaa_FacebookConnect_Model_Config
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Model_Config
{

    const DEFAULT_GRAPH_VERSION = 'v2.5';

    /** General Settings/configs */
    const XML_PATH_Facebook_CONFIG_ACTIVE                   = 'alaa_facebookconnect/config/active';
    const XML_PATH_FACEBOOK_CONFIG_PUBLIC_PROFILE           = 'alaa_facebookconnect/config/public_profile';
    const XML_PATH_FACEBOOK_CONFIG_USER_PROPERTIES          = 'alaa_facebookconnect/config/user_properties';
    const XML_PATH_FACEBOOK_CONFIG_PERMISSIONS              = 'alaa_facebookconnect/config/permissions';
    const XML_PATH_FACEBOOK_CONFIG_PERMISSIONS_DEPRECATED   = 'alaa_facebookconnect/config/permissions_deprecated';

    /** Alaa Credentials */
    const XML_PATH_FACEBOOK_API_ID                          = 'alaa_facebookconnect/credentials/api_id';
    const XML_PATH_FACEBOOK_API_SECRET                      = 'alaa_facebookconnect/credentials/api_secret';
    const XML_PATH_FACEBOOK_DEFAULT_GRAPH_VERSION           = 'alaa_facebookconnect/credentials/default_graph_version';

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->getConfigData(self::XML_PATH_Facebook_CONFIG_ACTIVE, $this->getAppStoreId());
    }

    /**
     * @return string
     */
    public function getUserProperties()
    {
        return $this->getConfigData(self::XML_PATH_FACEBOOK_CONFIG_USER_PROPERTIES, $this->getAppStoreId());
    }

    /**
     * @return string
     */
    public function getApiId()
    {
        return $this->getConfigData(self::XML_PATH_FACEBOOK_API_ID, $this->getAppStoreId());
    }

    /**
     * @return string
     */
    public function getApiSecret()
    {
        return $this->getConfigData(self::XML_PATH_FACEBOOK_API_SECRET, $this->getAppStoreId());
    }

    /**
     * @return string
     */
    public function getDefaultGraphVersion()
    {
        $defaultGraphVersion =  $this->getConfigData(
            self::XML_PATH_FACEBOOK_DEFAULT_GRAPH_VERSION,
            $this->getAppStoreId()
        );

        if (!$defaultGraphVersion) {
            $defaultGraphVersion = self::DEFAULT_GRAPH_VERSION;
        }

        return $defaultGraphVersion;
    }

    /**
     * @return string
     */
    public function getPermissions()
    {
        return $this->getConfigData(self::XML_PATH_FACEBOOK_CONFIG_PERMISSIONS, $this->getAppStoreId());
    }

    /**
     * @return string
     */
    public function getPermissionsDeprecated()
    {
        return $this->getConfigData(self::XML_PATH_FACEBOOK_CONFIG_PERMISSIONS_DEPRECATED, $this->getAppStoreId());
    }

    /**
     * @param string $path
     * @param int $storeId
     * @return string
     */
    public function getConfigData($path, $storeId = null)
    {
        return Mage::getStoreConfig($path, $storeId);
    }

    /**
     * @return int
     */
    public function getAppStoreId()
    {
        return Mage::app()->getStore()->getId();
    }
}