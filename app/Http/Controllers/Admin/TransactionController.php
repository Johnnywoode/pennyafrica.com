<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $page_title = __('locale.titles.transactions');
        $breadcrumbs = [
            ['name' => $page_title],
        ];

        $stats = [
            'total_transactions' => Transaction::count(),
            'credit_transactions' => Transaction::where('type', Transaction::TYPE_CREDIT)->count(),
            'debit_transactions' => Transaction::where('type', Transaction::TYPE_DEBIT)->count(),
        ];

        return view('admin.transactions.index', compact('page_title', 'stats', 'breadcrumbs'));
    }

    /**
     * View all customers
     *
     * @throws AuthorizationException
     */
    #[NoReturn]
    public function search(Request $request): void
    {

        $columns = [
            0 => 'responsive_id',
            1 => 'uuid',
            2 => 'uuid',
            3 => 'user',
            4 => 'type',
            5 => 'amount',
            6 => 'balance_before',
            7 => 'balance_after',
            8 => 'status',
            9 => 'created_at',
            10 => 'action',
        ];

        $totalData = Transaction::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $transactions = Transaction::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $transactions = Transaction::whereLike(['type', 'amount', 'balance_before', 'balance_after', 'status'], $search)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Transaction::whereLike(['type', 'amount', 'balance_before', 'balance_after', 'status'], $search)
                ->count();
        }

        $data = [];
        if (!empty($transactions)) {
            foreach ($transactions as $transaction) {
                $show = route(config('app.admin_path'). '.transactions.show', $transactions->uuid);
                $edit = 'Edit';
                $delete = 'Delete';

                $nestedData['responsive_id'] = '';
                $nestedData['uuid'] = $transaction->uuid;
                $nestedData['user'] = $transaction->user->details->name;
                $nestedData['type'] = $transaction->displayType();
                $nestedData['amount'] = $transaction->amount;
                $nestedData['balance_before'] =$transaction->balance_before;
                $nestedData['balance_after'] = $transaction->balance_after;
                $nestedData['status'] = $transaction->displayStatus();
                $nestedData['created_at'] = Carbon::parse($transaction->created_at)->format('jS M. Y');
                $nestedData['show'] = $show;
                $nestedData['show_label'] = $edit;
                $nestedData['delete'] = $transaction->uuid;
                $nestedData['delete_label'] = $delete;

                $data[] = $nestedData;
            }
        }

        $json_data = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ];

        echo json_encode($json_data);
        exit();
    }
}
