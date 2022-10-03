<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);

        $info = json_decode($request->info);

        $upload = new Receipt;

        if ($request->file()) {
            $file_name = time() . '_' . $request->file->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');

            $upload->username = $info->username;
            $upload->full_name = $info->fullName;
            $upload->email = $info->email;
            $upload->phone = $info->phone;

            $upload->receipt = $file_name;
            $upload->receipt_id = random_int(100000, 999999);
            $upload->status = 'pending';
            $upload->save();

            return response()->json([
                'message' => 'success',
                'recepit_id' => $upload->receipt_id
            ]);
        } else {
            return response()->json(['message' => 'failed']);
        }
    }

    public function setReceiptStatus(Request $request)
    {
        $receipt_id = $request->id;
        $status = $request->status;
        if (Auth::user()) {
            $receipt = Receipt::find($receipt_id);
            $receipt->status = $status;
            $receipt->save();
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'failed']);
        }
    }


    public function searchReceipt(Request $request)
    {
        $receipt_id = $request->receipt_id;
        $receipt = Receipt::where('receipt_id', $receipt_id)->first();
        return response()->json(['receipt' => $receipt]);
    }

    public function getReceipts(Request $request)
    {
        $receipts = Receipt::orderBy('created_at', 'desc')->paginate(20);
        return response()->json(['receipts' => $receipts]);
    }

    public function deleteReceipt(Request $request)
    {
        if (Auth::user()) {
            $receipt = Receipt::find($request->receipt_id);
            unlink(storage_path('app/public/uploads/' . $receipt->receipt));
            $receipt->delete();
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'failed'], 401);
        }
    }

    public function checkReceiptStatusView(Request $request)
    {
        return view('check_receipt_status');
    }

    public function searchReceipts(Request $request)
    {
        if (Auth::user()) {
            $search_text = $request->search_text;
            $receipts = Receipt::where('receipt_id', 'like', '%' . $search_text . '%')
                ->orWhere('username', 'like', '%' . $search_text . '%')->paginate(20);
            return response()->json(['receipts' => $receipts]);
        }
    }

    public function receiptDetailsView(Request $request)
    {
        if (Auth::user()) {
            $receipt = Receipt::find($request->receipt_id);
            return view('receipt_details', ['receipt' => $receipt]);
        }
    }
}
