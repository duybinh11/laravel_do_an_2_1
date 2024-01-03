<?php

namespace App\Http\Controllers;

use App\Models\AddressHistoryModel;
use App\Models\BillModel;
use App\Models\OrderModel;
use App\Models\ShopModel;
use App\Models\StatusTransportModel;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function login(Request $request)
    {
        $shop = ShopModel::where('email', $request->email)->where('password', $request->password)->first();

        if ($shop) {
            return Response()->json(['status' => true, 'shop' => $shop]);
        } else {
            return Response()->json(['status' => false]);
        }
    }
    public function get_order($id_shop)
    {
        $order = OrderModel::with([
            'item',
            'status_transport' => function ($state) {
                $state->orderBy('created_at', 'ASC');
            }
        ])
            ->whereHas('item', function ($item) use ($id_shop) {
                $item->where('id_shop', $id_shop);
            })
            ->orderByDesc('id')
            ->get();
        return Response()->json($order);
    }
    public function get_orde_data($id_order)
    {
        $order = OrderModel::find($id_order);
        $bill = BillModel::find($order->id_bill);
        $address_receive = AddressHistoryModel::find($bill->id_address_history);
        $user_model = User::find($bill->id_user);
        return Response()->json([
            'address_receive' => $address_receive,
            'user_model' => $user_model,
            'state_payment' => $bill->is_payment
        ]);
    }
    public function cofirm_order(Request $request)
    {
        $check = OrderModel::find($request->id_order)->update(['is_shop_confirm' => 1]);
        if ($check) {
            StatusTransportModel::create(
                [
                    'id_order' => $request->id_order,
                    'place' => 'Chuẩn bị hàng',
                    'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                ]
            );
        }
        return Response()->json(['status' => $check]);
    }
    public function update_address(Request $request)
    {
        $address = StatusTransportModel::create(['id_order' => $request->id_order, 'place' => $request->place, 'created_at' => Carbon::now('Asia/Ho_Chi_Minh')]);
        return Response()->json(['address' => $address]);
    }
}
