## Laravel Diamond Industry Employee Payroll Management System
 
- This is a diamond industry Employee payroll management application which is coded in laravel.suppose if you need a solution for managing the high amount of employees in your diamond industry then this will be time saver for you.

- With the help of this application you can assign daily timesheet to an employee by attaching date and diamond qty.through out the current month and future month too.

- Each employee's data can greatly be manage according to month/date/year range.

- You can easily find the total payable amount to your workers.

- You can add the worktypes (type of diamonds).

- **Note** : you will get the role called **SuperAdmin** added pre default. you need to create two roles named **Employee** &  **Managar** at your own which will be provided in installation steps.

- **Note** : Only one superadmin can be register via seeding there is not option for register only login option is given sothat anyone from outside cannot be register as superadmin.

- The advance cash service has been added sothat if any employee need to take advance cash at future month they can take. there is a manage area for that also.

- If you reached here by reading , keep calm and simply follow the <a href="#installation-local">installation</a> steps. you will get your application setup completely on your local machine.

## Screenshots

## SuperAdmin Dashboard
<a href="https://i.imgur.com/LH4MeEV.png?1"><img src="https://i.imgur.com/LH4MeEV.png?1" title="source: imgur.com" /></a><br>

## Manager Dashboard
<a href="https://i.imgur.com/JKbFqDs.png?1"><img src="https://i.imgur.com/JKbFqDs.png?1" title="source: imgur.com" /></a><br>

## Employee Dashboard
<a href="https://i.imgur.com/Euc5s01.png?1"><img src="https://i.imgur.com/Euc5s01.png?1" title="source: imgur.com" /></a><br>

## Installation (Local)

*You Can Install it on your local pc by following below steps:*

*Download or clone the repository in your system.*

```
git clone https://github.com/rkdharecha/diamond-industry-payroll-system-laravel.git
```

*Go to diamond-industry-payroll-system-laravel-master folder and open terminal then follow below steps.*

*Install Composer:*
```
composer Install
```

*Make a copy of .env.example file to .env:*
```
cp .env.example .env
```

*Set the database credentials:*
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=root
DB_PASSWORD=
```

*Then Generate Application Key:*
```
php artisan key:generate
```

*Then Migrate the database:*
```
php artisan migrate
```

*Now We Need to create Permissions that assign to Role (make sure to first run this command before superadmin seeding):*
```
php artisan db:seed --class=PermissionTableSeeder
``` 

*Create SuperAdmin:*
```
php artisan db:seed --class=CreateSuperAdminUserSeeder
```

*Run php artisan serve. Open http://localhost:8000, you should see the login page.*

*SuperAdmin Login*
```
email = superadmin@mailinator.com 
password = 12345678
```

**Note** :
After Login as Superadmin , goto Roles from sidebar and create two more roles named *Employee* & *Manager* & assign permissions to them which you want to. for example add 2 users with role manager from superadmin and login with that two managers and create employees from them.


 
