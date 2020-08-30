<?php

namespace App\Models\Forms;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $dates = [
        'acknowledged_date',
        'complaint_date',
        'resolved_date'
    ];

    CONST receipt_type_options = [
        0 => "Phone",
        1 => "Email",
        2 => "Verbal",
        3 => "Social Media",
    ];

    CONST category_options = [
        0 => "Product Quality",
        1 => "Breakdown",
        2 => "Lead Time",
        3 => "Delivery",
        4 => "Advice",
        5 => "No Response",
        6 => "Wrong Product",
    ];

    CONST department_options = [
        0 => "Sales",
        1 => "Warehouse",
        2 => "Purchasing",
        3 => "Other",
    ];

    CONST status_options = [
        0 => "Investigating",
        1 => "Resolved to customer satisfaction",
        2 => "Unresolved and ongoing",
    ];

    public function user_received_by(){
        return $this->belongsTo(User::class, "received_by", "id");
    }

    public function user_assigned_to(){
        return $this->belongsTo(User::class, "assigned_to", "id");
    }

    public function user_resolved_by(){
        return $this->belongsTo(User::class, "resolved_by", "id");
    }
}

