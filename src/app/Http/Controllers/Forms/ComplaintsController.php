<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\Complaint\Resolve;
use App\Http\Requests\Forms\Complaint\Save;
use App\Models\Forms\Complaint;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;

class complaintsController extends Controller
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
        return view('forms.complaints.list', []);
    }

    public function json($filter){

        switch ($filter) {
            case "asdadas":
                $complaints = Complaint::with('user_assigned_to')->get();
                break;
            case "My":
                $complaints = Complaint::where('assigned_to', Auth::id())
                    ->where('resolved_date', NULL)
                    ->with('user_assigned_to')
                    ->get();
                break;
            case "UnacknowledgedAll":
                $complaints = Complaint::where('acknowledged_date', NULL)
                    ->with('user_assigned_to')
                    ->get();
                break;
            case "UnacknowledgedMy":
                $complaints = Complaint::where('assigned_to', Auth::id())
                    ->where('acknowledged_date', NULL)
                    ->with('user_assigned_to')
                    ->get();
                break;
            default:
                $complaints = Complaint::with('user_assigned_to')->get();
        }

        return DataTables($complaints)
            ->editColumn('date', function ($complaint) {
                return $complaint->complaint_date->toDateString();
            })
            ->toJson();

    }

    public function add(){

        $user_array = [];
        foreach (User::all() as $user){
            $user_array[$user->id] = $user->name;
        }

        return view('forms.complaints.add_edit', ["complaint" => new Complaint, 'user_array' => $user_array]);
    }

    public function edit($id){

        $user_array = [];
        foreach (User::all() as $user){
            $user_array[$user->id] = $user->name;
        }

        $complaint = Complaint::findorfail($id);

        return view('forms.complaints.add_edit', ["complaint" => $complaint, 'user_array' => $user_array]);
    }

    public function view($id){

        $user_array = [];
        foreach (User::all() as $user){
            $user_array[$user->id] = $user->name;
        }

        $complaint = Complaint::findorfail($id);

        return view('forms.complaints.view', ["complaint" => $complaint, 'user_array' => $user_array]);
    }

    public function save(Save $request){

        $complaint = Complaint::where('id', $request->input('id'))->first();

        if(!$complaint){
            $complaint = new Complaint;
        }else{
            if($complaint->acknowledged_date != NULL && $complaint->assigned_to != $request->input('assigned_to')){
                $complaint->acknowledged_date = NULL;
            }
        }

        $complaint->complaint_date  = $request->input('complaint_date');
        $complaint->received_by     = $request->input('received_by');
        $complaint->receipt_type    = Complaint::receipt_type_options[$request->input('receipt_type')];
        $complaint->customer_name   = $request->input('customer_name');
        $complaint->description     = $request->input('description');
        $complaint->category        = Complaint::category_options[$request->input('category')];
        $complaint->department      = Complaint::department_options[$request->input('department')];
        $complaint->assigned_to     = $request->input('assigned_to');
        $complaint->status          = Complaint::status_options[$request->input('status')];

        $complaint->save();

        return Redirect::to("/Forms/Complaints/View/{$complaint->id}")->with('success', 'complaint Saved');

    }
    
    public function acknowledge($id){

        $complaint = Complaint::findorfail($id);
        
        if($complaint->acknowledged_date == NULL && $complaint->assigned_to == Auth::user()->id){
            $complaint->acknowledged_date = Carbon::now();
            $complaint->save();

            return Redirect::to("/Forms/Complaints/View/{$complaint->id}")->with('success', 'Acknowledged');
        }else{
            return Redirect::to("/Forms/Complaints/View/{$complaint->id}")->withErrors('Unable to Acknowledge');
        }
        
    }

    public function resolve(Resolve $request){

        $complaint = Complaint::findorfail($request->input('id'));

        $complaint->resolved_date = Carbon::now();
        $complaint->resolved_by = $request->input('resolved_by');
        $complaint->root_cause = $request->input('root_cause');
        $complaint->corrective_action = $request->input('corrective_action');
        $complaint->preventative_action = $request->input('preventative_action');
        $complaint->status = Complaint::status_options[1];
        $complaint->save();

        return Redirect::to("/Forms/Complaints/View/{$complaint->id}")->with('success', 'Resolved');

    }

    public function csv(){

        $columns = Schema::getColumnListing('complaints');

        $fd = fopen('php://temp/maxmemory:1048576', 'w');
        if($fd === FALSE) {
            die('Failed to open temporary file');
        }

        $user_relationships = [
            "received_by",
            "resolved_by",
            "assigned_to"
        ];

        fputcsv($fd, $columns);
        foreach(Complaint::all() as $record) {

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
        }, 'Complaints.csv');

    }
}
