<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use GuzzleHttp\Client;

class BankQrController extends Controller
{
    public function createQr(Request $request)
    {
        $amount = $request->input('amount');
        $amount = preg_replace('/[^\d]/', '', $amount);
        $amount = (int)$amount;
        $orderCode = $request->input('order_code');
        // Demo tài khoản ngân hàng
        $accountNo = '970436123456789'; // Số tài khoản demo
        $bankCode = 'VCB'; // Vietcombank
        $accountName = 'HUYNH CHI DUY'; // Tên chủ tài khoản demo
        $template = 'compact';
        $addInfo = $orderCode ? $orderCode : 'Thanh toan don hang';
        // Sử dụng API demo của vietqr.io
        $endpoint = 'https://img.vietqr.io/image/' . $bankCode . '-' . $accountNo . '-' . $template . '.png?amount=' . $amount . '&addInfo=' . urlencode($addInfo) . '&accountName=' . urlencode($accountName);
        // Trả về url ảnh QR cho frontend
        return response()->json(['qr_url' => $endpoint]);
    }
}
