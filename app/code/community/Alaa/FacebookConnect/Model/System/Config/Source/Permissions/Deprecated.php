<?php
/**
 * Class Alaa_FacebookConnect_Model_System_Config_Source_Permissions_Deprecated
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Model_System_Config_Source_Permissions_Deprecated
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $ops = array();

        foreach ($this->toArray() as $value => $label) {
            $ops[] = array(
                'label' => $label,
                'value' => $value,
            );
        }

        return $ops;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $permissions = array(
            'manage_notifications'  => $this->getHelper()->__('Manage Notifications'),
            'read_stream'           => $this->getHelper()->__('Read Stream'),
            'read_mailbox'          => $this->getHelper()->__('Read Mailbox'),
            'user_groups'           => $this->getHelper()->__('User Groups'),
            'user_status'           => $this->getHelper()->__('User Status'),
        );

        return $permissions;
    }

    /**
     * @return Alaa_FacebookConnect_Helper_Data
     */
    public function getHelper()
    {
        return Mage::helper('alaa_facebookconnect');
    }
}