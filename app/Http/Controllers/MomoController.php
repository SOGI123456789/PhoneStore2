<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use GuzzleHttp\Client;

class MomoController extends Controller
{
    public function createQr(Request $request)
    {
        $amount = $request->input('amount');
        $amount = preg_replace('/[^\d]/', '', $amount); // Loại bỏ ký tự không phải số
        $amount = (int)$amount; // Đảm bảo là số nguyên
        $orderCode = $request->input('order_code');
        $endpoint = 'https://test-payment.momo.vn/v2/gateway/api/create';
        $partnerCode = 'MOMO';
        $accessKey = 'F8BBA842ECF85';
        $secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';
        $orderId = $orderCode ? $orderCode : ('ORDER' . time());
        $orderInfo = $orderCode ? $orderCode : 'Thanh toan don hang';
        $redirectUrl = 'http://127.0.0.1:8000/order/success';
        $ipnUrl = 'http://127.0.0.1:8000/order/ipn';
        $requestType = 'captureWallet';
        $extraData = '';
        $requestId = $orderId; // Thêm trường requestId, có thể dùng orderId hoặc uniqid()

        // Tạo signature
        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac('sha256', $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'requestType' => $requestType,
            'ipnUrl' => $ipnUrl,
            'redirectUrl' => $redirectUrl,
            'orderId' => $orderId,
            'amount' => $amount,
            'orderInfo' => $orderInfo,
            'extraData' => $extraData,
            'lang' => 'vi',
            'signature' => $signature
        ];

        $client = new Client();
        try {
            $res = $client->post($endpoint, [
                'json' => $data,
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'verify' => false // Bỏ qua kiểm tra SSL cho môi trường test
            ]);
            $body = json_decode($res->getBody(), true);
            if (isset($body['payUrl'])) {
                return response()->json(['qr_url' => $body['payUrl']]);
            } else {
                return response()->json(['error' => 'Không lấy được mã QR Momo!', 'momo_response' => $body], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi khi gọi API Momo: ' . $e->getMessage()], 500);
        }
    }
}
