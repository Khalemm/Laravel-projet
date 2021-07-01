<!-- REQUIRED SCRIPTS -->

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" 
integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

<script>

$(function(){
    $('#updateProfil').on('submit', function(e){
         e.preventDefault();
         $.ajax({
            url:$(this).attr('action'),
            method:$(this).attr('method'),
            data:new FormData(this),
            processData:false,
            dataType:'json',
            contentType:false,
            beforeSend:function(){
              $(document).find('span.error-text').text('');
            },
            success:function(data){
              if(data.status == 0){
                $.each(data.error, function(prefix, val){
                  $('span.'+prefix+'_error').text(val[0]);
                });
              }else{
                $('#updateProfil')[0].reset();
                $("div.alert").text(data.msg);
                $("div.alert").addClass("alert-success");
                $("<button type='button' class='close' data-dismiss='alert'>×</button>").appendTo("div.alert");
              }
            }
         });
    });

    $('#updateEntreprise').on('submit', function(e){
         e.preventDefault();
         $.ajax({
            url:$(this).attr('action'),
            method:$(this).attr('method'),
            data:new FormData(this),
            processData:false,
            dataType:'json',
            contentType:false,
            beforeSend:function(){
              $(document).find('span.error-text').text('');
            },
            success:function(data){
              if(data.status == 0){
                $.each(data.error, function(prefix, val){
                  $('span.'+prefix+'_error').text(val[0]);
                });
              }else{
                $('#updateEntreprise')[0].reset();
                $("div.alert").text(data.msg);
                $("div.alert").addClass("alert-success");
                $("<button type='button' class='close' data-dismiss='alert'>×</button>").appendTo("div.alert");
              }
            }
         });
    });

    $('#changePassword').on('submit', function(e){
         e.preventDefault();
         $.ajax({
            url:$(this).attr('action'),
            method:$(this).attr('method'),
            data:new FormData(this),
            processData:false,
            dataType:'json',
            contentType:false,
            beforeSend:function(){
              $(document).find('span.error-text').text('');
            },
            success:function(data){
              if(data.status == 0){
                $.each(data.error, function(prefix, val){
                  $('span.'+prefix+'_error').text(val[0]);
                });
              }else{
                $('#changePassword')[0].reset();
                $("div.alert").text(data.msg);
                $("div.alert").addClass("alert-success");
                $("<button type='button' class='close' data-dismiss='alert'>×</button>").appendTo("div.alert");
              }
            }
         });
    });
});
</script>