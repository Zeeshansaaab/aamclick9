<?php

namespace App\Enums;

enum Status : string {
    case Active = 'active';
    case Pending = 'pending';
    case InActive = 'inactive';

    public function label()
    {
        return match($this){
            self::Active => 'Active',
            self::Pending => 'Pending',
            self::InActive => 'In Active'
        };
    }

    public function cssClass()
    {
        return match($this){
            self::Active => 'success text-success',
            self::Pending => 'warning text-warning',
            self::InActive => 'danger text-danger'
        };
    }

    //Get all cases Status::cases();
    // validation new Enum(Status::class);
}