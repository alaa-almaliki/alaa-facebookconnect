<?php

$configs = array(
    array(
        'path'  => 'alaa_facebookconnect/config/active',
        'value' => 1,
    ),
    array(
        'path'  => 'alaa_facebookconnect/config/user_properties',
        'value' => 'id,email,first_name,last_name,age_range,link,gender,locale,timezone,updated_time,verified',
    ),
    array(
        'path'  => 'alaa_facebookconnect/config/permissions',
        'value' => 'public_profile,email',
    ),
);


foreach ($configs as $config) {
    Mage::getModel('core/config')->saveConfig(
        $config['path'],
        $config['value']
    );
}