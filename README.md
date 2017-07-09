# SSO with JWT
Approach to achieve single sign on (SSO) using JSON Web Tokens (JWT).

## JWT
A JSON Web Token (JWT) is a JSON object that is defined in RFC 7519 as a safe way to represent a set of information between two parties. The token is composed of a header, a payload, and a signature.  
To know more about JWT, visit: https://jwt.io/introduction/ and https://tools.ietf.org/html/rfc7519

## Approach
*Overall process flow for sso with jwt*
![sso approach](assets/sso_using_jwt.png)

In the above diagram `Service 1 (S1)` is the primary service which the user is already logged in.  
`Service 2 (S2)` is the external service the user want to login using SSO.  

<code>K<sub>sp1</sub></code> is the key shared between `S1` and `S2` and `{JWT}Ksp1` is the JSON Web Token signed using <code>K<sub>sp1</sub></code>.

Both `S1` and `S2` can maintain a database of partners  as follows.  

#### sso_partner 

|id|partner_name|shared_key|is_active|
|--|-----------|---------|-----------|
|46323| Service 2|5f4dcc3b5aa765d61d8327deb882cf99|true|
|26432|Serice 3| 482c811da5d5b4bc6d497ffa98491e38|false|

If required, each service can implement access control mechanisms for their partner services.

### JSON Web Token format  

JSON Web Tokens consist of three parts separated by dots (`.`), which are:
* Header
* Payload
* Signature

Therefore, a JWT typically looks like the following.  
`xxxxx.yyyyy.zzzzz`

More details about JWT can be found at: https://jwt.io/introduction/ and https://tools.ietf.org/html/rfc7519
#### Header
The header typically consists of two parts: the type of the token, which is JWT, and the hashing algorithm being used, such as HMAC SHA256 or RSA.  
Since we are relaying on a shared key the hashing algorithm will be `HS256` (HMAC with SHA256).  

Example:
```
{
  "alg": "HS256",
  "typ": "JWT"
}
```
Then, this JSON is Base64Url encoded to form the first part of the JWT.
#### Payload
The second part of the token is the payload, which contains the claims. Claims are statements about an entity (typically, the user) and additional metadata. Read more about different types of claims at https://jwt.io/introduction/#payload.

Example for standard payload used at Linways:
```
{
  "email": "abc@xyz.com",
  "uid": "USER_123",
  "iss": "linways.com",
  "exp": "unix_timestamp",
  "iat": "unix_timestamp",
  "aud": "partner_id",
  "rand": "random_string"
}
```
In the above example `email` is the email address of the user who request access to `S2`.
`uid` is the user id shared between `S1` and `S2`. This is optional and can be used in case email address is not available.  
`iss`, `exp`, `iat` and `aud` are issuer, expiration time, issued at and audience. (Notice that these claim names are only three characters long as JWT is meant to be compact). `rand` is an optional random string or number to increase the entropy of the payload (Which is not required in most cases).

The payload is then Base64Url encoded to form the second part of the JSON Web Token.


#### Signature  
To create the signature part you have to take the encoded header, the encoded payload, a secret, the algorithm specified in the header, and sign that.

Since we are using HMAC SHA256 algorithm, the signature will be created in the following way:
```
HMACSHA256(
  base64UrlEncode(header) + "." +
  base64UrlEncode(payload),
  secret)
```
In this case `secret` will be <code>K<sub>sp1</sub></code>.

An example JWT:
```
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6ImFiY0B4eXouY29tIiwidWlkIjoiMjQ1MzIiLCJpc3MiOiJsaW53YXlzLmNvbSIsImV4cCI6IjE0OTk1ODMwMzMiLCJpYXQiOiIxNTk5NTgzMDMzIiwiYXVkIjoicGFydG5lcl9pZCIsInJhbmQiOiJjcyNYc2VGIn0.SlANo59m17AYgEUhRM55YCFggA884Luqa6kJ3iMIqC0.

```

[Click Here](http://bit.ly/2tZbHNY) to view this token in JWT debugger.

### Auto login on service 2  
This generated token should be passed to the `S2`. Since JWT is compact we can pass it through URL, POST parameter or inside HTTP Authentication header.

When `S2` receives the token, it can verify the signature using the shared key <code>K<sub>sp1</sub></code>. Once the token is validated check `exp` and `iss`, `aud` to make sure the token is not expired and issuer and audience. When all these check are positive, the S2 can automatically login the user with this token.

## Libraries for Token Signing/Verification  
Since, JWT is very popular and well accepted, almost all programming languages have libraries to create and verify the token.  
You can find different libraries for handling JWT here: https://jwt.io/#libraries
