
# For demonstration this will serve as the database of partners
# For real implementation this will come from a database.
# Both partnerId and key should be shared between services.

partners = {
    'abcd123' : {     # this is partner ssoId (abcd123)
        'name': 'Partner 1 inc.',
         'shared_key' : '5f4dcc3b5aa765d61d8327deb882cf99',
         'is_active' : True
    },
    'abcd1234':{   # this is partner ssoId (abcd1234)
        'name' : 'Partner 2 inc.',
        'shared_key' : '482c811da5d5b4bc6d497ffa98491e38',
        'is_active' : False
    }
}
