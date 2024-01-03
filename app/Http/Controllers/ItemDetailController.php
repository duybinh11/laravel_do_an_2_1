<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResoruce;
use App\Models\AddressHistoryModel;
use App\Models\BillModel;
use App\Models\CartModel;
use App\Models\ItemModel;
use App\Models\StatusTransportModel;
use App\Models\User;
use Exception;
use Illuminate\Support\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestStatus\Risky;

class ItemDetailController extends Controller
{
    public function item_detail($id_item)
    {
        $item = ItemModel::with('flash_sale')->find($id_item);
        $item->rate_star = $item->rate_star();
        return new CategoryResource($item);
    }

    public function get_shop($id_item)
    {
        $item = ItemModel::find($id_item);
        $shop = $item->shop()->first();
        return Response()->json($shop);
    }
    public function get_rate($id_item)
    {
        $item = ItemModel::with(['rate' => function ($rate) {
            $rate->orderByDesc('created_at')->with(['user']);
        }])->find($id_item);
        return Response()->json($item);
    }
    public function add_cart(Request $request)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        try {
            CartModel::create(
                [
                    'id_item' => ($request->id_item),
                    'id_user' => ($request->id_user),
                    'amount' => ($request->amount),
                    'created_at' => $now
                ]
            );

            return Response()->json(['status' => true]);
        } catch (Exception $e) {
            return Response()->json(['status' => false, 'erorr' => $e]);
        }
    }
    public function add_bill($price, $is_vnpay)
    {
        try {
            $id_bill = BillModel::create([
                'price' => $price,
                'is_vnpay' => $is_vnpay
            ]);
            return Response()->json(['status' => true, 'id_bill' => $id_bill]);
        } catch (Exception $e) {
            return Response()->json(['status' => false]);
        }
    }
    public function get_address($id_user)
    {
        $address = User::with('address_history_default')->find($id_user)->address_history_default;
        if ($address == null) {
            return Response()->json(['status' => false]);
        }
        return Response()->json(['status' => true, 'address' => $address]);
    }
}
