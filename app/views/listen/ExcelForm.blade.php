<div style="padding:40px;">
    <div style="padding:40px; text-align: center; border: 1px solid gray;width:700px;text-align: left;">
        {{ Form::open(array('url'=>'/ExcelAuswertung')) }}


        <h1>Erzeuge Excel-Übersicht für Ausmusterung</h1>


        <input type="text" name="iAusmusterung"  />
        <input type="hidden" name="iInquiries" value="0" />
        <input type="checkbox" name="iInquiries" value="1" />
        <input type="submit" value ="Excel Übersicht anfordern">

        {{ Form::close() }}
    </div>


    <div style="padding:40px; text-align: center; border: 1px solid gray;width:700px;text-align: left;margin-top: 30px;">

        {{ Form::open(array('url'=>'/ExcelEKVKRohertrag')) }}


        <h1>Erzeuge Excel-Übersicht EK - VK - Rohertrag</h1>

        <div style="padding:25px;">
            <table>
                <tr>
                    <td>Kurs für Berechnung: </td>
                    <td><input type="text" name="iKurs" value="1.18"   style="padding:4px;text-align: right;"/></td>
                </tr>
                <tr>
                    <td>
                        Ausmusterung:
                    </td>
                    <td>
                        <input type="text" name="iAusmusterungEKVKRohertrag"  style="padding:4px;text-align: right;"/>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" value ="Excel Übersicht anfordern"></td>
                </tr>
            </table>

        </div>



        {{ Form::close() }}


    </div>



</div>