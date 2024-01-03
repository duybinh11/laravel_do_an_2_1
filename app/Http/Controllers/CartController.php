<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\CartModel;
use App\Models\User;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function get_all_cart($id_user)
    {
        $carts = User::with(['cart' => function ($cart) {

            $cart->orderByDesc('created_at')->with(['item' => function ($item) {
                $item->with('flash_sale')->withAvg('rate as rate_star', 'rate_star');
            }]);
        }])->find($id_user);
        return CartResource::collection($carts->cart);
    }
    public function delete_cart($id_cart)
    {
        try {
            $check = CartModel::find($id_cart)->delete();
            return Response()->json(['status' => true]);
        } catch (Exception $e) {
            return Response()->json(['status' => false, 'erorr' => $e]);
        }
    }
    public function change_amount($id_cart, $is_tang)
    {

        if ($is_tang) {
            CartModel::find($id_cart)->increment('amount');
        } else {
            CartModel::find($id_cart)->decrement('amount');
        }
    }
}
