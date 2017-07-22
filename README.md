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

- Auth
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

- GET `/`: 返回认证状态
- GET `/home`: 返回普通管理员登录界面
- GET `/superhome`: 返回超级管理员登录界面
- GET `/graph`: 返回图表界面
- GET `/correct`: 返回？？界面
- GET `/export`: 返回？？界面
- GET `/holiday`： 返回？？界面
- GET `/timeedit`: 返回有效时间编辑界面

## Personal Information

个人信息 (增删查补)

table name: `employees`

columns:
|ID*	|name	|gender	|eamil	|phone_number	|work_title	|department	|car_number	|
|----|----|----|----|----|----|----|----|
|1|TripleZ|man|me@triplez.cn|15240241051|CEO|Develop Department|null|


--------

table names: `person_record_---`(id)

columns:
|ID*	|person_id^	|check_direction(Y/N)	|check_method	|check_time	|
|----|----|----|----|---|
|1|1|1|card|2017-07-21 13:22:13|
|2|1|0|card|2017-07-21 17:22:13|
|3|1|1|car|2017-07-22 07:22:13|
|4|1|0|car|2017-07-22 12:22:13|

|symbol	|means		|
|:---:	|:-----:	|
|\*		|primary key|
|^		|foreign key|

## User

用户(管理员)

table name: `users`

columns:
|ID*	|name	|email	|password	|admin(Y/N)	|phone_number	|created_at|updated_at|
|-----|----|----|----|-----|-----|----|----|
|1|TripleZ|me@triplez.cn|******|1|15240241051|
|2|test|test@triplez.cn|******|0|88888888|

## Check In

签到

## Check Out

签出

## Refresh Frequency

刷新频率

# Copyright

版权信息

Copyright (c) 2017 [TripleZ](https://triplez.cn) [foxnuaaer](http://403forbidden.website)