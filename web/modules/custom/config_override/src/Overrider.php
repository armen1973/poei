<?php

 namespace Drupal\config_override;

 use Drupal\Core\Config\ConfigFactoryOverrideInterface;
 use Drupal\Core\Config\StorageInterface;
 use Drupal\Core\Session\AccountProxyInterface;

 class Overrider implements ConfigFactoryOverrideInterface {
     /**
      * @var
      */
     protected $current_user;

     /**
      * Overrider constructor.
      * @param $current_user
      */
     public function __construct (AccountProxyInterface $current_user)
     {
         $this->current_user = $current_user;
     }

     /**
      * @param array $names
      * @return array
      */
     public function loadOverrides($names)
     {
         if(in_array('system.site', $names)) {
             if($this->current_user->isAnonymous()) {
                 $names['system.site']['name'] = t('Development ANON');
             } else {
                $names['system.site']['name'] = t('Development AUTH');
             }

         }
         return $names;
         // TODO: Implement loadOverrides() method.
     }

     /**
      * @return string|void
      */
     public function getCacheSuffix()
     {
         // TODO: Implement getCacheSuffix() method.
     }

     public function createConfigObject($name, $collection = StorageInterface::DEFAULT_COLLECTION)
     {
         // TODO: Implement createConfigObject() method.
     }

     public function getCacheableMetadata($name)
     {
         // TODO: Implement getCacheableMetadata() method.
     }

 }