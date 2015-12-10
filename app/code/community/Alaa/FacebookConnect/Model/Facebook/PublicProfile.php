<?php

/**
 * Class Alaa_FacebookConnect_Model_Facebook_PublicProfile
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Model_Facebook_PublicProfile
{
    /** default user properties */
    const DEFAULT_Facebook_USER_ID          = 'id';
    const DEFAULT_Facebook_USER_EMAIL       = 'email';
    const DEFAULT_Facebook_USER_FIRST_NAME  = 'first_name';
    const DEFAULT_Facebook_USER_LAST_NAME   = 'last_name';

    /**
     * @param \Facebook\Facebook $fb
     * @param $accessToken
     * @param $userProperties
     * @return \Facebook\FacebookResponse
     * @throws Exception
     */
    public function getMe(\Facebook\Facebook $fb, $accessToken, $userProperties)
    {
        $properties = explode(',', $userProperties);
        $properties = array_unique(
            array_merge($properties, $this->getDefaultUserProperties())
        );

        $fields = '?fields=' . implode(',', $properties);
        $endPoint = '/me';
        $endPoint .= $fields;

        return $this->get($fb, $endPoint, $accessToken);
    }

    /**
     * @param \Facebook\Facebook $fb
     * @param $endPoint
     * @param $accessToken
     * @return \Facebook\FacebookResponse
     * @throws Exception
     */
    protected function get(\Facebook\Facebook $fb, $endPoint, $accessToken)
    {
        if (is_null($fb)) {
            throw new \Exception('Null Facebook object');
        }

        if (!$endPoint) {
            throw new \Exception('No Endpoint provided.');
        }

        if (!$accessToken) {
            throw new \Exception('No Facebook Access Token');
        }

        return $fb->get($endPoint, $accessToken);
    }

    /**
     * @param \Facebook\Facebook $fb
     * @param $accessToken
     * @param $userProperties
     * @return array
     */
    public function getData(\Facebook\Facebook $fb, $accessToken, $userProperties)
    {
        $userProperties = $userProperties? $userProperties :
            implode(',', $this->getDefaultUserProperties());

        $data =  $this->getCoreHelper()->JsonDecode(
            $this->getMe($fb, $accessToken, $userProperties)->getBody()
        );

        return $this->modifyUserData($data);
    }

    /**
     * @param $data
     * @return array
     */
    public function modifyUserData(&$data)
    {
        if (array_key_exists('id', $data)) {
            $data['user_id']  = $data['id'];
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getDefaultUserProperties()
    {
        return array(
            self::DEFAULT_Facebook_USER_ID,
            self::DEFAULT_Facebook_USER_EMAIL,
            self::DEFAULT_Facebook_USER_FIRST_NAME,
            self::DEFAULT_Facebook_USER_LAST_NAME,
        );
    }

    /**
     * @return Mage_Core_Helper_Data
     */
    public function getCoreHelper()
    {
        return Mage::helper('core');
    }
}