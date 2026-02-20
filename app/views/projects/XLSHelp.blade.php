    <!-- +++++++++++++++++ -->
    <!-- + F O R M A T E + -->
    <!-- +++++++++++++++++ -->
    <xsl:decimal-format name="quantityFormat" NaN="0" grouping-separator="." decimal-separator="," />
    <!-- ++++++++++++++++++++++++++++++ -->
    <!-- + Ab hier T e m p l a t e s. + -->
    <!-- ++++++++++++++++++++++++++++++ -->
    <!-- +++ Templates mit match="elemente filter" +++ -->
    <!-- Allgemeines Key Value Pair, bestehend aus Label und Input Field. -->
    <xsl:template match="*">
        <xsl:variable name="nodeName" select="local-name()" />
     <div class="tgPropertyInput tgLangDE">
            <xsl:choose>
                <xsl:when test="$nodeName='name'">
                 <div name="{concat(local-name(..), '/', local-name())}" id="{local-name()}" class="tgLabel">
                        <xsl:value-of select="local-name()" />
                    </div>
                </xsl:when>
                <xsl:otherwise>
                 <div name="{local-name()}" id="{local-name()}" class="tgLabel">
                        <xsl:value-of select="local-name()" />
                    </div>
                </xsl:otherwise>
            </xsl:choose>
         <div lang="de" contentEditable="false" id="{concat(local-name(), '_input')}" class="tgInput tgCompare">
                <xsl:value-of select="." />
            </div>
        </div>
    </xsl:template>
    <!-- IAN mit Anzeige ob LIDL oder NON LIDL IAN -->
    <xsl:template match="ian">
     <div class="tgPropertyInput tgLangDE">
         <div name="{local-name()}" id="{local-name()}" class="tgLabel">
                <xsl:value-of select="local-name()" />
            </div>
         <div lang="de" contentEditable="false" id="{concat(local-name(), '_input')}" class="tgInput tgCompare">
                <xsl:value-of select="." />
            </div>
            <!-- <div class="tgLabel" id="{local-name(../noLIDLItem)}" name="{local-name(../noLIDLItem)}"><xsl:value-of select="local-name(../noLIDLItem)"/></div><xsl:choose><xsl:when test="contains(../noLIDLItem,false())"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="{local-name()}" id="{concat(local-name(..), '_', local-name(), '_input')}" value="false" disabled=""/></xsl:when><xsl:when test="contains(../noLIDLItem,true())"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="{local-name()}" id="{concat(local-name(..), '_', local-name(), '_input')}" value="true" checked="" disabled=""/></xsl:when></xsl:choose> -->
        </div>
    </xsl:template>
    <xsl:template match="noLIDLItem">
     <div class="tgPropertyInput tgLangDE">
         <div name="{local-name()}" id="{local-name()}" class="tgLabel">
                <xsl:value-of select="local-name()" />
            </div>
            <xsl:choose>
                <xsl:when test="contains(.,false())">
                    <input disabled="" lang="de" name="{local-name()}"
                        id="{concat(local-name(..), '_', local-name(), '_input')}" type="checkbox" class="tgCheckbox"
                        value="false" />
                </xsl:when>
                <xsl:when test="contains(.,true())">
                    <input disabled="" lang="de" name="{local-name()}"
                        id="{concat(local-name(..), '_', local-name(), '_input')}" type="checkbox" class="tgCheckbox"
                        value="true" checked="" />
                </xsl:when>
            </xsl:choose>
        </div>
    </xsl:template>
    <!-- Spezielles Key Value Pair, bestehend aus Label und Input Field. -->
    <!-- Die letzten vier Zeichen des Values werden abgeschnitten. -->
    <xsl:template match="creatorEmail|updateUserEmail">
     <div class="tgPropertyInput tgLangDE">
         <div name="{local-name()}" id="{local-name()}" class="tgLabel">
                <xsl:value-of select="local-name()" />
            </div>
         <div lang="de" contentEditable="false" id="{concat(local-name(), '_input')}" class="tgInput">
                <xsl:value-of select="substring(.,1,string-length(.)-4)" />
            </div>
        </div>
    </xsl:template>
    <xsl:template match="creatorName|updateUserName">
     <div class="tgPropertyInput tgLangDE">
         <div name="{local-name()}" id="{local-name()}" class="tgLabel">
                <xsl:value-of select="local-name()" />
            </div>
         <div lang="de" contentEditable="false" id="{concat(local-name(), '_input')}" class="tgInput">
                <xsl:value-of select="." />
            </div>
        </div>
    </xsl:template>
    <!-- Spezielles Key Value Pair, bestehend aus einem Bild. -->
    <xsl:template match="images/image">
     <div>
            <a href="{./fileName}" target="_blank">
                <img id="{concat(local-name(), '_img_', generate-id())}" class="tgImage" alt="{./fileName}"
                    src="{./fileName}" />
            </a>
            <!-<xsl:value-of select="./image/isSensitiveInformation"/>-->
        </div>
    </xsl:template>
    <!-- Spezielles Key Value Pair fuer Anhaenge. -->
    <xsl:template match="attachments/document">
        <li>
            <a name="{./filename}" id="{concat(local-name(), '_doc_', generate-id())}" href="{./filename}"
                class="tgAttachment" target="_blank">
                <xsl:value-of select="./filename" />
            </a>
        </li>
    </xsl:template>
    <xsl:template match="relatedItem">
        <tr id="{concat('relatedItem_', generate-id())}" class="tgLangDE">
            <td>
             <div lang="de" id="{concat('relatedItemIan_', generate-id())}" class="tgRow" additionalInfo="{./ian}">
                    <xsl:value-of select="./ian" />
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('relatedItemLotNo_', generate-id())}" class="tgRow"
                    additionalInfo="{./lotNo}">
                    <xsl:value-of select="./lotNo" />
                </div>
            </td>
        </tr>
    </xsl:template>
    <!-- Spezielles Key Value Pair, bestehend aus Label und Input Field. -->
    <!-- Der im Attribut match genannte name des Elementes ist im xml Dokument nicht eindeutig. -->
    <!-- Der Bezeichner (id) der HTML Elemente wird mit Hilfe der parent Element bestimmt. -->
    <xsl:template match="materialThickness">
     <div lang="de" class="tgPropertyInput tgLangDE">
         <div name="{concat(local-name(..), '/', local-name())}" id="{concat(local-name(..), '/', local-name())}"
                class="tgLabel">
                <xsl:value-of select="local-name(..)" />
                <xsl:text>/</xsl:text>
                <xsl:value-of select="local-name()" />
            </div>
            <xsl:choose>
                <xsl:when test="translate(../../../../rfq/status, 'rfs', 'RFS') = 'RFS'">
                 <div lang="de" contentEditable="true" id="{concat(local-name(..), '/', local-name(), '_input')}"
                        class="tgInputEditable tgCompare">
                        <xsl:value-of select="." />
                    </div>
                </xsl:when>
                <xsl:otherwise>
                 <div lang="de" contentEditable="false" id="{concat(local-name(..), '/', local-name(), '_input')}"
                        class="tgInput tgCompare">
                        <xsl:value-of select="." />
                    </div>
                </xsl:otherwise>
            </xsl:choose>
        </div>
    </xsl:template>
    <!-- Spezielles Key Value Pair, bestehend aus Label und mehrzeiligem textarea. -->
    <xsl:template match="guarantee|guaranteeType|comments">
     <div lang="de" class="tgPropertyTextArea tgLangDE">
         <div name="{local-name()}" id="{local-name()}" class="tgLabel">
                <xsl:value-of select="local-name()" />
            </div>
         <div lang="de" contentEditable="false" id="{concat(local-name(), '_input')}" class="tgInput tgCompare">
                <xsl:value-of select="." />
            </div>
        </div>
    </xsl:template>
    <!-- <xsl:template match="catalogue/isCatalogue|catalogue/initialOrder|catalogue/timeOfOrder|catalogue/minOrderQuantity|catalogue/initialCharge"> -->
    <!-- <div lang="de" class="tgPropertyTextArea tgLangDE"> -->
    <!-- <div class="tgLabel" id="{local-name()}" name="{local-name()}"><xsl:value-of select="local-name()"/></div> -->
    <!-- <div lang="de" contentEditable="false" class ="tgInput tgCompare" id="{concat(local-name(), '_input')}"> -->
    <!-- <xsl:value-of select="."/> -->
    <!-- </div> -->
    <!-- </div> -->
    <!-- </xsl:template> -->
    <!-- Register Basic Data (1/1): Aufbau der Daten im Register Basic Data. -->
    <xsl:template match="guaranteeType">
     <div class="tgPropertyInput tgLangDE tgHidden">
         <div name="{local-name()}" id="{local-name()}" class="tgLabel">
                <xsl:value-of select="local-name()" />
            </div>
         <div lang="de" contentEditable="false" id="{concat(local-name(), '_input')}" class="tgInput tgCompare">
                <xsl:value-of select="." />
            </div>
        </div>
    </xsl:template>
    <!-- Register Quantity (1/3): Aufbau der Tabelle im Register Quantity. -->
    <xsl:template match="quantity">
        <tr id="{concat('quantity_', generate-id(), '_inputRow')}" class="tgLangDE">
            <td>
             <div lang="de" id="{concat('countryName_', generate-id())}" class="tgRow"
                    additionalInfo="{./country/name}">
                    <xsl:value-of select="./country/name" />
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('totalNumOfCtn_', generate-id())}" class="tgRow"
                    additionalInfo="{./country/name}">
                    <xsl:value-of select="format-number(./totalNumOfCtn, '###.###.###', 'quantityFormat')" />
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('totalSalesPerCarton_', generate-id())}" class="tgRow"
                    additionalInfo="{./country/name}">
                    <xsl:value-of select="./totalSalesPerCarton" />
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('totalQtyPerCountry_', generate-id())}" class="tgRow"
                    additionalInfo="{./country/name}">
                    <xsl:value-of select="format-number(./totalQtyPerCountry, '###.###.###', 'quantityFormat')" />
                </div>
            </td>
            <td>
             <div lang="de" contentEditable="true" id="{concat('ctryDeliveryWeek1_', generate-id(), '_inputCell')}"
                    class="tgInputEditable tgCompare" additionalInfo="{./country/name}">
                    <xsl:call-template name="adjustLtdWeek">
                        <xsl:with-param name="givenDate" select="./deliveryDateOWIM" />
                        <xsl:with-param name="weeksToSubtract" select="10" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('ctryDeliveryTotalQty1_', generate-id())}" class="tgRow"
                    additionalInfo="{./country/name}">
                    <xsl:value-of select="format-number(./countryDeliveryTotalQty1, '###.###.###', 'quantityFormat')" />
                </div>
            </td>
            <td>
             <div lang="de" contentEditable="true" id="{concat('ctryDeliveryWeek2_', generate-id(), '_inputCell')}"
                    class="tgInputEditable tgCompare" additionalInfo="{./country/name}">
                    <xsl:call-template name="adjustLtdWeek">
                        <xsl:with-param name="givenDate" select="./countryDeliveryWeek2" />
                        <xsl:with-param name="weeksToSubtract" select="13" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('ctryDeliveryTotalQty2_', generate-id())}" class="tgRow"
                    additionalInfo="{./country/name}">
                    <xsl:value-of select="format-number(./countryDeliveryTotalQty2, '###.###.###', 'quantityFormat')" />
                </div>
            </td>
            <td>
             <div lang="de" contentEditable="true" id="{concat('ctryDeliveryWeek3_', generate-id(), '_inputCell')}"
                    class="tgInputEditable tgCompare" additionalInfo="{./country/name}">
                    <xsl:call-template name="adjustLtdWeek">
                        <xsl:with-param name="givenDate" select="./countryDeliveryWeek3" />
                        <xsl:with-param name="weeksToSubtract" select="13" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('ctryDeliveryTotalQty3_', generate-id())}" class="tgRow"
                    additionalInfo="{./country/name}">
                    <xsl:value-of select="format-number(./countryDeliveryTotalQty3, '###.###.###', 'quantityFormat')" />
                </div>
            </td>
            <td>
             <div lang="de" contentEditable="true" id="{concat('articleInformation_', generate-id())}"
                    class="tgInputEditable tgCompare" additionalInfo="{./country/name}">
                    <xsl:value-of select="./articleInformation" />
                </div>
            </td>
        </tr>
    </xsl:template>
    <!-- Register Quantity (2/3): Aufbau der Tabelle im Register Quantity. -->
    <xsl:template name="adjustLtdWeek">
        <xsl:param name="givenDate" />
        <xsl:param name="weeksToSubtract" />
        <xsl:if test="string-length($givenDate) > 0">
            <xsl:variable name="week" select="number(substring-before($givenDate,'/'))" />
            <xsl:variable name="year" select="number(substring-after($givenDate,'/'))" />
            <xsl:choose>
                <xsl:when test="$week > $weeksToSubtract">
                    <xsl:variable name="calculatedWeek" select="$week - $weeksToSubtract" />
                    <xsl:value-of select="$calculatedWeek" />
                    /
                    <xsl:value-of select="$year" />
                </xsl:when>
                <xsl:otherwise>
                    <xsl:variable name="weekNumberOfYear">
                        <xsl:call-template name="calculateWeekNumber">
                            <xsl:with-param name="year" select="$year - 1" />
                        </xsl:call-template>
                    </xsl:variable>
                    <xsl:variable name="calculatedWeek" select="$week - $weeksToSubtract + $weekNumberOfYear" />
                    <xsl:variable name="calculatedYear" select="$year - 1" />
                    <xsl:value-of select="$calculatedWeek" />
                    /
                    <xsl:value-of select="$calculatedYear" />
                </xsl:otherwise>
            </xsl:choose>
        </xsl:if>
    </xsl:template>
    <!-- Register Quantity (3/3): Aufbau der Tabelle im Register Quantity. -->
    <xsl:template name="calculateWeekNumber">
        <xsl:param name="year" />
        <xsl:variable name="month" select="12" />
        <xsl:variable name="day" select="28" />
        <xsl:variable name="a" select="floor((14 - $month) div 12)" />
        <xsl:variable name="y" select="$year + 4800 - $a" />
        <xsl:variable name="m" select="$month + 12 * $a - 3" />
        <xsl:variable name="julianDay"
            select="$day + floor((153 * $m + 2) div 5) + $y * 365 + floor($y div 4) - floor($y div 100) + floor($y div 400) - 32045" />
        <xsl:variable name="d4" select="($julianDay + 31741 - ($julianDay mod 7)) mod 146097 mod 36524 mod 1461" />
        <xsl:variable name="L" select="floor($d4 div 1460)" />
        <xsl:variable name="d1" select="(($d4 - $L) mod 365) + $L" />
        <xsl:value-of select="floor($d1 div 7) + 1" />
    </xsl:template>
    <!-- Register Quality (1/4): Aufbau der Tabelle im Register Quality. -->
    <xsl:template match="style" mode="quality">
        <tr id="{concat('style_', ./styleNo, '_inputRow')}" class="tgLangDE">
            <td>
             <div lang="de" id="{concat('styleNo_', ./styleNo, '_inputCell')}" class="tgInput tgCompare"
                    additionalInfo="{./styleNo}" contenteditable="false">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./styleNo" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('productName_', ./styleNo, '_inputCell')}" class="tgInputEditable tgCompare"
                    additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./productName" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('weightWithoutPackaging_', ./styleNo, '_inputCell')}"
                    class="tgInputEditable tgCompare" additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./weightWithoutPackaging" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('sizeWithoutPackaging_', ./styleNo, '_inputCell')}"
                    class="tgInputEditable tgCompare" additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./sizeWithoutPackaging" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('qualityTechnicalData_', ./styleNo, '_inputCell')}"
                    class="tgInputEditable tgCompare" additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./qualityTechnicalData" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('additionalQualityInformation_', ./styleNo, '_inputCell')}"
                    class="tgInputEditable tgCompare" additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./additionalQualityInformation" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('changesFromPredecessor', ./styleNo, '_inputCell')}"
                    class="tgInput tgCompare" additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./changesFromPredecessor" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('brandReference', ./styleNo, '_inputCell')}" class="tgInput tgCompare"
                    additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./brandReference" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('material', ./styleNo, '_inputCell')}" class="tgInputEditable tgCompare"
                    additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./material" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('materialThickness', ./styleNo, '_inputCell')}"
                    class="tgInputEditable tgCompare" additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./materialThickness" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('color', ./styleNo, '_inputCell')}" class="tgInput tgCompare"
                    additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./color" />
                    </xsl:call-template>
                </div>
            </td>
        </tr>
    </xsl:template>
    <!-- Stammdaten Verkaufsverpackung-->
    <xsl:template match="style" mode="retailPackaging">
        <xsl:param name="nodes" />
        <tr id="{concat('style_', ./styleNo, '_inputRow')}" class="tgLangDE">
            <td>
             <div lang="de" id="{concat('styleNo_', ./styleNo, '_inputCell')}" class="tgInput tgCompare"
                    additionalInfo="{./styleNo}" contenteditable="false">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./styleNo" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('productName_', ./styleNo, '_inputCell')}" class="tgInput tgCompare"
                    additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./productName" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('retailPackagingWidth_', ./styleNo, '_inputCell')}"
                    class="tgInputEditable tgCompare" additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./retailPackagingWidth" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('retailPackagingHeight_', ./styleNo, '_inputCell')}"
                    class="tgInputEditable tgCompare" additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./retailPackagingHeight" />
                    </xsl:call-template>
                </div>
            </td>
            <td>
             <div lang="de" id="{concat('retailPackagingLength_', ./styleNo, '_inputCell')}"
                    class="tgInputEditable tgCompare" additionalInfo="{./styleNo}" contenteditable="true">
                    <xsl:call-template name="delFirstLF">
                        <xsl:with-param name="parStr" select="./retailPackagingLength" />
                    </xsl:call-template>
                </div>
            </td>
        </tr>
    </xsl:template>
    <!-- Register Quality (2/4): Aufbau der Daten im Register Quality. -->
    <xsl:template match="rfq/item/quality/*">
     <div class="tgPropertyInput tgLangDE">
         <div name="{local-name()}" id="{local-name()}" class="tgLabel">
                <xsl:value-of select="local-name()" />
            </div>
         <div lang="de" contentEditable="true" id="{concat(local-name(), '_input')}"
                class="tgInputEditable tgCompare">
                <xsl:value-of select="." />
            </div>
        </div>
    </xsl:template>
    <!-- Register Quality (3/4): Aufbau der Daten im Register Quality. -->
    <xsl:template match="rfq/item/quality/materialThickness">
     <div class="tgPropertyInput tgLangDE">
         <div name="{concat(local-name(..), '/', local-name())}" id="{concat(local-name(..), '/', local-name())}"
                class="tgLabel">
                <xsl:value-of select="local-name()" />
            </div>
         <div lang="de" contentEditable="true" id="{concat(local-name(..), '/', local-name(), '_input')}"
                class="tgInputEditable tgCompare">
                <xsl:value-of select="." />
            </div>
        </div>
    </xsl:template>
    <!-- Register Quality (4/4): Aufbau der Daten im Register Quality. -->
    <xsl:template match="rfq/item/quality/color">
     <div class="tgPropertyInput tgLangDE">
         <div name="{local-name()}" id="{local-name()}" class="tgLabel">
                <xsl:value-of select="local-name()" />
            </div>
         <div lang="de" contentEditable="false" id="{concat(local-name(), '_input')}" class="tgInput tgCompare">
                <xsl:value-of select="." />
            </div>
        </div>
    </xsl:template>
    <!-- Register Assortment (1/4): Aufbau der Tabelle im Register Assortment. -->
    <xsl:template
        match="assortment[not(every $token in tokenize(countryCodes, ',') satisfies starts-with($token, 'CB8'))]">
        <!-- <xsl:analyze-string select="." regex="\w+"> -->
        <!-- regex="CB(?!8)\d"> -->
        <!-- <xsl:matching-substring> -->
     <div>
            <xsl:value-of select="regex-group(1)" />
        </div>
        <tr>
            <td>
                <table class="tgtable tgAssortment">
                    <xsl:call-template name="countryCodes">
                        <xsl:with-param name="parStr" select="./countryCodes" />
                        <xsl:with-param name="parPos" select="1" />
                    </xsl:call-template>
                </table>
            </td>
            <td>
             <div class="tgData">
                    <xsl:value-of select="./totalPackRatio" />
                </div>
            </td>
            <td>
             <div class="tgData">
                    <xsl:value-of select="./name" />
                </div>
            </td>
        </tr>
        <xsl:apply-templates select="./styles/style" />
        <!-- </xsl:matching-substring></xsl:analyze-string> -->
    </xsl:template>
    <!-- Register Assortment (2/4): Aufbau der Tabelle im Register Assortment. -->
    <xsl:template name="countryCodes">
        <xsl:param name="parStr" />
        <xsl:param name="parPos" />
        <xsl:choose>
            <xsl:when test="string-length(substring-before($parStr,',')) > 0">
                <!-- Call des Box-Templates mit dem Teil vor dem Komma. -->
                <xsl:call-template name="countryBox">
                    <xsl:with-param name="parSubStr" select="substring-before($parStr,',')" />
                    <xsl:with-param name="parPos" select="$parPos" />
                </xsl:call-template>
                <!-- Rekursiver Aufruf mit dem Teil hinterm Komma. -->
                <xsl:call-template name="countryCodes">
                    <xsl:with-param name="parStr" select="substring-after($parStr,',')" />
                    <xsl:with-param name="parPos" select="$parPos + 1" />
                </xsl:call-template>
            </xsl:when>
            <xsl:otherwise>
                <!-- Call des Box-Templates mit dem Rest. -->
                <xsl:call-template name="countryBox">
                    <xsl:with-param name="parSubStr" select="$parStr" />
                    <xsl:with-param name="parPos" select="$parPos" />
                </xsl:call-template>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <!-- Register Assortment (3/4): Aufbau der Tabelle im Register Assortment. -->
    <xsl:template name="countryBox">
        <xsl:param name="parSubStr" />
        <xsl:param name="parPos" />
        <xsl:variable name="CB" select="substring-before($parSubStr,'-')" />
        <xsl:variable name="CC" select="substring-after($parSubStr,'-')" />
        <xsl:variable name="CBNo" select="substring-after($CB,'CB')" />
        <tr>
            <td class="tgCB {concat('tgRow',$CBNo)}">
                <xsl:value-of select="$CB" />
            </td>
            <td class="tgCC {concat('tgRow',$CBNo)}">
                <xsl:value-of select="$CC" />
            </td>
        </tr>
    </xsl:template>
    <!-- Register Assortment (4/4): Aufbau der Tabelle im Register Assortment. -->
    <xsl:template match="assortment/styles/style">
        <tr class="tgLangDE">
            <td>
             <div lang="de">
                    <xsl:value-of select="./styleNo" />
                </div>
            </td>
            <td>
             <div lang="de">
                    <xsl:value-of select="./productName" />
                </div>
            </td>
            <td>
             <div lang="de">
                    <xsl:value-of select="./sizes/size/value" />
                </div>
            </td>
        </tr>
    </xsl:template>
    <!-- Register Purchase Overview (1/2): Aufbau der Tabelle im Register Purchase Overview. -->
    <xsl:template match="localQuantity">
        <tr id="{concat('localQuantity_', generate-id(), '_inputRow')}" class="tgLangDE">
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./gtin" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./styleNo" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./productName" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./size/code" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./lsv/code" />
                </div>
            </td>
            <!-- quantitiesPerCountry -->
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='DE']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='FR']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='IT']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='ES']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='GB']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='BE']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='PT']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='NL']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='AT']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='GR']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='IE']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='NI']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='PL']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='FI']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='CZ']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='SE']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='SK']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='HU']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='DK']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='HR']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='SI']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='CH']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='CY']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='BG']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='RO']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='LT']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='US']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='RS']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='EE']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./quantitiesPerCountry/quantityPerCountry[country='LV']/value" />
                </div>
            </td>
        </tr>
    </xsl:template>
    <!-- Register Purchase Overview (2/2): Aufbau der Tabelle im Register Purchase Overview. -->
    <xsl:template match="onlineQuantity">
        <tr id="{concat('onlineQuantity_', generate-id(), '_inputRow')}" class="tgLangDE">
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./gtin" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./styleNo" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./productName" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./size/code" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./lsv/code" />
                </div>
            </td>
            <!-- quantitiesPerCountry -->
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./delivery/quantitiesPerCountry/quantityPerCountry[country='OSDE']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./delivery/quantitiesPerCountry/quantityPerCountry[country='OSBE']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./delivery/quantitiesPerCountry/quantityPerCountry[country='OSNL']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./delivery/quantitiesPerCountry/quantityPerCountry[country='OSCZ']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./delivery/quantitiesPerCountry/quantityPerCountry[country='OSES']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./delivery/quantitiesPerCountry/quantityPerCountry[country='OSGB']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./delivery/quantitiesPerCountry/quantityPerCountry[country='OSFR']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./delivery/quantitiesPerCountry/quantityPerCountry[country='OSPL']/value" />
                </div>
            </td>
            <td>
             <div lang="de" class="tgRow">
                    <xsl:value-of select="./delivery/quantitiesPerCountry/quantityPerCountry[country='OSSK']/value" />
                </div>
            </td>
        </tr>
    </xsl:template>
    <!-- Spezielles Template für Zertifizierungen. -->
    <xsl:template match="certifications">
     <div class="tgPropertyInput tgLangDE">
         <div name="{local-name()}" id="{local-name()}" class="tgLabel">
                <xsl:value-of select="local-name()" />
            </div>
            <xsl:choose>
                <xsl:when test="translate(../../../rfq/status, 'rfs', 'RFS') = 'RFS'">
                    <div lang="de" contentEditable="true" id="{concat(local-name(), '_input')}"
                        class="tgInputEditable tgCompare"> </div>
                </xsl:when>
                <xsl:otherwise>
                 <div lang="de" contentEditable="false" id="{concat(local-name(), '_input')}"
                        class="tgInput tgCompare">
                        <xsl:for-each select="./*">
                            <xsl:if test="position() > 1 ">
                                <xsl:text> </xsl:text>
                            </xsl:if>
                            <xsl:value-of select="./name" />
                        </xsl:for-each>
                    </div>
                </xsl:otherwise>
            </xsl:choose>
        </div>
    </xsl:template>
    <!-- Spezielles Template für restliche XML-Datenfelder. -->
    <xsl:template match="catalogue/*|measurement/*|fitting/*">
        <!-<div class="tgPropertyInput tgLangDE">-->
        <xsl:choose>
            <xsl:when test="contains(.,true()) or contains(.,false())">
             <div class="tgPropertyCheck tgLangDE">
                    <xsl:choose>
                        <xsl:when test="contains(.,false())">
                            <input disabled="" lang="de" name="{local-name()}"
                                id="{concat(local-name(..), '_', local-name(), '_input')}" type="checkbox"
                                class="tgCheckbox tgCompare" value="false" />
                        </xsl:when>
                        <xsl:when test="contains(.,true())">
                            <input disabled="" lang="de" name="{local-name()}"
                                id="{concat(local-name(..), '_', local-name(), '_input')}" type="checkbox"
                                class="tgCheckbox tgCompare" value="true" checked="" />
                        </xsl:when>
                        <xsl:otherwise>
                         <div lang="de" contentEditable="false"
                                id="{concat(local-name(..), '_', local-name(), '_input')}" class="tgInput tgCompare">
                                <xsl:value-of select="." />
                            </div>
                        </xsl:otherwise>
                    </xsl:choose>
                 <div name="{local-name()}" id="{local-name()}" class="tgLabel">
                        <xsl:value-of select="local-name()" />
                    </div>
                </div>
            </xsl:when>
            <xsl:otherwise>
             <div class="tgPropertyInput tgLangDE">
                 <div name="{local-name()}" id="{local-name()}" class="tgLabel">
                        <xsl:value-of select="local-name()" />
                    </div>
                 <div lang="de" contentEditable="false" id="{concat(local-name(..), '_', local-name(), '_input')}"
                        class="tgInput tgCompare">
                        <xsl:value-of select="." />
                    </div>
                </div>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <!-- +++ Templates mit Namen und Parameter +++ -->
    <!-- Spezielles Key Value Pair, bestehend aus Label und Input Field. -->
    <!-- Die ersten vier Zeichen des Values werden verwendet. -->
    <xsl:template name="charge">
     <div class="tgPropertyInput tgLangDE">
         <div name="charge" id="charge" class="tgLabel">
                <xsl:text>charge</xsl:text>
            </div>
         <div lang="de" id="charge_input" class="tgInput tgCompare">
                <xsl:value-of select="substring(rfq/item/selectionNo,1,4)" />
            </div>
        </div>
    </xsl:template>
    <!-- Funktion um ein führendes Linefeed zu entfernen. -->
    <xsl:template name="delFirstLF">
        <xsl:param name="parStr" />
        <xsl:choose>
            <xsl:when test="starts-with($parStr, ' ')">
                <xsl:value-of select="substring($parStr, 2, string-length($parStr)-2)" />
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="$parStr" />
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
</xsl:stylesheet>