<?php

class PPProduktpass_Menge_Final extends Eloquent {

    protected $primaryKey = 'PPProduktpass_Menge_Id';
    protected $table      = 'PPProduktpass_Menge_Final';
    public $timestamps    = false;
    protected $fillable = [
        'PPProduktpass_Menge_PPProduktpass_Id',
        'PPProduktpass_Menge_CountryBlock',
        'PPProduktpass_Menge_Country',
        'PPProduktpass_Menge_TotalSalePerUnit',
        'PPProduktpass_Menge_Quantity',
        'PPProduktpass_Menge_PackingMethod',
        'PPProduktpass_Menge_DeliveryWeek',
        'PPProduktpass_Menge_Rotterdamk',
        'PPProduktpass_Menge_Barcelona',
        'PPProduktpass_Menge_Koper',
        'PPProduktpass_Menge_EKUSD',
        'PPProduktpass_Menge_VKFOBEUR',
        'PPProduktpass_Menge_CBEK',
        'PPProduktpass_Menge_Countrysizes',
        'PPProduktpass_Menge_CBVK',
        'PPProduktpass_Menge_LT1',
        'PPProduktpass_Menge_LT1Menge',
        'PPProduktpass_Menge_LT2',
        'PPProduktpass_Menge_LT2Menge',
        'PPProduktpass_Menge_LT3',
        'PPProduktpass_Menge_LT3Menge',
        'PPProduktpass_Menge_ArtikelInfo',
        'PPProduktpass_Menge_Kolli',
        'PPProduktpass_Menge_CountryGSM',
        'PPProduktpass_Menge_CartonSize',
        'PPProduktpass_Menge_PcsPerCarton',
        'PPProduktpass_Menge_CartonPerPal',
        'PPProduktpass_Menge_Trucks'
    ];

}
