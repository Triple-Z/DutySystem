# DutySystem

A duty system for Drone Institution of NUAA.


<!-- vscode-markdown-toc -->
* 1. [Initialize](#Initialize)
* 2. [MySQL authentication](#MySQLauthentication)
* 3. [Model](#Model)
	* 3.1. [Model Relationship](#ModelRelationship)
* 4. [Controller](#Controller)
* 5. [Middleware](#Middleware)
* 6. [API](#API)
* 7. [Database tables](#Databasetables)
	* 7.1. [table name: `employees`](#tablename:employees)
	* 7.2. [table names: `records`](#tablenames:records)
	* 7.3. [table name: `users`](#tablename:users)
	* 7.4. [table name: `user_action_records`](#tablename:user_action_records)
* 8. [Migrations](#Migrations)
* 9. [Seeds](#Seeds)
* 10. [Employee Status](#EmployeeStatus)
* 11. [Important Timestamp](#ImportantTimestamp)
	* 11.1. [Default Timezone](#DefaultTimezone)
* 12. [Scheduling task](#Schedulingtask)
* 13. [note](#note)
	* 13.1. [Error message:](#Errormessage:)
	* 13.2. [Solution](#Solution)
	* 13.3. [Change Server Timezone](#ChangeServerTimezone)
* 14. [Source Code rewrite](#SourceCoderewrite)
	* 14.1. [modal position](#modalposition)
	* 14.2. [positionmethod](#positionmethod)
* 15. [Web-view Layouts Design](#Web-viewLayoutsDesign)
	* 15.1. [general page](#generalpage)
	* 15.2. [graph page](#graphpage)
	* 15.3. [valid records](#validrecords)
	* 15.4. [holiday page(option)](#holidaypageoption)
	* 15.5. [timeedit page](#timeeditpage)

<!-- vscode-markdown-toc-config
	numbering=true
	autoSave=true
	/vscode-markdown-toc-config -->
<!-- /vscode-markdown-toc -->


# Runtime Enviornment

运行环境

|Enviornment	|Version	|
|:-----------:	|:-------:	|
|Laravel		|5.4		|
|PHP			|7.0.10		|
|MySQL			|5.7.17		|
|Nginx			|1.11.9		|

##  1. <a name='Initialize'></a>Initialize

系统初始化

```
php artisan key:generate
php artisan make:auth
php artisan migrate
```

##  2. <a name='MySQLauthentication'></a>MySQL authentication

> account: `homestead`
> 
> password: `secret`

remote database:

- IP: `119.29.150.233:3306`
- Account: `root`
- Password: `DutySystem`

# Service Logic

业务逻辑

##  3. <a name='Model'></a>Model

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

###  3.1. <a name='ModelRelationship'></a>Model Relationship

模型间关系

```php
$user->actions; // 返回某个指定管理员操作记录
$actions->user; // 返回某条指定记录的管理员信息

$employee->records; // 返回某个指定雇员的签到记录
$employee->special_records(); // 以数组返回某个指定雇员的重要签到记录
$employee->month_report_data(); // 以数组返回某个指定雇员的月记录数据

$record->employee; // 返回某条指定签到记录的雇员信息

$absenceValidRecord->employee;// 返回某条指定请假记录的雇员信息
```


##  4. <a name='Controller'></a>Controller

控制器

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

##  5. <a name='Middleware'></a>Middleware

中间件

- EncryptCookies
- RedirectIfAuthenticated
- TrimStrings
- VerifyCsrfToken

##  6. <a name='API'></a>API

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
- GET `/leave/data` : 返回所有请假信息

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
- GET `/admin/actions/{id}` : 返回某个指定管理员的操作信息

- POST `/admin/resetpassword` : 重置管理员密码
  > 请求变量：
  > ```php
  > $oldpassword // 旧密码
  > $password // 新密码
  > $password_confirmation // 确认密码
  > ```




##  7. <a name='Databasetables'></a>Database tables

数据表

|symbol	|means		|
|:---:	|:-----:	|
|\*		|primary key|
|^		|foreign key|

###  7.1. <a name='tablename:employees'></a>table name: `employees`

columns:

|ID*	|name	|gender	|eamil	|phone_number	|work_title	|department	|car_number	|
|----|----|----|----|----|----|----|----|
|1|TripleZ|man|me@triplez.cn|15240241051|CEO|Develop Department|null|


###  7.2. <a name='tablenames:records'></a>table names: `records`

columns:

|ID*	|employee_id^	|check_direction(Y/N)	|check_method	|check_time	|
|----|----|----|----|---|
|1|3|1|card|2017-07-21 13:22:13|
|2|3|0|card|2017-07-21 17:22:13|
|3|1|1|car|2017-07-22 07:22:13|
|4|1|0|car|2017-07-22 12:22:13|

###  7.3. <a name='tablename:users'></a>table name: `users`

columns:

|ID*	|name	|email	|password	|admin(Y/N)	|phone_number	|created_at|updated_at|
|-----|----|----|----|-----|-----|----|----|
|1|TripleZ|me@triplez.cn|******|1|15240241051|
|2|test|test@triplez.cn|******|0|88888888|

###  7.4. <a name='tablename:user_action_records'></a>table name: `user_action_records`

columns:

|ID*	|user_id^	|action	|timestamp	|
|-----|----|----|----|
|1|1|login|2017-07-23 15:47:35|
|2|1|logout|2017-07-23 15:47:39|

##  8. <a name='Migrations'></a>Migrations

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
php artisan migrate
```

##  9. <a name='Seeds'></a>Seeds

填充假数据

- UsersTableSeeder
- EmployeeSeeder
- RecordSeeder
- ActionRecordSeeder
- CarRecordSeeder
- CardRecordSeeder
- TimeNodeSeeder
- DailyCheckStatusSeeder
- HolidayDateSeeder
- AbsenceValidRecordSeeder

```bash
composer dump-autoload
php artisan db:seed
```

记得将需要 seed 的数据在 `database/seeds/DatabaseSeeder.php` 中注册。

##  10. <a name='EmployeeStatus'></a>Employee Status

雇员状态

- 正常
- 迟到
- 早退
- 迟到早退
- 缺勤
- 事假
- 病假
- 暂无


##  11. <a name='ImportantTimestamp'></a>Important Timestamp

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


###  11.1. <a name='DefaultTimezone'></a>Default Timezone

默认时区

`UTC+8` `Asia/Shanghai`

##  12. <a name='Schedulingtask'></a>Scheduling task

计划任务


##  13. <a name='note'></a>note
###  13.1. <a name='Errormessage:'></a>Error message:
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
###  13.2. <a name='Solution'></a>Solution
in file: `config\database.php`

```
'charset' => 'utf8mb4',
'collation' => 'utf8mb4_unicode_ci',
'engine' => 'InnoDB ROW_FORMAT=DYNAMIC',
```

###  13.3. <a name='ChangeServerTimezone'></a>Change Server Timezone

```bash
sudo timedatectl set-timezone Asia/Shanghai
date
```

> Add timezone when written data into database!
>
> `Caron::now('Asia/Shanghai')` **OR** `Carbon::now('CST')`

##  14. <a name='SourceCoderewrite'></a>Source Code rewrite

###  14.1. <a name='modalposition'></a>modal position

demand:

make the modal box be at a right position

###  14.2. <a name='positionmethod'></a>positionmethod

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


##  15. <a name='Web-viewLayoutsDesign'></a>Web-view Layouts Design

###  15.1. <a name='generalpage'></a>general page

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


###  15.2. <a name='graphpage'></a>graph page

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


###  15.3. <a name='validrecords'></a>valid records

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


###  15.4. <a name='holidaypageoption'></a>holiday page(option)

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


###  15.5. <a name='timeeditpage'></a>timeedit page

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

