<div style="width:1000px;heigth:600px;border: 1px solid {{$data['bordercolor']}}; padding:50px;text-align: left;margin:0 auto;margin-top:50px;">
    {{$data['content']}}

    @if (strlen($data['msg'])>1 )
    <div style="border:1px solid lightgray;padding:25px;margin-top:40px;">
        {{$data['msg']}}
    </div>
    @endif

</div>