<style>
    #calcContainer div {
        border:1px solid lightblue;
        font-size: 0.9rem;
        padding:6px;

    }

    #calccontainer input {
        border:none;
        border-radius:0px; 
        margin:0px; 
        height:100%; 
        width:100%; 
        padding:4px; 
        padding-right:6px; 
        text-align: right;
    }
</style>
<?php


$calcs = $data['calcs']['calc'];
$vals = $data['calcs']['values'];
$text = $data['calcs']['containers'];

$colCount = 0;
if (!is_null($calcs)){
    $colCount = count($calcs);
}

$repeat = " ";
if ($colCount > 0){
    $repeat = " repeat( $colCount, 150px ) ";

}
?>


<div style="border:1px solid lightgray; height:835px; padding:6px; overflow: auto; border-radius: 0px;">

    <h1>Lieferantenauswahl</h1>

    <div style="padding:10px;font-weight:bolder;padding-bottom:15px;">Gesamtmenge: {{ number_format($data['pp']->PPProduktpass_Gesamtmenge,0,',','.') }}</div>

    <div id="calcContainer" style="display:grid; grid-template-columns:200px 120px {{ $repeat }} 200px; grid-gap:4px;">
        @if ($colCount > 0)
        <div>Position</div>
        <div style="border:none"></div>
      
        @foreach($calcs as $id => $calc )
            <div style="position:relative; padding-top: 15px;padding:0px;"> 


                <div style="padding:0px;border:none; width:15px; height:15px; position: absolute; top:0px; right: 0px; padding:0px; font-size: 8px;" >
                    <div style="padding:0px;border:none;">
                        <form action="/deleteCalc" id="frmDelete{{ $id }}" method="post" style="margin:0px;">
                            <input type="hidden" name="delCalcId" value="{{ $id }}" >
                            <input type="hidden" name="delppid" value="{{ $data['pp']->PPProduktpass_Id }}" >
                            <button type="button" style="text-align:center;width:15px;height:15px; background-color:red;color:white;padding:0px;border: none;font-size: x-small;"  onclick="frmConfirm({{ $id }});" >X</button>
                        </form>
                    </div>
                </div>
                <div  class="suppl" id="suppl{{ $id }}" style="margin:0px;padding:6px; padding-top: 20px;border:none;@if($calc->PPCalculation_selected) background-color:orange; @endif "   onclick="selectSupplier({{ $id }});">
                    {{ $data['calcSuppliers'][$calc->PPCalculation_SupplierId] -> Matchcode }}
                </div>
                
            </div>
        @endforeach
        @endif
        <div style="padding:0px;border:none;">
            <form action="/newProdCalc" method="post">
                <input type="hidden" name="ppid" value="{{ $data['pp']->PPProduktpass_Id }}" />
                
                <select name="calcProd" style="margin:0px;width: 150px; height:30px;">
                    <option>Auswahl Produzent</option>
                    @foreach ($data['calcSuppliers'] as $id =>  $supplier)
                    <option value="{{ $id  }}">{{ $supplier->Matchcode }}</option>
                    @endforeach
                </select>
                <button style="margin-top:3px;">+</button>
            </form>
        </div>
    </div>

    @if ($colCount > 0)
        <form action="/updateCalc" method="post" style="margin-top:6px;">
            <input type="hidden" name="ppid" value="{{ $data['pp']->PPProduktpass_Id }}" />
            <input type="hidden" name="totalQty" value="{{ $data['pp']->PPProduktpass_Gesamtmenge }}" />
            <div id="calcContainer" style="display:grid; grid-template-columns:200px 120px {{ $repeat }} 200px; grid-gap:4px;">
       
                
           


                <div>Bemerkung</div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                <div style="padding:0px;">
                    <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_Remark]" value="{{ $calc->PPCalculation_Remark }}" />
                </div>
                @endforeach
                <div style="border:none;"></div>

           



                <div>Load 40' HQ</div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                <div style="padding:0px;">
                    <input name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_SupplierLoadHQ]" value="{{ number_format($calc->PPCalculation_SupplierLoadHQ,0,',','.') }}" />
                </div>
                @endforeach
                <div style="border:none;"></div>


                <div>Container</div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                <div style="padding:6px; font-size:x-small;">
                    {{ $text[$id]}}
                </div>
                @endforeach
                <div style="border:none;"></div>



                {{-- TEST --}}
                <div>Währung</div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                    <div style="padding:0px;">
                        @if (strlen($calc->PPCalculation_Currency) > 2 or strlen($data['calcSuppliers'][$calc->PPCalculation_SupplierId] -> PPAdressen_DefaultWsym) < 2)
                        <select style="width:144px; height:24px" name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_Currency]" >
                            <option style="text-align:right;padding-right:6px;" value="">Währung auswählen...</option>
                            <option style="text-align:right;padding-right:6px;" @if ($calc->PPCalculation_Currency == 'EUR') selected="selected" @endif value="EUR">EUR</option>
                            <option style="text-align:right;padding-right:6px;" @if ($calc->PPCalculation_Currency == 'USD') selected="selected" @endif value="USD">USD</option>
                        </select>
                        
                        @else 
                        <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_Currency]" value="{{ $data['calcSuppliers'][$calc->PPCalculation_SupplierId] -> PPAdressen_DefaultWsym  }}" />
                        @endif    
                    </div>
                        
                @endforeach
                <div style="border:none;"></div>

                <div>Kurs</div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                <div style="padding:0px;">
                    <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_ExcR_Calc]" value="{{ number_format($calc->PPCalculation_ExcR_Calc,4,',','.')  }}" />
                </div>
                @endforeach
                <div style="border:none;"></div>


                <div>EK in Währung</div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                <div style="padding:0px;">
                    <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_EK]" value="{{ number_format($calc->PPCalculation_EK,2,',','.')  }}" />
                </div>
                @endforeach
                <div style="border:none;"></div>

                <div>EK-Provision %</div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:0px;">
                        @if ($calc->PPCalculation_EKProvision > 0 )
                        <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_EKProvision]" value="{{ number_format($calc->PPCalculation_EKProvision,2,',','.' ) }}" />
                        @else 
                        <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_EKProvision]" value="{{ number_format( $data['calcSuppliers'][$calc->PPCalculation_SupplierId] -> PPAdressen_DefaultProvision ,2,',','.')  }}" />
                        @endif    
                    </div>
                        
                @endforeach
                <div style="border:none;"></div>


                <!-- div>Abgangshafen</!-div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                <div> {{ $data['calcSuppliers'][$calc->PPCalculation_SupplierId] -> PPAdressen_Abgangshafen }}</div>
                @endforeach
                <div style="border:none;"></div -->


                    <div>Fracht</div>
                    <div style="border-radius:0px;border:none;padding:0px;"></div>
                    @foreach($calcs as $id => $calc )
                        <div style="text-align:right;padding:0px; ">
                            <input style="@if($calc->PPCalculation_Ausgangsfrachten <= 0) background-color:red; @endif"  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_Ausgangsfrachten]" value="{{ number_format($calc->PPCalculation_Ausgangsfrachten,2,',','.' ) }}" />
                        </div>
                    @endforeach
                    <div style="border:none;"></div>
    
                    <div>Fracht / Stk</div>
                    <div style="border-radius:0px;border:none;padding:0px;"></div>
                    @foreach($calcs as $id => $calc )
                        <div style="text-align:right;padding:6px;">
                            @if ($data['pp']->PPProduktpass_Gesamtmenge <> 0)
                           {{ number_format($calc->PPCalculation_Ausgangsfrachten/$data['pp']->PPProduktpass_Gesamtmenge,4,',','.' ) }}
                           @endif
                        </div>
                    @endforeach
                    <div style="border:none;"></div>
    
        
                <div>Zölle %</div>
                <div style="border-radius:0px;border:1px solid lightgray;padding:0px;"><input name="allval[PPCalculation_Zoll]" style="border-radius:0px; margin:0px;border:none;width:100%;height:100%;padding:4px; padding-right:6px; text-align:right;"/></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:0px;">
                        <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_Zoll]" value="{{ number_format($calc->PPCalculation_Zoll,4,',','.' ) }}" />
                    </div>
                        
                @endforeach
                <div style="border:none;"></div>

                <div style="border:1px solid green;border-radius:0px;">Einstandspreis</div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:4px; padding-right:6px; border:1px solid green;border-radius: 0px;">
                        {{ number_format($vals[$id]['ESP'],3,',','.') }}  
                    </div>
                @endforeach
                <div style="border:none;"></div>


                <div>Sonstige Kosten %VK</div>
                <div style="border-radius:0px;border:1px solid lightgray;padding:0px;"><input name="allval[PPCalculation_KostenProz]" style="border-radius:0px; margin:0px;border:none;width:100%;height:100%;padding:4px; padding-right:6px; text-align:right;"/></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:0px;">
                        @if ($calc->PPCalculation_KostenProz > 0 )
                        <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_KostenProz]" value="{{ number_format($calc->PPCalculation_KostenProz,4,',','.' ) }}" />
                        @else 
                        <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_KostenProz]" value="{{ number_format( $data['AusmusterungStamm']->AusmusterungStamm_kosten_sonstigeVK ,4,',','.')  }}" />
                        @endif    
                    </div>
                @endforeach
                <div style="border:none;"></div>

                <div>Finanzierungskosten %</div>
                <div style="border-radius:0px;border:1px solid lightgray;padding:0px;"><input name="allval[PPCalculation_Finanzierungskosten]" style="border-radius:0px; margin:0px;border:none;width:100%;height:100%;padding:4px; padding-right:6px; text-align:right;"/></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:0px;">
                        @if ($calc->PPCalculation_Finanzierungskosten > 0 )
                        <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_Finanzierungskosten]" value="{{ number_format($calc->PPCalculation_Finanzierungskosten,4,',','.' ) }}" />
                        @else 
                        <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_Finanzierungskosten]" value="{{ number_format( $data['AusmusterungStamm']->AusmusterungStamm_kosten_finanzierung ,4,',','.')  }}" />
                        @endif    
                    </div>
                @endforeach
                <div style="border:none;"></div>
             
                {{-- 
                <div>Sonderkosten je Container</div>
                <div style="border-radius:0px;border:1px solid lightgray;padding:0px;"><input name="allval[x]" style="border-radius:0px; margin:0px;border:none;width:100%;height:100%;padding:4px; padding-right:6px; text-align:right;"/></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:0px;">
                      
                        
                          
                    </div>
                @endforeach
                <div style="border:none;"></div>   
                --}}
                
            
                <div>Prüfkosten / Stück</div>
                <div style="border-radius:0px;border:1px solid lightgray;padding:0px;"><input name="allval[PPCalculation_Pruefkosten]" style="border-radius:0px; margin:0px;border:none;width:100%;height:100%;padding:4px; padding-right:6px; text-align:right;" placeholder="Gesamtkosten"/></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:0px;">
                      
                        <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_Pruefkosten]" value="{{ number_format($calc->PPCalculation_Pruefkosten,4,',','.' ) }}" />
                          
                    </div>
                @endforeach
                <div style="border:none;"></div>

                <div>Lizenzgebühren %</div>
                <div style="border-radius:0px;border:1px solid lightgray;padding:0px;"><input name="allval[PPCalculation_Lizenzgebuehren]" style="border-radius:0px; margin:0px;border:none;width:100%;height:100%;padding:4px; padding-right:6px; text-align:right;" placeholder="Lizenz %"/></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:0px;">
                      
                        <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_Lizenzgebuehren]" value="{{ number_format($calc->PPCalculation_Lizenzgebuehren,4,',','.' ) }}" />
                          
                    </div>
                @endforeach
                <div style="border:none;"></div>

                <div>Sonstige Kosten / Stück</div>
                <div style="border-radius:0px;border:1px solid lightgray;padding:0px;"><input name="allval[PPCalculation_Kosten]" style="border-radius:0px; margin:0px;border:none;width:100%;height:100%;padding:4px; padding-right:6px; text-align:right;" placeholder="Gesamtkosten"/></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:0px;">
                      
                        <input  name="calc[{{ $calc->PPCalculation_Id }}][PPCalculation_Kosten]" value="{{ number_format($calc->PPCalculation_Kosten,4,',','.' ) }}" />
                          
                    </div>
                @endforeach
                <div style="border:none;"></div>

                <div>Fracht</div>
                <div style="border-radius:0px;border:1px solid lightgray;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:6px;">
                      
                        {{ number_format($calc->PPCalculation_Fracht,2,',','.' ) }}
                          
                    </div>
                @endforeach
                <div style="border:none;"></div>

                <div>Fracht/Stk</div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:6px;">
                      
                        @if ($data['pp']->PPProduktpass_Gesamtmenge <> 0)
                        {{ number_format($calc->PPCalculation_Fracht/$data['pp']->PPProduktpass_Gesamtmenge,4,',','.' ) }}
                        @endif
                          
                    </div>
                @endforeach
                <div style="border:none;"></div>

                <div style="border:1px solid green;border-radius:0px;">Selbstkostenspreis</div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:4px; padding-right:6px; border:1px solid green;border-radius: 0px;">
                        {{ number_format($vals[$id]['SKP'],3,',','.') }}  
                    </div>
                @endforeach
                <div style="border:none;"></div>

                <div style="border:1px solid green;border-radius:0px;">Verkaufspreis EUR</div>
                <div style="border-radius:0px;border:1px solid lightgray;padding:0px;"><input name="allval[PPCalculation_VK]" style="border-radius:0px; margin:0px;border:none;width:100%;height:100%;padding:4px; padding-right:6px; text-align:right;"/></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right; padding:6px; border:1px solid green;border-radius: 0px;">
                        {{ number_format($calc->PPCalculation_VK,2,',','.' ) }}
                    </div>
                @endforeach
                <div style="border:none;"></div>

                <div style="border:1px solid green;border-radius:0px;">Verkaufspreis -0,3% EUR</div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:4px; padding-right:6px; border:1px solid green;border-radius: 0px;">
                        {{ number_format($vals[$id]['VK03'],3,',','.') }}  
                    </div>
                @endforeach
                <div style="border:none;"></div>

                <div style="border:1px solid green;border-radius:0px;">EK-Volumen EUR</div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                    <div style="text-align:right;padding:4px; padding-right:6px; border:1px solid green;border-radius: 0px;">
                        {{ number_format($vals[$id]['EKVol'],0,',','.') }}  
                    </div>
                @endforeach
                <div style="border:none;"></div>

                <div style="border:1px solid green;border-radius:0px; background-color:lightslategray; color:white;">Marge</div>
                <div style="border-radius:0px;border:none;padding:0px;"></div>
                @foreach($calcs as $id => $calc )
                    <div class="marge" id="marge{{ $id }}" style="text-align:right;padding:4px; padding-right:6px; border:1px solid green; background-color:lightslategray; color:white; border-radius: 0px;">
                        @if ($vals[$id]['VK03'] <> 0)
                        {{ number_format(($vals[$id]['VK03'] - $vals[$id]['ESP']) / $vals[$id]['VK03'] * 100 ,2,',','.') }}%
                        @endif
                    </div>
                @endforeach
                <div style="border:none;"></div>



            </div>
            <div style="padding-top:15px;">
                <button type="submit" style="width:200px;height: 30px;background-color:dodgerblue; color: white; border:1px solid gray;"><b>Speichern</b></button>
            </div>
            
        </form>

      
        
    @endif


</div>

<script>

    function selectSupplier (id){
      
        
        if (!confirm("Wollen sie dieser Lieferant gewählt werden? ")){
            return;
        }
        
        var elements = document.getElementsByClassName('suppl');
        for (var i=0; i<elements.length; i++) {
            elements[i].style.backgroundColor = '';
        }
        var div = document.getElementById('suppl' + id);
        div.style.backgroundColor = "orange";

           
        $.ajax({
            url: "/selectCalcSupplier",
            method: 'post',
            data: {
                id: id
            },
            success: function(result){
                console.log(result);                
            }});
    }

    function frmConfirm( id) {

        message="Kalkulation für diesen Lieferanten wirklich löschen?"
        if (confirm(message)){
           
          
            var frm = document.getElementById('frmDelete'+id);
            frm.submit();

        } 
        return false;
    }
</script>