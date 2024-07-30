//funcoes gerais

$(function(){
    
    var open = true
    var windowSize = $(window)[0].innerWidth;
    if(windowSize <= 780){
        $('.menu-tabela').css({width: '0',padding: '0'});
        $('.header-tabela i').removeClass('fa-angles-left').addClass('fa-angles-right');
        open = false;
    }
    


   
    $(document).on('click', '.close', function() {
        $('.box-alert').css('display', 'none');
    });
    $('.menu-btn').click(function(){
        if (open) {
            // Menu aberto
            $('.menu-tabela').css({width: '0',padding: '0'});
          //  alert('fechando');
            $('.content,.itens-menu').css('width','100%');
            $('.header-tabela i').removeClass('fa-angles-left').addClass('fa-angles-right');
            open = false;
        } else {
            // Menu fechado
            $('.menu-tabela').css('display', 'block');
            $('.menu-tabela').css('width', '200'),function(){
                open=true;
            };
            $('.content').css('width','calc(100% - 200px');
            $('.header-tabela i').removeClass('fa-angles-right').addClass('fa-angles-left');
            open = true;
        }
    }) 

    $(window).resize(function(){
        windowSize = $(window)[0].innerWidth;
        if(windowSize <= 780){
            $('.menu-tabela').css({width: '0',padding: '0'});
            $('.content,.itens-menu').css('width','100%');
            $('.header-tabela i').removeClass('fa-angles-left').addClass('fa-angles-right');
            open = false;
        }else{
            $('.menu-tabela').css('display', 'block');
            $('.menu-tabela').css('width', '200'),function(){
                open=true;
            };
            $('.content').css('width','calc(100% - 200px');
            $('.header-tabela i').removeClass('fa-angles-right').addClass('fa-angles-left');
            open = true;
        }
    })


    
    
  })