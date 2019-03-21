<?php

namespace pantera\billing\helpers;

use pantera\billing\models\CompanyBalance;
use pantera\billing\models\ServiceBalance;
use pantera\billing\models\UserBalance;
use yii\helpers\ArrayHelper;

class FinanceHelper
{
    public static function BalancesByEntity()
    {
        //Балансы компаний
        $companyBalances = CompanyBalance::find()->all();
        //Балансы пользователей
        $userBalances = UserBalance::find()->all();
        //Сервисные балансы
        $serviceBalances = ServiceBalance::find()->all();

        $result = [];

        foreach ($companyBalances as $companyBalance) {
            $result[] = [
                'id' => $companyBalance->balance_id,
                'name' => $companyBalance->company->name,
                'group' => 'Компании'
            ];
        }

        foreach ($userBalances as $userBalance) {
            $result[] = [
                'id' => $userBalance->balance_id,
                'name' => $userBalance->user->username,
                'group' => 'Пользователи'
            ];
        }

        foreach ($serviceBalances as $serviceBalance) {
            $result[] = [
                'id' => $serviceBalance->balance_id,
                'name' => $serviceBalance->name,
                'group' => 'ПП'
            ];
        }

        return $result;

    }
}