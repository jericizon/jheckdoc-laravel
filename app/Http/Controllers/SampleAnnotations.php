<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class SampleAnnotations extends Controller
{

    /*@jheckdocInfo
    {
        "version": "1.0.0",
        "title":"Jheck doc info",
        "description" : "Sample description of api",
        "contact" : "support@jheckdoc.com",
        "servers": [
            {
                "url" : "https://jheckdoc-laravel-demo.herokuapp.com",
                "description": "Demo server"
            }
        ]
    }
    */

    /*@jheckdoc
    {
        "name":"Login post",
        "route" : "/users/login",
        "method" : "POST",
        "description": "Login description",
        "headers":{
            "Content-Type": {
                "required": true,
                "value":"application/x-www-form-urlencoded"
            }
        },
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
                "description": "This is success response"
            },
            "401": {
                "description": "Unauthorized"
            },
            "404": {
                "description": "Not-found"
            }
        }
    }
    */

    /*@jheckdoc
    {
        "name":"Login get",
        "route" : "/users/login",
        "method" : "GET",
        "description": "Login with get method",
        "headers":{
            "Content-Type": {
                "required": true,
                "value":"application/x-www-form-urlencoded"
            }
        },
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
                "description": "This is success response"
            },
            "401": {
                "description": "Unauthorized"
            },
            "404": {
                "description": "Not-found"
            }
        }
    }
    */

    /*@jheckdoc
    {
        "name":"Register",
        "group":"user",
        "route" : "/register",
        "method" : "POST",
        "description": "Register description",
        "headers":{
            "Content-Type": {
                "required": true,
                "value":"application/x-www-form-urlencoded"
            }
        },
        "params" : {
            "email" :{
                "type":"string",
                "required" : true
            },
            "password" :{
                "type":"string",
                "required" : true
            },
            "remember" :{
                "type":"bool",
                "required" : false
            }
        }
    }
    */

}
