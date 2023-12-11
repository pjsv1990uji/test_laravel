<?php

namespace App\Enums;

enum frequencyType: string {
	case diaria = 'diaria';
    case mensual = 'mensual';
    case anual = 'anual';

    public static function fromCase($case)
    {   
        try {
            $value = (new \ReflectionEnum(self::class))->getCase($case)->getValue()->value;
        } catch (\ReflectionException $e) {
            $value = null;
        }
        return $value;
    }
}