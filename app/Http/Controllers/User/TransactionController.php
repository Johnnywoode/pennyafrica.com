<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $page_title = __('locale.titles.my_transactions');
        $breadcrumbs = [
            ['name' => $page_title],
        ];

        $stats = [
            'total_transactions' => Transaction::forUser()->count(),
            'credit_transactions' => Transaction::forUser()->where('type', Transaction::TYPE_CREDIT)->count(),
            'debit_transactions' => Transaction::forUser()->where('type', Transaction::TYPE_DEBIT)->count(),
        ];

        return view('user.transactions.index', compact('page_title', 'stats', 'breadcrumbs'));
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
            3 => 'type',
            4 => 'amount',
            5 => 'balance_before',
            6 => 'balance_after',
            7 => 'status',
            8 => 'created_at',
            // 9 => 'action',
        ];

        $user = Auth::user();
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

            $transactions = Transaction::where()->whereLike(['type', 'amount', 'balance_before', 'balance_after', 'status'], $search)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Transaction::where()->whereLike(['type', 'amount', 'balance_before', 'balance_after', 'status'], $search)
                ->count();
        }

        $data = [];
        if (!empty($transactions)) {
            foreach ($transactions as $transaction) {
                // $show = route(config('app.admin_path'). '.transactions.show', $transactions->uuid);
                // $edit = 'Edit';
                // $delete = 'Delete';

                $nestedData['responsive_id'] = '';
                $nestedData['uuid'] = $transaction->uuid;
                $nestedData['type'] = $transaction->displayType();
                $nestedData['amount'] = $transaction->amount;
                $nestedData['balance_before'] = $transaction->balance_before;
                $nestedData['balance_after'] = $transaction->balance_after;
                $nestedData['status'] = $transaction->displayStatus();
                $nestedData['created_at'] = Carbon::parse($transaction->created_at)->format('jS M. Y');
                // $nestedData['show'] = $show;
                // $nestedData['show_label'] = $edit;
                // $nestedData['delete'] = $transaction->uuid;
                // $nestedData['delete_label'] = $delete;

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
