<p align="center"><a href="https://github.com/jericizon/jheckdoc-laravel" target="_blank" rel="noopener noreferrer"><img width="150" src="https://github.com/jericizon/jheckdoc-laravel/blob/master/assets/logo/jheckdoc-logo.jpg" alt="JheckDoc Laravel logo"></a></p>

<h2 align="center">Jheckdoc laravel</h2>

<p align="center">
    <a href="https://github.com/tterb/atomic-design-ui/blob/master/LICENSEs" target="_blank"><img src="https://img.shields.io/apm/l/atomic-design-ui.svg?" alt="MIT License"></a>
    <a href="#" target="_blank"><img src="https://img.shields.io/github/last-commit/google/skia.svg?style=flat" alt="GitHub last commit"></a>
</p>


<p align="center">Simple laravel api document generator</p>

<br>
<br>

<p align="center"><img width="800" src="https://github.com/jericizon/jheckdoc-laravel/blob/master/assets/jheckdoc-preview.jpg" alt="Dashboard preview"></p>

## Demo page:

https://jheckdoc-laravel-demo.herokuapp.com/api/documentation

## Installation

You can install the package via composer

```bash
composer require jheckdoc/jheckdoc-laravel
```

## Usage

Generate json file
```bash
php artisan jheckdoc:generate
```

### Publish config files

```bash
$ php artisan vendor:publish --tag=jheckdoc-config
```

### Parameters

| Name                  |  Type  |  Description |
| --------------------- | ------ |--------------|
| `@jheckdocInfo`       | String | TThis is required for details of api documentation. [Sample header](annotations/ApiInformation.php) |
| `@jheckdoc`           | String | This is required to add on top of each codeblocks. [Sample annotation](annotations/BasicAnnotation.php) |
| `method`              | String | Your desired route method, Sample `GET`, `POST`, `PUT`, `DELETE`, `OPTIONS` |
| `route`               | String | Your api endpoint. Note: no need to put the full url |
| `name`                | String | Enter desired name for your endpoint |
| `description`         | String | Description of your endpoint |
| `headers`             | Object | For custom headers |
| `params`              | Object | Enter parameters for your endpoint |
| `responses`           | Object | Server responses |


### Api documentation detail information (required)

```bash
/*@jheckdocInfo
{
    "version": "1.0.0",
    "title":"Jheckdoc API",
    "description" : "Sample description of api",
    "contact" : "hello@jheckdoc.com",
    "servers": [
        {
            "url" : "https://jheckdoc.com",
            "description": "Production api server"
        },
        {
            "url" : "https://dev.jheckdoc.com",
            "description": "Development api server"
        }
    ]
}
*/
```

### Sample annotation

Each code block requires a valid json format.
Please see [Sample annotations](annotations) for more.

```bash
/*@jheckdoc
    {
        "method" : "POST",
        "route" : "/v1/users/login",
        "name":"User login",
        "description": "Login to get authorization token.",
        "group":"user",
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
                "description": "Success"
            },
            "401": {
                "description": "Unauthenticated"
            }
        }
    }
*/
```

### View api docs (default)

http://localhost:8000/api/documentation


### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, pelase use [issue tracker](../../issues).

## Credits

- [Jeric Izon](https://github.com/jheckdoc)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

Copyright (c) 2020, Jeric

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
