<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 16.04.2022
 * Time: 14:44
 */
namespace App\Http\Controllers\Services;

use App\Repositories\SettingsRepositories\SettingsRepository;

class SettingsService
{
    private $settingsRepository = null;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function getAllSettings(array $params)
    {
        $currentSettings = $this->settingsRepository->getCurrentSettings($params);

        return $currentSettings;
    }
} 