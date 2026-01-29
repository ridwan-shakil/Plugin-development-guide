## there are sevarel plugin for creating api authentication 
### 1) Basic Auth
        install basic auth plugin : https://github.com/WP-API/Basic-Auth
        open postman > Authentication > set Basic auth > give wp id , password
        make API requests
        
### 2) JWT Authentication
    1) JWT Authentication for WP-API
    2) enter only user name & password in postman [ just for practice ]

    -------------------------------
    JWT Authentication for WP-API
    -------------------------------
    create a POST request in this endpoint  :     /wp-json/jwt-auth/v1/token 
    ( send tis two paramiter with the request :   'username' = ridwan  , 'password' = ridwan )
    
    /wp-json/jwt-auth/v1/token/validate | POST
