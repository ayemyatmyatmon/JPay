<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Wallet;
use App\Helpers\Generate;
use App\Helpers\Response;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProfileResource;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Resources\TransactionCollection;
use App\Http\Requests\Backend\TransferRequest;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\TransactionDetailResource;
use App\Http\Resources\NotificationDetailResource;

class PageController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $data = new ProfileResource($user);
        return Response::success($data);
    }

    public function logout()
    {
        $user = Auth::user();
        $data = $user->token()->revoke();
        return Response::success($data);
    }

    public function transfer(TransferRequest $request)
    {
        $from_user = Auth::user();
        if ($from_user->phone_number == $request->to_phone) {
            return Response::error(422, 'This Account is invalid', null);

        }
        if ($request->amount > $from_user->wallet->amount) {
            return Response::error(422, 'The Amount is not enough.', null);
        }
        $to_user = User::where('phone_number', $request->to_phone)->first();

        if (!$to_user) {
            return Response::error(422, 'This Account is invalid', null);
        }
        if (!$from_user->wallet || !$to_user->wallet) {
            return Response::error(422, 'Wallet is invalid', null);
        }
        $amount = $request->amount;
        $note = $request->note ? $request->note : '-';
        $to_phone = $request->to_phone;
        $after_from_amount = bcsub(optional($from_user->wallet)->amount, $amount);
        $after_to_amount = bcadd(optional($to_user->wallet)->amount, $amount);

        $from_wallet = $from_user->wallet;
        $from_wallet->amount = $after_from_amount;
        $from_wallet->update();

        $to_wallet = $to_user->wallet;
        $to_wallet->amount = $after_to_amount;
        $to_wallet->update();

        $reference_number = Generate::referenceNumber();

        //   From User
        $from_account_transaction = Transaction::create([
            'user_id' => $from_user->id,
            'amount' => $amount,
            'reference_number' => $reference_number,
            'transaction_id' => Generate::transactionId(),
            'note' => $note,
            'source_id' => $to_user->id,
            'type' => 2, //expense
        ]);
        $title = "Transfer Successfully";
        $message = 'Transfer to ' . $to_user->name . ' Amount is ' . $amount;
        $sourceable_id = $from_account_transaction->id;
        $sourceable_type = Transaction::class;
        $web_link = url('/profile');

        Notification::send($from_user, new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link));
        //  To User
        $to_account_transaction = Transaction::create([
            'user_id' => $to_user->id,
            'amount' => $amount,
            'reference_number' => $reference_number,
            'transaction_id' => Generate::transactionId(),
            'note' => $note,
            'source_id' => $from_user->id,
            'type' => 1, //income
        ]);

        $title = "Transfer Successfully";
        $message = 'Transfer from ' . $from_user->name . ' Amount is ' . $amount;
        $sourceable_id = $to_account_transaction->id;
        $sourceable_type = Transaction::class;
        $web_link = url('/profile');

        Notification::send($to_user, new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link));
        //  To User
        return Response::success('Transfer Successfully.');
    }

    public function transaction(Request $request)
    {
        $auth_user = auth()->user();
        $transactions = Transaction::where('user_id', $auth_user->id);
        if ($request->type) {
            if ($request->type == 'income') {
                $type = 1;
            } elseif ($request->type == 'expense') {
                $type = 2;
            }
            $transactions = $transactions->where('type', $type);
        }
        if ($request->start_date && $request->end_date) {
            $transactions = $transactions->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date);
        }
        $transactions = $transactions->paginate(3);
        $data = new TransactionCollection($transactions);
        return Response::success($data);
    }

    public function transactionDetail(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required',
        ]);
        $transaction = Transaction::where('user_id', auth()->user()->id)->where('transaction_id', $request->transaction_id)->first();
        $data = new TransactionDetailResource($transaction);
        return Response::success($data);

    }
    public function notification(){
        $auth_user=auth()->user();
        $notifications=$auth_user->notifications()->paginate(3);
        $data=new NotificationCollection($notifications);
        return Response::success($data);
    }

    public function notificationDetail(Request $request){
        $auth_user=auth()->user();
        $notification=$auth_user->notifications()->where('id',$request->notification_id)->first();
        if(!$notification){
            return Response::error(422,'This notification is invalid.',null);
        }
        $notification->markAsRead();
        $data=new NotificationDetailResource($notification);
        return Response::success($data);
    }
}
