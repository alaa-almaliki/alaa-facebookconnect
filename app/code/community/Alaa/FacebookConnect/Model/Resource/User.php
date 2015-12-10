<?php
/**
 * Class Alaa_FacebookConnect_Model_Resource_User
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Model_Resource_User extends
    Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('alaa_facebookconnect/user', 'entity_id');
    }

    /**
     * @param Alaa_FacebookConnect_Model_User $user
     * @param array $field
     * @return $this
     * @throws Exception
     */
    public function loadBy(Alaa_FacebookConnect_Model_User $user, $field)
    {
        $isValidField = isset($field['property']) && isset($field['value']);
        if (!$isValidField) {
            throw new Exception('Field property or value are not set.');
        }

        $adapter = $this->_getReadAdapter();
        $bind    = array($field['property'] => $field['value']);
        $select  = $adapter->select()
            ->from($this->getMainTable(), array($this->getIdFieldName()))
            ->where("{$field['property']} = :{$field['property']}");

        if (!$user->hasData('store_id')) {
            $user->setData('store_id', $this->getMageApp()->getStore()->getId());
        }
        $bind['store_id'] = (int)$user->getData('store_id');
        $select->where('store_id = :store_id');

        $userId = $adapter->fetchOne($select, $bind);
        if ($userId) {
            $this->load($user, $userId);
            Mage::dispatchEvent('alaa_facebookconnect_user_load', array('user' => $user));
        } else {
            $user->setData(array());
        }

        return $this;
    }

    /**
     * @param Alaa_FacebookConnect_Model_User $user
     * @param string $field
     * @return Alaa_FacebookConnect_Model_Resource_User
     * @throws Exception
     */
    public function loadByEmail(Alaa_FacebookConnect_Model_User $user, $field)
    {
        return $this->loadBy(
            $user,
            array('property' => 'email', 'value' => $field)
        );
    }

    /**
     * @param Alaa_FacebookConnect_Model_User $user
     * @param string $field
     * @return Alaa_FacebookConnect_Model_Resource_User
     * @throws Exception
     */
    public function loadByFacebookId(Alaa_FacebookConnect_Model_User $user, $field)
    {
        return $this->loadBy(
            $user,
            array('property' => 'user_id', 'value' => $field)
        );
    }

    /**
     * @return Mage_Core_Model_App
     */
    protected function getMageApp()
    {
        return Mage::app();
    }
}