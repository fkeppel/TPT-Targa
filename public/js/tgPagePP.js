// Diese Anonyme Funktion wird beim Laden des Scripts automatisch gestartet.
// Die Funktion erlaubt das Speichern des Dokumentes.  
//
(function(){
	var scriptVersion_basic = 'Basic Script Version 1.5';
	function getFileName(incrementVersion, updateDocument)
	{
		let docVer = getVersion(incrementVersion, updateDocument);
		let ian = document.getElementById("ian_input").textContent;
		let charge = document.getElementById("charge_input").textContent;
		let buyerShortCode = document.getElementById("buyerShortCode_input").textContent;
		let description = document.getElementById("description_input").textContent;
		let shortDescription = description.substring(0, 20);
		let fileName = ian + '_' + charge + '_' + buyerShortCode + '_' + shortDescription + '_v' + docVer;
		return fileName;
	}
	// Generiert eine Version; optional wird diese in der HTML-Datei aktualisiert (F9CCAB0D-7AE6-4A1B-B76E-D0D276086875)
	function getVersion(incrementVersion, updateDocument)
	{
		var divDocVerMajor = document.getElementById('tgDocVerMajor'); 
		var divDocVerMinor = document.getElementById('tgDocVerMinor'); 
		var docVerMajor = divDocVerMajor.innerHTML.toString();
		var docVerMinor = parseInt(divDocVerMinor.innerHTML);
		if(incrementVersion)
		{
			docVerMinor += 1;
		}
		if(updateDocument)
		{
			docVerMinor = docVerMinor.toString();
			divDocVerMinor.innerHTML = docVerMinor;
		}
		var docVer = docVerMajor + '.' + docVerMinor;
		return docVer;
	}
	function getCleanContent()
	{
		var clonedDocument = document.cloneNode(true);
		var cleanDoc = cleanupLinks(clonedDocument).documentElement.innerHTML;
		return cleanDoc;
	}
	// Bereinigt eine HTML-Datei und entfernt interne Links
	function cleanupLinks(cleanContent)
	{
		// Entfernt interne Links zu Bildern (681A4A5E-EC1D-4261-B096-D6C2F01F060A)
		try
		{
			var imageFiles = cleanContent.getElementsByClassName('tgImage');
			for (let imageFile of imageFiles)
			{
				if(imageFile !== undefined && imageFile.src !== undefined && imageFile.src !== "")
				{
					var imageName = imageFile.src;
					var imageFileName = imageName.substring(imageName.lastIndexOf('/')+1);
					imageFile.src = imageFileName;
					imageFile.alt = imageFileName;
					var imageLinkFile = imageFile.parentElement;
					imageLinkFile.href = imageFileName;
				}
			}
			if(imageFiles.length <= 0)
			{
				console.log('No images found!');
			}
		}
		catch(exc)
		{
			console.log('No images found!');
		}
		// Entfernt interne Links zu DateianhÃ¤ngen (5A7A0B5B-6730-4DEE-9241-07373F42093B)
		try
		{
			var docFiles = cleanContent.getElementsByClassName('tgAttachment');
			for (let docFile of docFiles)
			{
				if(docFile !== undefined && docFile.href !== undefined && docFile.href !== "")
				{
					var docName = docFile.href;
					var docFileName = docName.substring(docName.lastIndexOf('/')+1);
					docFile.href = docFileName;
				}
			}
			if(docFiles.length <= 0)
			{
				console.log('No attachments found!');
			}
		}
		catch(exc)
		{
			console.log('No attachments found!');
		}
		return cleanContent;
	}
	function saveAsFile()
	{
		// Eventuell bestehende Vergleiche werden entfernt (7665B937-0133-4DB1-9DBA-44050A5D75E8)
		resetInputs();
		// Generiert die alte und neue Versionsnummer (744A8AEE-B0C4-49A4-B139-59BECD2A176A)
		let oldVersion = getVersion(false, false);
		let newVersion = getVersion(true, false);
		// Erstellt ein Historie-Element mit allen Ã„nderungen (67574106-170F-4C84-ADCD-AB7E9C78C69B)
		let changesExist = createHistoryElement(oldVersion, newVersion);
		let docHistory = document.getElementById('tgHistory');
		let imported = docHistory.getAttribute('import');
		if(imported === 'true' || imported === true)
		{
			imported = true;
		}
		else
		{
			imported = false;
		}
		// ÃœberprÃ¼ft, ob Ã„nderungen oder ein Import vorliegen (696C16FB-730B-4C6B-97A3-6D08F9B118D9)
		if(changesExist || imported)
		{
			docHistory.setAttribute('import', false);
			docHistory.setAttribute('currentVersion', newVersion)
			// ÃœberprÃ¼ft, ob sensitive Daten in der HTML-Datei existieren. (4DCCCE1E-9E89-45EC-BC28-17D7ACC67C72)
			if(document.getElementById('tgExternal').innerHTML == "0")
			{
				var sendExternal = confirm("Soll die Datei an einen externen Partner versendet werden (Lidl Ansprechpartner entfernen)?");
				if (sendExternal == true)
				{
					let createUser = document.getElementById('createUserName_input');
					let updateUser = document.getElementById('updateUserName_input');
					// Fallback fÃ¼r alte Versionen
					if(createUser === null) {
						createUser = document.getElementById('creatorName_input');
						updateUser = document.getElementById('updateUserName_input');
					}
					document.getElementById('tgExternal').innerHTML = "1"
					//document.getElementById('creatorEmail_input').innerHTML = "";
					createUser.innerHTML = "";
					//document.getElementById('updateUserEmail_input').innerHTML = "";
					updateUser.innerHTML = "";
				} 
			}
			// Entfernt interne Links (D80B4D1F-97D8-49BA-B197-844DA7F25228)
			var textToWrite = getCleanContent();
			var textFileAsBlob = new Blob([textToWrite], {type:'text/plain'});
			var baseFileName = getFileName(true, true);
			var fileNameToSaveAs = baseFileName + ".html";
			// Generiert einen Download-Link und fÃ¼hrt ihn aus. (865E3E4B-F471-4985-952F-344357B343FF)
			var downloadLink = document.createElement("a");
			downloadLink.download = fileNameToSaveAs;
			downloadLink.innerHTML = "Download File";
			if (window.webkitURL != null)
			{
				// Chrome allows the link to be clicked
				// without actually adding it to the DOM.
				downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
			}
			else
			{
				// Firefox requires the link to be added to the DOM
				// before it can be clicked.
				downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
				// downloadLink.onclick = destroyClickedElement;
			}
			downloadLink.style.display = "none";
			document.body.appendChild(downloadLink);
			downloadLink.click();
		}
		else
		{
			let countryCode = getCountryCode();
			alert(translate.structure('noChanges', countryCode));
		}
	}
	// Erstellt aus den gegebenen Informationen eine ZIP-Datei und lÃ¤dt diese herunter
	function createZipFile(zipFileName, htmFileName, htmlContent, files)
	{
		// Erstellt einen Download Link (4819BA17-35E3-415C-B058-CFEE8E90005C))
		var downloadLink = document.createElement("a");
		downloadLink.innerHTML = "Download File";
		downloadLink.download = zipFileName;
		// Initialisiert eine leere ZIP-Datei
		var zip = new JSZip();
		// FÃ¼gt der leeren ZIP-Datei das gereinigte HTML hinzu (D2E062CC-A60B-46B9-B307-A0C07D7D2DB3)
		zip.file(htmFileName, htmlContent);
		// FÃ¼gt der ZIP-Datei Bilder und DateianhÃ¤nge hinzu
		for (let filedata of files)
		{
			let filename = filedata.filename;
			let filecontent = filedata.content;
			if(filename !== undefined && filename !== "" && filename !== null  && filecontent !== undefined && filecontent !== null)
			{
				zip.file(filename, filecontent);
			}
		}
		// Generiert asynchron die ZIP-Datei, verknÃ¼pft sie mit dem Download Link und klickt diesen (3C20C381-306A-45E7-9298-5BF0C352E08B)
        zip.generateAsync({type:"blob"})		
		.then(
            function(content) {
		        if (window.webkitURL != null)
		        {
                    // Chrome allows the link to be clicked
                    // without actually adding it to the DOM.
                    downloadLink.href = window.webkitURL.createObjectURL(content);
                }
                else
                {
                    // Firefox requires the link to be added to the DOM
                    // before it can be clicked.
                    downloadLink.href = window.URL.createObjectURL(content);
                    // downloadLink.onclick = destroyClickedElement;
                    downloadLink.style.display = "none";
                    document.body.appendChild(downloadLink);
                }
                downloadLink.click();
            }
        );
	}
	// Erstellt eine ZIP-Datei mit den verlinkten Dateien
	function createZip(event)
	{
		let htmlContent = getCleanContent();
		// Generiert einen Dateinamen fÃ¼r die HTML- und ie ZIP-Datei (6BFCF624-54E7-48C2-A862-0E6A65A9363B)
        let fileNameBase = getFileName(false, false);
		let htmlFileName = fileNameBase + '.html';
		let zipFileName = fileNameBase + '.zip';
		let fileRequests = [];
		// Such alle Links, die auf Bilder verweisen und merkt diese fÃ¼r den Download vor (072AB137-B9A4-42BF-B0A1-B3B9045BA25D)
        try
		{
			let imageFiles = document.getElementsByClassName('tgImage');
			for(let imageFile of imageFiles)
			{
				if(imageFile !== undefined && imageFile.src !== undefined && imageFile.src !== "")
				{
					let imgLink = imageFile.src;
					let imgFileName = imgLink.substring(imgLink.lastIndexOf('/')+1);
					fileRequests.push(getFile(imgFileName, imgLink));
				}
			}
		}
		catch(exc)
		{
		}
        // Such alle Links, die auf DateinanhÃ¤nge verweisen und merkt diese fÃ¼r den Download vor (29FB2EE0-31AE-4BDD-8E07-4BEB61A90C6E)
        try
		{
			let docFiles = document.getElementsByClassName('tgAttachment');
			for(let docFile of docFiles)
			{
				if(docFile !== undefined && docFile.href !== undefined && docFile.href !== "")
				{
					let docLink = docFile.href;
					let docFileName = docLink.substring(docLink.lastIndexOf('/')+1);
					fileRequests.push(getFile(docFileName, docLink));
				}
			}
		}
		catch(exc)
		{
		}
		getData(zipFileName, htmlFileName, htmlContent, fileRequests);
	}
	function getData(zipFileName, htmlFileName, htmlContent, fileRequests)
	{
		Promise.all(fileRequests).then((results) => {
			//create zip
			createZipFile(zipFileName, htmlFileName, htmlContent, results);
		});
	}
	function getFile(filename, url)
	{
		return requestFile(url).catch((err) => {
			// handle our error first
			console.log(err)
			// decide how you want to handle a lack of data
			return null;
		}).then((res) => {
			let result =
			{
				"filename": filename,
				"url": url,
				"content": res
			};
			return result;
		});
	}
	function requestFile(url)
	{
		return new Promise((resolve, reject) =>
		{
			let fileRequest = new XMLHttpRequest();
			fileRequest.open('GET', url, true);
			fileRequest.responseType = "blob";
			fileRequest.onreadystatechange = function()
			{
				if (fileRequest.readyState === 4)
				{  // Makes sure the document is ready to parse.
					if (fileRequest.status === 200)
					{  // Makes sure it's found the file.
						var fileContent = fileRequest.response;
						return resolve(fileContent);
					}
				}
			}
			fileRequest.onload = function()
			{
				if (this.status >= 200 && this.status < 300)
				{
					return resolve(fileRequest.response);
				}
				else
				{
					return reject({ status: this.status, text: fileRequest.statusText });
				}
			};
			fileRequest.onerror = reject;
			fileRequest.send();
		});
	}
	// Entfernt bestehende Vergleichsinformationen (9D49DDAE-0AD1-499A-85AE-6B8270AE5A94)
	function resetInputs()
	{
		var inputs = document.getElementsByClassName("tgDiff");
		var divs = [];
		for (let item of inputs) {
			if(divs.includes(item.parentNode) == false)
			{
				divs.push(item.parentNode);
			}
		}
		for(let i = 0; i < divs.length; i++)
		{
			divs[i].innerHTML = divs[i].getAttribute("initialValue");
			divs[i].style.borderColor = "black";
			divs[i].style.borderWidth = 1;
		}
	}
	// Vergleich zweier Textelemente (9700AF38-ABBB-4519-86A2-A56A9320A443)
	function GetTextDiff(oldText, newText)
	{
		var color = '',
			span = null;
		var diff = Diff.diffChars(oldText, newText),
		fragment = document.createDocumentFragment();
		diff.forEach(	
			function(part){
				// green for additions, red for deletions
				// grey for common parts
				color = part.added ? 'green' :
					part.removed ? 'red' : 'grey';
				span = document.createElement('span');
				span.classList.add("tgDiff");
				span.style.color = color;
				span.style.fontWeight = "bold";
				span.appendChild(document.createTextNode(part.value));				
				fragment.appendChild(span);		
			}
		);
		return fragment;
	}
	function compareFiles(e)
	{
		console.log('compareFiles');
		resetInputs();
		var a = e.target.files[0];
		var reader = new FileReader();
		reader.onload = function(e)
		{
			var contents = e.target.result;
			var doc = new DOMParser().parseFromString(contents, "text/html");
			// Vergleich aller Elemente mit festgelegten Klassen (5698F80E-FF5C-47FD-BEFB-CE8C01E58797)
			var inputs = doc.querySelectorAll('.tgInput, .tgInputEditable');
			for (let item of inputs) {
				if(item.id != ""){
					var currentInput = document.getElementById(item.id);
					if ((typeof(currentInput) !== 'undefined') && (currentInput !== null)) {
						var oldText = currentInput.innerHTML;
						var newText = item.innerHTML;
						if(oldText != newText)
						{		
							console.log(currentInput);
							console.log(oldText);										
							currentInput.setAttribute("initialValue", oldText);
							currentInput.style.borderColor = "red";
							currentInput.style.borderWidth = 2;
							currentInput.innerHTML = "";
							// Detaillierter Vergleich der beiden Elemente (CDD842E0-9E8E-4CE8-ADF2-CBD4E18A7CD4)
							currentInput.appendChild(GetTextDiff(newText, oldText));
						}
					}
				}
			}
			var checkboxes = doc.getElementsByClassName("tgCheckbox");
			for (let item of checkboxes) {
				if(item.id != ""){
					var currentInput = document.getElementById(item.id);
					if ((typeof(currentInput) !== 'undefined') && (currentInput !== null)) {
						if(item.checked != currentInput.checked)
						{	
							currentInput.parentNode.childNodes[1].style.color = "red";
						}
					}
				}
			}
			// Importiert (falls vorhanden) eine bestehende Historie (5AD7EE91-A01E-45CE-B3FF-51A6FC394350)
			let importHistory = doc.getElementById('tgHistory');
			let importHistoryEntries = importHistory.childNodes;
			if(importHistoryEntries !== undefined && importHistoryEntries !== null && importHistoryEntries.length > 0)
			{
				let currentHistory = document.getElementById('tgHistory');
				let oldVersion = '1.0';
				for (i = 0; i < importHistoryEntries.length; i++)
				{
					let historyEntry = importHistoryEntries[i].cloneNode(true);
					currentHistory.appendChild(historyEntry);
					if(historyEntry.hasAttribute('newVersion'))
					{
						oldVersion = historyEntry.getAttribute('newVersion');
					}
				}
				if(importHistory.hasAttribute('currentVersion'))
				{
					oldVersion = importHistory.getAttribute('currentVersion');
				}
				var newVersion = getVersion(false, false);
				let historyVersion = 'V' + oldVersion + ' -> V' + newVersion;
				let importEntry = document.createElement('div');
				importEntry.setAttribute('oldVersion', oldVersion);
				importEntry.setAttribute('newVersion', newVersion);
				importEntry.classList.add('tgHistoryData');
				importEntry.id = 'hist_' + oldVersion + '_' + newVersion ;
				let importHeader = document.createElement('h3');
				importHeader.textContent = historyVersion;
				importEntry.appendChild(importHeader);
				let importData = document.createElement('div');
				importData.innerText = 'Imported history from version ' + oldVersion;
				importEntry.appendChild(importData);
				let lineBreak = document.createElement('hr');
				currentHistory.appendChild(importEntry);
				currentHistory.appendChild(lineBreak);
				currentHistory.setAttribute('import', true);
			}
		};
		reader.readAsText(a);
		//document.getElementById('fileCompare').disabled = true;
	}
	function getDocumentVersion()
	{
		var url = window.location.pathname;
		var version = url.substring(url.lastIndexOf('_v')+2, url.lastIndexOf('.'));
		var versionMajor = version.substring(0, version.lastIndexOf('.'));
		var versionMinor = version.substring(version.lastIndexOf('.')+1);
		var divDocVerMajor = document.getElementById('tgDocVerMajor'); 
		divDocVerMajor.innerHTML = versionMajor;
		var divDocVerMinor = document.getElementById('tgDocVerMinor'); 
		divDocVerMinor.innerHTML = versionMinor;
	}
	function hideElements()
	{
		var hideElements = document.getElementsByClassName('tgHidden');
		for (let item of hideElements)
		{
			item.style.display = 'none';
		}
		var languageButton = document.getElementById('buttonExt0');
		languageButton.style.display = 'none';
		var tabOtherHideElements = document.getElementById('tabOtherXML');
		for (let item of tabOtherHideElements.childNodes)
		{
			if((item.nodeName && item.nodeName.toLowerCase() === 'div') || item.id === 'h3fitting')
			{
				item.style.display = 'none';
			}
		}
		var tabOtherShowElements = tabOtherHideElements.querySelectorAll('#h3measurement, #h3catalogue');
		for (let item of tabOtherShowElements)
		{
			item.parentNode.style.display = 'inline';
		}
	}
	// Erstellt ein neues Historien Element
	function createHistoryElement(oldVersion, newVersion)
	{
		// Sucht alle Elemente, die Ã„nderungen enthalten und legt fÃ¼r diese eine Historie-Tabelle an (819DC927-6BFA-46AD-A0DC-AEFC309B9D67)
		let changesExist = false;
		let historyVersion = 'V' + oldVersion + ' -> V' + newVersion;
		let historyTableBody = document.createElement('tbody');
		let countryCode = getCountryCode();
		for(let compareElement of document.getElementsByClassName('tgCompare'))
		{
			let initialValue = compareElement.getAttribute('data-initial-value');
			let currentValue = null;
			if(compareElement.type && compareElement.type === 'checkbox')
			{
				currentValue = compareElement.value;
			}
			else
			{
				currentValue = compareElement.textContent;
			}
			if(currentValue !== initialValue)
			{
				changesExist = true;
				let historyRow = document.createElement('tr');
				let nameElement = document.createElement('td');
				nameElement.classList.add('tgCell');
				let compareElementId = compareElement.id;
				let translationId = compareElementId;
				if(translationId !== undefined && translationId !== null)
				{
					translationId = translationId.split('_')[0];
					nameElement.textContent = translate.structure(translationId, countryCode);
					nameElement.setAttribute('name', translationId);
				}
				let additionalInfoElement = document.createElement('td');
				let additionalInfo = compareElement.getAttribute('additionalInfo');
				additionalInfoElement.textContent = additionalInfo;
				let initialValueElement = document.createElement('td');
				initialValueElement.textContent = initialValue;
				initialValueElement.id = 'initialValue';
				let currentValueElement = document.createElement('td');
				currentValueElement.textContent = currentValue;
				currentValueElement.id = 'currentValue';
				let diffElement = document.createElement('td');
				let diffData = GetTextDiff(initialValue, currentValue)
				for(let diffElement of diffData.childNodes)
				{
					diffElement.classList.remove('tgDiff');
				}
				diffElement.appendChild(diffData);
				// FÃ¼r jeden Eintrag in der Historie-Tabelle wird ein Button fÃ¼r das ZurÃ¼cksetzen der Ã„nderung angelegt (3BDDE1C8-877E-46E7-853A-50A654DDCDD0)
				let restoreButton = document.createElement('button');
				restoreButton.textContent = translate.structure('buttonRestore', countryCode);
				restoreButton.setAttribute('name', 'buttonRestore');
				restoreButton.setAttribute('elementId', compareElementId);
				restoreButton.setAttribute('oldValue', initialValue);
				restoreButton.classList.add('tgRestoreButton');
				restoreButton.addEventListener('click', restoreValue);
				let restoreElement = document.createElement('td');
				restoreElement.appendChild(restoreButton);
				let idElement = document.createElement('td');
				idElement.style = 'display: none';
				idElement.textContent = compareElementId;
				idElement.id = 'inputElementId';
				historyRow.appendChild(nameElement);
				historyRow.appendChild(additionalInfoElement);
				historyRow.appendChild(initialValueElement);
				historyRow.appendChild(currentValueElement);
				historyRow.appendChild(diffElement);
				historyRow.appendChild(restoreElement);
				historyRow.appendChild(idElement);
				historyTableBody.appendChild(historyRow);
				// Setzt fÃ¼r jedes Element, das Ã„nderungen enthÃ¤lt, das Attribut "data-inital-value" auf den aktuellen Wert (FD25BE62-252F-4F23-9E44-76F492AC9F65)
				compareElement.setAttribute('data-initial-value', currentValue);
			}
		}
		// Falls Ã„nderungen vorliegen, werden der Tabelle eine Kopfzeile und die Tabelle dem Element "tgHistory" hinzugefÃ¼gt (CBA720EE-8D0F-4CCE-86DA-E16F834159EF)
		if(changesExist)
		{
			let historyEntry = document.createElement('div');
			historyEntry.id = 'hist_' + oldVersion + '_' + newVersion ;
			historyEntry.setAttribute('oldVersion', oldVersion);
			historyEntry.setAttribute('newVersion', newVersion);
			historyEntry.classList.add('tgHistoryData');
			let historyHeader = document.createElement('h3');
			historyHeader.textContent = historyVersion;
			let historyTable = document.createElement('table');
			historyTable.width = '100%';
			let historyTableHead = document.createElement('thead');
			let historyTableHeadContent = document.createElement('tr');
			let header_name = document.createElement('th');
			header_name.classList.add('tgTableHeads');
			header_name.textContent = translate.structure('history_header_name', countryCode);
			header_name.id = 'history_header_name';
			header_name.setAttribute('name', 'history_header_name');
			header_name.setAttribute('width', '15%');
			let header_additionalInfo = document.createElement('th');
			header_additionalInfo.classList.add('tgTableHeads');
			header_additionalInfo.textContent = translate.structure('history_header_additionalInfo', countryCode);
			header_additionalInfo.id = 'history_header_additionalInfo';
			header_additionalInfo.setAttribute('name', 'history_header_additionalInfo');
			header_additionalInfo.setAttribute('width', '5%');
			let header_initialValue = document.createElement('th');
			header_initialValue.classList.add('tgTableHeads');
			header_initialValue.textContent = translate.structure('history_header_initialValue', countryCode);
			header_initialValue.id = 'history_header_initialValue';
			header_initialValue.setAttribute('name', 'history_header_initialValue');
			header_initialValue.setAttribute('width', '25%');
			let header_currentValue = document.createElement('th');
			header_currentValue.classList.add('tgTableHeads');
			header_currentValue.textContent = translate.structure('history_header_currentValue', countryCode);
			header_currentValue.id = 'history_header_currentValue';
			header_currentValue.setAttribute('name', 'history_header_currentValue');
			header_currentValue.setAttribute('width', '25%');
			let header_diff = document.createElement('th');
			header_diff.classList.add('tgTableHeads');
			header_diff.textContent = translate.structure('history_header_diff', countryCode);
			header_diff.id = 'history_header_diff';
			header_diff.setAttribute('name', 'history_header_diff');
			header_diff.setAttribute('width', '25%');
			let header_restore = document.createElement('th');
			header_restore.classList.add('tgTableHeads');
			header_restore.textContent = translate.structure('history_header_restore', countryCode);
			header_restore.id = 'history_header_restore';
			header_restore.setAttribute('name', 'history_header_restore');
			header_restore.setAttribute('width', '5%');
			let header_id = document.createElement('th');
			header_id.textContent = 'ID';
			header_id.style = 'display: none';
			historyTableHeadContent.appendChild(header_name);
			historyTableHeadContent.appendChild(header_additionalInfo);
			historyTableHeadContent.appendChild(header_initialValue);
			historyTableHeadContent.appendChild(header_currentValue);
			historyTableHeadContent.appendChild(header_diff);
			historyTableHeadContent.appendChild(header_restore);
			historyTableHeadContent.appendChild(header_id);
			historyTableHead.appendChild(historyTableHeadContent);
			historyTable.appendChild(historyTableHead);
			historyTable.appendChild(historyTableBody);
			historyEntry.appendChild(historyHeader);
			historyEntry.appendChild(historyTable);
			let lineBreak = document.createElement('hr');
			let docHistory = document.getElementById('tgHistory');
			docHistory.appendChild(historyEntry);
			docHistory.appendChild(lineBreak);
		}
		return changesExist;
	}
	// Stellt einen vorherigen Wert wieder her
	function restoreValue(event)
	{
		let restoreButton = event.target;
		let elementId = restoreButton.getAttribute('elementId');
		let oldValue = restoreButton.getAttribute('oldValue');
		document.getElementById(elementId).textContent = oldValue;
	}
	// Sucht die ausgewÃ¤hlte Sprache
	function getCountryCode()
	{
		let languageDropDown = document.getElementById('structureLangDropDown');
		let countryCode = languageDropDown.options[languageDropDown.selectedIndex].value;
		if(countryCode === undefined || countryCode === null)
		{
			countryCode = 'en';
		}
		return countryCode;
	}
	// Initialisierung. Wird nach dem laden des Dokument gestartet.
	function init()
	{
		return;
		console.log(scriptVersion_basic);
		document.getElementById('buttonExt4').addEventListener('click', saveAsFile);
		document.getElementById('fileCompare').addEventListener('change', compareFiles, false);			
		getDocumentVersion();
		hideElements();
		try
		{
			document.getElementById('buttonZip').addEventListener('click', createZip);
		}
		catch(exc)
		{
			console.log('Missing zip button!');
		}
		for(let compareElement of document.getElementsByClassName('tgCompare'))
		{
			let initialValue = null;
			if(compareElement.type && compareElement.type === 'checkbox')
			{
				initialValue = compareElement.value;
			}
			else
			{
				initialValue = compareElement.textContent;
			}
			compareElement.setAttribute('data-initial-value', initialValue);
		}
		for(let restoreButton of document.getElementsByClassName('tgRestoreButton'))
		{
			restoreButton.addEventListener('click', restoreValue);
		}
		setCountryDropDown();
	}
	// Durch diese Registrierung wird die Funktion init() beim Laden des Dokuments gestartet.    
	window.addEventListener('DOMContentLoaded', init);
})();
// Diese Anonyme Funktion wird beim Laden des Scripts automatisch gestartet.
// Die Funktion steuert die Ãœbersetzung der Strukturelemente  
(function() {
	// BenÃ¶tigt die Funktion translate(key,language) in Global.
	// Diese Funktion befindet sich derzeit in der Datei languageDict.js
	// Benennt die Formularfelder des Dokumentes in der gewÃ¼nschten Sprache.
	function chooseLanguage (event) {
		renameElements(event.currentTarget.value);
	}
	// Umbenennen der Elemente gemÃ¤ÃŸ CountryCode.
	function renameElements(countryCode) {
		let elements = document.querySelectorAll(".tgLabel, .tgTableHeads, .tgHeadline, .tgCategoryHeadline, .tgTopHeader, .tgTabLinks, .tgLinkButton, .tgZipButton, .languageButton, .tgDisplayLinks, .tgLanguageLinks, .tgDropDownOption, .extensionButton, .tgCell, .tgRestoreButton");
		Array.from(elements).forEach(element => {
			if (countryCode=="xml") {
				element.innerHTML = element.id;
			}
			else {
				let elementID = (element.id.endsWith('_en')) ?  element.id.substring(0, element.id.length-3) : element.id;
				let translationId = element.getAttribute('name');
				if(translationId === undefined || translationId === null)
				{
					translationId = elementID;
				}
				element.innerHTML = translate.structure(translationId, countryCode);
			}
		});
	}
	function setCountryDropDown(countryCode){
		var oSelected = document.getElementById("structureLangDropDown");
		for (var i=0; i<oSelected.options.length; i++) {
			if (oSelected.options[i].value == countryCode) {
				oSelected.options[i].selected = true;
				return;
			}
		}
	}
	// Initialisierung. Wird nach dem laden des Dokument gestartet.
	function init() {
		return;
		document.getElementById('structureLangDropDown').addEventListener('change', chooseLanguage);
		//Sprache beim Start vom Browser auslesen 
		//var userLang = 'en';
		var userLang = (navigator.language || navigator.userLanguage || 'en').substr(0, 2);
		setCountryDropDown(userLang);
		renameElements(userLang);
		// debug only: alert(userLang);
	}
	// Durch diese Registrierung wird die Funktion init() beim Laden des Dokuments gestartet.    
	window.addEventListener('DOMContentLoaded', init)
})();
// Diese Anonyme Funktion wird beim Laden des Scripts automatisch gestartet.
// Die Funktion steuert die Anzeige der Bereiche DocumentData und ProductData.
(function(){
	// Schaltet das gewÃ¼nschte Top Element ein.
	function openTop(event) {
		// Der Zustand des Button (current) und der Anzeige (target) wird umgeschaltet. Da die SynchronitÃ¤t der ZustÃ¤nde vorab nicht sicher ist, 
		// kann nicht mit classList.toggle gearbeitet werden. Der Zustand des current ist fÃ¼hrend. Die target.id wird aus der current.id abgeleitet.
		const current = event.currentTarget;
		const target = document.getElementById("top" + current.id.substring(6));
		if (current.classList.contains('active')){
			current.classList.remove('active');
			target.classList.remove('active');
		}
		else{
			current.classList.add('active');
			target.classList.add('active');
		}
	}
	function init() {
		let tabButtons = document.getElementsByClassName("tgDisplayLinks");
		Array.from(tabButtons).forEach(element => element.addEventListener('click', openTop));
	}
	// Durch diese Registrierung wird die Funktion init() beim Laden des Dokuments gestartet.    
	window.addEventListener('DOMContentLoaded', init)
})();
// Diese Anonyme Funktion wird beim Laden des Scripts automatisch gestartet.
// Die Funktion steuert die Anzeige der Register.
(function(){
	// Schaltet das gewÃ¼nschte Tab (Register) ein.
	function openTab(event)
	{
		// Alle Button und Tabs werden durch Enfernen der class="active" auf nicht aktiv gesetzt.
		// getElementsByClassName() funktioniert nicht mit ClassName1 or ClassName2. Daher qerySelectorAll().
		let elements = document.querySelectorAll(".tgTabLinks, .tgTabContent");
		Array.from(elements).forEach(element => element.classList.remove('active'));
		// Der gewÃ¤hlte Button (current) und das Register (target) wird durch hinzufÃ¼gen der class="active hervorgehoben bzw. Angezeigt.
		// Die tab id wird aus der button id abgeleitet.
		const current = event.currentTarget;
		const target = document.getElementById("tab" + current.id.substring(6));
		current.classList.add('active');
		target.classList.add('active');
	}
	// Ã–ffnet ein neues Fenster mit dem hinterlegten Link.
	function openLink(event)
	{
		// Die tab id wird aus der button id abgeleitet.
		const current = event.currentTarget;
		var target = current.attributes['target'].value;
		window.open(target);
	}
	function init() {
		let tabButtons = document.getElementsByClassName("tgTabLinks");
		Array.from(tabButtons).forEach(element => element.addEventListener('click', openTab));
		let linkButtons = document.getElementsByClassName("tgLinkButton");
		Array.from(linkButtons).forEach(element => element.addEventListener('click', openLink));
	}
	// Durch diese Registrierung wird die Funktion init() beim Laden des Dokuments gestartet.    
	window.addEventListener('DOMContentLoaded', init)
})();
// Diese Anonyme Funktion wird beim Laden des Scripts automatisch gestartet.
// Die funktion reorganisiert die Tabelle in dem Register Assortment. 
(function(){
	let assortments = document.getElementsByClassName("tgAssortment");
	Array.from(assortments).forEach(assortment => {
		var x = [];
		let rows = assortment.getElementsByTagName("tr");
		Array.from(rows).forEach(row => {
			let columns = row.getElementsByTagName("td");
			let CBNo = columns[0].innerHTML.substring(2)
			// Wenn dem Feld im Array schon eine Wert zugewiesen wurde, dann wird der aktuelle angefÃ¼gt
			if (x[CBNo]){
				x[CBNo] += ", " + columns[1].innerHTML;
			}
			// Wenn dem Feld im Array noch kein Wert zugewiesen wurde, dann wir der aktuelle eingefÃ¼gt.
			else {
				x[CBNo] = columns[1].innerHTML;
			}
		})
		var s = "";
		x.forEach((item, i) => {if (item){ s += "<tr><td>CB" + i + "</td><td>" + item + "</td></tr>";}});
		assortment.innerHTML = s; 
	});
})();