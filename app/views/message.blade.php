<style>
    #cpcmsg {
        width:900px;
        height:200px;
        border:4px solid lightgray;
        padding:30px;
        margin:40px;
        position:relative;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        color:darkblue;
    }
    #cpcmsg .btn {
        width:200px;
        height:20px;
        background-color:dodgerblue;
        padding:20px;
        position:absolute;
        bottom:0;
        right:0;
        color:white;
    }
    #cpmsg .msg {
        width:200px;
        height:20px;
        border:1px solid darkblue;
        background-color:dodgerblue;
        padding:20px;
        position:absolute;
        bottom:0;
        right:0;
        color:white;
    }
</style>
<div id='cpcmsg'>
    <h1>Schade, das hat nicht geklappt!</h1>
    <div  class="msg">
        {{ $Message['Message'] }}
    </div>
    {{-- $Message['BackLink'] --}}
    <a href="javascript:history.back()">
    <div class='btn'>
        Zurück!
    </div>
    </a>
</div>