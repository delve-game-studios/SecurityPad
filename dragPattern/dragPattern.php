<html>
    <head>
        <script src="/jquery-1.10.2.js"></script>
        <link rel="stylesheet" href="/style.css">
    </head>
    <body>
        <div id="dragPad"></div>
        <script type="text/javascript">
            $(document).ready(function(){
                var $dragPad = document.getElementById('dragPad').getBoundingClientRect();
                var $pass = [];
                var $dragPadcenter = (parseInt($('#dragPad').css('border-radius'))/parseInt(2));
                var XMLlink = "/dragPattern.xml";
                $.ajax({
                    url: XMLlink,
                    method: 'GET',
                    success: function(DATA){
                        var dragItems = DATA.getElementsByTagName('dragItems')[0].getElementsByTagName('item');
                        for(var i = 0;i<9;i++){
                            var value = dragItems[i].getAttribute('value');
                            var active = parseInt(dragItems[i].getAttribute('active'));
                            var x = parseInt(dragItems[i].getAttribute('x')) + parseInt($dragPad.left);
                            var y = parseInt(dragItems[i].getAttribute('y')) + parseInt($dragPad.top);
                            if(active){
                                $('#dragPad').append('<div value="'+value+'" class="dragItem hidden" style="top:'+parseInt($dragPad.top+$dragPadcenter)+'px; left:'+parseInt($dragPad.left+$dragPadcenter)+'px; padding:10px;" x="'+x+'" y="'+y+'">'+value+'</div>');
                            }
                        }
                    }
                });
                $('#dragPad').on('click', function(){
                    $('.dragItem').removeClass('hidden');
                    $('.dragItem').each(function(){
                        $(this).animate({
                            left: $(this).attr('x'),
                            top: $(this).attr('y')
                        }, "slow", function(){
                            $('#dragPad').css('cursor','none');
                        });
                    });
                });
                $(document).on('click', '.dragItem', function(){
                    $(this).animate({
                        left: parseInt($dragPad.left+$dragPadcenter),
                        top: parseInt($dragPad.top+$dragPadcenter),
                        opacity: "0"
                    }, "slow"<?php if(!isset($_REQUEST['bigpass'])){ ?>, function(){
                        $pass.push($(this).attr('value'));
                        $(this).removeClass('dragItem').addClass('hidden');
                        if($('.dragItem').length === 0){
                            $('#dragPad').dblclick();
                        }
                    }<?php } ?>);
                });
                $('#dragPad').on('dblclick', function(){
                    $.ajax({
                        url: XMLlink,
                        method: 'GET',
                        success: function(DATA){
                            var $correct = DATA
                                    .getElementsByTagName('dragItems')[0]
                                    .getElementsByTagName('currentPassword')[0]
                                    .childNodes[0]
                                    .nodeValue;
                            var $p = $pass.join('');
                            if($p === $correct){
                                $('#dragPad').css('background','lime');
                            }else{
                                $('#dragPad').css('background','red');
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>