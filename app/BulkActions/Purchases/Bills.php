<?php

namespace App\BulkActions\Purchases;

use App\Abstracts\BulkAction;
use App\Events\Document\DocumentCancelled;
use App\Events\Document\DocumentReceived;
use App\Exports\Purchases\Bills as Export;
use App\Jobs\Document\CreateDocumentHistory;
use App\Jobs\Document\DeleteDocument;
use App\Models\Document\Document;

class Bills extends BulkAction
{
    public $model = Document::class;

    public $text = 'general.bills';

    public $path = [
        'group' => 'purchases',
        'type' => 'bills',
    ];

    public $actions = [
        'received' => [
            'icon' => 'send',
            'name' => 'bills.mark_received',
            'message' => 'bulk_actions.message.received',
            'permission' => 'update-purchases-bills',
        ],
        'cancelled' => [
            'icon' => 'cancel',
            'name' => 'general.cancel',
            'message' => 'bulk_actions.message.cancelled',
            'permission' => 'update-purchases-bills',
        ],
        'delete' => [
            'icon' => 'delete',
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'permission' => 'delete-purchases-bills',
        ],
        'export' => [
            'icon' => 'file_download',
            'name' => 'general.export',
            'message' => 'bulk_actions.message.export',
            'type' => 'download',
        ],
    ];

    public function received($request)
    {
        $bills = $this->getSelectedRecords($request);

        foreach ($bills as $bill) {
            if ($bill->status == 'received') {
                continue;
            }

            event(new DocumentReceived($bill));
        }
    }

    public function cancelled($request)
    {
        $bills = $this->getSelectedRecords($request);

        foreach ($bills as $bill) {
            if ($bill->status == 'cancelled') {
                continue;
            }

            event(new DocumentCancelled($bill));
        }
    }

    public function duplicate($request)
    {
        $bills = $this->getSelectedRecords($request);

        foreach ($bills as $bill) {
            $clone = $bill->duplicate();

            $description = trans('messages.success.added', ['type' => $clone->document_number]);

            $this->dispatch(new CreateDocumentHistory($clone, 0, $description));
        }
    }

    public function destroy($request)
    {
        $bills = $this->getSelectedRecords($request, [
            'items', 'item_taxes', 'histories', 'transactions', 'recurring', 'totals',
        ]);

        foreach ($bills as $bill) {
            try {
                $this->dispatch(new DeleteDocument($bill));
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }

    public function export($request)
    {
        $selected = $this->getSelectedInput($request);

        return $this->exportExcel(new Export($selected), trans_choice('general.bills', 2));
    }
}
