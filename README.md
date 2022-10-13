## laravel simple MLM
using laravel framework version 9

feature : 
The system stores and calculates bonus earnings from a multi-level system marketing (MLM). Each member of MLM can have 1 parent or no parent and can have many downlines. Members who do not have parents are called members level 1, downlines from level 1 members are referred to as level 2 members, downlines from members level 2 is referred to as member level 3, and so on. New members can registered by the admin as a downline from a registered member or as an upline new.

Each member can experience the migration carried out by the admin. Migration is transfer member to new parent / without parent. If the migrated member has downline, all downlines under the member are also migrated.

A member gets a bonus of $1 per downline who is exactly 1 level below and get a $0.5 bonus per downline that is exactly 2 levels below it. Downline 3 levels or more under a member does not add to the bonus of the member. Admin can ask the system to calculate the bonus of each member.

From the user story above, the following system can do :
1. Register a new member
2. Moving the parent of a member
3. Calculating the bonus earned from a member
4. Simple display in web form to describe member tree condition at that time

## Route
    {{base_path}}/member

## Installation
1. copy .env.example .env
2. composer Install
3. php artisan migrate 
4. php artisan serve
