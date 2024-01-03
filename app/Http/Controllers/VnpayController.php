<?php

namespace App\Http\Controllers;

use App\Models\BillModel;
use App\Models\VnPayModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class VnpayController extends Controller
{
    public function get_vnpay($id_bill)
    {
        $vnpay = BillModel::find($id_bill)->with('vnpay')->first();
        return Response()->json($vnpay->vnpay);
    }
    public function update_bill(Request $request)
    {
        $id = $request->id_bill;
        BillModel::find($id)->update(['is_payment' => 1]);
    }
    public function add_vnpay($id_bill, $id, $bank_code, $money, $is_payment)
    {

        try {
            VnPayModel::create([
                'id' => $id,
                'id_bill' => $id_bill,
                'money' => $money,
                'bank_code' => $bank_code,
                'is_payment' => $is_payment,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            ]);
            return Response()->json(['status' => true]);
        } catch (Exception $e) {
            return Response()->json(['status' => false, 'erorr' => $e]);
        }
    }
    public function get_url(Request $request)
    {
        $money = $request->money;
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "https://localhost/vnpay_php/vnpay_return.php";
        $vnp_TmnCode = "3K3KM342"; //Mã website tại VNPAY 
        $vnp_HashSecret = "EWFJOVVVXDDURGIYOPGUPXDKLDFBWQFJ"; //Chuỗi bí mật

        $time1 = time();
        $vnp_TxnRef = "$time1";
        $vnp_OrderInfo = 'Bshop';
        $vnp_OrderType = 'Banking';
        $vnp_Amount = $money * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        // $vnp_BankCode = $_POST['bank_code'];
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];


        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );


        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) { // nếu trong button k có trường name = redirect thì nó chạy else
            header('Location: ' . $vnp_Url);
            die();
        } else {
            $returnData = array(
                'code' => '00',
                'message' => 'success',
                'data' => $vnp_Url,
            );
            return Response()->json($returnData);
        }
    }
}
