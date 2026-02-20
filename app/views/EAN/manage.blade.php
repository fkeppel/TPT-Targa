                <div style="border:1px solid gray;height:700px;overflow: auto;">
                    <table style="font-family: Tahoma, Arial, sans-serif; font-size: 14px;">
                    @if (count($searchean)== 0)
                        <tr>
                           <td style="padding:20px;">Kein Ergebnis</td>
                        </tr>    
                    @else 
                        <tr style="background-color: lightgray; border: 1px solid gray;">
                            <td style="width:150px;padding:6px;">Bezeichnung</td>
                            <td style="width:200px;padding:6px;">EAN</td>
                            <td style="width:100px;padding:6px;">IAN</td>
                            <td style="width:40px;padding:6px;">Mitarbeiter</td>
                            <td style="width:100px;padding:6px;">Status</div></td>
                            <td style="width:150px; text-align: right;padding:6px;">Datum</td>
                            <td style="width:200px;padding:6px;padding-left:20px;">Aktion</td>
                            
                        </tr>
                    @endif
                                            
                    @foreach ($searchean as $mean)
                        <tr  style="background-color: {{$staticolor[$mean->EAN_Nummern_Status]}}">
                            <td style="width:150px;padding:6px;">{{$search_bn[$mean->EAN_Nummern_EAN_Basisnummern_Id]->EAN_Basisnummern_Kd}}</td>
                            <td style="width:200px;padding:6px;">{{$mean->EAN_Nummern_EAN}}</td>
                            <td style="width:100px;padding:6px;">{{$mean->EAN_Nummern_IAN}}</td>
                            <td style="width:40px;padding:6px;">@if (isset($u[$mean->EAN_Nummern_MA])){{$u[$mean->EAN_Nummern_MA]}}@endif</td>
                            <td style="width:100px;padding:6px;"><div style="background-color:{{$staticolor[$mean->EAN_Nummern_Status]}};" id="EANStatus{{$mean->EAN_Nummern_Id}}">{{$mean->EAN_Nummern_Status}}</div></td>
                            <td style="width:150px; text-align: right;padding:6px;">{{date('d.m.y', strtotime($mean['EAN_Nummern_LetzteAenderung']))}}</td>
                            <td style="width:200px;padding:6px;padding-left:20px;">
                               @if ($mean->EAN_Nummern_Status == "Gelöscht")
                                     <button style="width:200px;" onclick="deleteEAN({{$mean->EAN_Nummern_Id}},'Freigeben');">Freigeben</button>
                                     <button style="width:200px;margin-top:4px;"  onclick="deleteEAN({{$mean->EAN_Nummern_Id}},'Löschen rückgängig');">Löschen rückgängig</button>
                               @endif
                               @if ($mean->EAN_Nummern_Status == "Frei")
                                     <button style="width:200px;"  onclick="deleteEAN({{$mean->EAN_Nummern_Id}},'Zuordnen');">Zuordnen</button>
                               @endif
                               @if ($mean->EAN_Nummern_Status == "Gültig")
                                     <button style="width:200px;"  onclick="deleteEAN({{$mean->EAN_Nummern_Id}},'Löschen');">Löschen</button>
                               @endif
                            </td>
                        </tr>
                    @endforeach 
                    </table>
                    
                </div>
