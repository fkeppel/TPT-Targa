<input id="magicsuggest" class="form-control" name="artikel" style="width:150px;"/>
<script>
$(function() {
    $('#magicsuggest').magicSuggest({
        data:['London', 'Paris','Rom'],
        maxSelection:1,
    });
});
</script>

