<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="version" content="1.5">
    <title id="requestForQuotation">requestForQuotation</title>
    
    <style>
        .cpcMarkerOK {
            background-color: tranparent;
            border-radius: 0px;
            /* border: 1px solid #1c73c5;*/
            
            padding:6px;
            min-height: 30px;
        }
        
        .cpcMarkerQuestion {
            background-color: tranparent;
            border-radius: 0px;
            /*border: 3px solid #1c73c5;*/
            padding:6px;
        }

<!-- Targa Stylesheet  -->

/* Version 1.5 */


/* --tgBlue:#0d62af; Original Targa blau. */

* {
	box-sizing: border-box;
}

.tgTranslateTrue {
	display: auto;
}

.tgTranslateFalse {
	display: none;
}

:root {
	--tgRed:#ff0000;
	--tgBlue:#1C73C5;
	--tgDarkBlue: #103F6B;
	--tgLightBlue:#5ec3f1;
}

html, body {
	margin: 0;
	padding: 0;
}

body {
	font-family: Arial;
}

/**** Trennlinie ****/
hr {
	background-color: var(--tgDarkBlue);
	color: var(--tgDarkBlue);
	border: none;
	height: 1px;
}

/**** Ab hier die Ãœberschriften. ****/

h2, h3, h4 {
	margin: 0.2em 0.2em 0.5em 0.2em;
	flex-basis: 100%;
}

input[type="file"] {
    display: none;
}

a:link, a:visited, a:hover, a:active {
	text-decoration:none;
	font-weight:bold;
	color: var(--tgDarkBlue);
}

.tgHeadline {
	padding-left: 0.5em;
	font-size: 1.0em;
}

.tgHeadlineVersion {
	margin-left: -0.1em;
	padding-left: 0.1em;
	font-size: 1.0em;
}

.tgHeadlineVersionStop {
	margin-left: -0.1em;
	padding-left: 0.1em;
	flex-grow: 1;
	font-size: 1.0em;
}


.tgCategoryHeadline {
	margin: 0.5em 0.2em 0.5em 0.4em;
	flex-grow: 1;
	font-size: 1.2em;
	color: var(--tgDarkBlue);
}



/**** Ab hier die Container ****/

.tgContent {
	padding: 3em 0 2em 0;
}

.tgCommonData {
	/* Container Properties: */
	display: flex;
	flex-direction: row;
	justify-content: space-between;
	align-items: strech;
	flex-wrap: wrap;
	/* Item Properties: - */
	/* Other Properties: */
	margin: 0 0 0 0;
}

.tgHistoryData {
	/* Container Properties: */
	justify-content: space-between;
	align-items: strech;
	/* Item Properties: - */
	/* Other Properties: */
	margin: 0 0 0 0;
}

.tgColumn {
	/* Container Properties: */
	display: flex;
	flex-direction: column;
	justify-content: flex-start;
	align-items: strech;
	flex-wrap: nowrap;
	/* Item Properties: */
	flex-grow: 1;
	flex-shrink: 1;
	/* Other Properties: */
	margin: 0 0 0 0;
}

.tgColumnReverse {
	flex-direction: column-reverse;
}

/* Wenn nur eine Spalte vorhanden dann 100% der Breite einnehmen. */
.tgColumn:first-child:nth-last-child(1) {
	flex-basis: 100%;
}
/* Wenn zwei Spalten vorhanden dann 50% der Breite einnehmen. */
.tgColumn:first-child:nth-last-child(2),
.tgColumn:first-child:nth-last-child(2) ~ .tgColumn {
	flex-basis: 50%;
}
/* Wenn drei Spalten vorhanden dann 33% der Breite einnehmen. */
.tgColumn:first-child:nth-last-child(3),
.tgColumn:first-child:nth-last-child(3) ~ .tgColumn {
	flex-basis: 33.33%;
}

#tabOtherXML .tgColumn {
	border: 1px solid gray;
}



.tgPropertyInput, .tgPropertyTextArea {
	/* Container Properties: */
	display: flex;
	flex-direction: row;
	justify-content: space-between;
	align-items: flex-start;
	flex-wrap: wrap;
	/* Item Properties: - */
	/* Other Properties: */
	/* Nur die Endpunkte im Dokumentenbaum sorgen fÃ¼r die AbstÃ¤nde. */
	margin: 0.5em 0.5em 0.5em 0.5em;
}

.tgPropertyCheck {
	/* Container Properties: */
	display: flex;
	flex-direction: row;
	justify-content: flex-start;
	align-items: flex-start;
	flex-wrap: wrap;
	/* Item Properties: - */
	/* Other Properties: */
	/* Nur die Endpunkte im Dokumentenbaum sorgen fÃ¼r die AbstÃ¤nde. */
	margin: 0.5em 0.5em 0.5em 0.5em;

}

.tgLabel {
	color: var(--tgBlue);
	margin-bottom: 0.4em;
	overflow: auto;
	word-wrap: break-word;
}

.tgInput {
	border: solid;
	border-width: 1px;
	padding: 0.2em;
	min-height: 1.8em;
	white-space: pre-wrap;
	background-color: #dddddd;

	-webkit-transition: all 0.30s ease-in-out;
	-moz-transition: all 0.30s ease-in-out;
	-ms-transition: all 0.30s ease-in-out;
	-o-transition: all 0.30s ease-in-out;
}

.tgInputEditable {
	border: solid;
	border-width: 1px;
	padding: 0.2em;
	min-height: 1.8em;
	white-space: pre-wrap;
	background-color: clear;

	-webkit-transition: all 0.30s ease-in-out;
	-moz-transition: all 0.30s ease-in-out;
	-ms-transition: all 0.30s ease-in-out;
	-o-transition: all 0.30s ease-in-out;
}

.tgInputVersion {
	white-space: pre-wrap;

	-webkit-transition: all 0.30s ease-in-out;
	-moz-transition: all 0.30s ease-in-out;
	-ms-transition: all 0.30s ease-in-out;
	-o-transition: all 0.30s ease-in-out;
}

.tgInput:focus, .tgInputEditable:focus {
	border-color: var(--tgBlue);
	box-shadow: 0 0 3px var(--tgLightBlue);
}

.tgCommonData > .tgPropertyInput , .tgCommonData > .tgPropertyTextArea {
	flex-basis: 100%;
}

.tgCommonData .tgPropertyInput .tgLabel {
	flex-basis: 15%;
}

.tgCommonData .tgPropertyInput .tgInput, .tgCommonData .tgPropertyInput .tgInputEditable {
	flex-basis: 85%;
}

.tgColumn .tgPropertyInput .tgLabel {
	flex-basis: 30%;
}

.tgColumn > .tgPropertyInput > .tgInput, .tgColumn > .tgPropertyInput > .tgInputEditable {
	flex-basis: 70%;
}

.tgPropertyTextArea .tgLabel {
	flex-basis: 100%;
}

.tgPropertyTextArea .tgInput, .tgPropertyTextArea .tgInputEditable {
	flex-basis: 100%;
	min-height: 6em;
}

.tgPropertyCheck .tgLabel {
	flex-basis: 80%;
}

.tgPropertyCheck .tgInput, .tgPropertyCheck .tgInputEditable {
	flex-basis: 20%;
}

.tgCheckbox {
	margin-right: 1em;
	-webkit-transition: all 0.30s ease-in-out;
	-moz-transition: all 0.30s ease-in-out;
	-ms-transition: all 0.30s ease-in-out;
	-o-transition: all 0.30s ease-in-out;
}

.tgCheckbox:focus {
	border-color: var(--tgBlue);
	box-shadow: 0 0 3px var(--tgLightBlue);
}

/** Container zum aktivieren bzw. deaktivieren **/

.tgTabContent, .tgTopContent {
	display: none;
}

.tgTabContent.active {
	display: block;
}

.tgTopContent.active {
	display: flex;
}

/** Spezieller Content **/

.tgColumn img {
	width: 100%;
	max-width: 400px;
}

.tgAttachmentList {
	margin-left: 0.4em;
}

ul {
	list-style: square outside none;
}

/**** Head, Foot and Menue Items ****/

.tgHead, .tgFoot {
	/* Container Properties: */
	display: flex;
	flex-direction: row;
	justify-content: space-between;
	align-items: center;
	flex-wrap: wrap;
	/* Item Properties: - */
	/* Other Properties: */
	position: fixed;
	margin: 0;
    left: 0em;
	right: 0em;
	background-color: var(--tgBlue);
	font-size: 1.2em;
	color: white;
}

.tgFoot {
	bottom: 0;
}

.tgHead h2, .tgColumn h3 {
	/* Ausnahme fÃ¼r Verwendung im Header und in einer Spalte. */
	flex-basis: auto;
}

/** Button **/

button {
	flex-grow: 1;
	border: none;
	outline: none;
	cursor: pointer;
	padding: 0 20px;
	transition-duration: 0.4s;
	color: white;
	background-color: var(--tgBlue);
}

button.active {
	background-color: var(--tgDarkBlue);
}
button:hover {
	background-color: var(--tgLightBlue);
	color: var(--tgDarkBlue);
}

.tgFoot button, .tgHead button {
	font-size: 1.0em;
}

#buttonToggle {
	flex-grow: 0;
	box-sizing: content-box;
	width: 16em;
	height: 2em;
}

/** DropDown **/

.tgDropDownWrapper {
	padding: 0 20px;
}

.tgDropDown {
	font-size: 1.0em !important;
    color: #ffffff !important;
	padding-right: 30px !important;
	padding-left: 10px;
    border-color: var(--tgDarkBlue) !important;
    position: relative;
    -moz-appearance: none;
    -webkit-appearance: none;
    appearance: none;
    border: none;
    background: var(--tgDarkBlue) url("data:image/svg+xml;utf8,<svg viewBox='0 0 140 140' width='24' height='24' xmlns='http://www.w3.org/2000/svg'><g><path d='m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z' fill='white'/></g></svg>") no-repeat;
    background-position: right 4px top 50%;
}
.tgDropDown > option {
	padding-left: 10px;
}
.tgDropDown:hover {
	background-color: var(--tgLightBlue);
}

.tgDropDown:active {
	background-color: var(--tgDarkBlue);
}

.tgFooterMessages {
	margin-left: 0.4em;
	font-size: 0.8em;
}


/**** Register Menue und Button ****/

.tgTab {
	/* Container Properties: */
	display: flex;
	flex-direction: row;
	justify-content: space-between;
	flex-wrap: wrap;
	/* Item Properties: */
	flex-grow: 1;
	flex-basis: 100%;
	/* Other Properties: */
	background-color: var(--tgBlue);
	margin-top: 1em;
}

.tgTab button {
	height: 2.5em;
	font-size: 1.2em;
}

/**** Ab hier Tabellen. ****/

tr:nth-child(even) {background-color: #f2f2f2;}
tr:hover {background-color: #ddd;}
th {
	border: 1px solid #ddd;
	background-color: #ddd;
	padding: 8px;
}
td {
	border: 1px solid #ddd;
	padding: 4px;
	white-space: pre-line;
	vertical-align: text-top;
}

/**** Responsive Design ****/

@media (max-width: 1500px) {
	/* Umschaltung v. einer auf zwei Zeilen. */
	.tgInput, .tgLabel, .tgInputEditable {
		flex-basis: 100% !important;
	}
}

@media (max-width: 800px) {
	/* Umschaltung Menue von Zeile auf Spalte. */
	.tgTab {
		flex-direction: column !important;
	}
}



    </style>
 </head>
 <body>
    <div class="tgHead" style="width:100%;position:relative;background-color:#1c73c5;border-radius:0px; padding:6px;">
         <div class="tgIconWrap" style="background-color:transparent;border-radius:0px; border:none;"><img src="{{url('/images/Targa_FavIcon.ico')}}" alt="" width="16px" height="16px"></div>
         <div class="tgHeadline" style="background-color:transparent;border-radius:0px; border:none;"id="h2RFQ" name="h2RFQ">Produktpass &nbsp;</div>
         <div class="tgHeadlineVersion tgInputVersion"  contenteditable="true" ></div>
         <div class="tgHeadlineVersion" style="background-color:transparent;border-radius:0px; border:none;"></div>
         <div class="tgHeadlineVersionStop tgInputVersion"  style="background-color:transparent;border-radius:0px; border:none;" contenteditable="true" ></div>
         <div>
         </div>
         <!-- div class="tgHeadlineVersion tgInputVersion" style="background-color:#1c73c5;" contenteditable="true" id="tgDocVerMajor">4</div -->
         <!-- div class="tgHeadlineVersion" style="background-color:#1c73c5;">.</div -->
         <!--div class="tgHeadlineVersionStop tgInputVersion"  style="background-color:#1c73c5;" contenteditable="true" id="tgDocVerMinor">0</div -->
         <!-- div>
            <button class="tgDisplayLinks active" id="buttonDocument" name="buttonDocument">Dokument Info</button>
            <button class="tgDisplayLinks active" id="buttonProduct" name="buttonProduct">Produkt Info</button>
         </div -->
         <!-- select id="structureLangDropDown" class="tgDropDown">
            <option class="tgDropDownOption" value="de" id="german" name="german">Deutsch</option>
            <option class="tgDropDownOption" value="en" id="english" name="english">Englisch</option>
            <option class="tgDropDownOption" value="xml" id="element" name="element">Element</option>
         </select -->
    </div>

    <div class="tgContent">
       <div class="tgCommonData tgTopContent active" id="topDocument" name="topDocument">
          <h3 class="tgCategoryHeadline" id="h3documentData" name="h3documentData">Dokument Info</h3>
          <div class="tgColumn">
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="rfqNo" name="rfqNo">Produktpass Nummer</div>
                <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="rfqNo_input" data-initial-value="{{ $data['pp']->rfqNo }}">{{ $data['pp']->rfqNo }}</div>
             </div>
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="status" name="status">Status</div>
                <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="status_input" data-initial-value="{{ $data['pp']->statusDoc }}">{{ $data['pp']->statusDoc }}</div>
             </div>
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="category" name="category">Kategorie</div>
                <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="category_input" data-initial-value="{{ $data['pp']->category }}">{{ $data['pp']->category }}</div>
             </div>
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="vendorNo" name="vendorNo">Lieferantennummer</div>
                <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="vendorNo_input" data-initial-value="{{ $data['pp']->vendorNo }}">{{ $data['pp']->vendorNo }}</div>
             </div>
          </div>
          <div class="tgColumn">
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="createUserName" name="createUserName">createUserName</div>
                <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="createUserName_input" data-initial-value="{{ $data['pp']->createUserName }}">{{ $data['pp']->createUserName }}</div>
             </div>
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="updateUserName" name="updateUserName">Geändert von Benutzer</div>
                <div lang="de" contenteditable="false" class="tgInput cpcMarkerOK" id="updateUserName_input">{{ $data['pp']->updateUserName }}</div>
             </div>
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="createdOn" name="createdOn">Erstellt am</div>
                <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="createdOn_input" data-initial-value="{{ $data['pp']->createdOn }}">{{ $data['pp']->createdOn }}</div>
             </div>
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="updatedOn" name="updatedOn">Letzte Aktualisierung</div>
                <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="updatedOn_input" data-initial-value="{{ $data['pp']->updatedOn }}">{{ $data['pp']->updatedOn }}</div>
             </div>
          </div>
          <div class="tgColumn">
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="isLatest" name="isLatest">isLatest</div>
                <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="isLatest_input" data-initial-value="{{ $data['pp']->isLatest }}">{{ $data['pp']->isLatest }}</div>
             </div>
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="expiryDate" name="expiryDate">Fälligkeitsdatum</div>
                <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="expiryDate_input" data-initial-value="{{ $data['pp']->expiryDate }}">{{ $data['pp']->expiryDate }}</div>
             </div>
          </div>
       </div>
       <div class="tgCommonData tgTopContent active" id="topProduct" name="topProduct">
          <h3 class="tgCategoryHeadline" id="h3productData" name="h3productData">Produkt Info</h3>
          <div class="tgColumn">
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="ian" name="ian">IAN</div>
                <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="ian_input" data-initial-value="{{ $data['pp']->PPProduktpass_IAN }}">{{ $data['pp']->PPProduktpass_IAN }}</div>
             </div>
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="charge" name="charge">Charge</div>
                <div  lang="de" class="tgInput tgCompare cpcMarkerOK" id="charge_input" data-initial-value="{{ substr($data['pp']->PPProduktpass_Ausmusterungnummer,0,4) }}">{{ substr($data['pp']->PPProduktpass_Ausmusterungnummer,0,4) }}</div>
             </div>
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="version" name="version">Version</div>
                <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="version_input" data-initial-value="{{ $data['pp']->version }}">{{ $data['pp']->version }}</div>
             </div>
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="description" name="description">Artikelbezeichnung</div>
                <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="description_input" data-initial-value="{{ $data['pp']->PPProduktpass_Artikelbezeichnung }}">{{ $data['pp']->PPProduktpass_Artikelbezeichnung }}</div>
             </div>
          </div>
          <div class="tgColumn">
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="noLIDLItem" name="noLIDLItem">Non LIDL IAN</div><input lang="de" class="tgCheckbox" type="checkbox" name="noLIDLItem" id="item_noLIDLItem_input" value="false" disabled=""></div>
             <div class="cpcMarkerOK_"><a href="{{url('/data/uploads/'.$data['pp']['PPProduktpass_ProjektBild'])}}" target="_blank"><img src="{{url('/data/uploads/'.$data['pp']['PPProduktpass_ProjektBild'])}}" alt="{{$data['pp']['PPProduktpass_ProjektBild']}}" id="image_img_d0e289" class="tgImage"></a></div>
          </div>
       </div>
       <div class="tgCommonData">
          <h3 class="tgCategoryHeadline" id="h3AngebotsnummerPraefix" name="h3AngebotsnummerPraefix">Angebotsnummer Präfix</h3>
          <div class="tgColumn">
             <div class="tgPropertyInput tgLangDE">
                <div class="tgLabel" id="angebotsnummerPraefix" name="angebotsnummerPraefix">Angebotsnummer Präfix</div>
                <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="angebotsnummerPraefix_input" data-initial-value="{{ $data['pp']->vendorNo.'_'.$data['pp']->rfqNo . '_' . $data['pp']->PPProduktpass_IAN . '_' . substr($data['pp']->PPProduktpass_Ausmusterungnummer,0,4) .'_'}}">{{ $data['pp']->vendorNo.'_'.$data['pp']->rfqNo . '_' . $data['pp']->PPProduktpass_IAN . '_' . substr($data['pp']->PPProduktpass_Ausmusterungnummer,0,4) .'_'}}</div>
             </div>
          </div>
       </div>
       <div class="tgTab"><button class="tgTabLinks" id="buttonMasterData" name="buttonMasterData">Stammdaten</button><button class="tgTabLinks active" id="buttonQuality" name="buttonQuality">Qualität</button><button class="tgTabLinks" id="buttonAssortment" name="buttonAssortment">Sortierung</button><button class="tgTabLinks" id="buttonQuantity" name="buttonQuantity">Menge</button><!--button class="tgTabLinks" id="buttonOverview" name="buttonOverview">Bestellübersicht</button --><button class="tgTabLinks tgHidden" id="buttonOtherXML" name="buttonOtherXML" style="display: none;">Zusätzliche Daten</button><button class="tgTabLinks tgHidden" id="buttonTranslationList" name="buttonTranslationList" style="display: none;">Übersetzungsliste</button><!-- button class="tgTabLinks" id="buttonHistory" name="buttonHistory">Historie</button --><button class="tgLinkButton tgHidden" id="buttonOffer" name="buttonOffer" target="" style="display: none;">Angebot</button></div>
       <div id="tabMasterData" name="tabMasterData" class="tgTabContent">
          <div class="tgCommonData">
             <h3 class="tgCategoryHeadline" id="h3MasterData" name="h3MasterData">Artikel Stammdaten</h3>
             <div class="tgColumn">
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="selectionNo" name="selectionNo">Ausm-Nr.</div>
                   <div  lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="selectionNo_input" data-initial-value="{{ $data['pp']->Ausmusterungnummer }}">{{ $data['pp']->PPProduktpass_Ausmusterungnummer }}</div>
                </div>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="name" name="articleGroup/name">Warengruppe</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="name_input" data-initial-value="{{ $data['pp']->Warengruppe }}">{{ $data['pp']->PPProduktpass_Warengruppe }}</div>
                </div>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="buyerShortCode" name="buyerShortCode">Einkäufer</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="buyerShortCode_input" data-initial-value="{{ $data['pp']->PPProduktpass_Einkaeufer }}">{{ $data['pp']->PPProduktpass_Einkaeufer }}</div>
                </div>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="name" name="rfSafety/name">RF-Sicherung</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="name_input" data-initial-value="{{ $data['pp']->rfSafety }}">{{ $data['pp']->rfSafety }}</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="predecessor" name="predecessor">Vorgänger</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="predecessor_input" data-initial-value="{{ $data['pp']->PPProduktpass_AltIAN }}">{{ $data['pp']->PPProduktpass_AltIAN }}</div>
                </div>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="theme" name="theme">Thema AM</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="theme_input" data-initial-value="{{ $data['pp']->PPProduktpass_Thema }}">{{ $data['pp']->PPProduktpass_Thema }}</div>
                </div>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="wholeSalePackaging" name="wholeSalePackaging">Versandfähige Umverpackung OS</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerQuestion" id="wholeSalePackaging_input" data-initial-value="Nein">Nein</div>
                </div>
             </div>
          </div>
          <div class="tgCommonData">
             <div class="tgColumn"></div>
          </div>
          <hr>
          <div class="tgCommonData">
             <div class="tgColumn">
                <h3 class="tgCategoryHeadline" id="h3KlData" name="h3KlData">Zugehörige KL-Informationen</h3>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="name" name="itemTypeKL/name">Itemtyp</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare" id="name_input" data-initial-value=""></div>
                </div>
                <h2 class="tgCategoryHeadline cpcMarkerQuestion" id="h2RelatedItems" name="h2RelatedItems">Dazugehörige Artikel</h2>
                <table id="relatedItems">
                   <thead>
                      <tr>
                         <th class="tgTableHeads" id="relatedItemIan" name="relatedItemIan">IAN</th>
                         <th class="tgTableHeads" id="lotNo" name="lotNo">Charge</th>
                      </tr>
                   </thead>
                   <tbody></tbody>
                </table>
             </div>
             <div class="tgColumn"></div>
          </div>
          <hr>
          <div class="tgCommonData">
            <h3 class="tgCategoryHeadline" id="h3Sample" name="h3Sample">Artikel Muster</h3>
            <div class="tgColumn">
               <div class="tgPropertyInput tgLangDE">
                  <div class="tgLabel" id="sampleNumberKL" name="sampleNumberKL">Anzahl Muster KL</div>
                  <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="sampleNumberKL_input" data-initial-value="{{ $data['pp']->sampleNumberKL }}">{{ $data['pp']->sampleNumberKL }}</div>
               </div>
               <div class="tgPropertyInput tgLangDE">
                  <div class="tgLabel" id="buyerShortCodeKL" name="buyerShortCodeKL">Einkäufer Code KL</div>
                  <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="buyerShortCodeKL_input" data-initial-value="{{ $data['pp']->buyerShortCodeKL }}">{{ $data['pp']->buyerShortCodeKL }}</div>
               </div>
            </div>
            <div class="tgColumn">
               <div class="tgPropertyInput tgLangDE">
                  <div class="tgLabel" id="buyerNameKL" name="buyerNameKL">Einkäufer KL</div>
                  <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="buyerNameKL_input" data-initial-value="{{ $data['pp']->buyerNameKL }}">{{ $data['pp']->buyerNameKL }}</div>
               </div>
               <div class="tgPropertyInput tgLangDE">
                  <div class="tgLabel" id="themeNoKL" name="themeNoKL">Thema AM KL</div>
                  <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="themeNoKL_input" data-initial-value="{{ $data['pp']->themeNoKL }}">{{ $data['pp']->themeNoKL }}</div>
               </div>
            </div>
         </div>
         <hr>
          <div class="tgCommonData">
             <div class="tgColumn">
                <h3 class="tgCategoryHeadline" id="h3Identification" name="h3Identification">Kennzeichnung</h3>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="name" name="brand/name">Marke</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="name_input" data-initial-value="{{ $data['pp']->PPProduktpass_Marke }}">{{ $data['pp']->PPProduktpass_Marke }}</div>
                </div>
                <!--   ****************************   -->
                <div class="tgPropertyInput tgLangDE">
                  <div class="tgLabel" id="brandKL" name="brandKL">Marke KL</div>
                  <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="brandKL_input" data-initial-value="{{ $data['pp']->PPProduktpass_KauflandMarke }}">{{ $data['pp']->PPProduktpass_KauflandMarke }}</div>
               </div>
                <!--   ****************************   -->
             </div>
             <div class="tgColumn"></div>
          </div>
          <hr>
          <div class="tgCommonData">
             <div class="tgColumn">
                <h3 class="tgCategoryHeadline" id="h3TestCriteria" name="h3TestCriteria">Prüfkriterien</h3>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="name" name="testLab/name">Prüfinstitut</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="name_input" data-initial-value="{{ $data['pp']->PPProduktpass_PPProduktpass_Pruefinstitut }}">{{ $data['pp']->PPProduktpass_Pruefinstitut }}</div>
                </div>
             </div>
             <div class="tgColumn"></div>
          </div>
          <hr>
          <div class="tgCommonData">
             <div class="tgColumn">
                <h3 class="tgCategoryHeadline" id="h3Certifications" name="h3Certifications">Zertifizierungen / Eigenschaften</h3>
                <div class="tgColumn">
                   <div class="tgPropertyInput tgLangDE">
                      <div class="tgLabel" id="certifications" name="certifications">certifications</div>
                      <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="certifications_input" data-initial-value="{{ $data['pp']->PPProduktpass_Zertifizierungen }} {{ $data['pp']->PPProduktpass_ZertifizierungEigenschaften2 }} {{ $data['pp']->PPProduktpass_ZertifizierungEigenschaften3 }} {{ $data['pp']->PPProduktpass_ZertifizierungEigenschaften4 }} {{ $data['pp']->PPProduktpass_ZertifizierungEigenschaften5 }}">{{ $data['pp']->PPProduktpass_Zertifizierungen }} {{ $data['pp']->PPProduktpass_ZertifizierungEigenschaften2 }} {{ $data['pp']->PPProduktpass_ZertifizierungEigenschaften3 }} {{ $data['pp']->PPProduktpass_ZertifizierungEigenschaften4 }} {{ $data['pp']->PPProduktpass_ZertifizierungEigenschaften5 }}</div>
                   </div>
                </div>
                <div class="tgColumn"></div>
             </div>
             <div class="tgColumn"></div>
          </div>
          <hr>
          <div class="tgCommonData">
             <h3 class="tgCategoryHeadline" id="h3Packaging" name="h3Packaging">Verpackung</h3>
          </div>
          <div class="tgCommonData">
             <div class="tgColumn">
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="name" name="agency/name">Verpackungsagentur</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="name_input" data-initial-value="{{ $data['pp']->PPProduktpass_Agentur }}">{{ $data['pp']->PPProduktpass_Agentur }}</div>
                </div>
                <div lang="de" class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="packaging/materialThickness" name="packaging/materialThickness">Materialstärke</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="packaging/materialThickness_input" data-initial-value="{{ $data['pp']->PPProduktpass_Materialstaerke_der_Verkaufsverpackung }}">{{ $data['pp']->PPProduktpass_Materialstaerke_der_Verkaufsverpackung }}</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="name" name="retailPackaging/name">Verkaufsverpackung</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="name_input" data-initial-value="{{ $data['pp']->PPProduktpass_Verkaufsverpackung }}">{{ $data['pp']->PPProduktpass_Verkaufsverpackung }}</div>
                </div>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="retailPackagingComment" name="retailPackagingComment">Bemerkung Verpackung</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="retailPackagingComment_input" data-initial-value="{{ $data['pp']->retailPackagingComment }}">{{ $data['pp']->retailPackagingComment }}</div>
                </div>
             </div>
          </div>
          <hr>
          <div class="tgCommonData">
             <h3 class="tgCategoryHeadline" id="h3RetailPackaging" name="h3RetailPackaging">Verpackung Abmessungen</h3>
          </div>
          <div class="tgCommonData">
             <div class="tgColumn">
                <table id="retailPackaging">
                   <thead>
                      <tr>
                         <th class="tgTableHeads" id="retailPackaging/styleNo" name="retailPackaging/styleNo">Stylenr.</th>
                         <th class="tgTableHeads" id="retailPackaging/productName" name="retailPackaging/productName">Stylebezeichnung</th>
                         <th class="tgTableHeads" id="retailPackaginWidth" name="retailPackaginWidth">Verkaufsverpackung Breite(cm)</th>
                         <th class="tgTableHeads" id="retailPackaginHeight" name="retailPackaginHeight">Verkaufsverpackung Höhe(cm)</th>
                         <th class="tgTableHeads" id="retailPackaginLength" name="retailPackaginLength">Verkaufsverpackung Länge(cm)</th>
                      </tr>
                   </thead>
                   <tbody>

                     @foreach ($data['style'] as $style)
                     <tr id="style_{{ $style->PPProduktpass_Style_Header }}_inputRow" class="tgLangDE">
                        <td>
                           <div id="styleNo_{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInput tgCompare  cpcMarkerOK" contenteditable="false" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value="{{ $style->PPProduktpass_Style_Header }}">{{ $style->PPProduktpass_Style_Header }}</div>
                        </td>
                        <td>
                           <div id="productName_{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInput tgCompare  cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value="{{ $style->PPProduktpass_Style_Value01 }}">{{ $style->PPProduktpass_Style_Value01 }}</div>
                        </td>
                        <td>
                           <div id="retailPackagingWidth_{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInputEditable tgCompare  cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value=""></div>
                        </td>
                        <td>
                           <div id="retailPackagingHeight_{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInputEditable tgCompare  cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value=""></div>
                        </td>
                        <td>
                           <div id="retailPackagingLength_{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInputEditable tgCompare  cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value=""></div>
                        </td>
                     </tr>
                     @endforeach
                     <!--tr id="style_364978_B_inputRow" class="tgLangDE">
                         <td>
                            <div id="styleNo_364978_B_inputCell" class="tgInput tgCompare  cpcMarkerQuestion" contenteditable="false" additionalinfo="364978_B" lang="de" data-initial-value="364978_B">364978_B</div>
                         </td>
                         <td>
                            <div id="productName_364978_B_inputCell" class="tgInput tgCompare  cpcMarkerQuestion" contenteditable="true" additionalinfo="364978_B" lang="de" data-initial-value="Wind-Messgerät">Wind-Messgerät</div>
                         </td>
                         <td>
                            <div id="retailPackagingWidth_364978_B_inputCell" class="tgInputEditable tgCompare  cpcMarkerQuestion" contenteditable="true" additionalinfo="364978_B" lang="de" data-initial-value="17.5">17.5</div>
                         </td>
                         <td>
                            <div id="retailPackagingHeight_364978_B_inputCell" class="tgInputEditable tgCompare  cpcMarkerQuestion" contenteditable="true" additionalinfo="364978_B" lang="de" data-initial-value="5.4">5.4</div>
                         </td>
                         <td>
                            <div id="retailPackagingLength_364978_B_inputCell" class="tgInputEditable tgCompare  cpcMarkerQuestion" contenteditable="true" additionalinfo="364978_B" lang="de" data-initial-value="7.8">7.8</div>
                         </td>
                      </tr -->
                   </tbody>
                </table>
             </div>
          </div>
          <hr>
          <div class="tgCommonData">
             <h3 class="tgCategoryHeadline" id="h3PackagingKl" name="h3PackagingKl">Verpackung KL</h3>
          </div>
          <div class="tgCommonData">
             <div class="tgColumn">
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="name" name="retailPackaging/name">Verkaufsverpackung</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="name_input" data-initial-value="{{ $data['pp']->packagingKL_rt_name }}">{{ $data['pp']->packagingKL_rt_name }}</div>
                </div>
                <div lang="de" class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="packagingKL/materialThickness" name="packagingKL/materialThickness">Materialstärke</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="packagingKL/materialThickness_input" data-initial-value="{{ $data['pp']->packagingKL_materialThickness }}">{{ $data['pp']->packagingKL_materialThickness }}</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="name" name="tray/name">Thekendisplay</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="name_input" data-initial-value="{{ $data['pp']->packagingKL_tray_name }}">{{ $data['pp']->packagingKL_tray_name }}</div>
                </div>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="retailPackagingComment" name="retailPackagingComment">Bemerkung Verpackung</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="retailPackagingComment_input" data-initial-value="{{ $data['pp']->packagingKL_trayRemarks }}">{{ $data['pp']->packagingKL_trayRemarks }}</div>
                </div>
             </div>
          </div>
          <hr>
          <div class="tgCommonData">
             <h3 class="tgCategoryHeadline" id="h3Warranty" name="h3Warranty">Garantie</h3>
             <div class="tgColumn">
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="name" name="guarantee/name">Garantiezeit (Dauer)</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="name_input" data-initial-value="{{ $data['pp']->Garantie }}">{{ $data['pp']->Garantie }}</div>
                </div>
                <div class="tgPropertyInput tgLangDE tgHidden" style="display: none;">
                   <div class="tgLabel" id="guaranteeType" name="guaranteeType">Art</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare" id="guaranteeType_input" data-initial-value="Inkl. 1 zu 1 Austauschservice. Der Kunde meldet sich bei einem Defekt bei der Hotline,
                      E-mail- oder Postadresse. (ggf. Angabe der Hotline-Nummern) Die Adresse des Kunden
                      wird aufgenommen.
                      Zu dieser Adresse wird innerhalb von 4 Werktagen ein Austauschartikel bzw. Ersatzteil
                      geschickt. Dem Kunden entstehen keinerlei Kosten.">Inkl. 1 zu 1 Austauschservice. Der Kunde meldet sich bei einem Defekt bei der Hotline,
                      E-mail- oder Postadresse. (ggf. Angabe der Hotline-Nummern) Die Adresse des Kunden
                      wird aufgenommen.
                      Zu dieser Adresse wird innerhalb von 4 Werktagen ein Austauschartikel bzw. Ersatzteil
                      geschickt. Dem Kunden entstehen keinerlei Kosten.</div>
                </div>
             </div>
             <div class="tgColumn"></div>
          </div>
          <hr>
          <div class="tgCommonData">
             <h3 class="tgCategoryHeadline" id="h3catalogue" name="h3catalogue">Katalog</h3>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare cpcMarkerOK" type="checkbox" name="isCatalogue" id="catalogue_isCatalogue_input" value="{{ $data['pp']->isCatalogue }}" disabled="" data-initial-value="{{ $data['pp']->isCatalogue }}"><div class="tgLabel" id="isCatalogue" name="isCatalogue">Katalogbestellung</div>
                </div>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="name" name="initialOrder/name">Erstbestellung</div>
                   <div lang="de" contenteditable="false" class="tgInput tgCompare cpcMarkerOK" id="name_input" data-initial-value="{{ $data['pp']->initialOrder }}">{{ $data['pp']->initialOrder }}</div>
                </div>
             </div>
             <div class="tgColumn"></div>
          </div>
          <hr>
          <div class="tgCommonData">
             <h4 class="tgCategoryHeadline" id="h4Attachments" name="h4Attachments">Dateien und Anhänge</h4>
             <div class="tgColumn">
                <ul class="tgAttachmentList">
                   <li><a href="" target="_blank" name="" id="document_doc_d0e79" class="tgAttachment"></a></li>
                </ul>
             </div>
          </div>
       </div>
       <div id="tabQuality" name="tabQuality" class="tgTabContent active">
          <div class="tgCommonData">
             <h3 class="tgCategoryHeadline" id="h3Quality" name="h3Quality">Qualität</h3>
          </div>
          <div class="tgCommonData">
             <div class="tgColumn"></div>
             <div class="tgColumn"></div>
          </div>
          <div class="tgCommonData"></div>
          <div class="tgCommonData">
             <h3 class="tgCategoryHeadline" id="h3Styles" name="h3Styles">Styles</h3>
          </div>
          <table id="styles">
             <thead>
                <tr>
                   <th class="tgTableHeads" id="styleNo" name="styleNo">Stylenr.</th>
                   <th class="tgTableHeads" id="productName" name="productName">Stylebezeichnung</th>
                   <th class="tgTableHeads" id="weightWithoutPackaging" name="weightWithoutPackaging">Gewicht (ohne Verpackung)</th>
                   <th class="tgTableHeads" id="sizeWithoutPackaging" name="sizeWithoutPackaging">Größe (ohne Verpackung)</th>
                   <th class="tgTableHeads" id="qualityTechnicalData" name="qualityTechnicalData">Qualität/technische Daten</th>
                   <th class="tgTableHeads" id="additionalQualityInformation" name="additionalQualityInformation">Fortsetzung Qualität</th>
                   <th class="tgTableHeads" id="changesFromPredecessor" name="changesFromPredecessor">Änderungen vom Vorgänger</th>
                   <th class="tgTableHeads" id="brandReference" name="brandReference">Markenreferenz</th>
                   <th class="tgTableHeads" id="material" name="material">Material</th>
                   <th class="tgTableHeads" id="materialThickness" name="materialThickness">Materialstärke</th>
                   <th class="tgTableHeads" id="color" name="color">Farbe</th>
                </tr>
             </thead>
             <tbody>
                @foreach ($data['style'] as $style)
                <tr id="style_{{ $style->PPProduktpass_Style_Header }}_inputRow" class="tgLangDE">
                   <td>
                      <div id="styleNo_{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInput tgCompare cpcMarkerOK" contenteditable="false" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value="{{ $style->PPProduktpass_Style_Header }}">{{ $style->PPProduktpass_Style_Header }}</div>
                   </td>
                   <td>
                      <div id="productName_{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInputEditable tgCompare cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value="Luftfeuchte- und Temperaturmesssgerät">{{ $style->PPProduktpass_Style_Value01 }}</div>
                   </td>
                   <td>
                      <div id="weightWithoutPackaging_{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInputEditable tgCompare cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value="{{ $style->weightWithoutPackaging }}">{{ $style->weightWithoutPackaging }}</div>
                   </td>
                   <td>
                      <div id="sizeWithoutPackaging_{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInputEditable tgCompare cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value="{{ $style->sizeWithoutPackaging }}">{{ $style->sizeWithoutPackaging }}</div>
                   </td>
                   <td>
                      <div id="qualityTechnicalData_{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInputEditable tgCompare cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value="{{ $style->qualityTechnicalData }}">{{ $style->qualityTechnicalData }}</div>
                   </td>
                   <td>
                      <div id="additionalQualityInformation_{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInputEditable tgCompare cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value="{{ $style->additionalQualityInformation }}">{{ $style->additionalQualityInformation }}</div>
                   </td>
                   <td>
                      <div id="changesFromPredecessor{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInput tgCompare cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value="{{ $style->changesFromPredecessor }}">{{ $style->changesFromPredecessor }}</div>
                   </td>
                   <td>
                      <div id="brandReference{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInput tgCompare cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value="{{ $style->brandReference }}">{{ $style->brandReference }}</div>
                   </td>
                   <td>
                      <div id="material{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInputEditable tgCompare cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value="{{ $style->material }}">{{ $style->material }}</div>
                   </td>
                   <td>
                      <div id="materialThickness{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInputEditable tgCompare cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value="{{ $style->materialThickness }}">{{ $style->materialThickness }}</div>
                   </td>
                   <td>
                      <div id="color{{ $style->PPProduktpass_Style_Header }}_inputCell" class="tgInput tgCompare cpcMarkerOK" contenteditable="true" additionalinfo="{{ $style->PPProduktpass_Style_Header }}" lang="de" data-initial-value="{{ $style->color }}">{{ $style->color }}</div>
                   </td>
                </tr>
                @endforeach
             </tbody>
          </table>
       </div>
       <div id="tabAssortment" name="tabAssortment" class="tgTabContent">
          <div class="tgFullTextContainer">
             <h3 class="tgCategoryHeadline" id="h3Assortment" name="h3Assortment">Sortierung</h3>
          </div>
          <div class="tgFullTextContainer">
             <div></div>
             <table id="Assortment" class="cpcMarkerOK">
                <thead>
                   <tr>
                      <th class="tgTableHeads" id="countryCodes" name="countryCodes">Länderblöcke</th>
                      <th class="tgTableHeads" id="totalPackRatio" name="totalPackRatio">Kolliinhalt</th>
                      <th class="tgTableHeads" id="name" name="name">Sortierung</th>
                   </tr>
                </thead>
                <tbody>
                  @foreach ($data['tAssortment'] as $assortment)
                  <tr>
                     <td><table class="tgtable tgAssortment">
                        <tbody>
                        @foreach($assortment['laenderbloecke'] as $lb => $countries)
                           <tr><td>{{$lb}}</td><td>{{$countries}}</td></tr>
                        @endforeach
                        </tbody>
                        </table>
                     </td>
                     <td><div class="tgData">{{number_format($assortment['pack'],0)}}</div></td>
                     <td><div class="tgData"></div></td>
                  </tr>
                  @foreach($assortment['style'] as  $astyle => $val)
                  <tr class="tgLangDE">
                     <td><div lang="de">{{$astyle}}</div></td>
                     <td><div lang="de">{{ $val['description']}}</div></td>
                     <td><div lang="de">{{ number_format($val['quantity'],0)}}</div></td>
                  </tr>
                  @endforeach
                  @endforeach
                   <!--tr>
                      <td>
                         <table class="tgtable tgAssortment"><tbody><tr><td>CB1</td><td>DE, AT, CH</td></tr><tr><td>CB2</td><td>FR</td></tr><tr><td>CB3</td><td>PL, FI, SE, LT, EE, LV</td></tr><tr><td>CB4</td><td>CZ, SK, HU, SI</td></tr><tr><td>CB5</td><td>IT, ES, PT, OSES</td></tr><tr><td>CB6</td><td>GB, BE, NL, IE, NI, DK</td></tr><tr><td>CB7</td><td>GR, HR, CY, BG, RO, RS</td></tr><tr><td>CB8</td><td>OSDE, OSBE, OSNL, OSCZ, OSGB, OSFR, OSPL, OSSK, OSAT, OSDK, OSHU</td></tr><tr><td>CB9</td><td>US</td></tr><tr><td>CB10</td><td>KDE, KPL, KCZ, KRO, KSK, KHR, KBG, KODE</td></tr></tbody></table>
                      </td>
                      <td>
                         <div class="tgData">4</div>
                      </td>
                      <td>
                         <div class="tgData"></div>
                      </td>
                   </tr>
                   <tr class="tgLangDE">
                      <td>
                         <div lang="de">364978_A</div>
                      </td>
                      <td>
                         <div lang="de">Luftfeuchte- und Temperaturmesssgerät</div>
                      </td>
                      <td>
                         <div lang="de">1</div>
                      </td>
                   </tr>
                   <tr-- class="tgLangDE">
                      <td>
                         <div lang="de">364978_B</div>
                      </td>
                      <td>
                         <div lang="de">Wind-Messgerät</div>
                      </td>
                      <td>
                         <div lang="de">3</div>
                      </td>
                   </tr-->
                </tbody>
             </table>
          </div>
       </div>
       <div id="tabQuantity" name="tabQuantity" class="tgTabContent">
          <div style="float:left;width:95px;"><h3 class="tgCategoryHeadline" id="h3Quantity" name="h3Quantity">Menge</h3></div>
          @if(count($data['menge']) < 2 )
          <div  style="float:left;width:300px;"><h3 style="color:#1C73C5; margin:0.5em 0.2em 0.5em 0.4em;">Planmenge:  {{ number_format($data['pp']->PPProduktpass_Gesamtmenge,0,',','.')  }} Stk</h3></div>
          @endif
          <div style="clear:both;">&nbsp;</div>
          <!-- div class="tgTableHeads" id="tooltipQuantity" name="tooltipQuantity">Gesamtmenge pro Land ist die Summe aus 1. LT Menge, 2. LT Menge und 3. LT Menge</div !-->
          <table id="quantity">
             <thead>
                <tr>
                   <th class="tgTableHeads" id="country" name="country">LandX</th>
                   <th class="tgTableHeads" id="totalNumOfCtn" name="totalNumOfCtn">Kollianzahl</th>
                   <th class="tgTableHeads" id="totalPackRatio" name="totalPackRatio">Kolliinhalt</th>
                   <th class="tgTableHeads" id="totalQtyPerCountry" name="totalQtyPerCountry">Gesamtmenge pro Land</th>
                   <th class="tgTableHeads" id="deliveryDateOWIM_tpt" name="deliveryDateOWIM_tpt">1. LT OWIM (ETA)</th>
                   <th class="tgTableHeads" id="ctryDeliveryWeek1_tpt" name="ctryDeliveryWeek1_tpt">1. LT Land</th>
                   <th class="tgTableHeads" id="ctryDeliveryTotalQty1_tpt" name="ctryDeliveryTotalQty1_tpt">1. LT Menge</th>
                   <th class="tgTableHeads" id="ctryDeliveryWeek2_tpt" name="ctryDeliveryWeek2_tpt">2. LT Land</th>
                   <th class="tgTableHeads" id="ctryDeliveryTotalQty2_tpt" name="ctryDeliveryTotalQty2_tpt">2. LT Menge</th>
                   <th class="tgTableHeads" id="ctryDeliveryWeek3_tpt" name="ctryDeliveryWeek3_tpt">3. LT Land</th>
                   <th class="tgTableHeads" id="ctryDeliveryTotalQty3_tpt" name="ctryDeliveryTotalQty3_tpt">3. LT Menge</th>
                   <th class="tgTableHeadsX" id="completionType" name="completionType">Abwicklungsart</th>
                   <th class="tgTableHeads" id="articleInformation" name="articleInformation">Artikelinfo</th>
                   <th class="tgTableHeads" id="countryRemarks" name="countryRemarks">sonstige Länderbemerkungen</th>
                </tr>
             </thead>
             <tbody>
                <?php $total1 = 0; $total2 = 0; $total3 = 0; $totalCtn = 0; $total = 0; ?>
                @foreach ($data['menge'] as $qty)
                   <?php if($qty->PPProduktpass_Menge_Kolli <> 0) { $totalCtn += $qty->PPProduktpass_Menge_Quantity / $qty->PPProduktpass_Menge_Kolli; }  
                   $total += is_null($qty->PPProduktpass_Menge_Quantity)?0:$qty->PPProduktpass_Menge_Quantity;
                   $total1 += is_null($qty->PPProduktpass_Menge_LT1Menge)?0:$qty->PPProduktpass_Menge_LT1Menge;
                   $total2 += is_null($qty->PPProduktpass_Menge_LT2Menge)?0:$qty->PPProduktpass_Menge_LT2Menge;
                   $total3 += is_null($qty->PPProduktpass_Menge_LT3Menge)?0:$qty->PPProduktpass_Menge_LT3Menge;
                   ?>
                <tr id="quantity_d0e427_inputRow" class="tgLangDE">
                   <td>
                      <div class="tgRow cpcMarkerOK"  id="countryName_d0e427" additionalinfo="DE" lang="de">{{ $qty->PPProduktpass_Menge_Country  }}</div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="totalNumOfCtn_d0e427" additionalinfo="DE" lang="de">@if($qty->PPProduktpass_Menge_Kolli <> 0) {{ number_format($qty->PPProduktpass_Menge_Quantity / $qty->PPProduktpass_Menge_Kolli,0,',','.') }} @else 0 @endif</div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="totalSalesPerCarton_d0e427" additionalinfo="DE" lang="de">{{ number_format($qty->PPProduktpass_Menge_Kolli,0) }}</div>
                   </td>
                   <td>
                     <div class="tgRow cpcMarkerOK" id="totalQtyPerCountry_d0e427" additionalinfo="DE" lang="de">{{ number_format($qty->PPProduktpass_Menge_Quantity,0,",",".") }}</div>
                  </td>
                  <td>
                     <div class="tgRow cpcMarkerOK" id="DDP_d0e427" additionalinfo="DE" lang="de">{{ $qty->PPProduktpass_Menge_DeliveryWeek  }}</div>
                  </td>
                 <td>
                      <div class="tgInputEditable tgCompare cpcMarkerOK" id="ctryDeliveryWeekOWIM_d0e427_inputCell" contenteditable="true" additionalinfo="DE" lang="de" data-initial-value="{{ $qty->PPProduktpass_Menge_LTT1 }}">{{ $qty->PPProduktpass_Menge_LT1 }}</div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="ctryDeliveryTotalQty1_d0e427" additionalinfo="DE" lang="de">{{ number_format($qty->PPProduktpass_Menge_LT1Menge,0,",",".") }}</div>
                   </td>
                   <td>
                      <div class="tgInputEditable tgCompare cpcMarkerOK" id="ctryDeliveryWeek2_d0e427_inputCell" contenteditable="true" additionalinfo="DE" lang="de" data-initial-value="{{ $qty->PPProduktpass_Menge_LT2 }}">{{ $qty->PPProduktpass_Menge_LT2 }}</div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="ctryDeliveryTotalQty2_d0e427" additionalinfo="DE" lang="de">{{ number_format($qty->PPProduktpass_Menge_LT2Menge,0,",",".") }}</div>
                   </td>
                   <td>
                      <div class="tgInputEditable tgCompare cpcMarkerOK" id="ctryDeliveryWeek3_d0e427_inputCell" contenteditable="true" additionalinfo="DE" lang="de" data-initial-value="{{ $qty->PPProduktpass_Menge_LT3 }}">{{ $qty->PPProduktpass_Menge_LT3 }}</div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="ctryDeliveryTotalQty3_d0e427" additionalinfo="DE" lang="de">{{ number_format($qty->PPProduktpass_Menge_LT3Menge,0,",",".") }}</div>
                   </td>
                   <td>
                     <div class="tgInputEditable tgCompare cpcMarkerOK" id="completionType_d0e427" contenteditable="true" additionalinfo="DE" lang="de" data-initial-value="{{ $data['pp']->Abwicklungsart }}">{{ $data['pp']->Abwicklungsart }}</div>
                  </td>
                  <td>
                     <div class="tgInputEditable tgCompare cpcMarkerOK" id="articleInformation_d0e427" contenteditable="true" additionalinfo="DE" lang="de" data-initial-value="{{ $qty->PPProduktpass_Menge_articleInfo }}">{{ $qty->PPProduktpass_Menge_ArtikelInfo }}</div>
                  </td>
                  <td>
                     <div class="tgInputEditable tgCompare cpcMarkerOK" id="countryRemarks_d0e427" contenteditable="true" additionalinfo="DE" lang="de" data-initial-value="{{ $qty->PPProduktpass_Menge_countryRemarks }}">{{ $qty->PPProduktpass_Menge_countryRemarks }}</div>
                  </td>
              </tr>
                @endforeach
                <tr>
                   <td>
                      <div class="tgTableHeads" lang="de" id="totalQuantity" name="totalQuantity">Gesamtmenge</div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="totalNumOfCtn-sum" lang="de">{{ number_format($totalCtn,0,",",".") }}</div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="totalPackRatio-sum" lang="de"></div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="totalQtyPerCountry-sum" lang="de">{{ number_format($total,0,",",".") }}</div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="ctryDDP-sum" lang="de"></div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="ctryDeliveryWeek1-sum" lang="de"></div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="ctryDeliveryTotalQty1-sum" lang="de">{{ number_format($total1,0,",",".") }}</div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="ctryDeliveryWeek2-sum" lang="de"></div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="ctryDeliveryTotalQty2-sum" lang="de">{{ number_format($total2,0,",",".") }}</div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="ctryDeliveryWeek3-sum" lang="de"></div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="ctryDeliveryTotalQty3-sum" lang="de">{{ number_format($total3,0,",",".") }}</div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="completionType-sum" lang="de"></div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="articleInformation-sum" lang="de"></div>
                   </td>
                   <td>
                      <div class="tgRow cpcMarkerOK" id="countryRemarks-sum" lang="de"></div>
                   </td>
                </tr>
             </tbody>
          </table>
       </div>
       <div id="tabOverview" name="tabOverview" class="tgTabContent">
          <h3 class="tgCategoryHeadline" id="h3Overview" name="h3Overview">Bestellübersicht</h3>
          <?php $countries = $data['OrderOverview']['countries']; 
                $overview = $data['OrderOverview']['overview'];
          ?>
        
          <table id="">
             <thead>
                <tr>
                   <th class="tgTableHeads" id="gtin" name="gtin">GTIN</th>
                   <th class="tgTableHeads" id="styleNo" name="styleNo">Stylenr.</th>
                   <th class="tgTableHeads" id="productName" name="productName">Stylebezeichnung</th>
                   <th class="tgTableHeads" id="sizeName" name="sizeName">Größe</th>
                   <th class="tgTableHeads" id="LSV" name="LSV">LSV</th>
                   
                   @foreach ($countries as $country )
                   <th class="tgTableHeads" id="{{ $country }}" name="{{ $country }}">{{ $country }}</th>
                   @endforeach
                </tr>
             </thead>
             <tbody>

               @foreach ($overview as $gtin => $style) 
                <tr>
                <td> {{$gtin}} </td>
                @foreach ($style as $style => $colors)
                    <td>{{$style}}</td>
                    @foreach ($colors as $color => $sorts)
                        <td>{{$color}}</td>
                        @foreach ($sorts as $sort => $sizes)
                            <td>{{$sort}}</td>
                            @foreach ($sizes as $size => $countries)
                                <td> {{ $size }}</td>
                                @foreach ($countries as $country => $qty)
                                 <?php if (!isset($qt[$country])){ $qt[$country] = 0;}
                                    $qt[$country] += $qty; ?>    
                                 <td>{{$qty}}</td>
                                @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach

            @endforeach


                   <td class="tgTableHeads"></td>
                   <td class="tgTableHeads"></td>
                   <td class="tgTableHeads"></td>
                   <td class="tgTableHeads"></td>
                   <td class="tgTableHeads" id="totalPackRatio" name="totalPackRatio">Kolliinhalt</td>
                
                   @if (isset($qt) and count($qt) > 0 )
                     @foreach ($qt as $q)
                        
                   <td id="DE_sum">
                        <div lang="de">{{ $q }}</div>
                   </td>
                     @endforeach
                   @endif
                 
                </tr>
             </tbody>
          </table>
          <h3 class="tgCategoryHeadline" id="h3OverviewOnline" name="h3OverviewOnline">Bestellübersicht (Online)</h3>

          <?php $countries = $data['OrderOverviewOS']['countries']; 
                $overview = $data['OrderOverviewOS']['overview'];
          ?>
          <table id="onlineQuantity">
             <thead>
                <tr>
                   <th class="tgTableHeads" id="gtin" name="gtin">GTIN</th>
                   <th class="tgTableHeads" id="styleNo" name="styleNo">Stylenr.</th>
                   <th class="tgTableHeads" id="productName" name="productName">Stylebezeichnung</th>
                   <th class="tgTableHeads" id="sizeName" name="sizeName">Größe</th>
                   <th class="tgTableHeads" id="LSV" name="LSV">LSV</th>
                   @foreach ($countries as $c)
                   <th class="tgTableHeads" id="{{$c}}" name="{{$c}}">{{$c}}</th>
                   @endforeach
                </tr>
             </thead>
             <tbody>
             @foreach ($overview as $gtin => $style) 
                <tr id="onlineQuantity_d0e300_inputRow" class="tgLangDE">
                <td> {{$gtin}} </td>
                @foreach ($style as $style => $colors)
                    <td>{{$style}}</td>
                    @foreach ($colors as $color => $sorts)
                        <td>{{$color}}</td>
                        @foreach ($sorts as $sort => $sizes)
                            <td>{{$sort}}</td>
                            @foreach ($sizes as $size => $countries)
                                <td> {{ $size }}</td>
                                @foreach ($countries as $country => $qty)
                                 <?php if (!isset($qt[$country])){ $qt[$country] = 0;}
                                    $qt[$country] += $qty; ?>    
                                 <td>{{$qty}}</td>
                                @endforeach
                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach

            @endforeach
                
            

                
                
             </tbody>
          </table>
       </div>
       <div id="tabOtherXML" name="tabOtherXML" class="tgTabContent">
          <div class="tgCommonData" style="display: inline;">
             <h3 class="tgCategoryHeadline" id="h3measurement" name="h3measurement">Abmessungen</h3>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCombinedArtRef" id="measurement_isCombinedArtRef_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCombinedArtRef" name="isCombinedArtRef">isCombinedArtRef</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isEntireSizeSet" id="measurement_isEntireSizeSet_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isEntireSizeSet" name="isEntireSizeSet">isEntireSizeSet</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isFittingPep" id="measurement_isFittingPep_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isFittingPep" name="isFittingPep">isFittingPep</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isNoSizeSet" id="measurement_isNoSizeSet_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isNoSizeSet" name="isNoSizeSet">isNoSizeSet</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isReducedSizeSet" id="measurement_isReducedSizeSet_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isReducedSizeSet" name="isReducedSizeSet">isReducedSizeSet</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isRepeater" id="measurement_isRepeater_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isRepeater" name="isRepeater">isRepeater</div>
                </div>
             </div>
          </div>
          <hr>
          <div class="tgCommonData" style="display: inline;">
             <h3 class="tgCategoryHeadline" id="h3catalogue" name="h3catalogue">Katalog</h3>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCatalogue" id="catalogue_isCatalogue_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCatalogue" name="isCatalogue">Katalogbestellung</div>
                </div>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="lotNumber" name="lotNumber">Charge</div>
                   <div lang="de" class="tgInput tgCompare" contenteditable="false" id="catalogue_lotNumber_input" data-initial-value="2204">2204</div>
                </div>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="initialOrder" name="initialOrder">initialOrder</div>
                   <div lang="de" class="tgInput tgCompare" contenteditable="false" id="catalogue_initialOrder_input" data-initial-value=""></div>
                </div>
                <div class="tgPropertyInput tgLangDE">
                   <div class="tgLabel" id="timeOfOrders" name="timeOfOrders">timeOfOrders</div>
                   <div lang="de" class="tgInput tgCompare" contenteditable="false" id="catalogue_timeOfOrders_input" data-initial-value=""></div>
                </div>
             </div>
          </div>
          <hr>
          <h3 class="tgCategoryHeadline" id="h3fitting" name="h3fitting" style="display: none;">h3fitting</h3>
          <div class="tgCommonData" style="display: none;">
             <h4 class="tgCategoryHeadline"></h4>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isAgeGroupBaby" id="fitting_isAgeGroupBaby_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isAgeGroupBaby" name="isAgeGroupBaby">isAgeGroupBaby</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isAgeGroupKids" id="fitting_isAgeGroupKids_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isAgeGroupKids" name="isAgeGroupKids">isAgeGroupKids</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isAgeGroupOlderThan15" id="fitting_isAgeGroupOlderThan15_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isAgeGroupOlderThan15" name="isAgeGroupOlderThan15">isAgeGroupOlderThan15</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isAgeGroupOlderThan25" id="fitting_isAgeGroupOlderThan25_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isAgeGroupOlderThan25" name="isAgeGroupOlderThan25">isAgeGroupOlderThan25</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isAgeGroupOlderThan35" id="fitting_isAgeGroupOlderThan35_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isAgeGroupOlderThan35" name="isAgeGroupOlderThan35">isAgeGroupOlderThan35</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isAgeGroupOlderThan55" id="fitting_isAgeGroupOlderThan55_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isAgeGroupOlderThan55" name="isAgeGroupOlderThan55">isAgeGroupOlderThan55</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isAgeGroupSmallKids" id="fitting_isAgeGroupSmallKids_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isAgeGroupSmallKids" name="isAgeGroupSmallKids">isAgeGroupSmallKids</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isAimAthletic" id="fitting_isAimAthletic_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isAimAthletic" name="isAimAthletic">isAimAthletic</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isAimBusiness" id="fitting_isAimBusiness_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isAimBusiness" name="isAimBusiness">isAimBusiness</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isAimCasualOrBasic" id="fitting_isAimCasualOrBasic_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isAimCasualOrBasic" name="isAimCasualOrBasic">isAimCasualOrBasic</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isAimFeastful" id="fitting_isAimFeastful_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isAimFeastful" name="isAimFeastful">isAimFeastful</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isAimOthers" id="fitting_isAimOthers_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isAimOthers" name="isAimOthers">isAimOthers</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBackLengthDeep" id="fitting_isBackLengthDeep_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBackLengthDeep" name="isBackLengthDeep">isBackLengthDeep</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBackLengthHigh" id="fitting_isBackLengthHigh_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBackLengthHigh" name="isBackLengthHigh">isBackLengthHigh</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBackLengthNormal" id="fitting_isBackLengthNormal_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBackLengthNormal" name="isBackLengthNormal">isBackLengthNormal</div>
                </div>
             </div>
          </div>
          <div class="tgCommonData" style="display: none;">
             <h4 class="tgCategoryHeadline"></h4>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBandAddWaistband" id="fitting_isBandAddWaistband_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBandAddWaistband" name="isBandAddWaistband">isBandAddWaistband</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBandAllArndElastic" id="fitting_isBandAllArndElastic_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBandAllArndElastic" name="isBandAllArndElastic">isBandAllArndElastic</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBandFoldBackWaistbd" id="fitting_isBandFoldBackWaistbd_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBandFoldBackWaistbd" name="isBandFoldBackWaistbd">isBandFoldBackWaistbd</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBandOthers" id="fitting_isBandOthers_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBandOthers" name="isBandOthers">isBandOthers</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBandPartElastic" id="fitting_isBandPartElastic_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBandPartElastic" name="isBandPartElastic">isBandPartElastic</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBandShapedWaist" id="fitting_isBandShapedWaist_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBandShapedWaist" name="isBandShapedWaist">isBandShapedWaist</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBandAddWaistband" id="fitting_isBandAddWaistband_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBandAddWaistband" name="isBandAddWaistband">isBandAddWaistband</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBkLen1by2BksideCvd" id="fitting_isBkLen1by2BksideCvd_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBkLen1by2BksideCvd" name="isBkLen1by2BksideCvd">isBkLen1by2BksideCvd</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBkLenBellyBtnUncvd" id="fitting_isBkLenBellyBtnUncvd_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBkLenBellyBtnUncvd" name="isBkLenBellyBtnUncvd">isBkLenBellyBtnUncvd</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBkLenBksideCvd" id="fitting_isBkLenBksideCvd_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBkLenBksideCvd" name="isBkLenBksideCvd">isBkLenBksideCvd</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBkLenMini" id="fitting_isBkLenMini_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBkLenMini" name="isBkLenMini">isBkLenMini</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBkLenNormal" id="fitting_isBkLenNormal_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBkLenNormal" name="isBkLenNormal">isBkLenNormal</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBkLenShort" id="fitting_isBkLenShort_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBkLenShort" name="isBkLenShort">isBkLenShort</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBraFormSport" id="fitting_isBraFormSport_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBraFormSport" name="isBraFormSport">isBraFormSport</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBraFormWireless" id="fitting_isBraFormWireless_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBraFormWireless" name="isBraFormWireless">isBraFormWireless</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isBraFormWithWire" id="fitting_isBraFormWithWire_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isBraFormWithWire" name="isBraFormWithWire">isBraFormWithWire</div>
                </div>
             </div>
          </div>
          <div class="tgCommonData" style="display: none;">
             <h4 class="tgCategoryHeadline"></h4>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCoatLongCoat" id="fitting_isCoatLongCoat_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCoatLongCoat" name="isCoatLongCoat">isCoatLongCoat</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCoatOthers" id="fitting_isCoatOthers_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCoatOthers" name="isCoatOthers">isCoatOthers</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCoatParka" id="fitting_isCoatParka_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCoatParka" name="isCoatParka">isCoatParka</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCoatShortCoat" id="fitting_isCoatShortCoat_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCoatShortCoat" name="isCoatShortCoat">isCoatShortCoat</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCollarFormBubi" id="fitting_isCollarFormBubi_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCollarFormBubi" name="isCollarFormBubi">isCollarFormBubi</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCollarFormHaifisch" id="fitting_isCollarFormHaifisch_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCollarFormHaifisch" name="isCollarFormHaifisch">isCollarFormHaifisch</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCollarFormKapuze" id="fitting_isCollarFormKapuze_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCollarFormKapuze" name="isCollarFormKapuze">isCollarFormKapuze</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCollarFormKent" id="fitting_isCollarFormKent_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCollarFormKent" name="isCollarFormKent">isCollarFormKent</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCollarFormOthers" id="fitting_isCollarFormOthers_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCollarFormOthers" name="isCollarFormOthers">isCollarFormOthers</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCollarFormPolokragen" id="fitting_isCollarFormPolokragen_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCollarFormPolokragen" name="isCollarFormPolokragen">isCollarFormPolokragen</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCollarFormStehkragen" id="fitting_isCollarFormStehkragen_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCollarFormStehkragen" name="isCollarFormStehkragen">isCollarFormStehkragen</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCollarLapel" id="fitting_isCollarLapel_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCollarLapel" name="isCollarLapel">isCollarLapel</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isCollarTurtleNeck" id="fitting_isCollarTurtleNeck_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isCollarTurtleNeck" name="isCollarTurtleNeck">isCollarTurtleNeck</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isGenderDivers" id="fitting_isGenderDivers_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isGenderDivers" name="isGenderDivers">isGenderDivers</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isGenderFemale" id="fitting_isGenderFemale_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isGenderFemale" name="isGenderFemale">isGenderFemale</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isGenderMale" id="fitting_isGenderMale_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isGenderMale" name="isGenderMale">isGenderMale</div>
                </div>
             </div>
          </div>
          <div class="tgCommonData" style="display: none;">
             <h4 class="tgCategoryHeadline"></h4>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isLvlExtreme" id="fitting_isLvlExtreme_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isLvlExtreme" name="isLvlExtreme">isLvlExtreme</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isLvlHigh" id="fitting_isLvlHigh_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isLvlHigh" name="isLvlHigh">isLvlHigh</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isLvlLight" id="fitting_isLvlLight_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isLvlLight" name="isLvlLight">isLvlLight</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isLvlMedium" id="fitting_isLvlMedium_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isLvlMedium" name="isLvlMedium">isLvlMedium</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isLvlOther" id="fitting_isLvlOther_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isLvlOther" name="isLvlOther">isLvlOther</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isNecklineBoat" id="fitting_isNecklineBoat_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isNecklineBoat" name="isNecklineBoat">isNecklineBoat</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isNecklineDeepV" id="fitting_isNecklineDeepV_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isNecklineDeepV" name="isNecklineDeepV">isNecklineDeepV</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isNecklineEnvelope" id="fitting_isNecklineEnvelope_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isNecklineEnvelope" name="isNecklineEnvelope">isNecklineEnvelope</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isNecklineOthers" id="fitting_isNecklineOthers_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isNecklineOthers" name="isNecklineOthers">isNecklineOthers</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isNecklineRDHINeck" id="fitting_isNecklineRDHINeck_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isNecklineRDHINeck" name="isNecklineRDHINeck">isNecklineRDHINeck</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isNecklineRoundNeck" id="fitting_isNecklineRoundNeck_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isNecklineRoundNeck" name="isNecklineRoundNeck">isNecklineRoundNeck</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isNecklineScoopNeck" id="fitting_isNecklineScoopNeck_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isNecklineScoopNeck" name="isNecklineScoopNeck">isNecklineScoopNeck</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isNecklineVNeck" id="fitting_isNecklineVNeck_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isNecklineVNeck" name="isNecklineVNeck">isNecklineVNeck</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPant3by4" id="fitting_isPant3by4_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPant3by4" name="isPant3by4">isPant3by4</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPant7by8" id="fitting_isPant7by8_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPant7by8" name="isPant7by8">isPant7by8</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPantBermuda" id="fitting_isPantBermuda_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPantBermuda" name="isPantBermuda">isPantBermuda</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPantCapri" id="fitting_isPantCapri_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPantCapri" name="isPantCapri">isPantCapri</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPantLong" id="fitting_isPantLong_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPantLong" name="isPantLong">isPantLong</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPantPanty" id="fitting_isPantPanty_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPantPanty" name="isPantPanty">isPantPanty</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPantShorts" id="fitting_isPantShorts_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPantShorts" name="isPantShorts">isPantShorts</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPant3by4" id="fitting_isPant3by4_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPant3by4" name="isPant3by4">isPant3by4</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPant7by8" id="fitting_isPant7by8_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPant7by8" name="isPant7by8">isPant7by8</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPantBermuda" id="fitting_isPantBermuda_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPantBermuda" name="isPantBermuda">isPantBermuda</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPantCapri" id="fitting_isPantCapri_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPantCapri" name="isPantCapri">isPantCapri</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPantLong" id="fitting_isPantLong_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPantLong" name="isPantLong">isPantLong</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPantPanty" id="fitting_isPantPanty_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPantPanty" name="isPantPanty">isPantPanty</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isPantShorts" id="fitting_isPantShorts_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isPantShorts" name="isPantShorts">isPantShorts</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSlipFormPanty" id="fitting_isSlipFormPanty_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSlipFormPanty" name="isSlipFormPanty">isSlipFormPanty</div>
                </div>
             </div>
          </div>
          <div class="tgCommonData" style="display: none;">
             <h4 class="tgCategoryHeadline"></h4>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isShoulderBtnForBaby" id="fitting_isShoulderBtnForBaby_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isShoulderBtnForBaby" name="isShoulderBtnForBaby">isShoulderBtnForBaby</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSkirt3by4" id="fitting_isSkirt3by4_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSkirt3by4" name="isSkirt3by4">isSkirt3by4</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSkirt7by8" id="fitting_isSkirt7by8_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSkirt7by8" name="isSkirt7by8">isSkirt7by8</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSkirtForm" id="fitting_isSkirtForm_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSkirtForm" name="isSkirtForm">isSkirtForm</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSkirtKneeCovered" id="fitting_isSkirtKneeCovered_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSkirtKneeCovered" name="isSkirtKneeCovered">isSkirtKneeCovered</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSkirtKneeOpen" id="fitting_isSkirtKneeOpen_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSkirtKneeOpen" name="isSkirtKneeOpen">isSkirtKneeOpen</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSkirtLenOthers" id="fitting_isSkirtLenOthers_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSkirtLenOthers" name="isSkirtLenOthers">isSkirtLenOthers</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSkirtLong" id="fitting_isSkirtLong_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSkirtLong" name="isSkirtLong">isSkirtLong</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSkirtMini" id="fitting_isSkirtMini_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSkirtMini" name="isSkirtMini">isSkirtMini</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSkirtShapeFlared" id="fitting_isSkirtShapeFlared_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSkirtShapeFlared" name="isSkirtShapeFlared">isSkirtShapeFlared</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSkirtShapeOther" id="fitting_isSkirtShapeOther_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSkirtShapeOther" name="isSkirtShapeOther">isSkirtShapeOther</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSkirtShapeStraight" id="fitting_isSkirtShapeStraight_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSkirtShapeStraight" name="isSkirtShapeStraight">isSkirtShapeStraight</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSkirtShort" id="fitting_isSkirtShort_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSkirtShort" name="isSkirtShort">isSkirtShort</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSleLen1by1" id="fitting_isSleLen1by1_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSleLen1by1" name="isSleLen1by1">isSleLen1by1</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSleLen1by1A1" id="fitting_isSleLen1by1A1_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSleLen1by1A1" name="isSleLen1by1A1">isSleLen1by1A1</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSleLen1by1A2" id="fitting_isSleLen1by1A2_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSleLen1by1A2" name="isSleLen1by1A2">isSleLen1by1A2</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSleLen1by2" id="fitting_isSleLen1by2_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSleLen1by2" name="isSleLen1by2">isSleLen1by2</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSleLen1by4" id="fitting_isSleLen1by4_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSleLen1by4" name="isSleLen1by4">isSleLen1by4</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSleLen1by8" id="fitting_isSleLen1by8_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSleLen1by8" name="isSleLen1by8">isSleLen1by8</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSleLen3by4" id="fitting_isSleLen3by4_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSleLen3by4" name="isSleLen3by4">isSleLen3by4</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSleLenCapSleeve" id="fitting_isSleLenCapSleeve_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSleLenCapSleeve" name="isSleLenCapSleeve">isSleLenCapSleeve</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSleLenOther" id="fitting_isSleLenOther_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSleLenOther" name="isSleLenOther">isSleLenOther</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSleLenSleeveless" id="fitting_isSleLenSleeveless_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSleLenSleeveless" name="isSleLenSleeveless">isSleLenSleeveless</div>
                </div>
             </div>
          </div>
          <div class="tgCommonData" style="display: none;">
             <h4 class="tgCategoryHeadline"></h4>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSlipFormBoxershorts" id="fitting_isSlipFormBoxershorts_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSlipFormBoxershorts" name="isSlipFormBoxershorts">isSlipFormBoxershorts</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSlipFormBrief" id="fitting_isSlipFormBrief_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSlipFormBrief" name="isSlipFormBrief">isSlipFormBrief</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSlipFormHipster" id="fitting_isSlipFormHipster_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSlipFormHipster" name="isSlipFormHipster">isSlipFormHipster</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSlipFormHuftslip" id="fitting_isSlipFormHuftslip_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSlipFormHuftslip" name="isSlipFormHuftslip">isSlipFormHuftslip</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSlipFormJazzpants" id="fitting_isSlipFormJazzpants_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSlipFormJazzpants" name="isSlipFormJazzpants">isSlipFormJazzpants</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSlipFormMinislip" id="fitting_isSlipFormMinislip_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSlipFormMinislip" name="isSlipFormMinislip">isSlipFormMinislip</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSlipFormPanty" id="fitting_isSlipFormPanty_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSlipFormPanty" name="isSlipFormPanty">isSlipFormPanty</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSlipFormString" id="fitting_isSlipFormString_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSlipFormString" name="isSlipFormString">isSlipFormString</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSlipFormHuftslip" id="fitting_isSlipFormHuftslip_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSlipFormHuftslip" name="isSlipFormHuftslip">isSlipFormHuftslip</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isSlipFormMinislip" id="fitting_isSlipFormMinislip_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isSlipFormMinislip" name="isSlipFormMinislip">isSlipFormMinislip</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTopBodyNear" id="fitting_isTopBodyNear_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTopBodyNear" name="isTopBodyNear">isTopBodyNear</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTopCasual" id="fitting_isTopCasual_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTopCasual" name="isTopCasual">isTopCasual</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTopIssued" id="fitting_isTopIssued_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTopIssued" name="isTopIssued">isTopIssued</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTopOthers" id="fitting_isTopOthers_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTopOthers" name="isTopOthers">isTopOthers</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTopOversize" id="fitting_isTopOversize_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTopOversize" name="isTopOversize">isTopOversize</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTopStraight" id="fitting_isTopStraight_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTopStraight" name="isTopStraight">isTopStraight</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTopTight" id="fitting_isTopTight_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTopTight" name="isTopTight">isTopTight</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTopWaisted" id="fitting_isTopWaisted_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTopWaisted" name="isTopWaisted">isTopWaisted</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTopWide" id="fitting_isTopWide_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTopWide" name="isTopWide">isTopWide</div>
                </div>
             </div>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTrouserLegBootCut" id="fitting_isTrouserLegBootCut_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTrouserLegBootCut" name="isTrouserLegBootCut">isTrouserLegBootCut</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTrouserLegFlared" id="fitting_isTrouserLegFlared_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTrouserLegFlared" name="isTrouserLegFlared">isTrouserLegFlared</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTrouserLegLooseFit" id="fitting_isTrouserLegLooseFit_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTrouserLegLooseFit" name="isTrouserLegLooseFit">isTrouserLegLooseFit</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTrouserLegOthers" id="fitting_isTrouserLegOthers_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTrouserLegOthers" name="isTrouserLegOthers">isTrouserLegOthers</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTrouserLegSlim" id="fitting_isTrouserLegSlim_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTrouserLegSlim" name="isTrouserLegSlim">isTrouserLegSlim</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTrouserLegSsfit" id="fitting_isTrouserLegSsfit_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTrouserLegSsfit" name="isTrouserLegSsfit">isTrouserLegSsfit</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isTrouserLegStraight" id="fitting_isTrouserLegStraight_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isTrouserLegStraight" name="isTrouserLegStraight">isTrouserLegStraight</div>
                </div>
             </div>
          </div>
          <div class="tgCommonData" style="display: none;">
             <h4 class="tgCategoryHeadline"></h4>
             <div class="tgColumn">
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isUnderpartBodyNear" id="fitting_isUnderpartBodyNear_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isUnderpartBodyNear" name="isUnderpartBodyNear">isUnderpartBodyNear</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isUnderpartCasual" id="fitting_isUnderpartCasual_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isUnderpartCasual" name="isUnderpartCasual">isUnderpartCasual</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isUnderpartOversize" id="fitting_isUnderpartOversize_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isUnderpartOversize" name="isUnderpartOversize">isUnderpartOversize</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isUnderpartTight" id="fitting_isUnderpartTight_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isUnderpartTight" name="isUnderpartTight">isUnderpartTight</div>
                </div>
                <div class="tgPropertyCheck tgLangDE"><input lang="de" class="tgCheckbox tgCompare" type="checkbox" name="isUnderpartWide" id="fitting_isUnderpartWide_input" value="false" disabled="" data-initial-value="false"><div class="tgLabel" id="isUnderpartWide" name="isUnderpartWide">isUnderpartWide</div>
                </div>
             </div>
          </div>
       </div>
       <div id="tabTranslationList" name="tabTranslationList" class="tgTabContent">
          <div class="tgCommonData">
             <h3 class="tgCategoryHeadline" id="h3TranslationList" name="h3TranslationList">List der Übersetzungen</h3>
             <div id="tgTranslationList" class="tgColumn tgColumnReverse"><button class="extensionButton" id="buttonToggle" name="buttonToggle">Auswahl umschalten</button></div>
             <div id="tgTranslationControl" class="tgColumn">
                <div lang="de" class="tgPropertyTextArea tgLangDE">
                   <div class="tgLabel" id="translationBoard" name="translationBoard">Übersetzungs Mitteilungen</div>
                   <div lang="de" contenteditable="true" class="tgInputEditable" id="translationBoard_input">
                                                              no translation yet
                                                          </div>
                </div>
             </div>
          </div>
       </div>
       <div id="tabHistory" name="tabHistory" class="tgTabContent">
          <h3 class="tgCategoryHeadline" id="h3History" name="h3History">Historie</h3>
          <div id="tgHistory" name="tgHistory"></div>
       </div>
    </div>
    <div class="tgFoot" style="border:1px solid #1C73C5;position: relative;border-radius:0px;padding:6px;">
       <div class="tgFooterMessages" id="tgWindowMessage" style="background-color:#1c73c5; ">Copyright by Targa GmbH</div>
       <div style="background-color:#1c73c5; ">
            <!-- button id="buttonExt0" style="display:none;">DE -&gt; EN</button -->
            <!-- button class="extensionButton tgHidden" id="buttonExt1" name="buttonExt1" style="display: none;">Alles übersetzen</button -->
            <!-- button class="extensionButton tgHidden" id="buttonExt2" name="buttonExt2" style="display: none;">Teile übersetzen</button -->
            <!-- button class="extensionButton tgHidden" id="buttonExt3" name="buttonExt3" style="display: none;">Auswahl übersetzen</button -->
            <!-- button class="extensionButton" id="buttonExt4" name="buttonExt4">Speichern</button -->
            <!-- label for="fileCompare" class="extensionButton" id="buttonExt5" name="buttonExt5">Vergleichen</label><input type="file" class="extensionButton" id="fileCompare" name="fileCompare" -->
            <!-- button class="extensionButton" id="buttonZip" name="buttonZip">ZIP erstellen</button -->
      </div>
    </div>
    <div id="tgExternal" style="display: none;">0</div>
    <div id="tgLanguage" style="display: none;">0</div>


    


   
    <!-- script src="http://schema.ad.targa.de/Lieferantenportal/v1.5/tgPage-PP-LocalExtension.js"></script -->


    <script>
      // Links nicht ersetzen
      window.removeEventListener('DOMContentLoaded', createInternalLinks);
      
      // Buttons ausblenden
      document.getElementById('buttonDocument').style.visibility = 'hidden';
      document.getElementById('buttonProduct').style.visibility = 'hidden';
      document.getElementById('buttonTranslationList').style.visibility = 'hidden';
      document.getElementById('buttonHistory').style.visibility = 'hidden';
      document.getElementById('buttonOffer').style.visibility = 'hidden';
      document.getElementsByClassName('tgFoot')[0].style.visibility = 'hidden';

   </script>
</body></html>