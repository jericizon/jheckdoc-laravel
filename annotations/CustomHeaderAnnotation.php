<?php
/**
 * Inside a parameter use
 *
 * "headers"
 *
 */

/*@jheckdoc
    {
        "method" : "POST",
        "route" : "/v1/user-lists",
        "name":"User listing",
        "description": "Get list of users",
        "headers":{
            "Content-Type": {
                "required": true,
                "value":"application/x-www-form-urlencoded"
            },
            "Authorization": {
                "required": true,
                "placeholder": "Insert bearer token here..."
            }
        },
        "params" : {
            "email" :{
                "type":"string",
                "description": "Enter E-mail address",
                "required" : true
            }
        },
        "responses": {
            "200": {
                "description": "Success"
            },
            "400": {
                "description": "Bad request"
            },
            "401": {
                "description": "Unauthenticated"
            },
            "403": {
                "description": "Access Forbidden"
            },
            "404": {
                "description": "Not-found"
            }
        }
    }
*/
