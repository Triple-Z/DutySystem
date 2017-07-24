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
- Employee
- Record (For employees)
- ActionRecord (For admins)

## Controller

- Controller
- IndexController
- HomeController
- RouteController
- EmployeeController

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
- GET `/correct`: 返回数据修正界面
- GET `/export`: 返回导出excel界面
- GET `/holiday`： 返回节假日编辑界面
- GET `/timeedit`: 返回有效时间编辑界面

- GET `/employees/{id}`: 返回某个指定雇员信息
- GET `/employees/{id}/records`: 返回某个指定雇员的签到记录

- GET `/admin/actions`: 返回当前管理员操作信息
- GET `/admin/actions/{id}`: 返回某个指定管理员的操作信息

- POST `/admin/resetpassword` 重置管理员密码


## Database tables

|symbol	|means		|
|:---:	|:-----:	|
|\*		|primary key|
|^		|foreign key|

### table name: `employees`

columns:
|ID*	|name	|gender	|eamil	|phone_number	|work_title	|department	|car_number	|
|----|----|----|----|----|----|----|----|
|1|TripleZ|man|me@triplez.cn|15240241051|CEO|Develop Department|null|


### table names: `records`

columns:
|ID*	|employee_id^	|check_direction(Y/N)	|check_method	|check_time	|
|----|----|----|----|---|
|1|3|1|card|2017-07-21 13:22:13|
|2|3|0|card|2017-07-21 17:22:13|
|3|1|1|car|2017-07-22 07:22:13|
|4|1|0|car|2017-07-22 12:22:13|



### table name: `users`

columns:
|ID*	|name	|email	|password	|admin(Y/N)	|phone_number	|created_at|updated_at|
|-----|----|----|----|-----|-----|----|----|
|1|TripleZ|me@triplez.cn|******|1|15240241051|
|2|test|test@triplez.cn|******|0|88888888|


### table name: `user_action_records`

columns:
|ID*	|user_id^	|action	|timestamp	|
|-----|----|----|----|
|1|1|login|2017-07-23 15:47:35|
|2|1|logout|2017-07-23 15:47:39|

## Migrations

- 2014_10_12_000000_create_users_table
- 2014_10_12_100000_create_password_resets_table
- 2017_07_22_053844_create_employees_table
- 2017_07_23_074658_create_records_table
- 2017_07_23_142002_create_login_records_table

## Seeds

填充假数据

- EmployeeSeeder
- RecordSeeder
- ActionRecordSeeder

```bash
composer dump-autoload
php artisan db:seed
```

记得将需要 seed 的数据在 `database/seeds/DatabaseSeeder.php` 中注册。


## Check In

签到

## Check Out

签出

## Refresh Frequency

刷新频率


## note
#### Error message:
```
$ php artisan migrate
Migration table created successfully.


  [Illuminate\Database\QueryException]
  SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was t
  oo long; max key length is 1000 bytes (SQL: alter table `users` add unique
  `users_email_unique`(`email`))

  [PDOException]
  SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was t
  oo long; max key length is 1000 bytes
```
#### Solution
in file: `config\database.php`

```
'charset' => 'utf8mb4',
'collation' => 'utf8mb4_unicode_ci',
'engine' => 'InnoDB ROW_FORMAT=DYNAMIC',
```

## Web-view Layouts Design

#### general page

function:display all the records ordered by time stamp

demand:
1. day/week/month
2. export as excel
3. correct records
4. search by employee name

view structure:
```
   _____________________________
  |                     export  |
  |display option | search box  |
  |-----------------------------|
  |records                      |
  |record 1              correct|
  |record 2              correct|
  |   .                     .   |
  |   .                     .   |
  |_____________________________|
```


#### graph page

function: build a calendar, and display each employee duty status.

demand:

1. a calendar can show as day/week/month.
2. mark up the time/date that has record

view structure:
```
   _____________________________
  |                             |
  |display option | search box  |
  |-----------------------------|
  |calendar option              |
  |   .                     .   |
  |   .                     .   |
  |   .     calendar        .   |
  |   .                     .   |
  |_____________________________|
```


#### valid records

function: display all records by day.

demand:

1. display single record(included in and out) of each employee devided by day
2. should include arrive&leave time,also,a status indicate valid(invalid) should be shown

view structure:
```
   _____________________________
  |                     export  |
  |       | search box  |       |
  |-----------------------------|
  |records        status        |
  |record 1          Y   correct|
  |record 2          Y   correct|
  |   .                     .   |
  |      pagination by day      |
  |_____________________________|
```


#### holiday page(option)

function: mark up holiday.

demand:

1. decide which day has no duty
2. mark up the time/date in the calendar view

view structure:
```
   _____________________________
  |                             |
  |        ????????????         |
  |-----------------------------|
  |calendar option              |
  |   .                     .   |
  |   .                     .   |
  |   .     calendar        .   |
  |   .                     .   |
  |_____________________________|
```


#### timeedit page

function:define legal time

demand:

1. define valid time of records

view structure:
```
   _____________________________
  |                             |
  |        ????????????         |
  |-----------------------------|
  |                             |
  |   .                     .   |
  |   .      post form      .   |
  |   .                     .   |
  |   .                     .   |
  |_____________________________|
```



# Copyright

版权信息

Copyright (c) 2017 [TripleZ](https://triplez.cn) [foxnuaaer](http://403forbidden.website)

