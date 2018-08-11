        
<section id="project">
  <div class="container">
    <div class="section-header">

      <h1 class="pull-left wow fadeInDown">Semua Berita</h1>
      <h1 class='spin pull-right'><i class="fa fa-refresh fa-spin"></i></h1>
      
    </div>

    <div class="row"> 

     <div class="col-md-12 pull-right">       
      <hr>
      <div class="index-content" id="news_available"> 

      </div>
    </div>
  </div>

  <br><br>

</div>
</div>
</section><!--/#pricing-->
<script>
  function get_news(){
    var news_html = '';
    $.getJSON("<?=base_url() . 'news/json' ?>", function(data) {
     console.log(data);
     if(data.data != ""){
      $.each(data.data, function(i, each) {
        news_html += '<div class="col-lg-4" style="margin-bottom: 10px;">';
        news_html += '<div class="card">';
        news_html += '<img src="'+each.thumb_url+'"  style="height:250px;">';
        news_html += '<h4><a href="'+each.link+'">'+each.title+'</a></h4><hr>';      
        news_html += '<p style="color:black">';
        news_html += '<strong><i class="fa fa-calendar"></i>&nbsp;'+each.created_at+'<br>';
        news_html += '<i class="fa fa-bookmark-o"></i>&nbsp;'+each.category_name+'</strong></p>';
        news_html += "<span style='color:black' style='margin-bottom: 10px;'>"+each.description+"</span><br><br></div></div>";            
      })
      $(".spin").remove();
      $("#news_available").append(news_html);
    }
  })    
  }

  get_news();

</script>


