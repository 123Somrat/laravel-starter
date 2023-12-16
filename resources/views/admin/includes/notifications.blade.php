
@if(!empty(Session::get('msg')))
    <script>
        $.notify({
            icon: 'glyphicon glyphicon-ok',
            title: '<strong>Success:</strong>',
            message: '{{Session::get('msg')}}'
        },{
            type: 'success',
        });
    </script>

@elseif(!empty(Session::get('msgErr')))
<script>
    $.notify({
        icon: 'glyphicon glyphicon-warning-sign',
        title: '<strong>Error:</strong>',
        message: '{{Session::get('msgErr')}}'
    },{
        type: 'danger'
    });
</script>
@endif