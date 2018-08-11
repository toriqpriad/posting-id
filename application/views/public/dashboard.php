<section id="main-slider"> 
    <div class="owl-carousel hidden-xs">
        <div class="item" style="background-image: url(<?= FRONTEND3_STATIC_FILES ?>images/slider/pid.jpg); ">
            <div class="slider-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="carousel-content">
                                <h2><font color="#2578B6">PostingID </font> <font color="#f39255">Group</font></h2>
                                <p>Positive Thinking Indonesia Group</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.item-->
        <div class="item" style="background-image: url(<?= FRONTEND3_STATIC_FILES ?>images/slider/institute.jpg);">
            <div class="slider-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="carousel-content" style='margin-top:-46px;'>
                                <h2><font color="#2578B6">PostingID </font>Institute</h2>
                                <p>Edukasi Wirausaha, Konsultan, Manajemen, Marketing dan Komunikasi Bisni</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item" style="background-image: url(<?= FRONTEND3_STATIC_FILES ?>images/slider/property.jpg);">
            <div class="slider-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="carousel-content">
                                <h2><font color="#2578B6">PostingID</font> Properti</h2>
                                <p> Developer, Kontraktor dan Agen Pemasaran Properti</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.item-->
        <div class="item" style="background-image: url(<?= FRONTEND3_STATIC_FILES ?>images/slider/franchise.jpg);">
            <div class="slider-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="carousel-content">
                                <h2><font color="#2578B6">PostingID </font> Franchiseholic</h2>
                                <p>Pengembangan produk Waralaba Lokal dan UMKM ( Creativepreneur )</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.item-->
        <div class="item" style="background-image: url(<?= FRONTEND3_STATIC_FILES ?>images/slider/itdev.jpg);">
            <div class="slider-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="carousel-content" style='margin-top:-46px;'>
                                <h2><font color="#2578B6">PostingID </font>IT Development</h2>
                                <p>Software House, Web Development, Programming, Internet Marketing, Cyber, Desain & Multimedia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.item-->
    </div><!--/.owl-carousel-->
</section><!--/#main-slider-->

<section id="hero-text" class="wow fadeIn">    
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h3 style='color:white'>Positive Thinking Indonesia Group </h3>
                <p align="center">Sesuai namanya, bergerak fokus menyebarkan energipositif di seluruh Indonesia melalui spirit entrepreneur di segenap lapisan masyarakat, baik tua dan muda. Bagi PostingID Group, penanaman nilai-nilai entrepreneur muda layak diberikan kepada siapa pun, kapan pun dan dimana pun. <b>PostingID Group, We Will Help You To Be Positive.</b>
                </p>
            </div>
            
            <div id="news">                
                <div class="col-md-12 text-left">                            
                    <div class="index-content">    
                        <?php
                        if(isset($news)){
                            foreach($news as $each){
                                ?>
                                <div class="col-lg-4" style='margin-bottom: 10px;'>
                                    <div class="card">
                                        <img src="<?=$each->thumb_url?>"  style="height:250px;">
                                        <h4><a href="<?=$each->link?>"><?=$each->title?></a></h4>
                                        <hr>
                                        <p style='color:black'>
                                            <strong><i class="fa fa-calendar"></i>&nbsp;<?=$each->created_at?><br>
                                               <i class="fa fa-bookmark-o"></i>&nbsp;<?=$each->category_name?></strong>
                                           </p>                   

                                           <span style='color:black' style='margin-bottom: 10px;'>
                                            <?=$each->description?>
                                        </span>
                                        
                                        <br>                                        
                                        <br>                                        
                                    </div>                                    
                                </div>
                                <?php 
                            }
                        }
                        ?>                                                                
                        <div class="col-md-12 text-center">
                            <a href="<?=PUBLIC_WEBAPP_URL?>news/">
                                <h3 style='color:white'>Berita Lebih Banyak <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></h3>
                            </a>
                        </div>                        
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>
</section><!--/#hero-text-->


<section id="product" >
    <div class="container">
        <div class="section-header">
            <h2 class="section-title text-center wow fadeInDown">Divisi Usaha Kami</h2>
            <p class="text-center wow fadeInDown">POSTING ID GROUP merupakan holding company yang mengembangkan berbagai lini bisnis berbasis kebutuhan masyarakat. Antara lain sebagai berikut : </p>
        </div>

        <div class="row">
            <div class="features">

                <div class="col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                    <div class="media service-box">
                        <div class="pull-left">
                            <i class="fa fa-university"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href='http://institute.posting-id.com'>PostingID Institute</a></h4>
                            <p align="justify">Sebuah layanan edukasi wirausaha, yang bergerak membantu visi dan misi PostingID Group dalam menyebarkan energi positif di kalangan enterpreneur dan atau dunia usaha. PostingID Institute juga menyediakan layanan konsultan bisnis, manajemen bisnis, dan marketing & komunikasi bisnis.</p><br>
                            <a class="btn btn-success btn-md" href='http://institute.posting-id.com'>Lihat Bisnis Kami </a>
                        </div>
                    </div>
                </div><!--/.col-md-4-->


                <div class="col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="0ms">
                    <div class="media service-box">
                        <div class="pull-left" >
                            <i class="fa fa-home"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href='http://properti.posting-id.com'>PostingID Properti</a></h4>
                            <p align="justify">Bergerak di bidang developer, kontraktor dan agensi properti dengan tagline <b>Your Trust Is Our Priority</b>.Posting ID Properti berkomitmen mengembangkan dan memasarkan project - project berkualitas, dengan lingkungan terbaik dan cara pembayaran yang aman dan terjangkau.</p>
                            <br><a class="btn btn-success btn-md" href='http://properti.posting-id.com'>Lihat Bisnis Kami </a>

                        </div>
                    </div>
                </div><!--/.col-md-4-->

                <div class="col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="100ms">
                    <div class="media service-box">
                        <div class="pull-left">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href='http://franchiseholic.posting-id.com'>PostingID Franchiseholic</a></h4>
                            <p align="justify">Sebuah lini bisnis yang fokus menggarap pengembangan industri waralaba lokal dan mengangkat potensi produk-produk kreatif (UMKM) lebih terarah dan terukur. Posting ID Franchisecholic konsisten mengembangkan produk - produk dan jasa terbaik masyarakat Indonesia yang dikemas secara profesional dan kekinian.</p>
                            <br><a class="btn btn-success btn-md" href='http://franchiseholic.posting-id.com'>Lihat Bisnis Kami </a>
                        </div>
                    </div>
                </div><!--/.col-md-4-->

                <div class="col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                    <div class="media service-box">
                        <div class="pull-left">
                            <i class="fa fa-desktop"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href='http://itdev.posting-id.com'>PostingID IT Development</a></h4>
                            <p align="justify">Sebuah usaha dibidang teknologi informasi dan desain digital dengan mengusung konsep Software House, diantaranya ; jasa pembuatan web development, programming, penciptaan aplikasi, design grafis dan lain-lain.</p>
                            <br><a class="btn btn-success btn-md" href='http://itdev.posting-id.com'>Lihat Bisnis Kami </a>
                        </div>
                    </div>
                </div><!--/.col-md-4-->

            </div>
        </div><!--/.row-->    
    </div><!--/.container-->
</section><!--/#services-->

<section id="project">
    <div class="container">
        <div class="section-header">
            <br><br><br><br>
            <h2 class="section-title text-center wow fadeInDown">Project Pengembangan</h2>
            <p class="text-center wow fadeInDown">Berdasarkan bidang produk usaha yang sedang dikembangkan, kami juga mengembangkan project branding untuk bidang tersebut, diantaranya adalah sebagai berikut :  </p>
        </div>

        <div class="row"> 
            <div class="col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                <div class="media service-box">
                    <div class="pull-left">
                        <img src="<?= FRONTEND3_STATIC_FILES ?>images/slider/thl.png" class="img img-responsive" style='width:150px;'>

                    </div>
                    <div class="media-body">
                        <a href='http://thl.posting-id.com'><h4 class="media-heading">Toyomarto Heritage Land (THL)</h4></a>
                        <p align="justify">Sebuah Produk PostingID Properti yang merupakan kawasan tanah kavling dan hunian dengan lokasi dan view terbaik dan sistem pembayaran termudah tanpa bank tanpa bunga tanpa denda tanpa sita, dengan misi mewujudkan impian masyarakat dalam memiliki hunian murah dan terjangkau</p>
                        <br><a class="btn btn-success btn-md" href='http://thl.posting-id.com'>Lihat Bisnis Kami </a>
                        <br>
                    </div>
                </div>
            </div><!--/.col-md-4-->

            <div class="col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                <div class="media service-box">
                    <div class="pull-left">
                        <img src="<?= FRONTEND3_STATIC_FILES ?>images/slider/pid.png" class="img img-responsive" style='width:150px;'>
                    </div>
                    <div class="media-body">
                        <a href=''><h4 class="media-heading">PostingID  Agent</h4></a>
                        <p align="justify">Sebuah persembahan dari PostingID  Properti, merupakan jasa agency property nasional dengan tim profesional di kelasnya, menawarkan jasa jual, beli dan sewa properti.</p>
                        <br><a class="btn btn-success btn-md" href='http://properti.posting-id.com'>Lihat Bisnis Kami </a>
                    </div>
                </div>
            </div><!--/.col-md-4-->
        </div>
        <div class="row"> 
            <div class="col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                <div class="media service-box">
                    <div class="pull-left">
                        <!--<i class="fa fa-home"></i>-->
                        <img src="<?= FRONTEND3_STATIC_FILES ?>images/slider/bigstone.png" class="img img-responsive" style='width:150px;'>
                    </div>
                    <div class="media-body">
                        <a href='http://franchiseholic.posting-id.com'><h4 class="media-heading">Big Stone Crispy</h4></a>
                        <p align="justify">Salah satu project franchising andalan yang ada dalam PostingID Franchiseholic. Gerai Usaha yang menyajijan produk olahan makanan cepat saji yang halal, unik, nikmat dan murah</p>
                        <br><a class="btn btn-success btn-md" href='http://bigstone.posting-id.com'>Lihat Bisnis Kami </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                <div class="media service-box">
                    <div class="pull-left">
                        <img src="<?= FRONTEND3_STATIC_FILES ?>images/slider/bigtea.png" class="img img-responsive" style='width:150px;'>
                    </div>
                    <div class="media-body">
                        <a href='http://franchiseholic.posting-id.com'><h4 class="media-heading">Bigtea</h4></a>
                        <p align="justify">Sebuah Persembahan dari PostingID  Franchiseholic, gerai usaha yang menyajikan menu pilihan minuman teh kekinian yang disukai dan jadi favorit</p>
                        <br><a class="btn btn-success btn-md" href='http://bigtea.posting-id.com'>Lihat Bisnis Kami </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">             
            <div class="col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                <div class="media service-box">
                    <div class="pull-left">
                        <img src="<?= FRONTEND3_STATIC_FILES ?>images/slider/pidinstitute.jpeg" class="img img-responsive" style='width:150px;'>
                    </div>
                    <div class="media-body">
                        <a href='http://institute.posting-id.com'><h4 class="media-heading">PostingID  Institute</h4></a>
                        <p align="justify">Merupakan persembahan dari PostingID Group dalam menyediakan layanan edukasi wirausaha, konsultasi bisnis, seperti marketing dan komunikasi, leadership, manajemen, dll.</p>
                        <br><a class="btn btn-success btn-md" href='http://institute.posting-id.com'>Lihat Bisnis Kami </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                <div class="media service-box">
                    <div class="pull-left">
                        <img src="<?= FRONTEND3_STATIC_FILES ?>images/slider/tpm2.png" class="img img-responsive" style='width:150px;height: 155px;'>
                    </div>
                </div>
                <div class="media-body">
                    <a href='http://technopostmedia.posting-id.com'><h4 class="media-heading">Techno Post Media</h4></a>
                    <p align="justify">Sebuah Persembahan dari PostingID IT Development, sebuah usaha jada teknologi informasi, menyediakan produk dan jasa berbasis IT dan Design seperti pembuatan Web Design, Digital Desain, Sistem Informasi berbasis Online , dll</p>
                    <br><a class="btn btn-success btn-md" href='http://technopostmedia.posting-id.com'>Lihat Bisnis Kami </a>
                </div>
            </div>

        </div>
        <div class="row"> 
            
            <div class="col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                <div class="media service-box">
                    <div class="pull-left">
                        <img src="<?= FRONTEND3_STATIC_FILES ?>images/slider/pid.png" class="img img-responsive" style='width:150px;height: 155px;'>
                    </div>
                    <div class="media-body">
                        <a href='https://iklamedia.com'><h4 class="media-heading">Iklamedia</h4></a>
                        <p align="justify">Sebuah persembahan dari PostingID IT Development, merupakan Marketplace khusus jual beli properti, memudahkan masyarakat untuk menjual dan mencari kebutuhan properti di Indonesia.</p>
                        <br><a class="btn btn-success btn-md" href='http://technopostmedia.posting-id.com'>Lihat Bisnis Kami </a>
                    </div>
                </div>
            </div>

        </div>
    </div>        
</section><!--/#pricing-->
<br>
<section id="about">
    <div class="container">
        <div class="row">

            <div class="col-sm-12 wow fadeInRight">
                <h3 class="column-title">Tentang Kami</h3>
                <p align="justify">
                 Positive Thinking Indonesia Group (PostingID Group) lahir dari PostingID Institute, sebuah wadah bisnis yang didirikan oleh Sam Iponk (Ahmad Baits Diponegoro, S.H.I., S.H.) dan Kang Apik ( Apik Syamsul Rijal, S.Sos. ), keduanya merupakan pengusaha muda, konsultan bisnis, dan penulis buku. PostingID Group sebagai holding company, memiliki Visi, Misi dan Nilai Dasar.

             </p>
             <p align="justify">Kami hadir ingin memberikan warna dan energy postif bagi masyarakat umum dan kalangan bisnis.Sebagai suatu gerakan bisnis yang concern membantu masyarakat, mahasiswa, pelajar, pengusaha UKM, pensiunan yang ingin berwiraswasta atau yang ingin mewaralabakan usaha ataukah perusahaan-perusahaan/ instansi yang butuh memotivasi karyawan-karyawannya untuk meningkatkan kinerja dan daya saing. </p>
         </div>

     </div>
     <br><br><br>
     <div class="row">
        <div class="col-sm-6 hidden-xs wow fadeInLeft">
            <img class="img-responsive" src="<?= FRONTEND3_STATIC_FILES ?>images/slider/about.jpg" alt="">
        </div>
        <div class='col-sm-6 col-xs-12 wow fadeInRight '>
            <h3 class="column-title">Visi & Misi</h3>
            <b>Visi : </b>
            <p align="">Menjadi sebuah perusahaan besar yang berkembang menyebarkan energi positif melalui jalur entrepreneur</p>
            <b>Misi : </b>
            <p align="">
                Memberikan layanan jasa dan produk-produk terbaik dan berkualitas.
                <br>
                Menjadi perusahaan yang amanah
                <br>
                Memberikan layanan yang ramah, sopan santun
                <br>
                Membangun kemitraan lintas bisnis dan sektoral
                <br>
                Memberikan kesempatan kepada seluruh anak negeri
                dalam rangka menanamkan nilai-nilai enterpreneur
                <br>
                Menjunjung tinggi visi perusahaan dalam menyebarkan 
                energi positif ke seluruh Indonesia
            </p>
        </div>



    </div>
    <br><br><br>
    <div class="row">
      <div class="col-sm-6 col-xs-12 wow fadeInRight">
          <h3 class="column-title">Filosofi Lambang & Logo</h3>
          <p align="justify">
              <b>Logo : </b><br>
              Berbentuk Huruf P melambangkan Positif.<br>
              Huruf P luar melengkung melambangkan gerakan yang
              dinamis dan semangat inovasi di perusahaan. <br>
              Huruf P dalam tajam melambangkan optimisme.<br>
              <b>Warna :</b><br>
              Warna biru melambangkan perusahaan yang seimbang, dan
              memiliki ketenangan dalam berbisnis, serta penegasan
              dalam jati diri perusahaan yang tangguh, terpercaya
              dan berpengalaman.<br>
              Warna Orange melambangkan perusahaan yang penuh
              kesenangan, keceriaan dan kebahagiaan filosofi ini
              mengacu juga pada visi PostingID untuk menyebarkan
              energi positif dengan kebih antusias.<br>
              Warna abu-abu melambangkan elegan dam keteduhan
              perusahaan
          </p>
      </div>
      <div class="col-sm-6 hidden-xs wow fadeInRight"><br><br><img class="img-responsive" src="<?= FRONTEND3_STATIC_FILES ?>images/logo-2.png" alt="" ></div>      
  </div>

  <br><br><br>
  <div class="row">
    <div class="col-sm-6 hidden-xs wow fadeInRight"><img class="img-responsive" src="https://thebookchiefblog.files.wordpress.com/2017/10/body_reading.jpg?w=400&h=200&crop=1" alt="" style='height:50%' ></div>      
    <div class="col-sm-6 col-xs-12 wow fadeInRight">
      <h3 class="column-title">Nilai Dasar</h3>
      <p align="justify"> <b>Lima Nilai Dasar PostingID Group :</b> <br>
         Berfikir dan Berjiwa Besar (Albaqoroh : 284)<br>
         Optimisme (Ar - Ra'du : 11)<br>
         Keikhlasan (Al - Insyirah : 5-8)<br>
         Kerjasama dan Tolong Menolong (Al - Maidah : 2)<br>
         Kepedulian Sosial (Al - Ma'un 1-7)<br>
         <br>
         PostingID GROUP hadir dengan keragaman dan energi positif yang konsisten membantu masyarakat Indonesia melalui jalur enterpreneur.
         <br>
         <b>Bergabunglah bersama kami dan wujudkan Indonesia yang lebih positif, berperadaban dan berkemajuan.</b>
     </p>

 </div>

</div>

</div>
</section><!--/#about-->
<section id="ourteam" class="section teams">
    <div class="container">
        <div class="section-header">
            <br><br><br><br>
            <h2 class="section-title text-center wow fadeInDown">Tim Kami</h2> 
            <p class="text-center wow fadeInDown"></p>
        </div>
        <div class="row"> 
            <div class="col-md-4 menuItem">     
                <ul class="menu">
                    <li>                
                        <center><img src="<?= FRONTEND3_STATIC_FILES ?>images/slider/samiponk.jpg" alt="" class="img-responsive">
                            <br>
                            <strong>Sam Iponk</strong>
                            <br><br>
                            <div class="detail">CEO POSTINGID GROUP</div>
                        </center>
                    </li>                    
                </ul>
            </div>
            <div class="col-md-4 menuItem">     
                <ul class="menu">
                    <li>                
                        <center>
                            <img src="<?= FRONTEND3_STATIC_FILES ?>images/slider/kgapik.jpg" alt="" class="img-responsive">
                            <br>
                            <strong>Kang Apik</strong>
                            <br><br>
                            <div class="detail">PRESIDEN POSTINGID GROUP</div>
                        </center>
                    </li>                    
                </ul>
            </div>
            <div class="col-md-4 menuItem">  
                <ul class="menu">
                    <li>                
                        <center>
                            <img src="<?= FRONTEND3_STATIC_FILES ?>images/slider/paidi.jpg" alt="" class="img-responsive">
                            <br>
                            <strong>Achmad Supaidi</strong>
                            <br><br>
                            <div class="detail">DEVCON POSTINGID PROPERTY</div>
                        </center>
                    </li>                    
                </ul>
            </div>
        </div>  
        <div class="row"> 
            <div class="col-md-4 menuItem">     
                <ul class="menu">
                    <li>                
                        <center>
                            <img src="<?= FRONTEND3_STATIC_FILES ?>images/slider/tofan.jpg" alt="" class="img-responsive">
                            <br>
                            <strong>Moh. Taufan Promono</strong>
                            <br><br>
                            <div class="detail">MANAGER POSTINGID  IT DEVELOPMENT</div>
                        </center>    
                    </li>                    
                </ul>
            </div>
            <div class="col-md-4 menuItem">     
                <ul class="menu">
                    <li>                    
                        <center>
                            <img src="<?= FRONTEND3_STATIC_FILES ?>images/slider/yayan.jpg" alt="" class="img-responsive">
                            <br>
                            <strong>Ditya Muhsan</strong>
                            <br><br>
                            <div class="detail">MANAGER POSTINGID  FRANCHISEHOLIC</div>
                        </center>
                    </li>                    
                </ul>
            </div>
            <div class="col-md-4 menuItem">  
                <ul class="menu">
                    <li>                                
                        <center>
                            <img src="<?= FRONTEND3_STATIC_FILES ?>images/slider/navil.jpg" alt="" class="img-responsive">
                            <br>
                            <strong>Navil Yunus</strong>
                            <br><br>
                            <div class="detail">MANAGER MARKETING POSTINGID  PROPERTI</div>
                        </center>
                    </li>                    
                </ul>
            </div>
        </div> 

    </div>
</section>
<!-- <section id='project'>

    <div class="row" style='background-color: #9099dc' >

      <div class="col-md-9">
        <span><b>Produk Kami Juga Tersedia di Kota - Kota di Indonesia </b></span>
    </div>
    <div class="col-md-3 text-right">
        <a class="btn-transparent" href="<?=base_url() . 'product/city'?>" target="_blank"><i class="fa fa-arrow-right"></i>Lihat Lainnya</a>
    </div>
</div>
<div class="row ">
  <div class="col-md-12">

  </div>
</div>

</section> -->

<!-- <section id="project">
    <div class="container">
        <div class="section-header">
            <br><br><br><br>
            <h2 class="section-title text-center wow fadeInDown">Temukan Kami</h2>

        </div>

        <div class="row"> 
            <div class="col-md-12 col-sm-12 wow fadeInUp pull-left" data-wow-duration="300ms" data-wow-delay="200ms">
                <?php 
                if(!empty($city_available)){
                  foreach($city_available as $city){
                    echo '<a href="'.$city->link.'" class="btn btn-xs btn-default" style="margin-top:5px;">'.$city->city.'</a>&nbsp; ';
                }
            } 
            ?>
        </div>


    </div>
</div>        
</section>  -->


