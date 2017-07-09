<h1>SSO using JWT - PHP example</h1><br />

Partner Data for demo: <br />
<pre>
partners =  array(
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
</pre>

To generate a token : <code>/sso/token/generate/{ssoId}</code><br />
To verify a token : <code>/sso/token/verify?ssoid={ssoId}&amp;jwt={token}</code><br />

Eg: <a href="/sso/token/generate/abcd123">Generate token for abcd123</a>
