<style>

    #changePassword {
        border:1px solid darkblue;
        border-radius: 0px;
        width:700px;
        height:425px;
        padding: 30px;
        margin-top:30px;
        margin-left:200px;
        font-size:20px;
    }
    #changePassword table {
        table-layout: fixed;
        border-collapse: collapse;
        font-family: tahoma;
        font-size: 18px;
    }

    #changePassword td {
        border:none;
        padding:20px;
        font-weight: bold;
    }
    #changePassword input {
        font-size:40px;
        padding:0px;
        width:300px;
        padding-left:8px;
    }
</style>

<div id="changePassword">
    <form method="post" action="changePassword">

        <table>
            <tr style="height:50px;">
                <td colspan="2"  style="font-weight: bold;background-color: #0099cc">Password ändern für : {{Auth::User()->PPMitarbeiter_Name}}, {{Auth::User()->PPMitarbeiter_Vorname}} - [{{Auth::User()->PPMitarbeiter_Kuerzel}}] </td>

            </tr>

            <tr>
                <td>Altes Passwort</td>
                <td><input name="pwalt" type="password" \></td>
            </tr>
            <tr>
                <td>Neues Passwort</td>
                <td><input name="pwneu" type="password" \></td>
            </tr>
            <tr>
                <td>Neues Passwort wiederholen</td>
                <td><input name="pwneu2" type="password" \></td>
            </tr>

            <tr>
                <td colspan="2" style="padding:10 0 0 0;">  <input style="width:700px;" type="submit" value="Passwort ändern" \></td>
            </tr>
            <tr>
                <td colspan="2" style="color:red;">      {{$message}}
                </td>
            </tr>





        </table>
    </form>

</div>

