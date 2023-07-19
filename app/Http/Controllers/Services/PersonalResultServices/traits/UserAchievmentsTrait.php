<?php
namespace App\Http\Controllers\Services\PersonalResultServices\traits;

//Here final data would counted
trait UserAchievmentsTrait
{
    use UserGroupTrait;
    use GetWorserUsersTrait;

    public function getData(array $data, array $configs)
    {
        //get user`s quantity in group according to user`s rate 
        $usersQuantityInGroup = UserGroupTrait::countUsersInGroupToday($data, $configs);
        //have to count % user`s who are worser
        //die(var_dump($usersQuantityInGroup));
        $data['QuantityInGroup'] = $usersQuantityInGroup['quantityInGroup'];
        $result['better'] = GetWorserUsersTrait::getData($data, $usersQuantityInGroup);
        //die(var_dump($result));
        return ($result);
    }
} 