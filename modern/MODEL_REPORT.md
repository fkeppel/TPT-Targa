# Targa Laravel 13 model inventory

Generated from the supplied MySQL schema and Laravel 4 model directory.
No relationships were inferred or added.

## Summary

- Schema tables: 150
- Schema views: 194
- Existing model files processed: 121
- Existing table models corrected: 92
- Existing view models retained: 10
- Missing table models generated: 60
- Unresolved legacy models retained: 19
- Excluded legacy template: `PP.php` (`class table`)
- Excluded schema table: `migrations` (managed by Laravel)

## Important notes

- `PPRetail` has a composite primary key (`PPRetail_Id`, `PPRetail_Code`).
  Eloquent does not support composite primary keys natively; the model uses the first key.
- Generated models use Laravel's secure default mass-assignment protection.
- Compatible existing `$fillable` and `$guarded` declarations were retained.
- Existing mass-assignment fields were checked against table columns; stale names were removed or mapped to current names.
- Timestamp management is enabled for all table models except `jobs`; its legacy `created_at` column is an integer queue timestamp.
- Only view models that already existed were retained; no model was generated for every view.

## Removed legacy relationship methods

- `PPPosition::ppkopf()`
- `Project::user_profile()`

## Unresolved legacy models

- `MassImportJob` — `mass_import_jobs`
- `PPAddo` — no explicit table
- `PPChangesConfir` — no explicit table
- `PPEmai` — no explicit table
- `PPGrou` — no explicit table
- `PPKopfArchi` — no explicit table
- `PPLot` — no explicit table
- `PPOrderTota` — no explicit table
- `PPPosition` — `PPPosition`
- `PPPosLo` — no explicit table
- `PPPosLotQuantit` — no explicit table
- `PPProtokollSav` — no explicit table
- `PPProtokollSi` — no explicit table
- `PPQ` — no explicit table
- `PPQSFile` — no explicit table
- `PPRelatedItems` — `PPRelatedItems`
- `Tem` — no explicit table
- `TPosLo` — no explicit table
- `VPosLot` — no explicit table

## Removed stale mass-assignment fields

- `EAN_Nummern::fillable $EAN_Nummern_EAN_Basisnummer_Id`
- `PPDevisenTerminKaeufe::fillable $PPDevisenTerminKaeufe_AngelegtAm`
- `PPLC::fillable $PPLC_PeriodeForPrensentation`
- `PPLieferavis::fillable $PPLieferavis_Schiffsnummer`
- `PPLieferavis_Container_Content::fillable $PPLieferavis_MARM_SATNR`
- `PPLieferavis_Container_Content::fillable $PPLieferavis_MARM_Laenge`
- `PPLieferavis_Container_Content::fillable $PPLieferavis_MARM_Breite`
- `PPLieferavis_Container_Content::fillable $PPLieferavis_MARM_Hoehe`
- `PPLieferavis_Container_Content::fillable $PPLieferavis_MARM_Brutto`
- `PPLieferavis_Container_Content::fillable $PPLieferavis_MARM_Netto`
- `PPLieferavis_Material::fillable $PPLieferavis_Material_Materialnummer`
- `PPLieferavis_Material::fillable $PPLiefveravis_Material_OrderGTIN`
- `PPLieferavis_Material::fillable $PPLiefveravis_Material_AvisPosNr`
- `PPProduktpass_Menge::fillable $PPProduktpass_Menge_Rotterdamk`
- `PPProduktpass_Menge_Final::fillable $PPProduktpass_Menge_Rotterdamk`
- `PPPurchaseDTK::fillable $PPPurchaseDTK_PPDevisenTerminKauf_Id`
- `PPZahlungen::fillable $PPZahlungen_Fälligkeit`

## Newly generated table models

- `Artikeltexte` → `artikeltexte`
- `Belegarten` → `belegarten`
- `Belege` → `belege`
- `Belegepositionen` → `belegepositionen`
- `Belegnummern` → `belegnummern`
- `Cpcincoterms` → `cpcincoterms`
- `Files` → `Files`
- `InquiryRechenmenge` → `Inquiry_Rechenmenge`
- `ISOLaender` → `ISOLaender`
- `Jobs` → `jobs`
- `Kalkulationskurs` → `Kalkulationskurs`
- `Konten` → `konten`
- `Kostenarten` → `Kostenarten`
- `Kundenartikeldaten` → `kundenartikeldaten`
- `Kundengruppen` → `Kundengruppen`
- `Lagerbewegungen` → `lagerbewegungen`
- `Lagerbewegungsarten` → `Lagerbewegungsarten`
- `Lagerplatzbuchungen` → `Lagerplatzbuchungen`
- `Load` → `Load`
- `LoadJeProduzent` → `LoadJeProduzent`
- `MoeglicheLieferanten` → `MoeglicheLieferanten`
- `MPPlan` → `MPPlan`
- `Nummernkreise` → `Nummernkreise`
- `Parameter` → `Parameter`
- `PasswordResets` → `password_resets`
- `PPAssortmentStyles` → `PPAssortmentStyles`
- `PPBoardSpalteSAVE` → `PPBoardSpalte_SAVE`
- `PPBoardSpalteDataDEV` → `PPBoardSpalteData_DEV`
- `PPBoardSpalteX` → `PPBoardSpalteX`
- `PPCountrySizes` → `PPCountrySizes`
- `PPLaenderbloeckeMitVersion` → `PPLaenderbloeckeMitVersion`
- `PPLidlQualitaetsarten` → `PPLidlQualitaetsarten`
- `PPLsvORG` → `PPLsvORG`
- `PPMengenUebersichtLaender` → `PPMengenUebersichtLaender`
- `PPPerioden` → `PPPerioden`
- `PPProduktpassIntern` → `PPProduktpass_Intern`
- `PPTCKosten` → `PPTCKosten`
- `PPTCKostenTypen` → `PPTCKostenTypen`
- `PPTempQualitaet` → `PPTempQualitaet`
- `PPTermineAnhaenge` → `PPTermineAnhaenge`
- `PPTermineHistory` → `PPTermineHistory`
- `PPTermineSave` → `PPTermineSave`
- `PPThema` → `PPThema`
- `PreisblattFracht` → `PreisblattFracht`
- `Protokoll` → `protokoll`
- `SammelkontenSKR03` → `SammelkontenSKR03`
- `SKR03` → `SKR03`
- `Steuersatz` → `Steuersatz`
- `Steuerschluessel` → `Steuerschluessel`
- `StrukturSKR03` → `StrukturSKR03`
- `TestTabelleKeineView` → `test_tabelle_keine_view`
- `Thema` → `Thema`
- `ThemaArtikel` → `ThemaArtikel`
- `TmpPPLsv` → `tmpPPLsv`
- `Users` → `users`
- `UsersX` → `usersX`
- `VorlaufMusterung` → `Vorlauf_Musterung`
- `XMLConverterMitVersion` → `XMLConverterMitVersion`
- `XPPProduktpass` → `XPPProduktpass`
- `Zkd` → `zkd`
