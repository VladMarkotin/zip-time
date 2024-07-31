<?php
namespace App\Http\Controllers\Services\PersonalResultServices\traits;

use App\Http\Helpers\GeneralHelpers\GeneralHelper;

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
            'better'                      => null,
            'more_pesponsible'            => null,
            'user_purposelness'           => null,
            'better_then_purposelness'    => null,
            'ratingData'                  => null,
            'is_emergency_mode_activated' => null,
        ];

        $result['is_emergency_mode_activated'] = GeneralHelper::checkIfEmergModeIsActive();
        if (!empty($result['is_emergency_mode_activated'])) {
            return $result;
        }

        //get user`s quantity in group according to user`s rate 
        $usersQuantityInGroup = UserGroupTrait::countUsersInGroupToday($data, $configs);

        $data['QuantityInGroup'] = $usersQuantityInGroup['quantityInGroup'];

        $better                      = GetWorserUsersTrait::getData($data, $usersQuantityInGroup);
        $more_pesponsible            = GetUserResponsibilityTrait::getData($data, $usersQuantityInGroup);
        [
            'user_purposelness'        => $user_purposelness, 
            'better_then_Purposelness' => $better_then_Purposelness
        ]                            = GetUserPurposelness::getData($data, $usersQuantityInGroup);
        
        $result['better']                   = $better;
        $result['more_pesponsible']         = $more_pesponsible;
        $result['user_purposelness']        = $user_purposelness;
        $result['better_then_purposelness'] = $better_then_Purposelness;
        $result['ratingData']               = $usersQuantityInGroup['ratingData'];
        
        return $result;
    }
} 