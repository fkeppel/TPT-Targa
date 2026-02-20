function tsave(id) {
    var values = {
        "Termine_Id": id,
        "Termine_Datum": $("#Termine_Datum" + id)[0].value,
        "Termine_Datum_Ende": $("#Termine_Datum_Ende" + id)[0].value,
        "Termine_Label": $("#Termine_Label" + id)[0].value,
        "Termine_Bemerkung": $("#Termine_Bemerkung" + id)[0].value,
        "Termine_Status": $("#Termine_Status" + id)[0].value,
        "Termine_Mitarbeiter": $("#Termine_Mitarbeiter" + id)[0].value
    };
    var jsonString = JSON.stringify(values);
    //SendAjaxJsonRequest("http://lis.lomotex.de/termineupdatejson", jsonString);
    return false;
}
function tsaveW(id) {
    var AWMs = document.getElementsByClassName("AWM" + id);
    var paramsOn = [];
    var paramsOff = [];
    for (var z = 0; z < AWMs.length; z++) {
        if (AWMs[z].checked) {
            paramsOn.push(AWMs[z].name);
        } else {
            paramsOff.push(AWMs[z].name);
        }
    }
    var values = {
        "Termine_Id": id,
        "Termine_Datum": $("#Termine_Datum" + id)[0].value,
        "Termine_Datum_Ende": $("#Termine_Datum_Ende" + id)[0].value,
        "Termine_Label": $("#Termine_Label" + id)[0].value,
        "Termine_Bemerkung": $("#Termine_Bemerkung" + id)[0].value,
        "Termine_Status": $("#Termine_Status" + id)[0].value,
        "Termine_Mitarbeiter": $("#Termine_Mitarbeiter" + id)[0].value,
        "AWMOn": paramsOn,
        "AWMOff": paramsOff
    };
    var jsonString = JSON.stringify(values);
    //SendAjaxJsonRequest("http://lis.lomotex.de/termineupdatejson", jsonString);
    return false;
}
function SendAjaxJsonRequest(url, jsonObject)
{
    $.ajax({
        type: "POST",
        url: url,
        data: {
            jsonObject: jsonObject
        },
        success: onSuccess
    });
}
/**
 * AJAX-Response auswerten
 */
function onSuccess(content)
{
    // Das empfangene Objekt wird wieder zum Objekt geparst
    //alert(content);
    //response = JSON.parse( content );
    var sResult = content.cont;
    console.log(content.cont);
    //var msgcontainer = $("#messagebox"+content.id);
    // geladenes Template im Container "content" austauschen
    //$("#content").html(response.template);
    $("#messagebox" + content.id)[0].innerHTML = sResult;
    // Pruefen ob die Eingabe richtig ist,
}
