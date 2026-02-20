<?php

class PPInquiry extends Eloquent {

    protected $table = 'PPInquiry';
    public $timestamps = false;
    protected $primaryKey = 'PPProduktpass_Id';
    protected $fillable = array(
        'PPProduktpass_IAN',
        'PPProduktpass_Artikelbezeichnung',
        'PPProduktpass_Ausmusterung',
        'PPProduktpass_Ausmusterungnummer',
        'PPProduktpass_AltIAN',
        'PPProduktpass_AltArtikelbezeichnung',
        'PPProduktpass_Warengruppe',
        'PPProduktpass_Neu_Warengruppe',
        'PPProduktpass_Verpackungseinheit',
        'PPProduktpass_Thema',
        'PPProduktpass_Liefertermin',
        'PPProduktpass_LieferterminJahr',
        'PPProduktpass_Einkaeufer',
        'PPProduktpass_Marke',
        'PPProduktpass_Gesamtmenge',
        'PPProduktpass_Pruefinstitut',
        'PPProduktpass_Andere_Kriterien',
        'PPProduktpass_Zertifizierungen',
        'PPProduktpass_Logos',
        'PPProduktpass_Verkaufsverpackung',
        'PPProduktpass_Materialstaerke_der_Verkaufsverpackung',
        'PPProduktpass_Agentur',
        'PPProduktpass_Material',
        'PPProduktpass_Lizenz',
        'PPProduktpass_PPProjekte_Projekt',
        'PPProduktpass_Status',
        'PPProduktpass_Konstruktion',
        'PPProduktpass_Verarbeitung',
        'PPProduktpass_ZBV1_Name',
        'PPProduktpass_ZBV1_Wert',
        'PPProduktpass_ZBV2_Name',
        'PPProduktpass_ZBV2_Wert',
        'PPProduktpass_ZBV3_Name',
        'PPProduktpass_ZBV3_Wert',
        'PPProduktpass_ZBV4_Name',
        'PPProduktpass_ZBV4_Wert',
        'PPProduktpass_ZBV5_Name',
        'PPProduktpass_ZBV5_Wert',
        'PPProduktpass_Produkt_ZusatzGSM',
        'PPProduktpass_Produkt_Laenge',
        'PPProduktpass_Produkt_Breite',
        'PPProduktpass_Produkt_Hoehe',
        'PPProduktpass_Produkt_GSM',
        'PPProduktpass_WAWIArtikelnummer',
        'PPProduktpass_IsRevision',
        'PPProduktpass_RevisionArt',
        'PPProduktpass_Revisionsnummer',
        'PPProduktpass_RevisionAktuell',
        'PPProduktpass_RevisionVon_PPProduktpass_Id',
        'PPProduktpass_ProjektBild',
        'PPProduktpass_VersandfaehigeUmverpackung',
        'PPProduktpass_RFSicherung',
        'PPProduktpass_Passformlabel',
        'PPProduktpass_AndereTestkriterien',
        'PPProduktpass_ZertifizierungEigenschaften2',
        'PPProduktpass_ZertifizierungEigenschaften3',
        'PPProduktpass_ZertifizierungEigenschaften4',
        'PPProduktpass_ZertifizierungEigenschaften5',
        'PPProduktpass_GarantiezeitDauer',
        'PPProduktpass_GarentieArt',
        'PPProduktpass_LogoDruckverfahren',
        'PPProduktpass_Import_BISUser_Id',
        'PPProduktpass_Import_Datum',
        'PPProduktpass_Logos2',
        'PPProduktpass_Logos3',
        'PPProduktpass_Logos4',
        'PPProduktpass_Logos5',
        'PPProduktpass_Positionierung',
        'PPProduktpass_Charge',
        'PPProduktpass_AltCharge',
        'PPProduktpass_KAT',
        'PPProduktpass_BZP',
        'PPProduktpass_MOQ',
        'PPProduktpass_InitialeCharge',
        'PPProduktpass_Erstbestellung',
        'PPProduktpass_IsInquiry',
        'PPProduktpass_InquiryArt'
    );

    public function fillPP($fields) {

        cpcDebug::cpc_Debug("FKE:::::" . print_r($fields, true));

        $this->PPProduktpass_IAN = $fields['PPProduktpass_IAN'];

        $this->PPProduktpass_Artikelbezeichnung = $fields['PPProduktpass_Artikelbezeichnung'];
        $this->PPProduktpass_Ausmusterung = $fields['PPProduktpass_Ausmusterung'];
        $this->PPProduktpass_Ausmusterungnummer = $fields['PPProduktpass_Ausmusterungnummer'];
        $this->PPProduktpass_AltIAN = $fields['PPProduktpass_AltIAN'];
        $this->PPProduktpass_AltArtikelbezeichnung = $fields['PPProduktpass_AltArtikelbezeichnung'];
        $this->PPProduktpass_Warengruppe = $fields['PPProduktpass_Warengruppe'];
        $this->PPProduktpass_Neu_Warengruppe = $fields['PPProduktpass_Neu_Warengruppe'];
        $this->PPProduktpass_Verpackungseinheit = $fields['PPProduktpass_Verpackungseinheit'];
        $this->PPProduktpass_Thema = $fields['PPProduktpass_Thema'];
        $this->PPProduktpass_Liefertermin = $fields[''];
        $this->PPProduktpass_Einkaeufer = $fields['PPProduktpass_Einkaeufer'];
        $this->PPProduktpass_Marke = $fields['PPProduktpass_Marke'];
        $this->PPProduktpass_Gesamtmenge = $fields['PPProduktpass_Gesamtmenge'];
        $this->PPProduktpass_Pruefinstitut = $fields['PPProduktpass_Pruefinstitut'];
        $this->PPProduktpass_Andere_Kriterien = $fields['PPProduktpass_Andere_Kriterien'];
        $this->PPProduktpass_Zertifizierungen = $fields['PPProduktpass_Zertifizierungen'];
        $this->PPProduktpass_Logos = $fields['PPProduktpass_Logos'];
        $this->PPProduktpass_Verkaufsverpackung = $fields['PPProduktpass_Verkaufsverpackung'];
        $this->PPProduktpass_Materialstaerke_der_Verkaufsverpackung = $fields['PPProduktpass_Materialstaerke_der_Verkaufsverpackung'];
        $this->PPProduktpass_Agentur = $fields['PPProduktpass_Agentur'];
        $this->PPProduktpass_Material = $fields['PPProduktpass_Material'];
        $this->PPProduktpass_Lizenz = $fields['PPProduktpass_Lizenz'];
    }

}
