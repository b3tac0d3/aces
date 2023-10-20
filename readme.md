
## Before you begin
Make a reference to the main query class. The other classes are loaded automatically when this class is called. All functionality for basic usage will be through the 'query' class.

#### Special Notes:
- All functions can be chained or used separately. 
- Each new query requires a new object to be created.
- Most single input functions have an alternate mult-input counterpart.
- Functions can be called in any order EXCEPT for the final query function which must be called last.

## Config File
- Config file automatically loaded from ~/src/app/plugins/aces/config.php
- Uses constants to define database structure and log files
    - Default log files are located under aces/logs/
    - Custom log files can be used by change log file path constants
    - If log file doesn't exist but is called, it will be created

- Default select is all columns (*)
- Default return is all rows fetchAll(PDO::FETCH_ASSOC)

## Include class
```php
$query = new aces\query();
```

# Query Types
---

## Select
Select has two arguments.
- table_name [required]
- alias [optional] **Recommended when using joins**
Here's a basic select query that would get all users from the users table.
```php
$query -> select("users")
```
The query return is an array containing results. Depending on the fetch method used, it could be one result or multiple. Either way, the returned result is always an array.

## Update
Only one argument is set in the update function. Update values and where values are set in their own functions which will be discussed later.
- table_name
```php
$query -> set_update_column("username", "jimmy") -> set_where("id", 1) -> update("users");
```
The return value is always an array. On error, the error handler will be thrown. On successful query, the return will be status => 1.

## Insert
Only one argument is set in the insert function. Insert values are set in their own functions which will be discussed later.
- table_name
```php
$query -> set_insert_column("username", "jimmy") -> insert("users");
```
The return array will have 2 keys. status => 1, last_insert_id.

## Delete
Only one argument is set in the delete function. Delete values and where values are set in their own functions which will be discussed later.
- table_name
```php
$query -> set_where("id", 1) -> delete("users");
```
The return array will be status => 1 on success.

## Deactivate
Aces uses table record logs that are stored in a log table. Some applications may want to be able to "soft" delete rows by deactivating the row instead of deleting the record. Deactivate queries just give a shortcut to update the active status and update the log table with the proper record tracking. This is in lieu of having to run an update query for both the record and the log table.

## Where Statments
Where statements work for all applicable query types. They have two required arguments and two optional arguments. 

This is how the where function looks in the query class. The arguments are as follows.
- column [required]
- value [required]
- operator [optional] {default "="} **Accepts all possible SQL values**
- logical_operator [optional] {default "AND"} **Accepts all possible SQL values**

### set_where()
The use of the where function is as follows:
```php
$query -> set_where("username", "b3tac0d3") -> select("users");
```
**or**
```php
$query -> set_where("id", 1);
$query -> select("users");
```
Multiple where statements can be chained together **OR** you can use ```set_where_array```

### set_where_array()
set_where_array functions like set_where. It only allows for 2 arguments:
- columns {simple array}
- values {simple array} **Corresponding directly with columns list**
This function does not allow for operators or logical_operators to be set but provides a way to run multiple simple where conditions in a single function. Each function is subsquently run through the set_where function to be handled.
```php
$query -> set_where_array(["id", "username", "active"], [1, "b3tac0d3", 1])
```
This function can also be chained and/or combined with additional set_where statements.


## Join Statements
The join statement has 4 arguments.
- table_name [required]
- alias [highly recommended] **Can also be used in where statements**
- ons_array [required] **Must be array, even if only single statement**
- type [required] {default = "INNER"}
```php
$query -> set_join("contacts", "c", ["c.id" => "u.id", "u.active" => 1]) -> set_where("u.id", 1) -> select("users", "u");
```

## Query Limit
Query limit is the count and limit of rows returned. This can also be chained.
There are two arguments.
- start [required] | First record to show in results
- limit [required] | Number of records to return
```php
$query -> set_limit(0, 25)
```

## Query order

## Record Grouping

## Fetch statements (PDO::FETCH)

## Set Select Columns 

## Set Update Columns 

## Set Insert Columns 

## Set Table Alias 

## Get Last Record Insert ID 

## Get Results

## Get Record Row Count 