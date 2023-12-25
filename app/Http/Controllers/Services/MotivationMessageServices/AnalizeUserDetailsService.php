<?php
namespace App\Http\Controllers\Services\MotivationMessageServices;


use Illuminate\Support\Facades\Auth;
use App\Models\TimetableModel;
use App\Http\Controllers\Services\PersonalResultServices\PersonalResultsService;
use App\Models\Tasks;
use Illuminate\Support\Carbon;

class AnalizeUserDetailsService
{
    /**
     * method will try to define index in motivation message`s array
     * return index [usual_day, first_day, second_day, after_1_week, after_1_month, after_weekend,
     *  after_fail, after_emergency]
     */
    public function analizeUserDetails(array $data)
    {
        /**
         * $data['state']
         * $data = ['state', 'id']
         * 1.create plan: have to define wether it is a usual day or a special day
        */
        switch($data['state']) {
            case 'create_plan':
                return $index = $this->defineState($data);
                
        }
    }

    private function defineState(array $data)
    {
        /**
         * Определяю какое сообщение нужно показать юзеру.
         * В результате проверок опредедяется индекс в массиве $messages. Массив находится в Message.php
         */
        if($this->isFirstPlan($data) ) {
            return 'first_day';
        } else if(3 != ($status = $this->getPreviousDayStatus($data))  ) {
            $statuses = [
                'after_weekend' => 1, 
                'after_fail' => -1,
                'after_emergency' => 0
            ];
            
            return (array_search($status, $statuses)) ?: 'usual_day' ;
        } 
        
        $points = [
           'second_day' => 2, 
           'after_1_week' => 7,//485,
           'after_1_month' => 30
        ];
            $point = $this->planNumber($data);
            $index = (array_search($point, $points)) ?: 'usual_day' ;
        
        return $index;
    }

    private function getPreviousDayStatus(array $data)
    {
        $yesterday = Carbon::yesterday();
        $status= (TimetableModel::select('day_status')->where([
            ['user_id', $data['user_id']],
            ['date', $yesterday] 
            ])
            ->get()
            ->pluck('day_status')
            ->toArray()
        );
        if(isset($status[0])) {
            return $status[0];
        }

        return -1;
    }

    private function isFirstPlan(array $data)
    {
        return ( (TimetableModel::select('id')->where([
            ['user_id', $data['user_id']], 
        ])
        ->get()
        ->count()
        ) > 0) ? false : true;
    }

    private function planNumber(array $data)
    {
        return (TimetableModel::select('id')->where([
            ['user_id', $data['user_id']], 
        ])
        ->get()
        ->count()
        );
    }
}