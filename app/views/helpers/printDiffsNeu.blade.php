<style>
    .theader {
        background-color: lightgray;
    }
    .tsep {
        background-color: lightskyblue;
    }
    td {
        border:1px solid gray;
        padding: 5px;
        border-radius: 0px;
    }
    table{
        border-collapse: collapse;
        width: 1550px;
        font-family: Arial, Helvetica, sans-serif;
    }
    .diffArray {
        font-family: Arial, Helvetica, sans-serif;
        width:100%;
        border-collapse:collapse;
        border:none;
        font-size:12px;
        margin:0px;
        vertical-align:top;
    }
    .diffArray th {
        vertical-align:top;
    }
    .diffArray td {
        vertical-align:top;
    }
</style>
<?php 
    $keys = array();
    if (isset($diffs['keys'])){
        if (!is_null($diffs['keys']) && count($diffs['keys']) > 0){
            $keys = $diffs['keys'];
        }
    }
?>
<div id="printDiff">
    <div>Link zum Produktpass: <a style='text-decoration:none;' href='https://tpt-dev.ad.targa.de/show/{{$diffs['pp']['ppid']}}'>{{$diffs['pp']['ian']}}</a></div>
    <div style="padding:20px;border:1px solid lightgray; text-align: left;">
        {{isset($diffs['message'])?$diffs['message']:''}}
    </div>
    <table class='diffArray' style='border-collapse:collapse;'>
        <tr>
            <td class="theader" style="width: 20%;background-color:lightgray;">XML-Knoten</td>
            <!-- td class="theader" style="width: 20%;">Art</td -->
            <td class="theader" style="width: 25%;background-color:lightgray;">alte Version</td>
            <td class="theader" style="width:  25%;background-color:lightgray;">Aktuelle Version</td>
            <td class="theader" style="width:  25%;background-color:lightgray;">Änderungen</td>
        <tr>
        @if( $diffs['diffs']['diffs'] !== null)
        @foreach ($diffs['diffs']['diffs'] as $k => $diff)
        <?php 
            $d1 = ServiceProvider::printArray($diff['Wert in Datei 1']);
            $d2 = ServiceProvider::printArray($diff['Wert in Datei 2']);
            $showLine = true;
            if ((($d1 === 'Keine Daten' or strlen($d1) == 0) ) and (strlen($d2) == 0 or strcmp($d2,'') == 0 or strcmp($d2,'0') == 0) ){
                $showLine = false;
            }
            if (strpos($diff['Pfad'],'PlanQty') !== false){
                $showLine = false;
            }
        ?>
        @if ($showLine)
            <tr>
                <td style='vertical-align:top;'>{{ ServiceProvider::changePath( isset($diff['Pfad'])?$diff['Pfad']:'NOPATH' )}}</td>
                <td>{{ $d1 }}</td>
                <td>{{ $d2 }}</td>
                <td style='vertical-align:top;'>{{ ServiceProvider::printDiffs($diff['Wert in Datei 1'],$diff['Wert in Datei 2'], $diff['Unterschied']) }}</td>
            </tr>
        @endif
        @endforeach
        @endif
    </table>
</div>
<script>
    function showDiffrence (id){
        //alert('Einblenden:'+ id );
        var elemShow = document.getElementById('diffShow_' + id);
        var elemHide = document.getElementById('diffHide_' + id);
        elemShow.style.display = 'block';
        elemHide.style.display = 'none';
    }
    function hideDiffrence (id){
        //alert('Ausblenden:' + id);
        var elemShow = document.getElementById('diffShow_' + id);
        var elemHide = document.getElementById('diffHide_' + id);
        elemShow.style.display = 'none';
        elemHide.style.display = 'block';
    }
</script>