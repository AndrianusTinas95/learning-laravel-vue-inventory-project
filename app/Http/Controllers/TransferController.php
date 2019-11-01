<?php

namespace App\Http\Controllers;

use App\Exports\TransferExport;
use App\Model\Location;
use App\Model\Product;
use App\Model\Transfer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfer = Transfer::orderBy('created_at','desc')->get();
        return response()->json(['transfer'=> $transfer],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        if(count(request()->all()) == 10){
            foreach ($request->serial as $key => $value) {
                $productid[] = Product::updateOrCreate([
                    'serial' => $request->serial[$key]
                ],[
                    'serial' => $request->serial[$key],
                    'quantity_id' => $request->quantity[$key],
                    'manufacture_id' => $request->manufacture[$key],
                    'description_id' => $request->description[$key],
                    'category_id' => $request->category[$key],
                    'brand_id' => $request->brand[$key],
                    'status' => $request->status[$key],
                ])->id;
            }
        }else{
            $productid = $request->serial;
        }
        $products = Product::where('id',$productid[0])->select('location_id')->first();

        $lastI4 = $products->location->BU;
        $lastI6 = $products->location->OU;
        $lastK6 = $products->location->name;

        foreach ($request->serial as $key => $value) {
            $product = Product::where('id',$productid[$key])->first();
            $location = Location::where('id',$request->location[$key])->first();
            $location->select('lastLocation')->update(['lastLocation'=> $lastK6]);

            Transfer::create([
                'product_id'    => $productid[$key],
                'location_id'   => $request->locaton[$key],
                'status'        => $request->status[$key]
            ])->toArray();

            $status = '';
            $serial = '';
            $quantity =1;

            if((int)$request->status[$key] === 1){
                $status = 'TRANSFER';
            }elseif((int)$request->status[$key] === 2){
                $status = 'DEPLOY';
            }elseif((int)$request->status[$key] === 3){
                $status = 'REPLACED';
            }

            if($product->serial){
                $serial = $product->serial;
            }else{
                $serial ='';
            }

            if($product->serial && $product->quantity == 1){
                $quantity = 1;
            }else{
                $quantity = $request->quantity[$key];
            }

            $cueentLocation = $request->location[$key] ?? '';

            $data[]=[
                'Record #'      => $key+1,
                'Asset ID'      => '',
                'Asset Category'=> $product->category ? $product->category->name : '',
                'Description'   => $product->description ? $product->description->name : '',
                'Tag Number'    => '',
                'Serial Number' => $serial,
                'Quantity'      => (int) $quantity,
                'UQM'           => '',
                'Invoice#'      => '',
                'Manufacture'   => $product->manufacure ? $product->manufacure->name : '',
                'Model'         => $product->brand ? $product->brand->name : '',
                'Status'        =>$status,
                'QU #'          => '',
                'Dept.'         => '',
                'Location'      => $product->location ? $product->location->name : '',
                'Comments'      => $status
            ];
            Product::where('id',$productid[$key])->update(
                ['location_id'=>$request->location[$key]]
            );
        }
        Excel::load(storage_path('excel/export/CFAT_APPROVAL.xlsx'),function($render) use($data,$lastI4, $lastI6, $lastK6,$location){
            $render->sheet('SFAT 1ST FLOOR LUSIA',function($sheet)use($data,$lastI4,$lastI6,$lastK6,$location){
                $currentI4 = $location->BU;
                $currentI6 = $location->QU;
                $currentK6 = $location->name;

                $sheet->setOrientation('landscape');
                $sheet->setCellValue('I4','BU Transferring From'.$lastI4 . 'to' . $currentI4);
                $sheet->setCellValue('I5','Operating Unit Testing '.$lastI6 . 'to' . $currentI6);

                $sheet->setCellValue('K6','From '.$lastK6 . 'to' . $currentK6);
                $sheet->setCellValue('B3',Carbon::now());
                $sheet->fromArray($data,null,'A12',false,false);
            });
        })->download('xlsx');

        // return Excel::download(new TransferExport,'tes.xlsx');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transfer $transfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfer $transfer)
    {
        //
    }
}
