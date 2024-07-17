<?php
namespace App\Http\Controllers\Services\PersonalResultServices\traits;

//Here final data would counted
trait UserAchievmentsTrait
{
    use UserGroupTrait;
    use GetWorserUsersTrait;
    use GetUserResponsibilityTrait;
    use GetUserPurposelness;

    public function getData(array $data, array $configs)
    {
        $result = [
            'better'            => null,
            'more_pesponsible'  => null,
            'user_purposelness' => null,
            'ratingData'        => null,
        ];
        //get user`s quantity in group according to user`s rate 
        $usersQuantityInGroup = UserGroupTrait::countUsersInGroupToday($data, $configs);
        $result['ratingData'] = $usersQuantityInGroup['ratingData'];

        $data['QuantityInGroup'] = $usersQuantityInGroup['quantityInGroup'];

        $result['better']            = GetWorserUsersTrait::getData($data, $usersQuantityInGroup);
        $result['more_pesponsible']  = GetUserResponsibilityTrait::getData($data, $usersQuantityInGroup);
        $result['user_purposelness'] = GetUserPurposelness::getData($data, $usersQuantityInGroup);
        
        return ($result);
    }
} 