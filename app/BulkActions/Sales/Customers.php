<?php

namespace App\BulkActions\Sales;

use App\Abstracts\BulkAction;
use App\Exports\Sales\Customers as Export;
use App\Models\Common\Contact;

class Customers extends BulkAction
{
    public $model = Contact::class;

    public $text = 'general.customers';

    public $path = [
        'group' => 'sales',
        'type' => 'customers',
    ];

    public $actions = [
        'enable' => [
            'icon' => 'check_circle',
            'name' => 'general.enable',
            'message' => 'bulk_actions.message.enable',
            'permission' => 'update-sales-customers',
        ],
        'disable' => [
            'icon' => 'hide_source',
            'name' => 'general.disable',
            'message' => 'bulk_actions.message.disable',
            'permission' => 'update-sales-customers',
        ],
        'delete' => [
            'icon' => 'delete',
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'permission' => 'delete-sales-customers',
        ],
        'export' => [
            'icon' => 'file_download',
            'name' => 'general.export',
            'message' => 'bulk_actions.message.export',
            'type' => 'download',
        ],
    ];

    public function disable($request)
    {
        $this->disableContacts($request);
    }

    public function destroy($request)
    {
        $this->deleteContacts($request);
    }

    public function export($request)
    {
        $selected = $this->getSelectedInput($request);

        return $this->exportExcel(new Export($selected), trans_choice('general.customers', 2));
    }
}
