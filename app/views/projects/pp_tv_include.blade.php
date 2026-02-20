<div id="tabOtherXML" name="tabOtherXML" class="tgTabContent">
            <div class="tgCommonData" style="display: inline;">
                <h3 class="tgCategoryHeadline" id="h3measurement" name="h3measurement">{{ ServiceProvider::tl('Kategorie') }}Abmessungen</h3>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCombinedArtRef" id="measurement_isCombinedArtRef_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isCombinedArtRef" name="isCombinedArtRef">{{ ServiceProvider::tl('Kategorie') }}isCombinedArtRef</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isEntireSizeSet" id="measurement_isEntireSizeSet_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isEntireSizeSet" name="isEntireSizeSet">{{ ServiceProvider::tl('Kategorie') }}isEntireSizeSet</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isFittingPep" id="measurement_isFittingPep_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isFittingPep" name="isFittingPep">{{ ServiceProvider::tl('Kategorie') }}isFittingPep</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isNoSizeSet" id="measurement_isNoSizeSet_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isNoSizeSet" name="isNoSizeSet">{{ ServiceProvider::tl('Kategorie') }}isNoSizeSet</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isReducedSizeSet" id="measurement_isReducedSizeSet_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isReducedSizeSet" name="isReducedSizeSet">{{ ServiceProvider::tl('Kategorie') }}isReducedSizeSet
                        </div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isRepeater" id="measurement_isRepeater_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isRepeater" name="isRepeater">{{ ServiceProvider::tl('Kategorie') }}isRepeater</div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="tgCommonData" style="display: inline;">
                <h3 class="tgCategoryHeadline" id="h3catalogue" name="h3catalogue">{{ ServiceProvider::tl('Kategorie') }}Katalog</h3>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCatalogue" id="catalogue_isCatalogue_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isCatalogue" name="isCatalogue">{{ ServiceProvider::tl('Kategorie') }}Katalogbestellung</div>
                    </div>
                    <div class="tgPropertyInput tgLangDE">
                        <div class="tgLabel" id="lotNumber" name="lotNumber">{{ ServiceProvider::tl('Kategorie') }}Charge</div>
                        <div lang="de" class="tgInput tgCompare" contenteditable="false"
                            id="catalogue_lotNumber_input" data-initial-value="2204">{{ ServiceProvider::tl('Kategorie') }}XXXX</div>
                    </div>
                    <div class="tgPropertyInput tgLangDE">
                        <div class="tgLabel" id="initialOrder" name="initialOrder">{{ ServiceProvider::tl('Kategorie') }}initialOrder</div>
                        <div lang="de" class="tgInput tgCompare" contenteditable="false"
                            id="catalogue_initialOrder_input" data-initial-value=""></div>
                    </div>
                    <div class="tgPropertyInput tgLangDE">
                        <div class="tgLabel" id="timeOfOrders" name="timeOfOrders">{{ ServiceProvider::tl('Kategorie') }}timeOfOrders</div>
                        <div lang="de" class="tgInput tgCompare" contenteditable="false"
                            id="catalogue_timeOfOrders_input" data-initial-value=""></div>
                    </div>
                </div>
            </div>
            <hr>
            <h3 class="tgCategoryHeadline" id="h3fitting" name="h3fitting" style="display: none;">{{ ServiceProvider::tl('Kategorie') }}fitting
            </h3>
            <div class="tgCommonData" style="display: none;">
                <h4 class="tgCategoryHeadline"></h4>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isAgeGroupBaby" id="fitting_isAgeGroupBaby_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isAgeGroupBaby" name="isAgeGroupBaby">{{ ServiceProvider::tl('Kategorie') }}isAgeGroupBaby</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isAgeGroupKids" id="fitting_isAgeGroupKids_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isAgeGroupKids" name="isAgeGroupKids">{{ ServiceProvider::tl('Kategorie') }}isAgeGroupKids</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isAgeGroupOlderThan15" id="fitting_isAgeGroupOlderThan15_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isAgeGroupOlderThan15" name="isAgeGroupOlderThan15">{{ ServiceProvider::tl('Kategorie') }}isAgeGroupOlderThan15</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isAgeGroupOlderThan25" id="fitting_isAgeGroupOlderThan25_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isAgeGroupOlderThan25" name="isAgeGroupOlderThan25">{{ ServiceProvider::tl('Kategorie') }}isAgeGroupOlderThan25</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isAgeGroupOlderThan35" id="fitting_isAgeGroupOlderThan35_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isAgeGroupOlderThan35" name="isAgeGroupOlderThan35">{{ ServiceProvider::tl('Kategorie') }}isAgeGroupOlderThan35</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isAgeGroupOlderThan55" id="fitting_isAgeGroupOlderThan55_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isAgeGroupOlderThan55" name="isAgeGroupOlderThan55">{{ ServiceProvider::tl('Kategorie') }}isAgeGroupOlderThan55</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isAgeGroupSmallKids" id="fitting_isAgeGroupSmallKids_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isAgeGroupSmallKids" name="isAgeGroupSmallKids">{{ ServiceProvider::tl('Kategorie') }}isAgeGroupSmallKids</div>
                    </div>
                </div>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isAimAthletic" id="fitting_isAimAthletic_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isAimAthletic" name="isAimAthletic">{{ ServiceProvider::tl('Kategorie') }}isAimAthletic</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isAimBusiness" id="fitting_isAimBusiness_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isAimBusiness" name="isAimBusiness">{{ ServiceProvider::tl('Kategorie') }}isAimBusiness</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isAimCasualOrBasic" id="fitting_isAimCasualOrBasic_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isAimCasualOrBasic" name="isAimCasualOrBasic">{{ ServiceProvider::tl('Kategorie') }}isAimCasualOrBasic</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isAimFeastful" id="fitting_isAimFeastful_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isAimFeastful" name="isAimFeastful">{{ ServiceProvider::tl('Kategorie') }}isAimFeastful</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isAimOthers" id="fitting_isAimOthers_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isAimOthers" name="isAimOthers">{{ ServiceProvider::tl('Kategorie') }}isAimOthers</div>
                    </div>
                </div>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBackLengthDeep" id="fitting_isBackLengthDeep_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBackLengthDeep" name="isBackLengthDeep">{{ ServiceProvider::tl('Kategorie') }}isBackLengthDeep</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBackLengthHigh" id="fitting_isBackLengthHigh_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBackLengthHigh" name="isBackLengthHigh">{{ ServiceProvider::tl('Kategorie') }}isBackLengthHigh</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBackLengthNormal" id="fitting_isBackLengthNormal_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBackLengthNormal" name="isBackLengthNormal">{{ ServiceProvider::tl('Kategorie') }}isBackLengthNormal</div>
                    </div>
                </div>
            </div>
            <div class="tgCommonData" style="display: none;">
                <h4 class="tgCategoryHeadline"></h4>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBandAddWaistband" id="fitting_isBandAddWaistband_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBandAddWaistband" name="isBandAddWaistband">{{ ServiceProvider::tl('Kategorie') }}isBandAddWaistband</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBandAllArndElastic" id="fitting_isBandAllArndElastic_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBandAllArndElastic" name="isBandAllArndElastic">{{ ServiceProvider::tl('Kategorie') }}isBandAllArndElastic</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBandFoldBackWaistbd" id="fitting_isBandFoldBackWaistbd_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBandFoldBackWaistbd" name="isBandFoldBackWaistbd">{{ ServiceProvider::tl('Kategorie') }}isBandFoldBackWaistbd</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBandOthers" id="fitting_isBandOthers_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBandOthers" name="isBandOthers">{{ ServiceProvider::tl('Kategorie') }}isBandOthers</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBandPartElastic" id="fitting_isBandPartElastic_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBandPartElastic" name="isBandPartElastic">{{ ServiceProvider::tl('Kategorie') }}isBandPartElastic</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBandShapedWaist" id="fitting_isBandShapedWaist_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBandShapedWaist" name="isBandShapedWaist">{{ ServiceProvider::tl('Kategorie') }}isBandShapedWaist</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBandAddWaistband" id="fitting_isBandAddWaistband_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBandAddWaistband" name="isBandAddWaistband">{{ ServiceProvider::tl('Kategorie') }}isBandAddWaistband</div>
                    </div>
                </div>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBkLen1by2BksideCvd" id="fitting_isBkLen1by2BksideCvd_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBkLen1by2BksideCvd" name="isBkLen1by2BksideCvd">{{ ServiceProvider::tl('Kategorie') }}isBkLen1by2BksideCvd</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBkLenBellyBtnUncvd" id="fitting_isBkLenBellyBtnUncvd_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBkLenBellyBtnUncvd" name="isBkLenBellyBtnUncvd">{{ ServiceProvider::tl('Kategorie') }}isBkLenBellyBtnUncvd</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBkLenBksideCvd" id="fitting_isBkLenBksideCvd_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBkLenBksideCvd" name="isBkLenBksideCvd">{{ ServiceProvider::tl('Kategorie') }}isBkLenBksideCvd</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBkLenMini" id="fitting_isBkLenMini_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBkLenMini" name="isBkLenMini">{{ ServiceProvider::tl('Kategorie') }}isBkLenMini</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBkLenNormal" id="fitting_isBkLenNormal_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBkLenNormal" name="isBkLenNormal">{{ ServiceProvider::tl('Kategorie') }}isBkLenNormal</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBkLenShort" id="fitting_isBkLenShort_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBkLenShort" name="isBkLenShort">{{ ServiceProvider::tl('Kategorie') }}isBkLenShort</div>
                    </div>
                </div>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBraFormSport" id="fitting_isBraFormSport_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBraFormSport" name="isBraFormSport">{{ ServiceProvider::tl('Kategorie') }}isBraFormSport</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBraFormWireless" id="fitting_isBraFormWireless_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBraFormWireless" name="isBraFormWireless">{{ ServiceProvider::tl('Kategorie') }}isBraFormWireless</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isBraFormWithWire" id="fitting_isBraFormWithWire_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isBraFormWithWire" name="isBraFormWithWire">{{ ServiceProvider::tl('Kategorie') }}isBraFormWithWire</div>
                    </div>
                </div>
            </div>
            <div class="tgCommonData" style="display: none;">
                <h4 class="tgCategoryHeadline"></h4>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCoatLongCoat" id="fitting_isCoatLongCoat_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isCoatLongCoat" name="isCoatLongCoat">{{ ServiceProvider::tl('Kategorie') }}isCoatLongCoat</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCoatOthers" id="fitting_isCoatOthers_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isCoatOthers" name="isCoatOthers">{{ ServiceProvider::tl('Kategorie') }}isCoatOthers</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCoatParka" id="fitting_isCoatParka_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isCoatParka" name="isCoatParka">{{ ServiceProvider::tl('Kategorie') }}isCoatParka</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCoatShortCoat" id="fitting_isCoatShortCoat_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isCoatShortCoat" name="isCoatShortCoat">{{ ServiceProvider::tl('Kategorie') }}isCoatShortCoat</div>
                    </div>
                </div>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCollarFormBubi" id="fitting_isCollarFormBubi_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isCollarFormBubi" name="isCollarFormBubi">{{ ServiceProvider::tl('Kategorie') }}isCollarFormBubi</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCollarFormHaifisch" id="fitting_isCollarFormHaifisch_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isCollarFormHaifisch" name="isCollarFormHaifisch">{{ ServiceProvider::tl('Kategorie') }}isCollarFormHaifisch</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCollarFormKapuze" id="fitting_isCollarFormKapuze_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isCollarFormKapuze" name="isCollarFormKapuze">{{ ServiceProvider::tl('Kategorie') }}isCollarFormKapuze</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCollarFormKent" id="fitting_isCollarFormKent_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isCollarFormKent" name="isCollarFormKent">{{ ServiceProvider::tl('Kategorie') }}isCollarFormKent</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCollarFormOthers" id="fitting_isCollarFormOthers_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isCollarFormOthers" name="isCollarFormOthers">{{ ServiceProvider::tl('Kategorie') }}isCollarFormOthers</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCollarFormPolokragen"
                            id="fitting_isCollarFormPolokragen_input" value="false" disabled=""
                            data-initial-value="false">
                        <div class="tgLabel" id="isCollarFormPolokragen" name="isCollarFormPolokragen">{{ ServiceProvider::tl('Kategorie') }}isCollarFormPolokragen</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCollarFormStehkragen"
                            id="fitting_isCollarFormStehkragen_input" value="false" disabled=""
                            data-initial-value="false">
                        <div class="tgLabel" id="isCollarFormStehkragen" name="isCollarFormStehkragen">{{ ServiceProvider::tl('Kategorie') }}isCollarFormStehkragen</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCollarLapel" id="fitting_isCollarLapel_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isCollarLapel" name="isCollarLapel">{{ ServiceProvider::tl('Kategorie') }}isCollarLapel</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isCollarTurtleNeck" id="fitting_isCollarTurtleNeck_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isCollarTurtleNeck" name="isCollarTurtleNeck">{{ ServiceProvider::tl('Kategorie') }}isCollarTurtleNeck</div>
                    </div>
                </div>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isGenderDivers" id="fitting_isGenderDivers_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isGenderDivers" name="isGenderDivers">{{ ServiceProvider::tl('Kategorie') }}isGenderDivers</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isGenderFemale" id="fitting_isGenderFemale_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isGenderFemale" name="isGenderFemale">{{ ServiceProvider::tl('Kategorie') }}isGenderFemale</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isGenderMale" id="fitting_isGenderMale_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isGenderMale" name="isGenderMale">{{ ServiceProvider::tl('Kategorie') }}isGenderMale</div>
                    </div>
                </div>
            </div>
            <div class="tgCommonData" style="display: none;">
                <h4 class="tgCategoryHeadline"></h4>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isLvlExtreme" id="fitting_isLvlExtreme_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isLvlExtreme" name="isLvlExtreme">{{ ServiceProvider::tl('Kategorie') }}isLvlExtreme</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isLvlHigh" id="fitting_isLvlHigh_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isLvlHigh" name="isLvlHigh">{{ ServiceProvider::tl('Kategorie') }}isLvlHigh</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isLvlLight" id="fitting_isLvlLight_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isLvlLight" name="isLvlLight">{{ ServiceProvider::tl('Kategorie') }}isLvlLight</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isLvlMedium" id="fitting_isLvlMedium_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isLvlMedium" name="isLvlMedium">{{ ServiceProvider::tl('Kategorie') }}isLvlMedium</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isLvlOther" id="fitting_isLvlOther_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isLvlOther" name="isLvlOther">{{ ServiceProvider::tl('Kategorie') }}isLvlOther</div>
                    </div>
                </div>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isNecklineBoat" id="fitting_isNecklineBoat_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isNecklineBoat" name="isNecklineBoat">{{ ServiceProvider::tl('Kategorie') }}isNecklineBoat</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isNecklineDeepV" id="fitting_isNecklineDeepV_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isNecklineDeepV" name="isNecklineDeepV">{{ ServiceProvider::tl('Kategorie') }}isNecklineDeepV</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isNecklineEnvelope" id="fitting_isNecklineEnvelope_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isNecklineEnvelope" name="isNecklineEnvelope">{{ ServiceProvider::tl('Kategorie') }}isNecklineEnvelope</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isNecklineOthers" id="fitting_isNecklineOthers_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isNecklineOthers" name="isNecklineOthers">{{ ServiceProvider::tl('Kategorie') }}isNecklineOthers</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isNecklineRDHINeck" id="fitting_isNecklineRDHINeck_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isNecklineRDHINeck" name="isNecklineRDHINeck">{{ ServiceProvider::tl('Kategorie') }}isNecklineRDHINeck</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isNecklineRoundNeck" id="fitting_isNecklineRoundNeck_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isNecklineRoundNeck" name="isNecklineRoundNeck">{{ ServiceProvider::tl('Kategorie') }}isNecklineRoundNeck</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isNecklineScoopNeck" id="fitting_isNecklineScoopNeck_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isNecklineScoopNeck" name="isNecklineScoopNeck">{{ ServiceProvider::tl('Kategorie') }}isNecklineScoopNeck</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isNecklineVNeck" id="fitting_isNecklineVNeck_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isNecklineVNeck" name="isNecklineVNeck">{{ ServiceProvider::tl('Kategorie') }}isNecklineVNeck</div>
                    </div>
                </div>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPant3by4" id="fitting_isPant3by4_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPant3by4" name="isPant3by4">{{ ServiceProvider::tl('Kategorie') }}isPant3by4</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPant7by8" id="fitting_isPant7by8_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPant7by8" name="isPant7by8">{{ ServiceProvider::tl('Kategorie') }}isPant7by8</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPantBermuda" id="fitting_isPantBermuda_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPantBermuda" name="isPantBermuda">{{ ServiceProvider::tl('Kategorie') }}isPantBermuda</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPantCapri" id="fitting_isPantCapri_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPantCapri" name="isPantCapri">{{ ServiceProvider::tl('Kategorie') }}isPantCapri</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPantLong" id="fitting_isPantLong_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPantLong" name="isPantLong">{{ ServiceProvider::tl('Kategorie') }}isPantLong</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPantPanty" id="fitting_isPantPanty_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPantPanty" name="isPantPanty">{{ ServiceProvider::tl('Kategorie') }}isPantPanty</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPantShorts" id="fitting_isPantShorts_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPantShorts" name="isPantShorts">{{ ServiceProvider::tl('Kategorie') }}isPantShorts</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPant3by4" id="fitting_isPant3by4_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPant3by4" name="isPant3by4">{{ ServiceProvider::tl('Kategorie') }}isPant3by4</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPant7by8" id="fitting_isPant7by8_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPant7by8" name="isPant7by8">{{ ServiceProvider::tl('Kategorie') }}isPant7by8</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPantBermuda" id="fitting_isPantBermuda_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPantBermuda" name="isPantBermuda">{{ ServiceProvider::tl('Kategorie') }}isPantBermuda</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPantCapri" id="fitting_isPantCapri_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPantCapri" name="isPantCapri">{{ ServiceProvider::tl('Kategorie') }}isPantCapri</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPantLong" id="fitting_isPantLong_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPantLong" name="isPantLong">{{ ServiceProvider::tl('Kategorie') }}isPantLong</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPantPanty" id="fitting_isPantPanty_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPantPanty" name="isPantPanty">{{ ServiceProvider::tl('Kategorie') }}isPantPanty</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isPantShorts" id="fitting_isPantShorts_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isPantShorts" name="isPantShorts">{{ ServiceProvider::tl('Kategorie') }}isPantShorts</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSlipFormPanty" id="fitting_isSlipFormPanty_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSlipFormPanty" name="isSlipFormPanty">{{ ServiceProvider::tl('Kategorie') }}isSlipFormPanty</div>
                    </div>
                </div>
            </div>
            <div class="tgCommonData" style="display: none;">
                <h4 class="tgCategoryHeadline"></h4>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isShoulderBtnForBaby" id="fitting_isShoulderBtnForBaby_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isShoulderBtnForBaby" name="isShoulderBtnForBaby">{{ ServiceProvider::tl('Kategorie') }}isShoulderBtnForBaby</div>
                    </div>
                </div>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSkirt3by4" id="fitting_isSkirt3by4_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSkirt3by4" name="isSkirt3by4">{{ ServiceProvider::tl('Kategorie') }}isSkirt3by4</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSkirt7by8" id="fitting_isSkirt7by8_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSkirt7by8" name="isSkirt7by8">{{ ServiceProvider::tl('Kategorie') }}isSkirt7by8</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSkirtForm" id="fitting_isSkirtForm_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSkirtForm" name="isSkirtForm">{{ ServiceProvider::tl('Kategorie') }}isSkirtForm</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSkirtKneeCovered" id="fitting_isSkirtKneeCovered_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSkirtKneeCovered" name="isSkirtKneeCovered">{{ ServiceProvider::tl('Kategorie') }}isSkirtKneeCovered</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSkirtKneeOpen" id="fitting_isSkirtKneeOpen_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSkirtKneeOpen" name="isSkirtKneeOpen">{{ ServiceProvider::tl('Kategorie') }}isSkirtKneeOpen</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSkirtLenOthers" id="fitting_isSkirtLenOthers_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSkirtLenOthers" name="isSkirtLenOthers">{{ ServiceProvider::tl('Kategorie') }}isSkirtLenOthers</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSkirtLong" id="fitting_isSkirtLong_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSkirtLong" name="isSkirtLong">{{ ServiceProvider::tl('Kategorie') }}isSkirtLong</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSkirtMini" id="fitting_isSkirtMini_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSkirtMini" name="isSkirtMini">{{ ServiceProvider::tl('Kategorie') }}isSkirtMini</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSkirtShapeFlared" id="fitting_isSkirtShapeFlared_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSkirtShapeFlared" name="isSkirtShapeFlared">{{ ServiceProvider::tl('Kategorie') }}isSkirtShapeFlared</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSkirtShapeOther" id="fitting_isSkirtShapeOther_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSkirtShapeOther" name="isSkirtShapeOther">{{ ServiceProvider::tl('Kategorie') }}isSkirtShapeOther</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSkirtShapeStraight" id="fitting_isSkirtShapeStraight_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSkirtShapeStraight" name="isSkirtShapeStraight">{{ ServiceProvider::tl('Kategorie') }}isSkirtShapeStraight</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSkirtShort" id="fitting_isSkirtShort_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSkirtShort" name="isSkirtShort">{{ ServiceProvider::tl('Kategorie') }}isSkirtShort</div>
                    </div>
                </div>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSleLen1by1" id="fitting_isSleLen1by1_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSleLen1by1" name="isSleLen1by1">{{ ServiceProvider::tl('Kategorie') }}isSleLen1by1</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSleLen1by1A1" id="fitting_isSleLen1by1A1_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSleLen1by1A1" name="isSleLen1by1A1">{{ ServiceProvider::tl('Kategorie') }}isSleLen1by1A1</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSleLen1by1A2" id="fitting_isSleLen1by1A2_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSleLen1by1A2" name="isSleLen1by1A2">{{ ServiceProvider::tl('Kategorie') }}isSleLen1by1A2</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSleLen1by2" id="fitting_isSleLen1by2_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSleLen1by2" name="isSleLen1by2">{{ ServiceProvider::tl('Kategorie') }}isSleLen1by2</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSleLen1by4" id="fitting_isSleLen1by4_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSleLen1by4" name="isSleLen1by4">{{ ServiceProvider::tl('Kategorie') }}isSleLen1by4</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSleLen1by8" id="fitting_isSleLen1by8_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSleLen1by8" name="isSleLen1by8">{{ ServiceProvider::tl('Kategorie') }}isSleLen1by8</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSleLen3by4" id="fitting_isSleLen3by4_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSleLen3by4" name="isSleLen3by4">{{ ServiceProvider::tl('Kategorie') }}isSleLen3by4</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSleLenCapSleeve" id="fitting_isSleLenCapSleeve_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSleLenCapSleeve" name="isSleLenCapSleeve">{{ ServiceProvider::tl('Kategorie') }}isSleLenCapSleeve</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSleLenOther" id="fitting_isSleLenOther_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSleLenOther" name="isSleLenOther">{{ ServiceProvider::tl('Kategorie') }}isSleLenOther</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSleLenSleeveless" id="fitting_isSleLenSleeveless_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSleLenSleeveless" name="isSleLenSleeveless">{{ ServiceProvider::tl('Kategorie') }}isSleLenSleeveless</div>
                    </div>
                </div>
            </div>
            <div class="tgCommonData" style="display: none;">
                <h4 class="tgCategoryHeadline"></h4>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSlipFormBoxershorts" id="fitting_isSlipFormBoxershorts_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSlipFormBoxershorts" name="isSlipFormBoxershorts">{{ ServiceProvider::tl('Kategorie') }}isSlipFormBoxershorts</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSlipFormBrief" id="fitting_isSlipFormBrief_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSlipFormBrief" name="isSlipFormBrief">{{ ServiceProvider::tl('Kategorie') }}isSlipFormBrief</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSlipFormHipster" id="fitting_isSlipFormHipster_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSlipFormHipster" name="isSlipFormHipster">{{ ServiceProvider::tl('Kategorie') }}isSlipFormHipster</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSlipFormHuftslip" id="fitting_isSlipFormHuftslip_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSlipFormHuftslip" name="isSlipFormHuftslip">{{ ServiceProvider::tl('Kategorie') }}isSlipFormHuftslip</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSlipFormJazzpants" id="fitting_isSlipFormJazzpants_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSlipFormJazzpants" name="isSlipFormJazzpants">{{ ServiceProvider::tl('Kategorie') }}isSlipFormJazzpants</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSlipFormMinislip" id="fitting_isSlipFormMinislip_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSlipFormMinislip" name="isSlipFormMinislip">{{ ServiceProvider::tl('Kategorie') }}isSlipFormMinislip</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSlipFormPanty" id="fitting_isSlipFormPanty_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSlipFormPanty" name="isSlipFormPanty">{{ ServiceProvider::tl('Kategorie') }}isSlipFormPanty</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSlipFormString" id="fitting_isSlipFormString_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSlipFormString" name="isSlipFormString">{{ ServiceProvider::tl('Kategorie') }}isSlipFormString</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSlipFormHuftslip" id="fitting_isSlipFormHuftslip_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSlipFormHuftslip" name="isSlipFormHuftslip">{{ ServiceProvider::tl('Kategorie') }}isSlipFormHuftslip</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isSlipFormMinislip" id="fitting_isSlipFormMinislip_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isSlipFormMinislip" name="isSlipFormMinislip">{{ ServiceProvider::tl('Kategorie') }}isSlipFormMinislip</div>
                    </div>
                </div>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTopBodyNear" id="fitting_isTopBodyNear_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTopBodyNear" name="isTopBodyNear">{{ ServiceProvider::tl('Kategorie') }}isTopBodyNear</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTopCasual" id="fitting_isTopCasual_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTopCasual" name="isTopCasual">{{ ServiceProvider::tl('Kategorie') }}isTopCasual</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTopIssued" id="fitting_isTopIssued_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTopIssued" name="isTopIssued">{{ ServiceProvider::tl('Kategorie') }}isTopIssued</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTopOthers" id="fitting_isTopOthers_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTopOthers" name="isTopOthers">{{ ServiceProvider::tl('Kategorie') }}isTopOthers</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTopOversize" id="fitting_isTopOversize_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTopOversize" name="isTopOversize">{{ ServiceProvider::tl('Kategorie') }}isTopOversize</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTopStraight" id="fitting_isTopStraight_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTopStraight" name="isTopStraight">{{ ServiceProvider::tl('Kategorie') }}isTopStraight</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTopTight" id="fitting_isTopTight_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTopTight" name="isTopTight">{{ ServiceProvider::tl('Kategorie') }}isTopTight</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTopWaisted" id="fitting_isTopWaisted_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTopWaisted" name="isTopWaisted">{{ ServiceProvider::tl('Kategorie') }}isTopWaisted</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTopWide" id="fitting_isTopWide_input" value="false"
                            disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTopWide" name="isTopWide">{{ ServiceProvider::tl('Kategorie') }}isTopWide</div>
                    </div>
                </div>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTrouserLegBootCut" id="fitting_isTrouserLegBootCut_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTrouserLegBootCut" name="isTrouserLegBootCut">{{ ServiceProvider::tl('Kategorie') }}isTrouserLegBootCut</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTrouserLegFlared" id="fitting_isTrouserLegFlared_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTrouserLegFlared" name="isTrouserLegFlared">{{ ServiceProvider::tl('Kategorie') }}isTrouserLegFlared</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTrouserLegLooseFit" id="fitting_isTrouserLegLooseFit_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTrouserLegLooseFit" name="isTrouserLegLooseFit">{{ ServiceProvider::tl('Kategorie') }}isTrouserLegLooseFit</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTrouserLegOthers" id="fitting_isTrouserLegOthers_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTrouserLegOthers" name="isTrouserLegOthers">{{ ServiceProvider::tl('Kategorie') }}isTrouserLegOthers</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTrouserLegSlim" id="fitting_isTrouserLegSlim_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTrouserLegSlim" name="isTrouserLegSlim">{{ ServiceProvider::tl('Kategorie') }}isTrouserLegSlim</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTrouserLegSsfit" id="fitting_isTrouserLegSsfit_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTrouserLegSsfit" name="isTrouserLegSsfit">{{ ServiceProvider::tl('Kategorie') }}isTrouserLegSsfit</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isTrouserLegStraight" id="fitting_isTrouserLegStraight_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isTrouserLegStraight" name="isTrouserLegStraight">{{ ServiceProvider::tl('Kategorie') }}isTrouserLegStraight</div>
                    </div>
                </div>
            </div>
            <div class="tgCommonData" style="display: none;">
                <h4 class="tgCategoryHeadline"></h4>
                <div class="tgColumn">
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isUnderpartBodyNear" id="fitting_isUnderpartBodyNear_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isUnderpartBodyNear" name="isUnderpartBodyNear">{{ ServiceProvider::tl('Kategorie') }}isUnderpartBodyNear</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isUnderpartCasual" id="fitting_isUnderpartCasual_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isUnderpartCasual" name="isUnderpartCasual">{{ ServiceProvider::tl('Kategorie') }}isUnderpartCasual
                        </div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isUnderpartOversize" id="fitting_isUnderpartOversize_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isUnderpartOversize" name="isUnderpartOversize">{{ ServiceProvider::tl('Kategorie') }}isUnderpartOversize</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isUnderpartTight" id="fitting_isUnderpartTight_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isUnderpartTight" name="isUnderpartTight">{{ ServiceProvider::tl('Kategorie') }}isUnderpartTight</div>
                    </div>
                    <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare"
                            type="checkbox" name="isUnderpartWide" id="fitting_isUnderpartWide_input"
                            value="false" disabled="" data-initial-value="false">
                        <div class="tgLabel" id="isUnderpartWide" name="isUnderpartWide">{{ ServiceProvider::tl('Kategorie') }}isUnderpartWide</div>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabTranslationList" name="tabTranslationList" class="tgTabContent">
            <div class="tgCommonData">
                <h3 class="tgCategoryHeadline" id="h3TranslationList" name="h3TranslationList">{{ ServiceProvider::tl('Kategorie') }}List der Übersetzungen</h3>
                <div id="tgTranslationList" class="tgColumn tgColumnReverse"><button class="extensionButton"
                        id="buttonToggle" name="buttonToggle">{{ ServiceProvider::tl('Kategorie') }}Auswahl umschalten</button></div>
                <div id="tgTranslationControl" class="tgColumn">
                    <div lang="de" class="tgPropertyTextArea tgLangDE">
                        <div class="tgLabel" id="translationBoard" name="translationBoard">{{ ServiceProvider::tl('Kategorie') }}Übersetzungs Mitteilungen</div>
                        <div lang="de" contenteditable="true" class="tgInputEditable"
                            id="translationBoard_input">{{ ServiceProvider::tl('Kategorie') }}no translation yet</div>
                    </div>
                </div>
            </div>
        </div>