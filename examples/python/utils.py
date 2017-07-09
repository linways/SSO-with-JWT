import jwt
from time import time

from partner_data import partners

"""
Returns the partner object of given partnerId
 Args:
    ssoId  Id of the partner
 Returns:
    The partner object
"""
def getSSOPartnerById(ssoId):
    if ssoId in partners and partners[ssoId]['is_active']:
        return partners[ssoId]
    raise Exception('partnerId not found or suspended')


"""
Generate JSON Web Token for partner service
 Args:
    ssoId  Id of the partner
    key    Shared key to sign the token
 Returns:
    encoded JWT
"""
def generateToken(ssoId, key):
    token ={
        'email': 'example@abc.com',
        'iss': 'https://linways.com',
        'exp': int(time() + (3*60)),
        'iat': int(time()),
        'aud': ssoId
    }
    return jwt.encode(token, key, algorithm='HS256')

"""
verify the token
 Args:
    ssoId  Id of the partner
    token  JWT from partner service
 Returns:
    Decoded token content if the token is valid
"""
def verifyToken(ssoId, token):
    partner = getSSOPartnerById(ssoId)

    return jwt.decode(token,
        partner["shared_key"],
        algorithms=['HS256'],
        audience=ssoId
        )
