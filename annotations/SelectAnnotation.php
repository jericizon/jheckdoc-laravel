<?php

/**
 * Inside a parameter use
 *
 * "options": ["super-admin", "admin", "normal-user"]
 *
 */


/*@jheckdoc
    {
        "method" : "POST",
        "route" : "/v1/user-lists",
        "name":"User listing",
        "description": "Get list of users",
        "params" : {
            "email" :{
                "type":"string",
                "description": "Enter E-mail address",
                "required" : true
            },
            "role" :{
                "type":"string",
                "description": "Filter users by role",
                "options": ["super-admin", "admin", "normal-user"]
            },
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
