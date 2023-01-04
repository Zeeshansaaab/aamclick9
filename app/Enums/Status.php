<?php

namespace App\Enums;

enum Status : string {
    case Active = 'active';
    case InActive = 'inactive';

    public function label()
    {
        return match($this){
            self::Active => 'Active',
            self::InActive => 'In Active'
        };
    }

    public function cssClass()
    {
        return match($this){
            self::Active => 'success',
            self::InActive => 'danger'
        };
    }

    //Get all cases Status::cases();
    // validation new Enum(Status::class);
}