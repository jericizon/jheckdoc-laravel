<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        "headers":{},
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

    public function userLogin(Request $req)
    {
        $req->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sample user found',
            'results' => [
                'email' => $req->email,
                'password' => $req->password,
            ]
        ]);
    }

    /*@jheckdoc
    {
        "name":"Get user details",
        "route" : "/users/details",
        "method" : "GET",
        "description": "Get user details",
        "headers":{},
        "params" : {
            "email" :{
                "type":"string",
                "description": "Enter E-mail address",
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

    public function userDetails($email)
    {
        return response()->json([
            'success' => true,
            'message' => 'Sample user found',
            'results' => [
                'email' => $email,
            ]
        ]);
    }

    /*@jheckdoc
    {
        "name":"Register",
        "group":"user",
        "route" : "/register",
        "method" : "POST",
        "description": "Register description",
        "headers":{},
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

    public function userRegister(Request $req)
    {
        $req->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Demo register user',
            'results' => [
                'email' => $req->email,
                'password' => $req->password,
                'remember' => (bool) $req->remember,
            ]
        ]);
    }
}
