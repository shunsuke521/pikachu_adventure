$(function(){

  var $option = $('.js-option'),
      $moreOption = $('.js-more-option');

  //行動の選択(ホバー)
  $option.on('mouseover', function(){
    if(!$('.js-move').hasClass('active')){
    $(this).find('.js-move').stop(true).animate({
      opacity:'1'
    },0);
    }
  }),
  $option.on('mouseout', function(){
    $(this).find('.js-move').stop(true).animate({
      opacity:'0'
    },0);
  });

  //行動の選択(クリック)
  $option.on('click', function(){
    $('.js-move').removeClass('active');
    $('.js-more-move').removeClass('active');
    $(this).find('.js-move').addClass('active');
    $('.more-option').removeClass('active');

    if ($('.arrow1').hasClass('active')) {
      $('.more-option').addClass('active');
    }
  });

  //技の選択(ホバー)
  $moreOption.on('mouseover', function(){
    if(!$('.js-more-move').hasClass('active')){
    $(this).find('.js-more-move').stop(true).animate({
      opacity:'1'
    },0);
    }
  }),
  $moreOption.on('mouseout', function(){
    $(this).find('.js-more-move').stop(true).animate({
      opacity:'0'
    },0);
  });

  //技の選択(クリック)
  $moreOption.on('click', function(){
    $('.js-more-move').removeClass('active');
    $(this).find('.js-more-move').addClass('active');
  });


  //文字を一字ずつ表示させる
  $(window).on('load',function(){
  // ここから文字を<span></span>で囲む記述
    $('.history-text').children().andSelf().contents().each(function() {
      if (this.nodeType == 3) {
        $(this).replaceWith($(this).text().replace(/(\S)/g, '<span>$1</span>'));
      }
    });
  // ここから一文字ずつフェードインさせる記述
    $('.history-text').css({'opacity':1});
    for (var i = 0; i <= $('.history-text').children().size(); i++) {
      $('.history-text').children('span:eq('+i+')').delay(50*i).animate({'opacity':1},0);
    };
  });

});
