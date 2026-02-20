<html>
    <head>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="1.5" name="version" />
        <title id="requestForQuotation">requestForQuotation</title>
        <link href="http://schema.targa.de/Lieferantenportal/v1.5/myCSS.css" type="text/css" rel="stylesheet" />
    </head>
    <body>

        
            <div class="tgHead">
                <div class="tgIconWrap">
                    <img height="16px" width="16px" alt="" src="include/favicon_white.gif" />
                </div>
                <div name="h2RFQ" id="h2RFQ" class="tgHeadline">h2RFQ</div>
                <div contentEditable="true" id="tgDocVerMajor" class="tgHeadlineVersion tgInputVersion">1</div>
                <div class="tgHeadlineVersion">.</div>
                <div contentEditable="true" id="tgDocVerMinor" class="tgHeadlineVersionStop tgInputVersion">1</div>
                <div>
                    <button name="buttonDocument" id="buttonDocument"
                        class="tgDisplayLinks active">buttonDocument</button>
                    <button name="buttonProduct" id="buttonProduct" class="tgDisplayLinks active">buttonProduct</button>
                </div>
                <select id="structureLangDropDown" class="tgDropDown">
                    <option name="german" id="german" class="tgDropDownOption" value="de">german</option>
                    <option name="english" id="english" class="tgDropDownOption" value="en">english</option>
                    <option name="element" id="element" class="tgDropDownOption" value="xml">element</option>
                </select>
            </div>
            <div class="tgContent">
                <!-- D o c u m e n t - d a t a -->
                <div name="topDocument" id="topDocument" class="tgCommonData tgTopContent active">
                    <h3 name="h3documentData" id="h3documentData" class="tgCategoryHeadline">h3documentData</h3>
                    <div class="tgColumn">
                        <xsl:apply-templates select="rfq/rfqNo" />
                        <xsl:apply-templates select="rfq/status" />
                        <xsl:apply-templates select="rfq/category" />
                        <xsl:apply-templates select="rfq/vendorNo" />
                    </div>
                    <div class="tgColumn">
                        <!-- <xsl:apply-templates select="rfq/creatorEmail"/> -->
                        <xsl:apply-templates select="rfq/createUserName" />
                        <!-- <xsl:apply-templates select="rfq/updateUserEmail"/> -->
                        <xsl:apply-templates select="rfq/updateUserName" />
                        <xsl:apply-templates select="rfq/createdOn" />
                        <xsl:apply-templates select="rfq/updatedOn" />
                    </div>
                    <div class="tgColumn">
                        <xsl:apply-templates select="rfq/isLatest" />
                        <xsl:apply-templates select="rfq/expiryDate" />
                    </div>
                </div>
                <!-- P r o d u c t - d a t a -->
                <div name="topProduct" id="topProduct" class="tgCommonData tgTopContent active">
                    <h3 name="h3productData" id="h3productData" class="tgCategoryHeadline">h3productData</h3>
                    <div class="tgColumn">

                        <div class="tgPropertyInput tgLangDE">
                            <div name="{local-name()}" id="{local-name()}" class="tgLabel">
                                   <xsl:value-of select="local-name()" />
                               </div>
                            <div lang="de" contentEditable="false" id="{concat(local-name(), '_input')}" class="tgInput tgCompare">
                                   99999
                               </div>
                               <!-- <div class="tgLabel" id="{local-name(../noLIDLItem)}" name="{local-name(../noLIDLItem)}"><xsl:value-of select="local-name(../noLIDLItem)"/></div><xsl:choose><xsl:when test="contains(../noLIDLItem,false())"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="{local-name()}" id="{concat(local-name(..), '_', local-name(), '_input')}" value="false" disabled=""/></xsl:when><xsl:when test="contains(../noLIDLItem,true())"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="{local-name()}" id="{concat(local-name(..), '_', local-name(), '_input')}" value="true" checked="" disabled=""/></xsl:when></xsl:choose> -->
                        </div>
                        <!--    <xsl:apply-templates select="rfq/item/ian" />
                                <xsl:call-template name="charge" />
                                <xsl:apply-templates select="rfq/item/version" />
                                <xsl:apply-templates select="rfq/item/description" />
                        -->
                    </div>
                    <div class="tgColumn">
                        <xsl:apply-templates select="rfq/item/noLIDLItem" />
                        <xsl:apply-templates select="rfq/item/images/image" />
                    </div>
                </div>
                <div class="tgCommonData">
                    <h3 name="h3AngebotsnummerPraefix" id="h3AngebotsnummerPraefix" class="tgCategoryHeadline">
                        h3AngebotsnummerPraefix</h3>
                    <div class="tgColumn">
                        <div class="tgPropertyInput tgLangDE">
                            <div name="angebotsnummerPraefix" id="angebotsnummerPraefix" class="tgLabel">angebotsnummerPraefix</div>
                            <div lang="de" contentEditable="false" id="angebotsnummerPraefix_input" class="tgInput tgCompare">
                                <xsl:value-of select="concat(rfq/vendorNo, '_', rfq/rfqNo, '_', rfq/item/ian, '_', substring-before(rfq/item/selectionNo, '_'), '_')" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tgTab">
                    <button name="buttonMasterData" id="buttonMasterData" class="tgTabLinks active">buttonMasterData</button>
                    <button name="buttonQuality" id="buttonQuality" class="tgTabLinks">buttonQuality</button>
                    <button name="buttonAssortment" id="buttonAssortment" class="tgTabLinks">buttonAssortment</button>
                    <button name="buttonQuantity" id="buttonQuantity" class="tgTabLinks">buttonQuantity</button>
                    <button name="buttonOverview" id="buttonOverview" class="tgTabLinks">buttonOverview</button>
                    <button name="buttonOtherXML" id="buttonOtherXML" class="tgTabLinks tgHidden">buttonOtherXML</button>
                    <button name="buttonTranslationList" id="buttonTranslationList" class="tgTabLinks tgHidden">buttonTranslationList</button>
                    <button name="buttonHistory" id="buttonHistory" class="tgTabLinks">buttonHistory</button>
                    <button name="buttonOffer" id="buttonOffer" class="tgLinkButton tgHidden" target="http://schema.ad.targa.de/Lieferantenportal/v1.5/offer_template.html">buttonOffer</button>
                </div>
                <!-- S t a m m d a t e n -->
                <div name="tabMasterData" id="tabMasterData" class="tgTabContent active">
                    <div class="tgCommonData">
                        <h3 name="h3MasterData" id="h3MasterData" class="tgCategoryHeadline">h3MasterData</h3>
                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/selectionNo" />
                            <xsl:apply-templates select="rfq/item/articleGroup/name" />
                            <xsl:apply-templates select="rfq/item/buyerShortCode" />
                            <xsl:apply-templates select="rfq/item/rfSafety/name" />
                        </div>
                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/predecessor" />
                            <xsl:apply-templates select="rfq/item/theme" />
                            <xsl:apply-templates select="rfq/item/wholeSalePackaging" />
                        </div>
                    </div>
                    <div class="tgCommonData">
                        <div class="tgColumn">
                            <xsl:choose>
                                <xsl:when test="translate(rfq/status, 'rfs', 'RFS') = 'RFS'">
                                    <div class="tgPropertyInput tgLangDE">
                                        <div name="comments" id="comments" class="tgLabel">comments</div>
                                        <div lang="de" contentEditable="true" id="'comments_input'" class="tgInputEditable tgCompare" />
                                    </div>
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:apply-templates select="rfq/item/comments" />
                                </xsl:otherwise>
                            </xsl:choose>
                        </div>
                    </div>
                    <hr />
                    <div class="tgCommonData">
                        <div class="tgColumn">
                            <h3 name="h3KlData" id="h3KlData" class="tgCategoryHeadline">h3KlData</h3>
                            <xsl:apply-templates select="rfq/item/itemTypeKL/name" />
                            <h2 name="h2RelatedItems" id="h2RelatedItems" class="tgCategoryHeadline">h2RelatedItems</h2>
                            <table id="relatedItems">
                                <thead>
                                    <tr>
                                        <th name="relatedItemIan" id="relatedItemIan" class="tgTableHeads">relatedItemIan</th>
                                        <th name="lotNo" id="lotNo" class="tgTableHeads">lotNo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <xsl:apply-templates select="rfq/item/relatedItems/relatedItem" />
                                </tbody>
                            </table>
                        </div>
                        <div class="tgColumn"> </div>
                    </div>
                    <hr />
                    <xsl:choose>
                        <xsl:when test="rfq/item/sampleNumberKL">
                            <div class="tgCommonData">
                                <h3 name="h3Sample" id="h3Sample" class="tgCategoryHeadline">h3Sample</h3>
                                <div class="tgColumn">
                                    <xsl:apply-templates select="rfq/item/sampleNumberKL" />
                                    <xsl:apply-templates select="rfq/item/buyerShortCodeKL" />
                                </div>
                                <div class="tgColumn">
                                    <xsl:apply-templates select="rfq/item/buyerNameKL" />
                                    <xsl:apply-templates select="rfq/item/themeNoKL" />
                                </div>
                            </div>
                            <hr />
                        </xsl:when>
                    </xsl:choose>
                    <div class="tgCommonData">
                        <div class="tgColumn">
                            <h3 name="h3Identification" id="h3Identification" class="tgCategoryHeadline">h3Identification</h3>
                            <xsl:apply-templates select="rfq/item/brand/name" />
                            <xsl:apply-templates select="rfq/item/brandKL" />
                        </div>
                        <div class="tgColumn"> </div>
                    </div>
                    <hr />
                    <div class="tgCommonData">
                        <div class="tgColumn">
                            <h3 name="h3TestCriteria" id="h3TestCriteria" class="tgCategoryHeadline">h3TestCriteria</h3>
                            <xsl:apply-templates select="rfq/item/testLab/name" />
                        </div>
                        <div class="tgColumn"> </div>
                    </div>
                    <hr />
                    <div class="tgCommonData">
                        <div class="tgColumn">
                            <h3 name="h3Certifications" id="h3Certifications" class="tgCategoryHeadline">h3Certifications</h3>
                            <div class="tgColumn">
                                <xsl:apply-templates select="rfq/item/certifications" />
                            </div>
                            <div class="tgColumn">
                                <xsl:apply-templates select="rfq/item/certifications/comment" />
                            </div>
                        </div>
                        <div class="tgColumn"> </div>
                    </div>
                    <hr />
                    <div class="tgCommonData">
                        <h3 name="h3Packaging" id="h3Packaging" class="tgCategoryHeadline">h3Packaging</h3>
                    </div>
                    <div class="tgCommonData">
                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/packaging/agency/name" />
                            <xsl:apply-templates select="rfq/item/packaging/materialThickness" />
                        </div>
                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/packaging/retailPackaging/name" />
                            <xsl:apply-templates select="rfq/item/packaging/retailPackagingComment" />
                        </div>
                    </div>
                    <hr />
                    <div class="tgCommonData">
                        <h3 name="h3RetailPackaging" id="h3RetailPackaging" class="tgCategoryHeadline">h3RetailPackaging</h3>
                    </div>

                    <div class="tgCommonData">
                        <div class="tgColumn">
                            <table id="retailPackaging">
                                <thead>
                                    <tr>
                                        <th name="retailPackaging/styleNo" id="retailPackaging/styleNo" class="tgTableHeads">styleNo</th>
                                        <th name="retailPackaging/productName" id="retailPackaging/productName" class="tgTableHeads">productName</th>
                                        <th name="retailPackaginWidth" id="retailPackaginWidth" class="tgTableHeads">retailPackaginWidth</th>
                                        <th name="retailPackaginHeight" id="retailPackaginHeight" class="tgTableHeads">retailPackaginHeight</th>
                                        <th name="retailPackaginLength" id="retailPackaginLength" class="tgTableHeads">retailPackaginLength</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <xsl:apply-templates select="rfq/item/styles/style" mode="retailPackaging" />
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr />
                    <div class="tgCommonData">
                        <h3 name="h3PackagingKl" id="h3PackagingKl" class="tgCategoryHeadline">h3PackagingKl</h3>
                    </div>
    
                    <div class="tgCommonData">
    
                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/packagingKL/retailPackaging/name" />
                            <xsl:apply-templates select="rfq/item/packagingKL/materialThickness" />
                        </div>
    
                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/packagingKL/tray/name" />
                            <xsl:apply-templates select="rfq/item/packagingKL/retailPackagingComment" />
                            <xsl:apply-templates select="rfq/item/packagingKL/trayRemarks" />
                        </div>
                    </div>
                    <hr />
    
                    <div class="tgCommonData">
                        <h3 name="h3Warranty" id="h3Warranty" class="tgCategoryHeadline">h3Warranty</h3>
    
                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/guarantee/name" />
                            <xsl:apply-templates select="rfq/item/guaranteeType" />
                        </div>
                        <div class="tgColumn"> </div>
                    </div>
                    <hr />
    
                    <div class="tgCommonData">
                        <h3 name="h3catalogue" id="h3catalogue" class="tgCategoryHeadline">h3catalogue</h3>
                     <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/catalogue/isCatalogue" />
                            <xsl:apply-templates select="rfq/item/catalogue/initialOrder/name" />
                            <xsl:apply-templates select="rfq/item/catalogue/timeOfOrder/name" />
                            <xsl:apply-templates select="rfq/item/catalogue/minOrderQuantity" />
                            <xsl:apply-templates select="rfq/item/catalogue/initialCharge" />
                        </div>
                        <div class="tgColumn"> </div>
                    </div>
                    <hr />
    
                    <div class="tgCommonData">
                        <h4 name="h4Attachments" id="h4Attachments" class="tgCategoryHeadline" />
    
                        <div class="tgColumn">
                            <ul class="tgAttachmentList">
                                <xsl:apply-templates select="rfq/item/attachments/document" />
                            </ul>
                        </div>
                    </div>
    
                </div>
    
                <!-- Q u a l i t ä t -->
    
                <div name="tabQuality" id="tabQuality" class="tgTabContent">
    
                    <div class="tgCommonData">
                        <h3 name="h3Quality" id="h3Quality" class="tgCategoryHeadline">h3Quality</h3>
                    </div>
    
                    <div class="tgCommonData">
    
                        <div class="tgColumn">
                            <xsl:choose>
                                <xsl:when test="translate(rfq/status, 'rfs', 'RFS') = 'RFS'">
                                <div class="tgPropertyInput tgLangDE">
                                    <div name="color" id="color" class="tgLabel">color</div>
                                    <div lang="de" contentEditable="true" id="'color_input'" class="tgInputEditable tgCompare" />
                                </div>
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:apply-templates select="rfq/item/quality/color" />
                                </xsl:otherwise>
                            </xsl:choose>
                        </div>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/quality/materialThickness" />
                        </div>
                    </div>

                    <div class="tgCommonData">
                        <xsl:apply-templates select="rfq/item/quality/material" />
                    </div>

                    <div class="tgCommonData">
                        <h3 name="h3Styles" id="h3Styles" class="tgCategoryHeadline">h3Styles</h3>
                    </div>

                    <table id="styles">
                        <thead>
                            <tr>
                                <th name="styleNo" id="styleNo" class="tgTableHeads">styleNo</th>
                                <th name="productName" id="productName" class="tgTableHeads">productName</th>
                                <th name="weightWithoutPackaging" id="weightWithoutPackaging" class="tgTableHeads">weightWithoutPackaging</th>
                                <th name="sizeWithoutPackaging" id="sizeWithoutPackaging" class="tgTableHeads">sizeWithoutPackaging</th>
                                <th name="qualityTechnicalData" id="qualityTechnicalData" class="tgTableHeads">qualityTechnicalData</th>
                                <th name="additionalQualityInformation" id="additionalQualityInformation" class="tgTableHeads">additionalQualityInformation</th>
                                <th name="changesFromPredecessor" id="changesFromPredecessor" class="tgTableHeads">changesFromPredecessor</th>
                                <th name="brandReference" id="brandReference" class="tgTableHeads">brandReference</th>
                                <th name="material" id="material" class="tgTableHeads">material</th>
                                <th name="materialThickness" id="materialThickness" class="tgTableHeads">materialThickness</th>
                                <th name="color" id="color" class="tgTableHeads">color</th>
                            </tr>
                        </thead>
                        <tbody>
                            <xsl:choose>
                                <xsl:when test="translate(rfq/status, 'rfs', 'RFS') = 'RFS' or translate(rfq/status, 'rfshg', 'RFSHG') = 'RFSHG'">
                                    <tr id="{concat('style_', generate-id(), '_1_inputRow')}" class="tgLangDE">
                                        <td>
                                            <div lang="de" id="{concat('styleNo_', generate-id(), '_1_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('productName_', generate-id(), '_1_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('weightWithoutPackaging_', generate-id(), '_1_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('sizeWithoutPackaging_', generate-id(), '_1_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('qualityTechnicalData_', generate-id(), '_1_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('additionalQualityInformation', generate-id(), '_1_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('changesFromPredecessor', generate-id(), '_1_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('brandReference', generate-id(), '_1_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('material', generate-id(), '_1_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('materialThickness', generate-id(), '_1_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('color', generate-id(), '_1_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                    </tr>
                                    <tr id="{concat('style_', generate-id(), '_2_inputRow')}" class="tgLangDE">
                                        <td>
                                            <div lang="de" ="{concat('styleNo_', generate-id(), '_2_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('productName_', generate-id(), '_2_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('weightWithoutPackaging_', generate-id(), '_2_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('sizeWithoutPackaging_', generate-id(), '_2_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('qualityTechnicalData_', generate-id(), '_2_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('additionalQualityInformation', generate-id(), '_2_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('changesFromPredecessor', generate-id(), '_2_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('brandReference', generate-id(), '_2_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('material', generate-id(), '_2_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('materialThickness', generate-id(), '_2_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('color', generate-id(), '_2_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                    </tr>
                                    <tr id="{concat('style_', generate-id(), '_3_inputRow')}" class="tgLangDE">
                                        <td>
                                            <div lang="de" ="{concat('styleNo_', generate-id(), '_3_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('productName_', generate-id(), '_3_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('weightWithoutPackaging_', generate-id(), '_3_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('sizeWithoutPackaging_', generate-id(), '_3_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('qualityTechnicalData_', generate-id(), '_3_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('additionalQualityInformation', generate-id(), '_3_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('changesFromPredecessor', generate-id(), '_3_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('brandReference', generate-id(), '_3_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('material', generate-id(), '_3_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('materialThickness', generate-id(), '_3_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('color', generate-id(), '_3_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                    </tr>
                                    <tr id="{concat('style_', generate-id(), '_4_inputRow')}" class="tgLangDE">
                                        <td>
                                            <div lang="de" ="{concat('styleNo_', generate-id(), '_4_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('productName_', generate-id(), '_4_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('weightWithoutPackaging_', generate-id(), '_4_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('sizeWithoutPackaging_', generate-id(), '_4_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('qualityTechnicalData_', generate-id(), '_4_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('additionalQualityInformation', generate-id(), '_4_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('changesFromPredecessor', generate-id(), '_4_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('brandReference', generate-id(), '_4_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('material', generate-id(), '_4_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('materialThickness', generate-id(), '_4_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('color', generate-id(), '_4_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                    </tr>
                                    <tr id="{concat('style_', generate-id(), '_5_inputRow')}" class="tgLangDE">
                                        <td>
                                            <div lang="de" ="{concat('styleNo_', generate-id(), '_5_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('productName_', generate-id(), '_5_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('weightWithoutPackaging_', generate-id(), '_5_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('sizeWithoutPackaging_', generate-id(), '_5_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('qualityTechnicalData_', generate-id(), '_5_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('additionalQualityInformation', generate-id(), '_5_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('changesFromPredecessor', generate-id(), '_5_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('brandReference', generate-id(), '_5_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('material', generate-id(), '_5_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" id="{concat('materialThickness', generate-id(), '_5_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                        <td>
                                            <div lang="de" ="{concat('color', generate-id(), '_5_inputCell')}" class="tgInputEditable tgCompare" additionalInfo="" contenteditable="true" />
                                        </td>
                                    </tr>
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:apply-templates select="rfq/item/styles/style" mode="quality" />
                                </xsl:otherwise>
                            </xsl:choose>
                        </tbody>
                    </table>
                </div>

                <!-- S o r t i e r u n g -->
             
                <div name="tabAssortment" id="tabAssortment" class="tgTabContent">
             
                    <div class="tgFullTextContainer">
                        <h3 name="h3Assortment" id="h3Assortment" class="tgCategoryHeadline">h3Assortment</h3>
                    </div>
             
                    <div class="tgFullTextContainer">
                        <table id="Assortment">
                            <thead>
                                <tr>
                                    <th name="countryCodes" id="countryCodes" class="tgTableHeads">countryCodes</th>
                                    <th name="totalPackRatio" id="totalPackRatio" class="tgTableHeads">totalPackRatio </th>
                                    <th name="name" id="name" class="tgTableHeads">name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <xsl:apply-templates select="rfq/item/assortments/assortment" />
                            </tbody>
                        </table>
                    </div>
                </div>
             
                <!-- M e n g e -->
             
                <div name="tabQuantity" id="tabQuantity" class="tgTabContent">
                    <h3 name="h3Quantity" id="h3Quantity" class="tgCategoryHeadline">h3Quantity</h3>
                    <div name="tooltipQuantity" id="tooltipQuantity" class="tgTableHeads">tooltipQuantity</div>
             
                    <table id="quantity">
                        <thead>
                            <tr>
                                <th name="country" id="country" class="tgTableHeads">country</th>
                                <th name="totalNumOfCtn" id="totalNumOfCtn" class="tgTableHeads">totalNumOfCtn</th>
                                <th name="totalPackRatio" id="totalPackRatio" class="tgTableHeads">totalPackRatio</th>
                                <th name="totalQtyPerCountry" id="totalQtyPerCountry" class="tgTableHeads">totalQtyPerCountry</th>
                                <th name="ctryDeliveryWeek1" id="ctryDeliveryWeek1" class="tgTableHeads">ctryDeliveryWeek1</th>
                                <th name="ctryDeliveryTotalQty1" id="ctryDeliveryTotalQty1" class="tgTableHeads">ctryDeliveryTotalQty1</th>
                                <th name="ctryDeliveryWeek2" id="ctryDeliveryWeek2" class="tgTableHeads">ctryDeliveryWeek2</th>
                                <th name="ctryDeliveryTotalQty2" id="ctryDeliveryTotalQty2" class="tgTableHeads">ctryDeliveryTotalQty2</th>
                                <th name="ctryDeliveryWeek3" id="ctryDeliveryWeek3" class="tgTableHeads">ctryDeliveryWeek3</th>
                                <th name="ctryDeliveryTotalQty3" id="ctryDeliveryTotalQty3" class="tgTableHeads">ctryDeliveryTotalQty3</th>
                                <th name="articleInformation" id="articleInformation" class="tgTableHeads">articleInformation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <xsl:apply-templates select="rfq/item/quantities/quantity" />
                            <tr>
                                <td>
                                    <div lang="de" name="totalQuantity" id="totalQuantity" class="tgTableHeads">totalQuantity</div>
                                </td>
                                <td>
                                    <div lang="de" id="totalNumOfCtn-sum" class="tgRow">
                                        <xsl:value-of select="format-number(sum(rfq/item/quantities/quantity/totalNumOfCtn), '###.###.###', 'quantityFormat')" />
                                    </div>
                                </td>
                                <td>
                                    <div lang="de" id="totalPackRatio-sum" class="tgRow" />
                                </td>
                                <td>
                                    <div lang="de" id="totalQtyPerCountry-sum" class="tgRow">
                                        <xsl:value-of select="format-number(sum(rfq/item/quantities/quantity/totalQtyPerCountry), '###.###.###', 'quantityFormat')" />
                                    </div>
                                </td>
                                <td>
                                    <div lang="de" id="ctryDeliveryWeek1-sum" class="tgRow" />
                                </td>
                                <td>
                                    <div lang="de" id="ctryDeliveryTotalQty1-sum" class="tgRow">
                                        <xsl:value-of select="format-number(sum(rfq/item/quantities/quantity/countryDeliveryTotalQty1), '###.###.###', 'quantityFormat')" />
                                    </div>
                                </td>
                                <td>
                                    <div lang="de" id="ctryDeliveryWeek2-sum" class="tgRow" />
                                </td>
                                <td>
                                    <div lang="de" id="ctryDeliveryTotalQty2-sum" class="tgRow">
                                        <xsl:value-of select="format-number(sum(rfq/item/quantities/quantity/countryDeliveryTotalQty2), '###.###.###', 'quantityFormat')" />
                                    </div>
                                </td>
                                <td>
                                    <div lang="de" id="ctryDeliveryWeek3-sum" class="tgRow" />
                                </td>
                                <td>
                                    <div lang="de" id="ctryDeliveryTotalQty3-sum" class="tgRow">
                                        <xsl:value-of select="format-number(sum(rfq/item/quantities/quantity/countryDeliveryTotalQty3), '###.###.###', 'quantityFormat')" />
                                    </div>
                                </td>
                                <td>
                                    <div lang="de" id="articleInformation-sum" class="tgRow" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- B e s t e l l ü b e r s i c h t -->

                <div name="tabOverview" id="tabOverview" class="tgTabContent">
                    <h3 name="h3Overview" id="h3Overview" class="tgCategoryHeadline">h3Overview</h3>
                    <table id="localQuantity">
                        <thead>
                            <tr>
                                <th name="gtin" id="gtin" class="tgTableHeads">gtin</th>
                                <th name="styleNo" id="styleNo" class="tgTableHeads">styleNo</th>
                                <th name="productName" id="productName" class="tgTableHeads">productName</th>
                                <th name="sizeName" id="sizeName" class="tgTableHeads">sizeName</th>
                                <th name="LSV" id="LSV" class="tgTableHeads">LSV</th>
                                <th name="DE" id="DE" class="tgTableHeads">DE</th>
                                <th name="FR" id="FR" class="tgTableHeads">FR</th>
                                <th name="IT" id="IT" class="tgTableHeads">IT</th>
                                <th name="ES" id="ES" class="tgTableHeads">ES</th>
                                <th name="GB" id="GB" class="tgTableHeads">GB</th>
                                <th name="BE" id="BE" class="tgTableHeads">BE</th>
                                <th name="PT" id="PT" class="tgTableHeads">PT</th>
                                <th name="NL" id="NL" class="tgTableHeads">NL</th>
                                <th name="AT" id="AT" class="tgTableHeads">AT</th>
                                <th name="GR" id="GR" class="tgTableHeads">GR</th>
                                <th name="IE" id="IE" class="tgTableHeads">IE</th>
                                <th name="NI" id="NI" class="tgTableHeads">NI</th>
                                <th name="PL" id="PL" class="tgTableHeads">PL</th>
                                <th name="FI" id="FI" class="tgTableHeads">FI</th>
                                <th name="CZ" id="CZ" class="tgTableHeads">CZ</th>
                                <th name="SE" id="SE" class="tgTableHeads">SE</th>
                                <th name="SK" id="SK" class="tgTableHeads">SK</th>
                                <th name="HU" id="HU" class="tgTableHeads">HU</th>
                                <th name="DK" id="DK" class="tgTableHeads">DK</th>
                                <th name="HR" id="HR" class="tgTableHeads">HR</th>
                                <th name="SI" id="SI" class="tgTableHeads">SI</th>
                                <th name="CH" id="CH" class="tgTableHeads">CH</th>
                                <th name="CY" id="CY" class="tgTableHeads">CY</th>
                                <th name="BG" id="BG" class="tgTableHeads">BG</th>
                                <th name="RO" id="RO" class="tgTableHeads">RO</th>
                                <th name="LT" id="LT" class="tgTableHeads">LT</th>
                                <th name="US" id="US" class="tgTableHeads">US</th>
                                <th name="RS" id="RS" class="tgTableHeads">RS</th>
                                <th name="EE" id="EE" class="tgTableHeads">EE</th>
                                <th name="LV" id="LV" class="tgTableHeads">LV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <xsl:apply-templates select="rfq/item/localQuantities/localQuantity" />
                            <tr>
                                <td class="tgTableHeads" />
                                <td class="tgTableHeads" />
                                <td class="tgTableHeads" />
                                <td class="tgTableHeads" />
                                <td name="totalPackRatio" id="totalPackRatio" class="tgTableHeads">totalPackRatio</td>
                                <td id="DE_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='DE']/value)" />
                                    </div>
                                </td>
                                <td id="FR_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='FR']/value)" />
                                    </div>
                                </td>
                                <td id="IT_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='IT']/value)" />
                                    </div>
                                </td>
                                <td id="ES_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='ES']/value)" />
                                    </div>
                                </td>
                                <td id="GB_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='GB']/value)" />
                                    </div>
                                </td>
                                <td id="BE_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='BE']/value)" />
                                    </div>
                                </td>
                                <td id="PT_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='PT']/value)" />
                                    </div>
                                </td>
                                <td id="NL_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='NL']/value)" />
                                    </div>
                                </td>
                                <td id="AT_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='AT']/value)" />
                                    </div>
                                </td>
                                <td id="GR_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='GR']/value)" />
                                    </div>
                                </td>
                                <td id="IE_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='IE']/value)" />
                                    </div>
                                </td>
                                <td id="NI_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='NI']/value)" />
                                    </div>
                                </td>
                                <td id="PL_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='PL']/value)" />
                                    </div>
                                </td>
                                <td id="FI_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='FI']/value)" />
                                    </div>
                                </td>
                                <td id="CZ_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='CZ']/value)" />
                                    </div>
                                </td>
                                <td id="SE_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='SE']/value)" />
                                    </div>
                                </td>
                                <td id="SK_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='SK']/value)" />
                                    </div>
                                </td>
                                <td id="HU_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='HU']/value)" />
                                    </div>
                                </td>
                                <td id="DK_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='DK']/value)" />
                                    </div>
                                </td>
                                <td id="HR_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='HR']/value)" />
                                    </div>
                                </td>
                                <td id="SI_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='SI']/value)" />
                                    </div>
                                </td>
                                <td id="CH_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='CH']/value)" />
                                    </div>
                                </td>
                                <td id="CY_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='CY']/value)" />
                                    </div>
                                </td>
                                <td id="BG_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='BG']/value)" />
                                    </div>
                                </td>
                                <td id="RO_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='RO']/value)" />
                                    </div>
                                </td>
                                <td id="LT_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='LT']/value)" />
                                    </div>
                                </td>
                                <td id="US_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='US']/value)" />
                                    </div>
                                </td>
                                <td id="RS_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='RS']/value)" />
                                    </div>
                                </td>
                                <td id="EE_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='EE']/value)" />
                                    </div>
                                </td>
                                <td id="LV_sum">
                                    <div lang="de">
                                        <xsl:value-of select="sum(rfq/item/localQuantities/localQuantity/quantitiesPerCountry/quantityPerCountry[country='LV']/value)" />
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h3 name="h3OverviewOnline" id="h3OverviewOnline" class="tgCategoryHeadline">h3OverviewOnline</h3>

                    <table id="onlineQuantity">
                        <thead>
                            <tr>
                                <th name="gtin" id="gtin" class="tgTableHeads">gtin</th>
                                <th name="styleNo" id="styleNo" class="tgTableHeads">styleNo</th>
                                <th name="productName" id="productName" class="tgTableHeads">productName</th>
                                <th name="sizeName" id="sizeName" class="tgTableHeads">sizeName</th>
                                <th name="LSV" id="LSV" class="tgTableHeads">LSV</th>
                                <th name="OSDE" id="OSDE" class="tgTableHeads">OSDE</th>
                                <th name="OSBE" id="OSBE" class="tgTableHeads">OSBE</th>
                                <th name="OSNL" id="OSNL" class="tgTableHeads">OSNL</th>
                                <th name="OSCZ" id="OSCZ" class="tgTableHeads">OSCZ</th>
                                <th name="OSES" id="OSES" class="tgTableHeads">OSES</th>
                                <th name="OSGB" id="OSGB" class="tgTableHeads">OSGB</th>
                                <th name="OSFR" id="OSFR" class="tgTableHeads">OSFR</th>
                                <th name="OSPL" id="OSPL" class="tgTableHeads">OSPL</th>
                                <th name="OSSK" id="OSSK" class="tgTableHeads">OSSK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <xsl:apply-templates select="rfq/item/onlineQuantities/onlineQuantity" />
                            <!-- <tr> -->
                            <!-- <td class="tgTableHeads"></td> -->
                            <!-- <td class="tgTableHeads"></td> -->
                            <!-- <td class="tgTableHeads"></td> -->
                            <!-- <td class="tgTableHeads"></td> -->
                            <!-- <td class="tgTableHeads" id="totalPackRatio" name="totalPackRatio">totalPackRatio</td> -->
                            <!-- <td id="OSDE_sum"><div lang="de"><xsl:value-of select="sum(rfq/item/onlineQuantities/onlineQuantity/quantitiesPerCountry/quantityPerCountry[country='OSDE']/value)"/></div></td> -->
                            <!-- <td id="OSBE_sum"><div lang="de"><xsl:value-of select="sum(rfq/item/onlineQuantities/onlineQuantity/quantitiesPerCountry/quantityPerCountry[country='OSBE']/value)"/></div></td> -->
                            <!-- <td id="OSNL_sum"><div lang="de"><xsl:value-of select="sum(rfq/item/onlineQuantities/onlineQuantity/quantitiesPerCountry/quantityPerCountry[country='OSNL']/value)"/></div></td> -->
                            <!-- <td id="OSCZ_sum"><div lang="de"><xsl:value-of select="sum(rfq/item/onlineQuantities/onlineQuantity/quantitiesPerCountry/quantityPerCountry[country='OSCZ']/value)"/></div></td> -->
                            <!-- <td id="OSES_sum"><div lang="de"><xsl:value-of select="sum(rfq/item/onlineQuantities/onlineQuantity/quantitiesPerCountry/quantityPerCountry[country='OSES']/value)"/></div></td> -->
                            <!-- <td id="OSGB_sum"><div lang="de"><xsl:value-of select="sum(rfq/item/onlineQuantities/onlineQuantity/quantitiesPerCountry/quantityPerCountry[country='OSGB']/value)"/></div></td> -->
                            <!-- <td id="OSFR_sum"><div lang="de"><xsl:value-of select="sum(rfq/item/onlineQuantities/onlineQuantity/quantitiesPerCountry/quantityPerCountry[country='OSFR']/value)"/></div></td> -->
                            <!-- <td id="OSPL_sum"><div lang="de"><xsl:value-of select="sum(rfq/item/onlineQuantities/onlineQuantity/quantitiesPerCountry/quantityPerCountry[country='OSPL']/value)"/></div></td> -->
                            <!-- <td id="OSSK_sum"><div lang="de"><xsl:value-of select="sum(rfq/item/onlineQuantities/onlineQuantity/quantitiesPerCountry/quantityPerCountry[country='OSSK']/value)"/></div></td> -->
                            <!-- </tr> -->
                        </tbody>
                    </table>
                </div>


                <!-- Z u s ä t z l i c h e D a t e n -->

                <div name="tabOtherXML" id="tabOtherXML" class="tgTabContent">

                    <div class="tgCommonData">
                        <h3 name="h3measurement" id="h3measurement" class="tgCategoryHeadline">h3measurement</h3>
                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/measurement/*" />

                        </div>

                    </div>

                    <hr />

                    <div class="tgCommonData">
                        <h3 name="h3catalogue" id="h3catalogue" class="tgCategoryHeadline">h3catalogue</h3>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/catalogue/*" />
                        </div>
                    </div>
                    <hr />

                    <h3 name="h3fitting" id="h3fitting" class="tgCategoryHeadline">Fitting</h3>

                    <div class="tgCommonData">
                        <h4 class="tgCategoryHeadline">AgeGroup, Aim, Back</h4>
                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(),'isAgeGroup')]" />
                        </div>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isAim')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'aim')]" />
                        </div>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(),'isBack')]" />
                        </div>
                    </div>

                    <div class="tgCommonData">
                        <h4 class="tgCategoryHeadline">Band, BkLen, Bra</h4>
                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isBand')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'band')]" />
                        </div>
                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isBkLen')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'bkLen')]" />
                        </div>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(),'isBraForm')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(),'braForm')]" />
                        </div>
                    </div>

                    <div class="tgCommonData">
                        <h4 class="tgCategoryHeadline">Coat, Collora, Gender</h4>
                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isCoat')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'coat')]" />
                        </div>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isCollar')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'collar')]" />
                        </div>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isGender')]" />
                        </div>
                    </div>

                    <div class="tgCommonData">
                        <h4 class="tgCategoryHeadline">Level, Neckline, Pant</h4>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isLvl')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'lvl')]" />
                        </div>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isNeckline')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'neckline')]" />
                        </div>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isPant')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'Pant')]" />
                        </div>
                    </div>

                    <div class="tgCommonData">
                        <h4 class="tgCategoryHeadline">Shoulder, Skirt, SleLen</h4>
                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isShoulder')]" />
                        </div>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isSkirt')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'skirt')]" />
                        </div>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isSleLen')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'sleLen')]" />
                        </div>
                    </div>

                    <div class="tgCommonData">
                        <h4 class="tgCategoryHeadline">Slip, Top, Trouser</h4>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isSlip')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'slip')]" />
                        </div>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isTop')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'top')]" />
                        </div>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isTrouser')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'trouser')]" />
                        </div>
                    </div>

                    <div class="tgCommonData">
                        <h4 class="tgCategoryHeadline">Underpart</h4>

                        <div class="tgColumn">
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'isUnderpart')]" />
                            <xsl:apply-templates select="rfq/item/fitting/*[contains(name(), 'underpart')]" />
                        </div>
                    </div>
                </div>

                <!-- T r a n s l a t i o n L i s t -->

                <div name="tabTranslationList" id="tabTranslationList" class="tgTabContent">

                    <div class="tgCommonData">
                        <h3 name="h3TranslationList" id="h3TranslationList" class="tgCategoryHeadline">h3TranslationList
                        </h3>

                        <div id="tgTranslationList" class="tgColumn tgColumnReverse">
                            <button name="buttonToggle" id="buttonToggle" class="extensionButton">buttonToggle</button>
                        </div>

                        <div id="tgTranslationControl" class="tgColumn">

                            <div lang="de" class="tgPropertyTextArea tgLangDE">
                                <div name="translationBoard" id="translationBoard" class="tgLabel">translationBoard</div>
                                <div lang="de" contentEditable="true" id="translationBoard_input" class="tgInputEditable">no translation yet </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- H i s t o r i e -->

                <div name="tabHistory" id="tabHistory" class="tgTabContent">
                    <h3 name="h3History" id="h3History" class="tgCategoryHeadline">h3History</h3>
                    <div name="tgHistory" id="tgHistory"> </div>
                </div>
            </div>

            <div class="tgFoot">
                <div id="tgWindowMessage" class="tgFooterMessages">Copyright by Targa GmbH</div>
                <div>
                    <button id="buttonExt0" style="display:none;">DE -> EN</button>
                    <button name="buttonExt1" id="buttonExt1" class="extensionButton tgHidden">buttonExt1</button>
                    <button name="buttonExt2" id="buttonExt2" class="extensionButton tgHidden">buttonExt2</button>
                    <button name="buttonExt3" id="buttonExt3" class="extensionButton tgHidden">buttonExt3</button>
                    <button name="buttonExt4" id="buttonExt4" class="extensionButton">buttonExt4</button>
                    <label name="buttonExt5" id="buttonExt5" class="extensionButton" for="fileCompare">buttonExt5</label>
                    <input name="fileCompare" id="fileCompare" type="file" class="extensionButton" />
                    <button name="buttonZip" id="buttonZip" class="extensionButton">buttonZip</button>
                </div>
            </div>
            <!--- Version placeholder -->
            <div id="tgExternal" style="display: none;">0</div>
            <div id="tgLanguage" style="display: none;">0</div>
            <script src="http://schema.targa.de/Lieferantenportal/common/diff.min.js" />
            <script src="http://schema.targa.de/Lieferantenportal/common/jszip.min.js" />
            <!--	todo: Das folgende Script muss online gestellt werden. -->
            <!--	todo: einen Closure erzeugen mit der lediglich die Funktion zur Übersetzung global verfügbar gemacht wird. -->
            <!--	Zu diskutieren wäre dann noch, ob die Resource dann nur für die aktuelle Anwendung oder auch für Andere Zwecke verendet wird.-->
            <script src="http://schema.targa.de/Lieferantenportal/v1.5/languageDict.js" />
            <!--	todo: Das folgende Script muss online gestellt werden. Verbesserungen können dadurch nachgereicht werden. -->
            <!--	todo: Aufteilenung. In diesem Script befinden sich nur die Funktionen die zur Bedienung der Seite verwendet werden. -->
            <!--	Z.B Umschaltung der Register. -->
            <!--	todo: Es muss eine Eindeutige Versonierung erstellt werden. Die Versionen müssen lebenslang online erreichbar bleiben. -->
            <script src="http://schema.targa.de/Lieferantenportal/v1.5/tgPage-PP-Basic+VersionNo.js" />
            <!--	todo: Das folgende Script muss online gestellt werden. Verbesserungen können dadurch nachgereicht werden. -->
            <!--	todo: Aufteilung. Dient der Funktionalen Erweiterung der Seite. -->
            <!--	todo: Es muss eine Eindeutige Versonierung erstellt werden. Die Versionen müssen lebenslang online erreichbar bleiben. -->
            <script src="http://schema.targa.de/Lieferantenportal/v1.5/tgPage-PP-OnlineExtension+VersionNo.js" />
            <!--	todo: Aufteilung. Dient der Funktionalen Erweiterung der Seite und kann zum Debugging von neuen Funtionen verwendet werden. -->
            <script src="http://schema.ad.targa.de/Lieferantenportal/v1.5/tgPage-PP-LocalExtension.js" />
    </body>
</html>
