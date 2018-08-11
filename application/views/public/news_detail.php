<section id="project">
  <div class="container">
    <div class="section-header">

      <h1 class=" text-left wow fadeInDown"><?=$record->title?></h1>
      <p class="text-left wow fadeInDown">

        <i class="fa fa-user">&nbsp;</i>Posting ID Group&nbsp;&nbsp;
        <i class="fa fa-bookmark-o"></i>&nbsp;<?=$record->category_name?> &nbsp;&nbsp; 
        <i class="fa fa-calendar"></i>&nbsp;<?=$record->created_at?>&nbsp;&nbsp; 
        <?php 
        if(!empty($city_name)){           
          ?>          
          <i class="fa fa-map-marker"></i> <small>Berita ini juga tersedia di <b><?=$city_name?></b></small> 
          
          <?php
        }
        ?>
      </p>
      
    </div>

    <div class="row"> 
      <?php

      if(!empty($record->images_news)){
        $desc_col = 'col-md-7';                
      } else {
        $desc_col = 'col-md-12';                
      }
      ?>
      <div class="<?=$desc_col?>  wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms" align='justify'>
        <?=$record->description?>
        <br>
        <div class="text-left">
          Bagikan berita ini : <br><br>
          <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
            <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
            <a class="a2a_button_facebook"></a>
            <a class="a2a_button_twitter"></a>
            <a class="a2a_button_google_plus"></a>
            <a class="a2a_button_whatsapp"></a>
            <a class="a2a_button_email"></a>
          </div>
          <script async src="https://static.addtoany.com/menu/page.js"></script>
        </div>
      </div><!--/.col-md-4-->
      <?php 
      if(!empty($record->images_news)){                 
        ?>

        <div class="col-md-5 col-sm-12 wow fadeInUp  " data-wow-duration="300ms" data-wow-delay="200ms" style='padding:10px;'>
          <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <?php 
              $num = '0';

              foreach($record->images_news as $each){
                $active = '';
                if($each['thumbnail'] == 'yes'){
                  $active = 'active';
                } 
                echo '<li data-target="#myCarousel" data-slide-to="'.$num.'" class="'.$active.'"></li>';
                $num++;
              }
              ?>
            </ol>
            <div class="carousel-inner">
              <?php
              foreach($record->images_news as $img){
               $active_img = '';
               if($img['thumbnail'] == 'yes'){
                $active_img = 'active';
              } 
              ?>
              <div class="item <?=$active_img?>">
                <img src="<?=$img['url']?>" alt="Los Angeles" style="width:100%;">                            
              </div>
              <?php
            }
            ?>
          </div>
          <!-- Left and right controls -->
          <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>      
    <?php } ?>
  </div>
  <hr>
  <div class="row">       
    <div class="col-md-12">
     <div class="fb-comments" data-href="" data-width="100%" data-numposts="5">
     </div>
   </div>   
   <div class="col-md-12 pull-right">
    Berita ini juga tersedia di wilayah : 
    <br>
    <div id="city_available">

    </div>
  </div>
</div>

<br><br>

</div>
</div>
</section><!--/#pricing-->
<script>
  function set_page_url(){
    $(".fb-comments").attr('data-href',window.location.href);
  }
  set_page_url();
  function cityAvailable(){
    var city_html = '';
    var expand = '';
    $.getJSON("<?=base_url() . 'news/cities' ?>", function(data) {
      
     if(data.data.length == '2'){
      

      $.each(data.data[0], function(i, each_city) {        
       city_html += '<a href="'+each_city.slug+'" class="label label-xs label-default" style="margin-top:5px;">'+each_city.city_name+'</a>&nbsp; ';
     });
      expand += "";
      expand += '<a data-toggle="collapse" data-target="#more" class="btn btn-xs btn-default"><b>Tampilkan Lebih Banyak <i class="fa fa-chevron-down"></i></b></a>';
      expand += '<div id="more" class="collapse">';

      $.each(data.data[1], function(i, each_city2) {
        expand += '<a href="'+each_city2.slug+'" class="label label-xs label-default" style="margin-top:5px;">'+each_city2.city_name+'</a>&nbsp; ';
      });
      expand += '</div>';      


      $("#city_available").append(city_html+expand);
    } else {
      $.each(data.data, function(i, city) {
       city_html += '<a href="'+city.slug+'" class="btn btn-xs btn-default" style="margin-top:5px;">'+city.city_name+'</a>&nbsp; ';
     });
      $("#city_available").append(city_html);
    }  
  })
  }

  cityAvailable();

</script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.12&appId=362734024250643&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

