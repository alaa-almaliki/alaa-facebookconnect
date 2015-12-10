<?php
/**
 * Class Alaa_FacebookConnect_Model_System_Config_Source_UserProfile
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Model_System_Config_Source_UserProfile
{
    /**
     * @return array
     */
    public function toArray()
    {
        $options = array(
            'id'            => $this->getHelper()->__('ID'),
            'email'         => $this->getHelper()->__('Email'),
            'first_name'    => $this->getHelper()->__('First Name'),
            'last_name'     => $this->getHelper()->__('Last Name'),
            'age_range'     => $this->getHelper()->__('Age Range'),
            'link'          => $this->getHelper()->__('Link'),
            'gender'        => $this->getHelper()->__('Gender'),
            'locale'        => $this->getHelper()->__('locale'),
            'timezone'      => $this->getHelper()->__('Timezone'),
            'updated_time'  => $this->getHelper()->__('Updated Time'),
            'verified'      => $this->getHelper()->__('Verified'),
        );

        return $options;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $ops = array();

        foreach ($this->toArray() as $value => $label) {
            $ops[] = array(
                'label'     => $label,
                'value'     => $value,
            );
        }

        return $ops;
    }

    /**
     * @return Alaa_FacebookConnect_Helper_Data
     */
    public function getHelper()
    {
        return Mage::helper('alaa_facebookconnect');
    }
}