<?php
/**
 * Class Alaa_FacebookConnect_Model_Resource_User_Collection
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Model_Resource_User_Collection extends
    Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('alaa_facebookconnect/user');
    }
}