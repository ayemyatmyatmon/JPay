<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Generate;
use App\Helpers\Testing;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\TransferConfirmationRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
class PageController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        return view('frontend.home', compact('user'));
    }
    public function profile()
    {
        $user = Auth::guard('web')->user();

        return view('frontend.profile', compact('user'));
    }
    public function wallet()
    {
        $user = Auth::guard('web')->user();
        return view('frontend.wallet', compact('user'));
    }
    public function checkPhone(Request $request)
    {
        $to_phone = User::where('phone_number', $request->to_phone)->first();
        if ($to_phone) {
            return response()->json([
                'message' => 'success',
                'data' => $to_phone,
            ]);
        }
        return response()->json([
            'message' => 'fail',
            'data' => 'Invalid Phone Number',
        ]);
    }
    public function transfer()
    {
        $user = Auth::guard('web')->user();
        return view('frontend.transfer', compact('user'));
    }

    public function transferConfirmation(TransferConfirmationRequest $request)
    {
        $auth_user = Auth::guard('web')->user();
        $user = User::where('phone_number', $request->to_phone)->first();
        if ($auth_user->phone_number == $request->to_phone || !$user) {
            return back()->withErrors(['fail' => 'Invalid Phone Number'])->withInput();
        }
        if ($user) {
            $from_phone = $auth_user->phone_number;
            $to_phone = $request->to_phone;
            $to_name = $user->name;
            $amount = $request->amount;
            $note = $request->note ? $request->note : '-';
            return view('frontend.transfer_confirmation', compact('auth_user', 'from_phone', 'to_phone', 'amount', 'note', 'to_name'));
        }

    }
    public function checkPassword(Request $request)
    {
        if (!$request->password) {
            return response()->json([
                'message' => 'fail',
                'data' => 'Please Enter your password.',
            ]);
        }
        $auth_user = Auth::guard('web')->user();
        if (Hash::check($request->password, $auth_user->password)) {
            return response()->json([
                'message' => 'success',
            ]);
        }
        return response()->json([
            'message' => 'fail',
            'data' => 'Password is incorrect.',
        ]);
    }

    public function transferComplete(TransferConfirmationRequest $request)
    {
        $from_user = Auth::guard('web')->user();
        $to_user = User::where('phone_number', $request->to_phone)->first();
        $amount = $request->amount;
        $note = $request->note;
        if ($from_user->phone_number == $request->to_phone) {
            return redirect()->route('transfer')->withErrors(['fail' => 'Invalid Phone Number'])->withInput();
        }
        if (!$from_user->wallet || !$to_user->wallet) {
            return redirect()->route('transfer')->withErrors(['fail' => 'Invalid Wallet'])->withInput();
        }
        if (optional($from_user->wallet)->amount < $request->amount) {
            return redirect()->route('transfer')->withErrors(['fail' => 'Your Balance not enough for transfer.'])->withInput();
        }
        DB::beginTransaction();

        try {

            $from_wallet = $from_user->wallet ? $from_user->wallet : null;
            $from_wallet->decrement('amount', $amount);
            $from_wallet->update();

            $to_wallet = $to_user->wallet ? $to_user->wallet : null;
            $to_wallet->increment('amount', $amount);
            $from_wallet->update();
            $reference_number = Generate::referenceNumber();

            $from_transaction = Transaction::create([
                'reference_number' => $reference_number,
                'transaction_id' => Generate::transactionId(),
                'user_id' => $from_user->id,
                'source_id' => $to_user->id,
                'type' => 2,
                'amount' => $amount,
                'note' => $note,
            ]);

            $to_transaction = Transaction::create([
                'reference_number' => $reference_number,
                'transaction_id' => Generate::transactionId(),
                'user_id' => $to_user->id,
                'source_id' => $from_user->id,
                'type' => 1,
                'amount' => $amount,
                'note' => $note,
            ]);
            DB::commit();
            return redirect("transaction_detail/" . $from_transaction->transaction_id)->with('success', 'Transfer Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transfer')->withErrors(['fail' => $e->getMessage()])->withInput();

        }

    }
    public function transaction(Request $request)
    {
        $auth_user = Auth::guard('web')->user();
        $transactions = Transaction::where('user_id', $auth_user->id);
        if ($request->type) {
            $transactions = $transactions->where('type', $request->type);
        }
        if ($request->date) {
            $transactions = $transactions->whereDate('created_at', $request->date);

        }
        $transactions = $transactions->orderByDesc('created_at')->paginate(5);
        return view('frontend.transaction', compact('transactions'));
    }

    public function transactionDetail($transaction_id)
    {
        $auth_user = Auth::guard('web')->user();
        $transaction = Transaction::where('user_id', $auth_user->id)->where('transaction_id', $transaction_id)->first();
        return view('frontend.transaction_detail', compact('transaction'));
    }
    public function changePassword()
    {
        $user = Auth::guard('web')->user();
        return view('frontend.change_password', compact('user'));
    }

    public function changePasswordStore(ChangePasswordRequest $request)
    {
        $user = Auth::guard('web')->user();
        $user_password = $user->password;
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        if (Hash::check($old_password, $user_password)) {
            $user->password = Hash::make($new_password);
            $user->update();

            $title = __('transaction.change_password');
            $message = __('transaction.successfully_change_password');
            $sourceable_id = 1;
            $sourceable_type = User::class;
            $web_link = url('profile');
            Notification::send([$user], new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link));
            return redirect()->route('account_profile')->with('success', 'Successfully Updated');
        }

        return back()->withErrors(['fail' => 'Old Password is not correct'])->withInput();
    }

    public function receiveQR()
    {
        $user = Auth::guard('web')->user();
        return view('frontend.receive_qr', compact('user'));
    }
    public function scanQR()
    {
        return view('frontend.scan_pay_qr');
    }

    public function scanPayForm(Request $request)
    {
        $to_user = User::where('phone_number', $request->to_phone)->first();
        if ($to_user) {
            $to_phone = $to_user->phone_number;
            $to_name = $to_user->name;

        }
        $user = Auth::guard('web')->user();

        if (!isset($to_user)) {
            return back()->withErrors(['fail' => 'Phone No is invalid.'])->withInput();
        }
        if ($to_phone == $user->phone_number) {
            return back()->withErrors(['fail' => 'Phone No is invalid.'])->withInput();

        }

        return view('frontend.scan_pay_form', compact('user', 'to_phone', 'to_name'));
    }
    public function scanPayConfirmation(TransferConfirmationRequest $request)
    {
        $auth_user = Auth::guard('web')->user();
        $user = User::where('phone_number', $request->to_phone)->first();
        if ($auth_user->phone_number == $request->to_phone || !$user) {
            return back()->withErrors(['fail' => 'Invalid Phone Number'])->withInput();
        }
        if ($user) {
            $from_phone = $auth_user->phone_number;
            $to_phone = $request->to_phone;
            $to_name = $user->name;
            $amount = $request->amount;
            $note = $request->note ? $request->note : '-';
            return view('frontend.transfer_confirmation', compact('auth_user', 'from_phone', 'to_phone', 'amount', 'note', 'to_name'));
        }

    }
    public function scanPayComplete(TransferConfirmationRequest $request)
    {
        $from_user = Auth::guard('web')->user();
        $to_user = User::where('phone_number', $request->to_phone)->first();
        $amount = $request->amount;
        $note = $request->note;
        if ($from_user->phone_number == $request->to_phone) {
            return redirect()->route('transfer')->withErrors(['fail' => 'Invalid Phone Number'])->withInput();
        }
        if (!$from_user->wallet || !$to_user->wallet) {
            return redirect()->route('transfer')->withErrors(['fail' => 'Invalid Wallet'])->withInput();
        }
        if (optional($from_user->wallet)->amount < $request->amount) {
            return redirect()->route('transfer')->withErrors(['fail' => 'Your Balance not enough for transfer.'])->withInput();
        }
        DB::beginTransaction();

        try {

            $from_wallet = $from_user->wallet ? $from_user->wallet : null;
            $from_wallet->decrement('amount', $amount);
            $from_wallet->update();

            $to_wallet = $to_user->wallet ? $to_user->wallet : null;
            $to_wallet->increment('amount', $amount);
            $from_wallet->update();
            $reference_number = Generate::referenceNumber();

            $from_transaction = Transaction::create([
                'reference_number' => $reference_number,
                'transaction_id' => Generate::transactionId(),
                'user_id' => $from_user->id,
                'source_id' => $to_user->id,
                'type' => 2,
                'amount' => $amount,
                'note' => $note,
            ]);

            $to_transaction = Transaction::create([
                'reference_number' => $reference_number,
                'transaction_id' => Generate::transactionId(),
                'user_id' => $to_user->id,
                'source_id' => $from_user->id,
                'type' => 1,
                'amount' => $amount,
                'note' => $note,
            ]);
            DB::commit();
            return redirect("transaction_detail/" . $from_transaction->transaction_id)->with('success', 'Transfer Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transfer')->withErrors(['fail' => $e->getMessage()])->withInput();

        }

    }

    public function test(){
        
       return $this->hello("Wrong");
       
    }
    public function hello($var){
        return "something".$var;
    }
    

}
