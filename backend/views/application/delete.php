<div class="wrapper">
    <div class="delete">
        <h4>应用删除后，所有内容也将被立刻删除，不可恢复，请谨慎操作！</h4>
        <div class="delete_btn" onclick="return appDelete()" app_id="<?= $app_id?>">删除应用</div>
    </div>
</div>
<script>
    function appDelete(){
        var a = confirm("确定删除吗？");
        var app_id=$(".delete_btn").attr('app_id');
        if(a== true){
            $.ajax({
                type:'GET',
                url:'index.php?r=application/delete',
                data:'app_id='+app_id,
                success:function(mes){
                    if(mes==1) {
                        alert("删除成功");
                        window.location.href='index.php?r=site/index';
                    }else {
                        alert("删除失败");
                    }
                }
            });
        }
    }

</script>