<?php

namespace App\BulkActions\Settings;

use App\Abstracts\BulkAction;
use App\Jobs\Setting\DeleteCurrency;
use App\Jobs\Setting\UpdateCurrency;
use App\Models\Setting\Currency;

class Currencies extends BulkAction
{
    public $model = Currency::class;

    public $text = 'general.currencies';

    public $path = [
        'group' => 'settings',
        'type' => 'currencies',
    ];

    public $actions = [
        'enable' => [
            'icon' => 'check_circle',
            'name' => 'general.enable',
            'message' => 'bulk_actions.message.enable',
            'permission' => 'update-settings-currencies',
        ],
        'disable' => [
            'icon' => 'hide_source',
            'name' => 'general.disable',
            'message' => 'bulk_actions.message.disable',
            'permission' => 'update-settings-currencies',
        ],
        'delete' => [
            'icon' => 'delete',
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'permission' => 'delete-settings-currencies',
        ],
    ];

    public function disable($request)
    {
        $currencies = $this->getSelectedRecords($request);

        foreach ($currencies as $currency) {
            try {
                $this->dispatch(new UpdateCurrency($currency, $request->merge(['enabled' => 0])));
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }

    public function destroy($request)
    {
        $currencies = $this->getSelectedRecords($request);

        foreach ($currencies as $currency) {
            try {
                $this->dispatch(new DeleteCurrency($currency));
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }
}
