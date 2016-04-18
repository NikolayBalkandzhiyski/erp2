<?php

namespace App\Http\Controllers\Reports;

use App\Deliveries;
use App\DeliveryProducts;
use App\Http\Requests\ReportsRequest;
use App\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Session\Session;

class ReportsController extends Controller
{

    public function __construct() {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deliveriesReport() {
        $title = trans('reports.reports');

        return view('reports.deliveries_report', compact('title'));
    }


    /**
     * Search deliveryes by date
     * @param ReportsRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deliveriesSearch(ReportsRequest $request) {

        $data = $request->all();

        $time = ' 00:00:00';

        if(isset($data['name']) && $data['name'] != ''){
            $deliveries = Products::join('delivery_products as dp' ,'products.id','=','dp.product_id')
                                ->join('deliveries as d','dp.delivery_id' ,'=','d.id')
                                ->select(
                                    'dp.*','d.*',
                                    'products.name',
                                    'dp.product_price',
                                    'dp.product_count as delivery_product_count',
                                    'dp.count_left as delivery_count_left'
                                )
                                ->where('products.name','LIKE','%'.$data['name'].'%')
                                ->groupBy('dp.delivery_id')
                                ->get();

        }
        else{

            $deliveries = Deliveries::whereBetween('created_at', [$data['date_from'] . $time, $data['date_to'] . $time])->get();

            foreach ($deliveries as $delivery) {

                $delivery_total = DeliveryProducts::where('delivery_id', '=', $delivery->id)->sum('total');

                $products = Products::join('delivery_products as dp', 'products.id', '=', 'dp.product_id')
                    ->select(
                        'products.name',
                        'dp.product_price',
                        'dp.product_count as delivery_product_count',
                        'dp.count_left as delivery_count_left'
                    )
                    ->where('dp.delivery_id', '=', $delivery->id)
                    ->get();
                $delivery->products = $products;
                $delivery->delivery_total = $delivery_total;
            }
        }
        $title = trans('reports.reports');

        $request->session()->put('deliveries', $deliveries);

        return view('reports.deliveries_report', compact('title', 'deliveries'));
    }

    /**
     * Send emails with deliveries report data
     * @param Request $request
     * @return mixed
     */
    public function deliveriesEmail(Request $request) {

        $deliveries = $request->session()->get('deliveries');

        //Where data will be send
        $emails = ['nikolay.balkandzhiyski@gmail.com'];

        $subject = trans('reports.deliveries_report').'_'.Carbon::now();

        Mail::send('emails.report_deliveries', ['deliveries' => $deliveries,'subject' => $subject], function ($message) use ($emails,$subject){
            $message->from('nikolay.balkandzhiyski@gmail.com', trans('reports.products_report').'_'.Carbon::now());
            $message->subject($subject);
            $message->to($emails);
        });

        return Redirect::back();

    }

    /**
     * Export deliveries to excel
     * @param Request $request
     */
    public function deliveriesExport(Request $request) {
        $deliveries = $request->session()->get('deliveries');

        $date = Carbon::now();
        $date = $date->format('Y-m-d H-i-s');

        // dd($deliveries->deliveries->id);
        Excel::create($date . '_export', function ($excel) use ($deliveries) {

            $excel->sheet('Sheetname', function ($sheet) use ($deliveries) {

                $i = 1;
                foreach ($deliveries as $delivery) {

                    $sheet->row($i, [
                        trans('reports.id'),
                        trans('reports.created_at'),
                        trans('reports.total').trans('reports.price_sign'),
                        trans('reports.product_name'),
                        trans('reports.product_price'),
                        trans('reports.count_delivered'),
                        trans('reports.count_left')
                    ]);
                    $sheet->row($i, function ($row) {
                        $row->setBackground('#dadada');
                        $row->setFont([
                            'family' => 'Calibri',
                            'size'   => '10',
                            'bold'   => true
                        ]);
                    });
                    $i++;

                    $sheet->row($i, [
                        $delivery->id,
                        $delivery->created_at,
                        $delivery->delivery_total
                    ]);

                    foreach ($delivery->products as $product) {

                        $sheet->cell('D'.$i,
                            $product->name
                        );
                        $sheet->cell('E'.$i,
                            $product->product_price
                        );
                        $sheet->cell('F'.$i,
                            $product->delivery_product_count
                        );
                        $sheet->cell('G'.$i,
                            $product->delivery_count_left
                        );

                        $i++;
                    }

                    $i++;
                }

            });


        })->export('xls');

    }


    /**
     * Show products report form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsReport() {


        $title = trans('reports.products_report');

        return view('reports.products_report', compact('title'));
    }

    /**
     * Search products by name
     * @param ReportsRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsSearch(Request $request) {

        $input = $request->all();
        $minimum = 0.5;

        $products = DeliveryProducts::join('products as p', 'delivery_products.product_id', '=', 'p.id')
            ->select(
                'p.name',
                'delivery_products.product_price',
                DB::raw('SUM(delivery_products.product_count)as delivery_product_count'),
                DB::raw('SUM(delivery_products.count_left) as delivery_count_left')
            )
            ->groupBy('delivery_products.product_id')
            ->orderBy('delivery_count_left', 'ASC')
            ->get();

        if (isset($input['product_id']) && $input['product_id'] == '' && !empty($input['name'])) {
            $products = DeliveryProducts::join('products as p', 'delivery_products.product_id', '=', 'p.id')
                ->select(
                    'p.name',
                    'delivery_products.product_price',
                    DB::raw('SUM(delivery_products.product_count)as delivery_product_count'),
                    DB::raw('SUM(delivery_products.count_left) as delivery_count_left')
                )
                ->where('p.name', 'LIKE', '%' . $input['name'] . '%')
                ->groupBy('delivery_products.product_id')
                ->orderBy('delivery_count_left', 'ASC')
                ->get();
        } elseif (isset($input['product_id']) && $input['product_id'] != '') {
            $products = DeliveryProducts::join('products as p', 'delivery_products.product_id', '=', 'p.id')
                ->select(
                    'p.name',
                    'delivery_products.product_price',
                    DB::raw('SUM(delivery_products.product_count)as delivery_product_count'),
                    DB::raw('SUM(delivery_products.count_left) as delivery_count_left')
                )
                ->where('delivery_products.product_id', '=', $input['product_id'])
                ->get();
        }
        elseif(!empty($input['delivery_count_left'])){
            $products = DeliveryProducts::join('products as p', 'delivery_products.product_id', '=', 'p.id')
                ->select(
                    'p.name',
                    'delivery_products.product_price',
                    DB::raw('SUM(delivery_products.product_count) as delivery_product_count'),
                    DB::raw('SUM(delivery_products.count_left) as delivery_count_left')
                )
                ->havingRaw('SUM(delivery_products.count_left) < '.$input['delivery_count_left'])
                ->groupBy('delivery_products.product_id')
                ->orderBy('delivery_count_left', 'ASC')
                ->get();
            $minimum = $input['delivery_count_left'];
        }




        $title = trans('reports.products_report');

        $request->session()->put('products', $products);

        return view('reports.products_report', compact('title', 'products', 'minimum'));
    }

    /**
     * Send email with products report data
     * @param Request $request
     * @return mixed
     */
    public function productsEmail(Request $request) {
        $products = $request->session()->get('products');
        //Minimum quantity left for alert
        $minimum = 0.5;
        //Where data will be send
        $emails = ['nikolay.balkandzhiyski@gmail.com'];
        $subject = trans('reports.products_report').'_'.Carbon::now();

        Mail::send('emails.report_products', ['products' => $products,'minimum' => $minimum,'subject' => $subject], function ($message) use ($emails,$subject){
            $message->from('nikolay.balkandzhiyski@gmail.com', trans('reports.products_report').'_'.Carbon::now());
            $message->subject($subject);
            $message->to($emails);
        });

        return Redirect::back();
    }

    /**
     * Export data to excel
     * @param Request $request
     */
    public function productsExport(Request $request) {

        $products = $request->session()->get('products');

        $date = Carbon::now();
        $date = $date->format('Y-m-d H-i-s');

        Excel::create($date . '_'.trans('reports.products_report'), function ($excel) use ($products) {

            $excel->sheet('Sheetname', function ($sheet) use ($products) {
                $i=1;
                $sheet->row($i,[
                    trans('reports.product_name'),
                    trans('reports.product_price'),
                    trans('reports.count_delivered'),
                    trans('reports.count_left')
                ]);
                $sheet->row($i, function ($row) {
                    $row->setBackground('#dadada');
                    $row->setFont([
                        'family' => 'Calibri',
                        'size'   => '10',
                        'bold'   => true
                    ]);
                });
                $i++;
                foreach($products as $product){
                    $sheet->cell('A'.$i, $product->name);
                    $sheet->cell('B'.$i, $product->product_price);
                    $sheet->cell('C'.$i, $product->delivery_product_count);
                    $sheet->cell('D'.$i, $product->delivery_count_left);
                    $sheet->cell('D'.$i, function($cell) use ($product){
                        if($product->delivery_count_left <= 0.5){
                            $cell->setBackground('#F44336');
                        }
                    });
                    $i++;
                }

            });

        })->export('xls');


    }


    /**
     * Search Products
     * @return mixed
     */
    public function ajaxsearch() {
        $input = Input::get('term');

        $products = DB::table('products')
            ->where('name', 'like', '%' . $input . '%')
            ->get();

        foreach ($products as $product) {
            $data[] = ['value' => $product->name, 'id' => $product->id];
        }
        return Response::json($data);
    }
}
