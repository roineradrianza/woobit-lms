<style type="text/css">
    @page {
      margin: 2.5%;
      background-image: url('<?php echo DIRECTORY; ?>/img/certificado-bg.png');

    }
    h1, h2, h3, h4, h5, h6 {
      font-weight: 400 !important;    
    }
    header{
      position: inline-block;
    }
    .container{
      border: 4px solid #003146;
      height: 1150px
    }
    .title{
        clear: both;
    }

    .certified-title, .certified-subtitle{
      font-family: 'constantia' ;
    }

    .certified-title{
      font-size: 35pt;
    }

    .certified-subtitle{
      font-size: 25pt;
    }

    .full-name{
      font-family: 'greatvibes' !important;
      font-size: 50pt;
      color: #003146;
    }
    .text-center{
        text-align: center;
    }
    .text-right{
        text-align: right;
    }
    .text-uppercase{
      text-transform: uppercase;
    }
    .titleDesc{
        color: #003146;
    }
    .titles{
        margin-top: -20px;
    }
</style>
<body>
  <div class="container">
    <header>
      <div style="width:100%" align="right">
          <img src="<?php echo DIRECTORY; ?>/img/logo.png" width="110px">
      </div>
    </header>
    <div style="margin-top:-40px;margin-bottom: -20px;" align="center">
      <img src="<?php echo DIRECTORY; ?>/img/SVCC.jpg" width="150px">
    </div>
    <div style="width:100%;">
        <h2 class="certified-title text-uppercase text-center" style="margin-bottom: -40px;">Certificado
          <h3 class="certified-subtitle text-uppercase text-center" style="margin-top: 0px;">de Aprobación</h3>
        </h2>
    </div>
    <div style="width:100%;margin-bottom: -65px;">
        <h3 class="text-center" style="font-size: 20pt;"><b>Otorgado a</b></h3>
    </div>
    <div style="width:100%;margin-bottom: -50px; padding: 0px 15px 0px 15px">
      <h3 class="full-name text-center"><?php echo $data['first_name'] ?> <?php echo $data['last_name'] ?></h3>
    </div>
    <div>
      <div style="width: 100%;">
        <div style="width:100%" align="left">
          <div align="left" style="margin-left: 10%">
            <img src="<?php echo DIRECTORY; ?>/img/firma-josesvg.png" style="border-bottom: 1.7px solid black" width="140px">          
          </div>
          <div style="margin-left: 6.5%" align="left">
            <h4 style="font-family: arial !important; font-size: 14pt;"><b>Dr. José Ramón Medina</b></h4>          
          </div>
        </div>
      </div>
      <div style="width: 100%;margin-top:-135px">
        <div style="width:100%" align="right">
          <div align="right" style="width:90%">
            <img src="<?php echo DIRECTORY; ?>/img/firma-armando.png" style="border-bottom: 1.7px solid black" width="140px">      
          </div>
          
          <div style="width:91.5%" align="right">
            <h4 style="font-family: arial !important; font-size: 14pt; text-align: right"><b>Dr. Armando Pineda</b></h4>          
          </div>
        </div>
      </div>
    </div>
    <div style="width: 100%; margin-top:-15px">
      <h4 class="text-center" style="color:#9C9B9B;font-family:arial !important;font-size: 12pt;">
        <b>Por haber aprobado
        <br>
        <span style="font-size: 14pt;">“Curso Básico de Columna 2020”</span> de la
        <br>
        Sociedad Venezolana de Cirugía de Columna
        </b>
      </h4>
    </div>
    <div>
      <h3 class="text-center text-uppercase" style="font-family: arial !important; margin-top: -15px;"><b>40 horas académicas / 27 horas crédito</b></h3>
    </div>
    <div style="width: 100%;" align="center">
      <img src="<?php echo DIRECTORY; ?>/img/federacion-venezolana.jpg" width="60px">
    </div>
    <?php if (count(explode(' ', $data['first_name'] . ' ' . $data['last_name'])) > 3): ?>
    <div style="width:100%; margin-top: 20px;">
        <img src="<?php echo DIRECTORY; ?>/img/hospital-san-juan-de-dios.jpg" width="300px">
    </div>
    <?php else: ?>
    <div style="width:100%; margin-top: 110px;">
        <img src="<?php echo DIRECTORY; ?>/img/hospital-san-juan-de-dios.jpg" width="300px">
    </div>
    <?php endif ?>
  </div>
</body>