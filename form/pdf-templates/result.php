<?php
  $firstName = $entity['first_name'];
  $lastName = $entity['last_name'];
  $userName = $firstName.' '.$lastName;
?>
<style>
  @font-face {
    font-family: "Kepler";
    src: url("<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/fonts/KeplerStd-Regular.eot");
    src: url("<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/fonts/KeplerStd-Regular.eot?#iefix")format("embedded-opentype"),
    url("<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/fonts/KeplerStd-Regular.woff") format("woff"),
    url("<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/fonts/KeplerStd-Regular.ttf") format("truetype");
    font-style: normal;
    font-weight: normal;
  }
  
  @page { margin: 0px; size: 500pt 708pt; }
  body { margin: 0px; font-family: sans-serif; width:500pt; }
  html { margin: 0px; }
  .page_block{
    overflow: hidden;
    width: 100%;
    height: 100%;
    position: relative;
  }
  .page_block .bg_img{
    position: absolute;
    top:0px;
    left: 0px;
    width: 100%;
    height: 100%;
  }
  .page_1_name{
    position: absolute;
    background: #263042;
    font-size: 24pt;
    color: #bcbdc1;
    z-index: 2;
    top: 38%;
    left: 10.2%;
    width: 80%;
    font-weight: 700;
  }
  .title_block{
    position: absolute;
    background: #263042;
    font-size: 24pt;
    color: #fff;
    z-index: 2;
    top: 0px;
    left: 0px;
    width: 100%;
    font-weight: 600;
    font-family: 'Kepler';
    font-size: 14pt;
    padding: 15px 10%;
  }
  .copy_year{
    background: #f9f9f9;
    color: #b4b8bd;
    position: absolute;
    bottom: 3.9%;
    right: 34.8%;
    font-size:10px;
    padding:1px;
  }
</style>

<div class='page_block'>
  <div class="page_1_name">
    <?=$userName?>
  </div>
  <img class="bg_img" src="<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/pdf-pages/pdf-page-1.jpg">
</div>

<div class='page_block'>
  <div class="title_block">
    Personal Mindset Assessment - <?=$userName?>
  </div>
  <img class="bg_img" src="<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/pdf-pages/pdf-page-2.jpg">
  <div class='copy_year'>
    <?=date('Y')?>
  </div>
</div>

<div class='page_block'>
  <div class="title_block">
    Personal Mindset Assessment - <?=$userName?>
  </div>
  <img class="bg_img" src="<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/pdf-pages/pdf-page-3.jpg">
  <div class='copy_year'>
    <?=date('Y')?>
  </div>
</div>

<style>
.score_block{
  color:#233043;
  font-size:24px;
  left:28%;
  top:20%;
  position: absolute;
  z-index: 2;
  width: 74px;
  text-align: center;
  background: transparent;
}
.score_block .srore_text{
  font-size:10px;
  text-align: center;
}
.result_text_1{
  position:absolute;
  width:100%;
  z-index: 2;
  top:12.8%;
  color:#464d5d;
  font-size: 26px;
  text-align: center;
  font-family: 'Kepler';
}
.title_left, .title_right{
  position: absolute;
  top:20.8%;
  z-index: 1;
  color:#233043;
  font-size:18px;
}
.title_left{
  right:73%;
}
.title_right{
  left:73%;
}
.title_bottom{
  position: absolute;
  top:33%;
  z-index: 1;
  color:#fff;
  font-size:18px;
  background: transparent;
  width: 100%;
  text-align: center;
}
.image_result_url{
  width:84%;
  position: absolute;
  top:40%;
  left:8%;
}
.score_block.cell_1{
  margin-left: calc(74px * 0);
}
.score_block.cell_2{
  margin-left: 74px;
}
.score_block.cell_3{
  margin-left: 148px;
}
.score_block.cell_4{
  margin-left: 220px;
    color: #fff;
}
</style>

<!-- RESULT 1 -->
<?php
  $score = (new AnswerHelper)->getScoreFirst($entity);
  $title1 = (new AnswerHelper)->getTitleTopOne((float) $score);
  $title2 = (new AnswerHelper)->getTitleBottomOne((float) $score);

  $titlesTop = explode(' ', $title1);
  $titleLeft = 'Fixed';
  $titleRight = 'Growth';
  $imageName = (new AnswerHelper)->getImageName($title1, 'png');
  $imageUrl = $imageName? $siteUrl.PLUGIN_ANSWER_FORM_URI.'/dist/pdf/new/'.$imageName : null;
  
  $positionScore = (new AnswerHelper)->getScorePositionText($title2);
?>
<div class='page_block'>
  <div class="title_block">
    Personal Mindset Assessment - <?=$userName?>
  </div>
  <div class='score_block <?=$positionScore?>'>
    <?=$score?>
    <div class='srore_text'>
      Raw Score
    </div>
  </div>
  <div class='result_text_1'>
    <?=$title1?>
  </div>
  <div class='title_left'>
    <?=$titleLeft?>
  </div>
  <div class='title_right'>
    <?=$titleRight?>
  </div>
  <div class='title_bottom'>
    <?=$title2?>
  </div>
  <img class="bg_img" src="<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/pdf-pages/pdf-page-4.jpg" />
  <img class='image_result_url' src='<?=$imageUrl?>' />
  <div class='copy_year'>
    <?=date('Y')?>
  </div>
</div>

<!-- RESULT 2 -->
<?php
  $score = (new AnswerHelper)->getScoreSeccond($entity);
  $title1 = (new AnswerHelper)->getTitleTopTwo((float) $score);
  $title2 = (new AnswerHelper)->getTitleBottomTwo((float) $score);

  $titlesTop = explode(' ', $title1);
  $titleLeft = 'Closed';
  $titleRight = 'Open';
  $imageName = (new AnswerHelper)->getImageName($title1, 'png');
  $imageUrl = $imageName? $siteUrl.PLUGIN_ANSWER_FORM_URI.'/dist/pdf/new/'.$imageName : null;
  
  $positionScore = (new AnswerHelper)->getScorePositionText($title2);
?>
<div class='page_block'>
  <div class="title_block">
    Personal Mindset Assessment - <?=$userName?>
  </div>
  <div class='score_block <?=$positionScore?>'>
    <?=$score?>
    <div class='srore_text'>
      Raw Score
    </div>
  </div>
  <div class='result_text_1'>
    <?=$title1?>
  </div>
  <div class='title_left'>
    <?=$titleLeft?>
  </div>
  <div class='title_right'>
    <?=$titleRight?>
  </div>
  <div class='title_bottom'>
    <?=$title2?>
  </div>
  <img class="bg_img" src="<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/pdf-pages/pdf-page-4.jpg" />
  <img class='image_result_url' src='<?=$imageUrl?>' />
  <div class='copy_year'>
    <?=date('Y')?>
  </div>
</div>

<!-- RESULT 3 -->
<?php
  $score = (new AnswerHelper)->getScoreThird($entity);
  $title1 = (new AnswerHelper)->getTitleTopThree((float) $score);
  $title2 = (new AnswerHelper)->getTitleBottomThree((float) $score);

  $titlesTop = explode(' ', $title1);
  $titleLeft = 'Prevention';
  $titleRight = 'Promotion';
  $imageName = (new AnswerHelper)->getImageName($title1, 'png');
  $imageUrl = $imageName? $siteUrl.PLUGIN_ANSWER_FORM_URI.'/dist/pdf/new/'.$imageName : null;
  
  $positionScore = (new AnswerHelper)->getScorePositionText($title2);
?>
<div class='page_block'>
  <div class="title_block">
    Personal Mindset Assessment - <?=$userName?>
  </div>
  <div class='score_block <?=$positionScore?>'>
    <?=$score?>
    <div class='srore_text'>
      Raw Score
    </div>
  </div>
  <div class='result_text_1'>
    <?=$title1?>
  </div>
  <div class='title_left'>
    <?=$titleLeft?>
  </div>
  <div class='title_right'>
    <?=$titleRight?>
  </div>
  <div class='title_bottom'>
    <?=$title2?>
  </div>
  <img class="bg_img" src="<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/pdf-pages/pdf-page-4.jpg" />
  <img class='image_result_url' src='<?=$imageUrl?>' />
  <div class='copy_year'>
    <?=date('Y')?>
  </div>
</div>

<!-- RESULT 4 -->
<?php
  $score = (new AnswerHelper)->getScoreFour($entity);
  $title1 = (new AnswerHelper)->getTitleTopFour((float) $score);
  $title2 = (new AnswerHelper)->getTitleBottomFour((float) $score);

  $titlesTop = explode(' ', $title1);
  $titleLeft = 'Inward';
  $titleRight = 'Outward';
  $imageName = (new AnswerHelper)->getImageName($title1, 'png');
  $imageUrl = $imageName? $siteUrl.PLUGIN_ANSWER_FORM_URI.'/dist/pdf/new/'.$imageName : null;
  
  $positionScore = (new AnswerHelper)->getScorePositionText($title2);
?>
<div class='page_block'>
  <div class="title_block">
    Personal Mindset Assessment - <?=$userName?>
  </div>
  <div class='score_block <?=$positionScore?>'>
    <?=$score?>
    <div class='srore_text'>
      Raw Score
    </div>
  </div>
  <div class='result_text_1'>
    <?=$title1?>
  </div>
  <div class='title_left'>
    <?=$titleLeft?>
  </div>
  <div class='title_right'>
    <?=$titleRight?>
  </div>
  <div class='title_bottom'>
    <?=$title2?>
  </div>
  <img class="bg_img" src="<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/pdf-pages/pdf-page-4.jpg" />
  <img class='image_result_url' src='<?=$imageUrl?>' />
  <div class='copy_year'>
    <?=date('Y')?>
  </div>
</div>

<style>
.price_img_table{
  width:80%;
  left:10%;
  position: absolute;
  top:40%;
  z-index: 2;
}
.image_btn_ghost_link, .image_btn_ghost_link_left, .image_btn_ghost_link_right{
  background: #000;
  position: absolute;
  top:85%;
  left:40.1%;
  width:130px;
  display:table;
  height:28px;
  z-index: 3;
  opacity:0;
}
.image_btn_ghost_link_left{
  left:14%;
}
.image_btn_ghost_link_right{
  left:66%;
}
.image_btn_ghost_text_top, .image_btn_ghost_text_bottom{
  background: #000;
  position: absolute;
  top:55%;
  left:47.1%;
  width:75px;
  display:table;
  height:10px;
  z-index: 3;
  opacity:0;
}
.image_btn_ghost_text_bottom{
  top:79.7%;
  left:44.1%;
  width:79px;
}
</style>

<!-- PRICE TABLE -->
<div class='page_block'>
  <div class="title_block">
    Personal Mindset Assessment - <?=$userName?>
  </div>
  <img class="bg_img" src="<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/pdf-pages/pdf-page-8.jpg">
  <div class='copy_year'>
    <?=date('Y')?>
  </div>
  <img class="price_img_table" src="<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/pdf-pages/price_table.jpg">
  <a class="image_btn_ghost_link" href='https://mindsetlibrary.ryangottfredson.com/' target='_blank'>
    
  </a>
  
  <a class="image_btn_ghost_link_left" href='https://mindsetlibrary.ryangottfredson.com/' target='_blank'>
    
  </a>
  
  <a class="image_btn_ghost_link_right" href='https://mindsetlibrary.ryangottfredson.com/' target='_blank'>
    
  </a>
  
  <a class="image_btn_ghost_text_top" href='https://ryangottfredson.com/resources/#books' target='_blank'>
    
  </a>
  <a class="image_btn_ghost_text_bottom" href='https://ryangottfredson.com/resources/#digital-coaching' target='_blank'>
    
  </a>
</div>

<div class='page_block'>
  <img class="bg_img" src="<?=$siteUrl?>/wp-content/plugins/user-answers-form/dist/pdf-pages/pdf-page-9.jpg">
</div>