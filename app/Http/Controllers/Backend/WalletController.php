<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class WalletController extends Controller
{
    public function Index()
    {
        return view('backend.wallet.index');
    }

    public function ssd()
    {
        $data = Wallet::with('user');

        return DataTables::eloquent($data)
            ->editColumn('created_at', function ($each) {
                $created_at = Carbon::parse($each->created_at)->format('Y-m-d H:i:s');
                return $created_at;
            })
            ->editColumn('updated_at', function ($each) {
                $updated_at = Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                return $updated_at;
            })
            ->addColumn('account_profile', function ($each) {
                $account_profile = $each->user;
                if ($account_profile) {
                    return '<div>Name -' . $account_profile->name . '</div>
                     <div>Phone Number -' . $account_profile->phone_number . '</div>
                     <div>Email -' . $account_profile->email . '</div>';

                }
                return '-';
            })
            ->rawColumns(['account_profile'])
            ->make(true);

    }
}
