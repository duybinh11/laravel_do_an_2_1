<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResoruce;
use App\Models\FlashSaleModel;
use App\Models\ItemModel;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function get_item_flash_sale()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $sales = FlashSaleModel::where('time_start', '<=', $now)
            ->where('time_end', '>=', $now)
            ->orderByDesc('percent')
            ->with(['item' => function ($item) {
                $item->withAvg('rate as rate_star', 'rate_star');
            }])
            ->paginate(6);


        return ItemResoruce::collection($sales);
    }
    public function get_item_by_category($id_category, $isASC)
    {
        $isASC = boolval($isASC);

        $items = ItemModel::with(['flash_sale']);

        if ($id_category == 6) {
            $items = $items->orderByDesc('created_at');
        } else
        if ($id_category) {
            $items = $items->where('id_category', $id_category);
        }

        if ($isASC) {
            $items = $items->orderBy('price');
        } else {
            $items = $items->orderByDesc('price');
        }



        $items = $items->withAvg('rate as rate_star', 'rate_star');
        $items = $items->paginate(6);


        return CategoryResource::collection($items);
    }
    public function search_item($name, $id_category, $isASC)
    {
        $isASC = boolval($isASC);
        if ($id_category == 6) {
            $items = ItemModel::where('name', 'like',  '%' . $name . '%')->orderByDesc('created_at');
        } else if ($id_category == 0) {
            $items = ItemModel::where('name', 'like',  '%' . $name . '%');
        } else {
            $items = ItemModel::where('name', 'like',  '%' . $name . '%')->where('id_category', $id_category);
        }

        if ($isASC) {
            $items->orderBy('price');
        } else {
            $items->orderByDesc('price');
        }

        $items = $items->with('flash_sale');
        $items = $items->withAvg('rate as rate_star', 'rate_star');
        $items = $items->paginate(6);

        return CategoryResource::collection($items);
    }
}
