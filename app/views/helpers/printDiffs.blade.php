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
    <div style="padding:20px;border:1px solid lightgray; text-align: left;">
        {{$diffs['message']}}
    </div>
    <table style="table-layout: fixed;width:1550px;">
        <tr>
            <td class="theader" style="width: 300px;">XML-Knoten</td>
            <td  class="theader" style="width: 200px;">Merkmal</td>
            <td class="theader" style="width: 500px;">alte Version</td>
            <td class="theader" style="width: 500px;">Aktuelle Version</td>
            <td class="theader" style="width: 500px;">Änderungen</td>
        <tr>
        @if( $diffs['diffs'] !== null)
        @foreach ($diffs['diffs'] as $k => $diff)
        <tr >
            <td class="tsep"><b>@if (isset($keys[$k]) and $keys[$k] != null ) {{$keys[$k]}} @else {{$k}} @endif</b></td>
            <td class="tsep"></td>
            <td class="tsep"></td>
            <td class="tsep"></td>
            <td class="tsep"></td>
        </tr>
             @foreach ($diff as $k2 => $d)
                    @if(isset($d['OLD']) and isset($d['NEW']))
                    <tr>
                        <td></td>
                        <td>{{strlen($d['CUSTOMNAME'])>0?$d['CUSTOMNAME']:$k2}}</td>
                        <td>{{is_array($d['OLD'])?json_encode($d['OLD']):$d['OLD'];}}</td>
                        <td>{{is_array($d['NEW'])?json_encode($d['NEW']):$d['NEW'];}}</td>
                        @if ($d['DIFF'] != 'NODATA')
                            @if (strpos($d['DIFF'],'Stru') === false)
                                <td>{{is_array($d['DIFF'])?json_encode($d['DIFF']):$d['DIFF'];}}</td>
                            @else 
                                <td><span style='color:white;background-color:red'>Alt: NULL</span>  <span style='color:white;background-color:green'>Neu: {{$d['OLD']}} </span></td>
                            @endif
                        @else 
                            <td><span style='color:white;background-color:red'>Alt: {{$d['DIFF']}} </span>  <span style='color:white;background-color:green'>Neu: {{$d['OLD']}}</span></td>
                        @endif
                    </tr>
                    @endif
                @endforeach
        @endforeach
        @endif
    </table>
</div>
