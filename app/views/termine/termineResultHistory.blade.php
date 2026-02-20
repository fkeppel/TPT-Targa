
<div  class="thRow">
    <div class="thHeader2" style="width:40px;">MA</div>
    <!-- div class="thHeader" style="width:40px;">Receiver</div -->
    <div class="thHeader2" style="width:150px;">Status</div>
    <div class="thHeader2" style="width:120px;">Datum</div>

    <div  class="thHeader2" style="width:100px;">Kategorie</div>
    <div class="thHeader2" style="width:120px;">Erledigen bis</div>
    <div class="thHeader2" style="width:40px;">von</div>
    <div class="thHeader2" style="width:120px;">Erledigt am</div>
    <div class="thHeader2" style="width:550px;">Bemerkung</div>
    <div class="thHeader2" style="width:100px;">Upload</div>
    <div class="thHeader2" style="width:100px;">Aktion</div>
</div>

@foreach($params['logs'] as $log)


<div class="thRow" style="">
    <div  class="thCell" >
        @if (isset($log->PPTermineChanges_Mitarbeiter_Id)){{$params['Mitarbeiter'][$log->PPTermineChanges_Mitarbeiter_Id]}}@endif
    </div>
    <div class="thCell" >@if($log->PPTermineChanges_oldStatus != $log->PPTermineChanges_newStatus){{$log->PPTermineChanges_oldStatus}} => {{$log->PPTermineChanges_newStatus}} @else History-Eintrag @endif</div>
    <div class="thCell" >{{substr($log->PPTermineChanges_Date,0,10)}}</div>
    <div class="thCell">{{$log->PPTermineChanges_Categorie}}</div>
    <div class="thCell">{{substr($log->PPTermineChanges_DoUntil,0,10)}}</div>
    <div  class="thCell" >
        @if (isset($log->PPTermineChanges_Receiver)){{$params['Mitarbeiter'][$log->PPTermineChanges_Receiver]}}@endif
    </div>
    <div class="thCell"'>{{substr($log->PPTermineChanges_DoneAt,0,10)}}</div>
    <div class="thCell">{{$log->PPTermineChanges_Remark}}</div>
    <div class="thCell">@if(strlen($log->URL) > 0)<a href="{{$log->URL}}" target="_blank"><img src="images/download_100x31.jpg" /></a>@endif</div>
    <div class="thCell">@if(strlen($log->PPTermineChanges_DoneAt) <10)
        <button id="btnErledig{{$log->PPTermineChanges_PPTermine_Id}}" onclick="setErledigt({{$log->PPTermineChanges_PPTermine_Id}},{{$log->PPTermineChanges_Id}});">Erledigt</button>
        @endif
    </div>

</div>
@endforeach




<!-- div class="thRow" style="border:4px solid red;">
   <div  class="thCell" style="width:40px;"></div>
   <div class="thCell" style="width:40px;">@if($log->PPTermineChanges_oldStatus != $log->PPTermineChanges_newStatus){{$log->PPTermineChanges_oldStatus}} => {{$log->PPTermineChanges_newStatus}} @else History-Eintrag @endif</div>
   <div class="thCell" style="width:120px;">{{substr($log->PPTermineChanges_Date,0,10)}}</div>
   <div class="thCell" style="width:100px;">{{$log->PPTermineChanges_Categorie}}</div>
   <div class="thCell" style="width:120px;">&nbsp;</div>
   <div class="thCell" style="width:120px;">&nbsp;</div>
   <div class="thCell" style="width:550px;">{{$log->PPTermineChanges_Remark}}</div>
   <div class="thCell" style="width:100px;">@if(strlen($log->URL) > 0)<a href="{{$log->URL}}" target="_blank">File</a>@endif</div>

</div -->
