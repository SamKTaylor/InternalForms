<?php

namespace App\Models\Forms;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    protected $dates = [
        'first_contact_date',
        'goods_receive_date',
        'inspected_date',
        'closed_date'
    ];

    CONST issue_options = [
        0 => "Unwanted - RTS",
        1 => "Warranty",
    ];

    CONST outcome_options = [
        1 => "Out Of Warranty",
        2 => "In Warranty - Fault Found",
        3 => "In Warranty - Unable To Check Fault",
        4 => "In Warranty - No Fault Found",
        5 => "Returned Not Wanted - Good Condition",
        6 => "Returned Not Wanted - Poor Condition",
    ];

    CONST outcome_actions = [
        0 => "Awaiting Inspection",
        1 => "Sales Inform Customer - No Credit & Scrap",
        2 => "Purchasing Send To Supplier",
        3 => "Purchasing Send To Supplier",
        4 => "Purchasing Send To Supplier",
        5 => "Sales Raise Credit Memo & Return To Stock",
        6 => "Sales Inform Customer No Credit And Scrap",
    ];

    CONST warehouse_outcomes = [0];
    CONST sales_outcomes = [1, 5, 6];
    CONST purchasing_outcomes = [2, 3, 4];

    public function user_created_by(){
        return $this->belongsTo(User::class, "created_by", "id");
    }

    public function Outcome(){
        if(isset(self::outcome_options[$this->outcome])){
            return self::outcome_options[$this->outcome];
        }else{
            return "UNKNOWN";
        }
    }

    public function OutcomeAction(){
        if(isset(self::outcome_actions[$this->outcome])){
            return self::outcome_actions[$this->outcome];
        }else{
            return "UNKNOWN";
        }
    }
}
