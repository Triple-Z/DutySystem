# DutySystem

A duty system for Drone Institution of NUAA.


# Runtime Enviornment

运行环境

|Enviornment	|Version	|
|:-----------:	|:-------:	|
|Laravel		|5.4		|
|PHP			|7.0.10		|
|MySQL			|5.7.17		|
|Nginx			|1.11.9		|

## Initialize

系统初始化

```
php artisan key:generate
php artisan make:auth
php artisan migrate
```

## MySQL authentication

> account: `homestead`
> 
> password: `secret`

# Service Logic

业务逻辑

## Model

- User

## Controller

- Controller
- HomeController
- SuperHomeController

Auth
- RegisterController
- LoginController
- ForgetPasswordController
- ResetPasswordController

## Middleware

- EncryptCookies
- RedirectIfAuthenticated
- TrimStrings
- VerifyCsrfToken

## API

- GET /: 返回认证状态
- GET /home: 返回普通管理员登录结果
- GET /superhome: 返回超级管理员登录结果

## Personal Information

个人信息 (增删查补)
table name: `person_info`

columns:
> ID* name gender work_title department first_time_work car_number

--------

table names: `person_record_---`(id)

columns:
> ID* personal_id^ checkin_condition(Y/N)

* primary key
^ foreign key

## User

用户(管理员)

table name: `users`

columns:
> ID* name email password admin(Y/N)

## Check In

签到

## Check Out

签出

## Refresh Frequency

刷新频率

# Copyright

版权信息

Copyright (c) 2017 [TripleZ](https://triplez.cn) [foxnuaaer](http://403forbidden.website)