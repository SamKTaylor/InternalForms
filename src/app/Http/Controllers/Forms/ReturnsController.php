<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\ProductReturn\Save;
use App\Http\Requests\Forms\ProductReturn\Resolve;
use App\Models\Forms\ProductReturn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;

class ReturnsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list(){
        return view('forms.returns.list', []);
    }

    public function json($filter){

        switch ($filter) {
            case "Active":
                $return = ProductReturn::whereNull('closed_date')
                            ->with('user_created_by')
                            ->get();
                break;
            case "Warehouse":
                $return = ProductReturn::whereIn('outcome', ProductReturn::warehouse_outcomes)
                        ->whereNull('closed_date')
                        ->with('user_created_by')
                        ->get();
                break;
            case "Sales":
                $return = ProductReturn::whereIn('outcome', ProductReturn::sales_outcomes)
                    ->whereNull('closed_date')
                    ->with('user_created_by')
                    ->get();
                break;
            case "Purchasing":
                $return = ProductReturn::whereIn('outcome', ProductReturn::purchasing_outcomes)
                    ->whereNull('closed_date')
                    ->with('user_created_by')
                    ->get();
                break;
            default:
                $return = ProductReturn::with('user_created_by')->get();
        }

        return DataTables($return)
            ->editColumn('date', function ($return) {
                return $return->first_contact_date->toDateString();
            })
            ->toJson();
    }

    public function add(){

        return view('forms.returns.add_edit', ["return" => new ProductReturn]);
    }

    public function edit($id){

        $return = ProductReturn::findorfail($id);

        if($return->closed_date == NULL){
            return view('forms.returns.add_edit', ["return" => $return]);
        }else{
            return Redirect::back()->withErrors("Unable to edit that return");
        }

    }

    public function view($id){

        $user_array = [];
        foreach (User::all() as $user){
            $user_array[$user->id] = $user->name;
        }

        $return = ProductReturn::findorfail($id);

        return view('forms.returns.view', ["return" => $return, 'user_array' => $user_array]);
    }

    public function save(Save $request){

        $return = ProductReturn::where('id', $request->input('id'))->first();

        if(!$return){
            $return = new ProductReturn;
        }else{
            if($return->closed_date != NULL){
                return Redirect::back()->withErrors("Unable to edit that return");
            }
        }

        $return->customer_name      = $request->input('customer_name');
        $return->issue              = ProductReturn::issue_options[$request->input('issue')];
        $return->first_contact_date = $request->input('first_contact_date');
        $return->order_number       = $request->input('order_number');
        $return->tag                = "";
        $return->created_by         = Auth::id();
        $return->save();
        $return->tag                = "RETURN-{$return->id}";
        $return->save();

        return Redirect::to("/Forms/Returns/View/{$return->id}")->with('success', 'Return Saved');
    }

    public function receive(Request $request)
    {

        $return = ProductReturn::findorfail($request->input('id'));

        if($return->goods_receive_date == NULL){

            $return->goods_receive_date = $request->input('goods_receive_date');
            $return->save();

            return Redirect::to("/Forms/Returns/View/{$return->id}")->with('success', 'Received');
        }else{
            return Redirect::to("/Forms/Returns/View/{$return->id}")->withErrors('Unable to Receive');
        }

    }

    public function inspected(Request $request)
    {

        $return = ProductReturn::findorfail($request->input('id'));

        if($return->goods_receive_date != NULL && $return->inspected_date == NULL){

            $return->inspected_date = $request->input('inspected_date');
            $return->outcome = $request->input('outcome');
            $return->save();

            return Redirect::to("/Forms/Returns/View/{$return->id}")->with('success', 'Inspected');
        }else{
            return Redirect::to("/Forms/Returns/View/{$return->id}")->withErrors('Unable to Inspect');
        }

    }

    public function resolve(Resolve $request){

        $return = ProductReturn::findorfail($request->input('id'));

        if($return->goods_receive_date != NULL && $return->inspected_date != NULL && $return->closed_date == NULL){

            $return->closed_date    = $request->input('closed_date');
            $return->further_action = $request->input('further_action');
            $return->save();

            return Redirect::to("/Forms/Returns/View/{$return->id}")->with('success', 'Inspected');
        }else{
            return Redirect::to("/Forms/Returns/View/{$return->id}")->withErrors('Unable to Inspect');
        }

    }

    public function csv(){

        $columns = Schema::getColumnListing('product_returns');

        $fd = fopen('php://temp/maxmemory:1048576', 'w');
        if($fd === FALSE) {
            die('Failed to open temporary file');
        }

        $user_relationships = [
            "created_by"
        ];

        fputcsv($fd, $columns);
        foreach(ProductReturn::all() as $record) {

            $array = [];
            foreach ($columns as $column){
                if(in_array($column, $user_relationships) && $record->$column != NULL){
                    $key = "user_" . $column;
                    $array[$column] = $record->$key->name;
                }else{
                    $array[$column] = $record->$column;
                }
            }

            fputcsv($fd, $array);
        }

        rewind($fd);
        $csv = stream_get_contents($fd);
        fclose($fd); // releases the memory (or tempfile)

        $headers = array(
            'Content-Type: text/csv',
        );

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'Returns.csv');

    }
}
