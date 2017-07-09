from flask import Flask, request
from utils import getSSOPartnerById, generateToken, verifyToken

app = Flask(__name__)

@app.route('/sso/token/generate/<ssoId>')
def generateTokenController(ssoId):
    try:
        partner = getSSOPartnerById(ssoId)
        # Check the user is logged in and have required permissions here
        jwt = generateToken(ssoId, partner['shared_key'])

        # Generating the response
        response ='''
        <b>Generated Token :</b><br/>
        <pre>
        {jwt}
        </pre>
        <a href="/sso/token/verify?ssoid={ssoId}&jwt={jwt}">Click Here</a> to verify the token.<br/>
        This should be done at the partner service.
        '''.format(jwt=jwt, ssoId=ssoId)
        return response
    except Exception as e:
        return str(e)

@app.route('/sso/token/verify')
def verifyTokenController():
    # getting data from query params
    ssoId = request.args.get('ssoid')
    jwt = request.args.get('jwt')
    try:
        token = verifyToken(ssoId, jwt)

        # Creating the response
        response = '''
        <b>Token verified: </b><br/>
        {token}
        '''.format(token=str(token))
        return response
    except Exception as e:
        return str(e)


@app.route('/')
def index():
    response = '''
    <h1>SSO using JWT - Python example</h1><br />

    Partner Data for demo: <br />
    <pre>
    partners = {
        'abcd123' : {     # this is partner ssoId
            'name': 'Partner 1 inc.',
             'shared_key' : '5f4dcc3b5aa765d61d8327deb882cf99',
             'is_active' : True
        },
        'abcd1234':{
            'name' : 'Partner 2 inc.',
            'shared_key' : '482c811da5d5b4bc6d497ffa98491e38',
            'is_active' : False
        }
    }

    </pre>

    To generate a token : <code>/sso/token/generate/{ssoId}</code><br />
    To verify a token : <code>/sso/token/verify?ssoid={ssoId}&amp;jwt={token}</code><br />

    Eg: <a href="/sso/token/generate/abcd123">Generate token for abcd123</a>
    '''
    return response
