<?php

/**
 * Inside a parameter use
 *
 * "type":"bool"
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
            "is_active" :{
                "type":"bool",
                "description": "To get all active users only",
                "value": "false"
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
