<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    #[Description('Onay Bekliyor')]
    const OnayBekliyor = 0;
    #[Description('Hazırlanıyor')]
    const Hazırlanıyor = 1;
    #[Description('İptal Edildi')]
    const İptalEdildi = 2;
    #[Description('Kargoya Verildi')]
    const KargoyaVerildi = 3;

}
