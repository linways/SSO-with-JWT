<?php
/**
 * For demonstration SSO will serve as the database of partners
 * For real implementation this will come from a database.
 * Both partnerId and key should be shared between services.
 */
 class SSO
 {
   const partners =  array(
     'abcd123' => array(              // this is the shared partner sso id
       'name' => 'Partner 1 inc.',
       'shared_key' => '5f4dcc3b5aa765d61d8327deb882cf99',
       'is_active' => true
     ),
      'abcd1234' => array(     // this is the shared partner sso id
        'name' => 'Partner 1 inc.',
        'shared_key' => '482c811da5d5b4bc6d497ffa98491e38',
        'is_active' => false
       )
   );
 }
