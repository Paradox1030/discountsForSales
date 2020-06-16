<?php

namespace App\Http\Controllers;

use App\Models\buyers;
use App\Models\discounts;
use App\Models\sales;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Index extends Controller
{
    public function build()
    {
        $buyers = buyers::all();

        $discounts_ar = [];
        $discounts = DB::table('discounts')->get();
        foreach ($discounts as $discount) {
            $date = new DateTime($discount->created_at);
            $date->modify('-' . $discount->recent_months . ' month');
            $discounts_ar[$discount->discount_percentage] = [
                'minMonth' => $date->format('Y-m-d h:i:s'),
                'number_purchases' => $discount->number_purchases
            ];
        }



        foreach ($buyers as &$buyer) {
            $disc = $this->discounts($buyer['id'], date('Y-m-d h:i:s'));
            $buyer['sale'] = isset($disc[0]) && $disc[0]->discount_percentage ? $disc[0]->discount_percentage : 0;
        }

        $sales = DB::select('select s.id, s.buyer_id , s.sale_amount, s.created_at, b.first_name, b.second_name, b.patronymic from sales as s left join buyers as b ON s.buyer_id = b.id');
        return view('index', [
            'buyers' => $buyers,
            'sales' => $sales
        ]);
    }

    public function createBuyer(Request $request)
    {
        $first_name = $request->input('first_name');
        $second_name = $request->input('second_name');
        $patronymic = $request->input('patronymic');

        DB::table('buyers')->insert([
            'first_name' => $first_name,
            'second_name' => $second_name,
            'patronymic' => $patronymic,
            'created_at' => Carbon::now()
        ]);

        return redirect('/');
    }

    public function deleteBuyer(Request $request)
    {
        $id = $request->input('id');

        DB::table('buyers')->delete($id);

        return redirect('/');
    }

    public function createSales(Request $request)
    {
        $buyer_id = $request->input('buyer_id');
        $sale_amount = $request->input('sale_amount');
        $date_sale = $request->input('date_sale');

        DB::table('sales')->insert([
            'buyer_id' => $buyer_id,
            'sale_amount' => $sale_amount,
            'created_at' => $date_sale
        ]);

        return redirect('/');
    }

    public function deleteSales(Request $request)
    {
        $id = $request->input('id');

        DB::table('sales')->delete($id);

        return redirect('/');
    }


    protected function discounts($buyerId, $date)
    {

        $max_recent_months = DB::select("select max(recent_months) as max_recent_months from discounts");

        $dateCur = new DateTime($date);
        $dateCur->modify('-' . $max_recent_months[0]->max_recent_months . ' month');
        $date_max = $dateCur->format('Y-m-d h:i:s');
        $number_purchases = DB::select("select count(*) as c from sales where buyer_id = $buyerId and MONTH(created_at) >= MONTH('$date_max')");
        $number_purchases = $number_purchases[0]->c;

        return DB::select("select max(discount_percentage) as discount_percentage from discounts where number_purchases <= $number_purchases");
    }

    public function getbuyers(Request $request)
    {
        $date = $request->get('date');
        $date = date('Y-m-d h:i:s', strtotime($date));
        $buyers = buyers::all();
        foreach ($buyers as &$buyer) {
            $disc = $this->discounts($buyer['id'], $date);
            $buyer['sale'] = isset($disc[0]) ? $disc[0]->discount_percentage : 0;
        }

        return json_encode($buyers);
    }
}
