<?php

/*@jheckdoc
    {
        "method" : "POST",
        "route" : "/login",
        "name":"User login",
        "description": "Login to get authorization token.",
        "params" : {
            "email" :{
                "type":"string",
                "description": "Enter E-mail address",
                "required" : true
            },
            "password" :{
                "type":"string",
                "description": "Enter Password",
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
