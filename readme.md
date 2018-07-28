# Gateid - Lumen API Gateway

[![Latest Stable Version](https://poser.pugx.org/harunnryd/gateid/v/stable)](https://packagist.org/packages/harunnryd/gateid)
[![Total Downloads](https://poser.pugx.org/harunnryd/gateid/downloads)](https://packagist.org/packages/harunnryd/gateid)
[![Latest Unstable Version](https://poser.pugx.org/harunnryd/gateid/v/unstable)](https://packagist.org/packages/harunnryd/gateid)
[![License](https://poser.pugx.org/harunnryd/gateid/license)](https://packagist.org/packages/harunnryd/gateid)

## What is an API Gateway?

> *An API Gateway sits in front of your application(s) and/or services and manages the heavy lifting of authorisation, access control and throughput limiting to your services. Ideally, it should mean that you can focus on creating services instead of implementing management infrastructure. For example, if you have written a really awesome web service that provides geolocation data for all the cats in NYC, and you want to make it public, integrating an API gateway is a faster, more secure route than writing your own authorisation middleware.*

## Requirements and dependencies

- PHP >= 7.0
- Lumen 5.6
- Guzzle 6
- Laravel Passport (with [Lumen Passport](https://github.com/dusterio/lumen-passport))
- Spatie Permission (with [Spatie Permission] (https://github.com/spatie/laravel-permission)

## How it works!

```
$ composer install
$ php artisan passport:install
$ vim storage/app/routes.json
```
> if you need to use Oauth2 (Passport) please tag oauth:api on middleware

```json
# example routes.json

{
    "global": {
        "domain": "54.169.181.142:7002"
    },
    "routes": [
        {
            "description": "get specific role",
            "method": "get",
            "middleware": ["auth:api"],
            "path": "/api/v2/roles/{id}",
            "actions": [
                {
                    "method": "get",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/roles/{id}",
                    "outputKey": "role"
                }
            ]
        },
        {
            "description": "get all roles",
            "method": "get",
            "middleware": ["auth:api"],
            "path": "/api/v2/roles",
            "actions": [
                {
                    "method": "get",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/roles",
                    "outputKey": "roles"
                }
            ]
        },
        {
            "description": "create role",
            "method": "post",
            "middleware": ["auth:api"],
            "path": "/api/v2/roles",
            "actions": [
                {
                    "method": "post",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/roles",
                    "outputKey": "role"
                }
            ]
        },
        {
            "description": "update role",
            "method": "patch",
            "middleware": ["auth:api"],
            "path": "/api/v2/roles/{id}",
            "actions": [
                {
                    "method": "patch",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/roles/{id}",
                    "outputKey": "role"
                }
            ]
        },
        {
            "description": "delete role",
            "method": "delete",
            "middleware": ["auth:api"],
            "path": "/api/v2/roles/{id}",
            "actions": [
                {
                    "method": "delete",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/roles/{id}",
                    "outputKey": "role"
                }
            ]
        },
        {
            "description": "get specific permission",
            "method": "get",
            "middleware": ["auth:api"],
            "path": "/api/v2/permissions/{id}",
            "actions": [
                {
                    "method": "get",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/permissions/{id}",
                    "outputKey": "permission"
                }
            ]
        },
        {
            "description": "get all permission",
            "method": "get",
            "middleware": ["auth:api"],
            "path": "/api/v2/permissions",
            "actions": [
                {
                    "method": "get",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/permissions",
                    "outputKey": "permissions"
                }
            ]
        },
        {
            "description": "create permission",
            "method": "post",
            "middleware": ["auth:api"],
            "path": "/api/v2/permissions",
            "actions": [
                {
                    "method": "post",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/permissions",
                    "outputKey": "permission"
                }
            ]
        },
        {
            "description": "update permission",
            "method": "patch",
            "middleware": ["auth:api"],
            "path": "/api/v2/permissions/{id}",
            "actions": [
                {
                    "method": "patch",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/permissions/{id}",
                    "outputKey": "permission"
                }
            ]
        },
        {
            "description": "delete permission",
            "method": "delete",
            "middleware": ["auth:api"],
            "path": "/api/v2/permissions/{id}",
            "actions": [
                {
                    "method": "delete",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/permissions/{id}",
                    "outputKey": "permission"
                }
            ]
        },
        {
            "description": "attach role to user",
            "method": "patch",
            "middleware": ["auth:api"],
            "path": "/api/v2/users/{id}/roles",
            "actions": [
                {
                    "method": "patch",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/users/{id}/roles",
                    "outputKey": "user"
                }
            ]
        },
        {
            "description": "detach role to user",
            "method": "delete",
            "middleware": ["auth:api"],
            "path": "/api/v2/users/{id}/roles",
            "actions": [
                {
                    "method": "delete",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/users/{id}/roles",
                    "outputKey": "user"
                }
            ]
        },
        {
            "description": "attach permission to user",
            "method": "patch",
            "middleware": ["auth:api"],
            "path": "/api/v2/users/{id}/permissions",
            "actions": [
                {
                    "method": "patch",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/users/{id}/permissions",
                    "outputKey": "user"
                }
            ]
        },
        {
            "description": "detach permission to user",
            "method": "delete",
            "middleware": ["auth:api"],
            "path": "/api/v2/users/{id}/permissions",
            "actions": [
                {
                    "method": "delete",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/users/{id}/permissions",
                    "outputKey": "user"
                }
            ]
        },
        {
            "description": "get all role by user",
            "method": "get",
            "middleware": ["auth:api"],
            "path": "/api/v2/users/{id}/roles",
            "actions": [
                {
                    "sequence": 0,
                    "method": "get",
                    "hostname": "54.169.181.142:7004",
                    "service": "",
                    "path": "/account/v2/users/{id}",
                    "outputKey": "user"
                },
                {
                    "sequence": 0,
                    "method": "get",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/users/{id}/roles",
                    "outputKey": "user.roles"
                }
            ]
        },
        {
            "description": "get all permission by role",
            "method": "get",
            "middleware": ["auth:api"],
            "path": "/api/v2/roles/{id}/permissions",
            "actions": [
                {
                    "sequence": 0,
                    "method": "get",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/api/v2/roles/{id}",
                    "outputKey": "role"
                },
                {
                    "sequence": 0,
                    "method": "get",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/roles/{id}/permissions",
                    "outputKey": "role.permissions"
                }
            ]
        },

        {
            "description": "get all user by role",
            "method": "get",
            "middleware": ["auth:api"],
            "path": "/api/v2/roles/{id}/users",
            "actions": [
                {
                    "sequence": 0,
                    "method": "get",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/api/v2/roles/{id}",
                    "outputKey": "role"
                },
                {
                    "sequence": 1,
                    "method": "get",
                    "hostname": "54.169.181.142:7003",
                    "service": "",
                    "path": "/rbac/v2/roles/{id}/users",
                    "outputKey": "role.users"
                }
            ]
        },
        {
            "description": "register user",
            "method": "post",
            "middleware": [],
            "path": "/api/v2/users",
            "actions": [
                {
                    "method": "post",
                    "hostname": "54.169.181.142:7004",
                    "service": "",
                    "path": "/account/v2/users",
                    "outputKey": "user"
                }
            ]
        },
        {
            "description": "delete user",
            "method": "delete",
            "middleware": [],
            "path": "/api/v2/users/{id}",
            "actions": [
                {
                    "method": "delete",
                    "hostname": "54.169.181.142:7004",
                    "service": "",
                    "path": "/account/v2/users/{id}",
                    "outputKey": "user"
                }
            ]
        },
        {
            "description": "update user",
            "method": "patch",
            "middleware": ["auth:api"],
            "path": "/api/v2/users/{id}",
            "actions": [
                {
                    "method": "patch",
                    "hostname": "54.169.181.142:7004",
                    "service": "",
                    "path": "/account/v2/users/{id}",
                    "outputKey": "user"
                }
            ]
        },
        {
            "description": "get user",
            "method": "get",
            "middleware": ["auth:api"],
            "path": "/api/v2/users/{id}",
            "actions": [
                {
                    "sequence": 0,
                    "method": "get",
                    "hostname": "54.169.181.142:7004",
                    "service": "",
                    "path": "/account/v2/users/{id}",
                    "outputKey": "user"                    
                }
            ]
        },
        {
            "description": "get user self",
            "method": "get",
            "middleware": ["auth:api"],
            "path": "/api/v2/self-users",
            "actions": [
                {
                    "sequence": 0,
                    "method": "get",
                    "hostname": "54.169.181.142:7004",
                    "service": "",
                    "path": "/account/v2/self-users",
                    "outputKey": "user"                    
                }
            ]
        },
        {
            "description": "get user",
            "method": "get",
            "middleware": ["auth:api"],
            "path": "/api/v2/users",
            "actions": [
                {
                    "sequence": 0,
                    "method": "get",
                    "hostname": "54.169.181.142:7004",
                    "service": "",
                    "path": "/account/v2/users",
                    "outputKey": "users"                    
                }
            ]
        },
        {
            "description": "get location point",
            "method": "post",
            "middleware": ["auth:api"],
            "path": "/api/v2/location-points",
            "actions": [
                {
                    "sequence": 0,
                    "method": "post",
                    "hostname": "54.169.181.142:7006",
                    "service": "",
                    "path": "/reservation/v2/location-points",
                    "outputKey": "location_points"                    
                }
            ]
        }
    ]
}
```

## Security Vulnerabilities

> If you discover a security vulnerability within Gateid, please send an e-mail to harun nur rasyid at **harunwols@gmail.com**. All security vulnerabilities will be promptly addressed.

## License

> Gateid is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

