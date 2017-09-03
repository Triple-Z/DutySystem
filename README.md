# DutySystem

A duty system for Drone Institution of NUAA.

<!-- TOC -->

- [DutySystem](#dutysystem)
- [Runtime Enviornment](#runtime-enviornment)
	- [Initialize](#initialize)
	- [MySQL authentication](#mysql-authentication)
	- [Cron Config](#cron-config)
- [Service Logic](#service-logic)
	- [Model](#model)
		- [Model Relationship](#model-relationship)
	- [Controller](#controller)
	- [Middleware](#middleware)
	- [Listener](#listener)
	- [API](#api)
	- [Database tables](#database-tables)
		- [table name: `employees`](#table-name-`employees`)
		- [table names: `records`](#table-names-`records`)
		- [table name: `users`](#table-name-`users`)
		- [table name: `user_action_records`](#table-name-`useractionrecords`)
	- [Migrations](#migrations)
	- [Seeds](#seeds)
	- [Schedule Tasks](#schedule-tasks)
	- [Artisan Command](#artisan-command)
	- [Employee Status](#employee-status)
	- [Important Timestamp](#important-timestamp)
		- [Default Timezone](#default-timezone)
	- [Scheduling task](#scheduling-task)
	- [Note](#note)
		- [Error message:](#error-message)
		- [Solution](#solution)
		- [Change Server Timezone](#change-server-timezone)
	- [Source Code rewrite](#source-code-rewrite)
		- [Modal Position](#modal-position)
		- [Position Method](#position-method)
	- [Web-view Layouts Design](#web-view-layouts-design)
		- [General Page](#general-page)
		- [Graph Page](#graph-page)
		- [Valid Records](#valid-records)
		- [Holiday Page (option)](#holiday-page-option)
		- [Timeedit Page](#timeedit-page)
- [Copyright](#copyright)

<!-- /TOC -->


# Runtime Enviornment

运行环境

|Enviornment    |Version|
|:-----------:  |:-------:|
|Laravel        |5.4|
|PHP            |7.0.10|
|MySQL          |5.7.17|
|Nginx          |1.11.9|

## Initialize

系统初始化

```bash
php artisan key:generate
php artisan make:auth
php artisan migrate
```

## MySQL authentication

> account: `homestead`
> 
> password: `secret`

remote database:

- IP: `119.29.150.233:3306`
- Account: `root`
- Password: `DutySystem`

## Cron Config

```bash
crontab -e
```

Add line:
```makefile
* * * * * php /home/vagrant/Code/artisan schedule:run >> /dev/null 2>&1
```

# Service Logic

业务逻辑

## Model

模型

- User
- Employee
- Record (For employees)
- ActionRecord (For admins)
- CarRecord
- CardRecord
- TimeNode
- DailyCheckStatus
- HolidayDate
- AbsenceValidRecord

### Model Relationship

模型间关系

```php
$user->actions; // 返回某个指定管理员操作记录
$actions->user; // 返回某条指定记录的管理员信息

$employee->records; // 返回某个指定雇员的签到记录
$employee->special_records(); // 以数组返回某个指定雇员的重要签到记录
$employee->special_records_date($date); // 以数组返回某个指定雇员的指定日期重要签到记录
$employee->special_records_date_cache($date); // 从数据库中缓存查询并返回一个 DailyCheckStatus 对象实例，含有某个指定雇员的某个指定日期的重要签到数据
$employee->daily_check_record_note($date); // 返回某个指定日期记录备注
$employee->month_report_data(); // 以数组返回某个指定雇员的月记录数据

$record->employee; // 返回某条指定签到记录的雇员信息

$absenceValidRecord->employee;// 返回某条指定请假记录的雇员信息

```


## Controller

控制器

- Controller
- IndexController
- HomeController
- RouteController
- EmployeeController
- RecordController
- TimeNodeController
- ActionRecordController
- AbsenceValidRecordController

- Auth
	- RegisterController
	- LoginController
	- ForgetPasswordController
	- ResetPasswordController

## Middleware

中间件

- EncryptCookies
- RedirectIfAuthenticated
- TrimStrings
- VerifyCsrfToken

## Listener

监听器



## API

应用程序接口

- GET `/` : 返回所有记录界面
- POST `/` : 返回指定日期内记录界面
  > 请求变量:
  > ```php
  > $start_time // 开始时间
  > $end_time // 结束时间
  > ```

- GET `/home` : 返回普通管理员登录界面
- GET `/superhome` : 返回超级管理员登录界面
<!-- - GET `/graph` : 返回图表界面
- GET `/correct` : 返回数据修正界面
- GET `/export` : 返回导出excel界面 -->
- GET `/valid` : 返回当日出勤情况界面
- POST `/valid` : 返回指定某个日期的出勤情况界面
  > 请求变量：
  >```php
  > $date // 请求日期
  >```

- GET `/report` : 返回月报表界面
- POST `/report` : 返回某个指定月份的月报表界面
  > 请求变量：
  > ```php
  > $month // 格式为 "YYYY-MM" 的某个指定月份
  > ```


- GET `/holidays` : 返回假期日历界面

- GET `/holidays/dates` : 请求当前**年**的假期信息

  > 返回 `JSON` 数据：
  > ```json
  > {
  >     "year": "2017",
  >     "dates": [
  >         { "date": "2017-08-01" },
  >         { "date": "2017-08-02" },
  >         { "date": "2017-08-03" },
  >         { "date": "2017-08-04" },
  >         { "date": "2017-08-05" },
  >         { "date": "2017-08-06" }
  >     ]
  > }
  > ```

- POST `/holidays` : 请求指定**月**的假期信息

  > 请求内容：
  > ```php
  > $month = "2017-07"
  > ```

  > 返回 `JSON` 数据：
  > ```json
  > {
  >     "month": "2017-07",
  >     "dates": [
  >         { "date": "2017-07-01" },
  >         { "date": "2017-07-02" },
  >         { "date": "2017-07-03" },
  >         { "date": "2017-07-04" },
  >         { "date": "2017-07-05" },
  >         { "date": "2017-07-06" }
  >     ]
  > }
  > ```

- PUT `/holidays` : 添加指定**月**的假期日期

  > 请求变量：
  > ```php
  > $month = "2017-08"; // 格式为 YYYY-MM 的月份
  > $day = "1, 2, 3, 4, 5"; // 以英文逗号分隔的数字（在 1 到 $maxDay 之间）
  > ```

- DELETE `/holidays` :  删除指定**月**的假期日期

  > 请求 `JSON` 数据：
  > ```php
  > $month = "2017-08"; // 格式为 YYYY-MM 的月份
  > $day = "1, 2, 3, 4, 5"; // 以英文逗号分隔的数字（在 1 到 $maxDay 之间）
  > ```

- GET `/leave` : 返回请假界面

- POST `/leave` : 请求指定日期的请假信息
  > 请求变量：
  > ```php
  > // Undeterminated
  > ```

- PUT `/leave` : 添加请假信息
  > 请求变量：
  > ```php
  > $start_date = '2017-08-03'; // 起始日期，格式为 YYYY-MM-DD
  > $end_date = '2017-08-14'; // 结束日期， 格式为 YYYY-MM-DD (包括该日期)
  > $employee_id = 21; // 雇员唯一 ID 号
  > $type = '病假'; // 请假类型
  > $note = '这是一条备注'; // 备注
  > ```

- DELETE `/leave` : 删除指定请假信息
  > 请求变量：
  > ```php
  > $start_date = '2017-08-10'; // 起始日期，格式为 YYYY-MM-DD
  > $end_date = '2017-08-19'; // 结束日期， 格式为 YYYY-MM-DD (包括该日期)
  > $employee_id = 21; // 雇员唯一 ID 号
  > $type = '病假'; // 请假类型
  > ```

- GET `/timeedit` : 返回有效时间编辑界面
- PUT `/timeedit/update` : 更改出勤时间设置
  > 请求变量：
  > ```php
  > $am_start_['day', 'hour', 'minute', 'second'] // 上班开始时间（时、分、秒）
  > $am_end_['day', 'hour', 'minute', 'second'] // 上班结束时间（时、分、秒）
  > $pm_start_['day', 'hour', 'minute', 'second'] // 下午开始时间（时、分、秒）
  > $pm_end_['day', 'hour', 'minute', 'second'] // 下午结束时间（时、分、秒）
  > $am_ddl_['day', 'hour', 'minute', 'second'] // 上午上班时间（时、分、秒）
  > $am_late_ddl_['day', 'hour', 'minute', 'second'] // 上午迟到最晚时间（时、分、秒）
  > $pm_ddl_['day', 'hour', 'minute', 'second'] // 下午上班时间（时、分、秒）
  > $pm_early_ddl_['day', 'hour', 'minute', 'second'] // 下午早退最早时间（时、分、秒）
  > $pm_away_['day', 'hour', 'minute', 'second'] // 下午下班时间（时、分、秒）
  > ```

- GET `/employees/{work_number}` : 返回某个指定雇员信息
- PUT `/employees/{work_number}/records/{id}` : 更改某个指定雇员的某条指定出勤记录
  > 请求变量：
  > ```php
  > $check_direction // 签到方向
  > $check_method // 签到方式（car || card || 请假）
  > $card_gate // 刷卡机器编号（可为空）
  > $note // 备注
  > ```

- GET `/admin/actions` : 返回当前管理员操作信息

  > 返回 `JSON` 数据：
  > ```json
  > {
  >   "current_page": 1,
  >   "data": [
  >     {
  >       "id": 29,
  >       "user_id": 1,
  >       "action": "login",
  >       "timestamp": "2017-08-21 08:50:20"
  >     },
  >     {
  >       "id": 28,
  >       "user_id": 1,
  >       "action": "logout",
  >       "timestamp": "2017-08-21 08:50:18"
  >     },
  >     {
  >       "id": 27,
  >       "user_id": 1,
  >       "action": "login",
  >       "timestamp": "2017-08-21 08:41:59"
  >     }
  >   ],
  >   "from": 1,
  >   "last_page": 2,
  >   "next_page_url": "http://homestead.app/admin/actions?page=2",
  >   "path": "http://homestead.app/admin/actions",
  >   "per_page": 15,
  >   "prev_page_url": null,
  >   "to": 15,
  >   "total": 19
  > }
  > ```

- GET `/admin/actions/{id}` (SuperAdmin ONLY): 返回某个指定管理员的操作信息

- GET `/admin/users` (SuperAdmin ONLY): 返回所有管理员信息
  > 返回 `JSON` 数据：
  > ```json
  > {
  >   "current_page": 1,
  >   "data": [
  >     {
  >       "id": 3,
  >       "name": "Foxwest",
  >       "email": "foxwest@403forbidden.website",
  >       "admin": 1,
  >       "phone_number": "15952055009",
  >       "created_at": "2017-08-02 21:31:24",
  >       "updated_at": "2017-08-02 21:31:24"
  >     },
  >     {
  >       "id": 1,
  >       "name": "TripleZ",
  >       "email": "me@triplez.cn",
  >       "admin": 1,
  >       "phone_number": "15240241051",
  >       "created_at": "2017-08-02 21:31:24",
  >       "updated_at": "2017-08-02 21:31:24"
  >     },
  >     {
  >       "id": 2,
  >       "name": "test",
  >       "email": "test@triplez.cn",
  >       "admin": 0,
  >       "phone_number": "15240241052",
  >       "created_at": "2017-08-02 21:31:24",
  >       "updated_at": "2017-08-02 21:31:24"
  >     }
  >   ],
  >   "from": 1,
  >   "last_page": 1,
  >   "next_page_url": null,
  >   "path": "http://homestead.app/admin/users",
  >   "per_page": 15,
  >   "prev_page_url": null,
  >   "to": 3,
  >   "total": 3
  > }
  > ```

- POST `/admin/resetpassword` : 重置管理员密码
  > 请求变量：
  > ```php
  > $oldpassword // 旧密码
  > $password // 新密码
  > $password_confirmation // 确认密码
  > ```


## Database tables

数据表

（有待补充……好多都没写……）

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
- 2017_07_24_130805_create_car_records_table
- 2017_07_24_132509_create_card_records_table
- 2017_07_28_080332_create_time_nodes_table
- 2017_07_31_105738_create_holiday_dates_table
- 2017_08_02_153827_create_absence_valid_records_table

```bash
php artisan migrate:reset
php artisan migratem
```

## Seeds

填充假数据

基础数据：
- UsersTableSeeder
- EmployeeSeeder
- TimeNodeSeeder

假数据核心：
- CarRecordSeeder
- CardRecordSeeder

垃圾数据 / 历史遗留：
- RecordSeeder
- ActionRecordSeeder
- DailyCheckStatusSeeder
- HolidayDateSeeder
- AbsenceValidRecordSeeder

```bash
composer dump-autoload
php artisan db:seed
```

记得将需要 seed 的数据在 `database/seeds/DatabaseSeeder.php` 中注册。

## Schedule Tasks

计划任务

|Task           |Frequency  |Note|
|:----:         |:----:     |:----:|
|SyncCarRecord  |每小时一次   |同步车辆进出记录到记录主数据表|
|SyncCardRecord |每小时一次   |同步步行进出记录到记录主数据表|
|AbsenceSimCheck|每日两次，分别在 `am_start` 和 `pm_away`|请假模拟签到|
|UpdateDailyCheckStatus|每日一次，在 `pm_end`|更新每日雇员签到状态|

## Artisan Command

自定义的 `artisan` 命令

```bash
php artisan sync:car        // 同步车辆进出记录到记录主数据表
php artisan sync:card       // 同步步行进出记录到记录主数据表
php artisan absence:check   // 请假模拟签到
php artisan daily:status    // 更新每日雇员签到状态
```

自定义命令需要在 `app/Console/Kernel.php` 中注册。

## Employee Status

雇员状态

- 正常
- 迟到
- 早退
- 迟到早退
- 缺勤
- 事假
- 病假
- 暂无


## Important Timestamp

重要时间戳

- Global
```php
$am_start = `3:00` // 上午记录开始时间
$am_end = `14:00` // 上午记录结束时间
$pm_start = `12:00` // 下午记录开始时间
$pm_end = `+1Day 3:00` // 下午记录结束时间
```
- AM
```php
$am_ddl = `8:00` // 上午签到最晚时间
$am_late_ddl = `10:00` // 上午签到迟到最晚时间
```
- PM
```php
$pm_ddl = `14:00` // 下午签到最晚时间
$pm_away = `18:00` // 下午离开最早时间
$pm_early_ddl = `16:00` // 下午离开早退最早时间
```


### Default Timezone

默认时区

`UTC+8` `Asia/Shanghai`

## Scheduling task

计划任务


## Note

### Error message:
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
### Solution
in file: `config\database.php`

```
'charset' => 'utf8mb4',
'collation' => 'utf8mb4_unicode_ci',
'engine' => 'InnoDB ROW_FORMAT=DYNAMIC',
```

### Change Server Timezone

```bash
sudo timedatectl set-timezone Asia/Shanghai
date
```

> Add timezone when written data into database!
>
> `Caron::now('Asia/Shanghai')` **OR** `Carbon::now('CST')`

## Source Code rewrite

### Modal Position

demand:

make the modal box be at a right position

### Position Method

find the function 'Modal.prototype.adjustDialog' bootstrap.js(in this project is included in public/js/app.js),then replace them as the follow code:

```
Modal.prototype.adjustDialog = function () {  
    var modalIsOverflowing = this.$element[0].scrollHeight > document.documentElement.clientHeight  
  
    this.$element.css({  
      paddingLeft:  !this.bodyIsOverflowing && modalIsOverflowing ? this.scrollbarWidth : '',  
      paddingRight: this.bodyIsOverflowing && !modalIsOverflowing ? this.scrollbarWidth : ''  
    });  
  

    var $modal_dialog = $(this.$element[0]).find('.modal-dialog');  
    //get the view heigh
    var clientHeight = (document.body.clientHeight < document.documentElement.clientHeight) ? document.body.clientHeight: document.documentElement.clientHeight;  
    //get dialog heigh 
    var dialogHeight = $modal_dialog.height();  
    //compute the distance to the top 
    var m_top = (clientHeight - dialogHeight)/3;  
    // console.log("clientHeight : " + clientHeight);  
    // console.log("dialogHeight : " + dialogHeight);  
    // console.log("m_top : " + m_top);  
    $modal_dialog.css({'margin': m_top + 'px auto'});  
}  
```


## Web-view Layouts Design

### General Page

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


### Graph Page

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


### Valid Records

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


### Holiday Page (option)

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


### Timeedit Page

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

