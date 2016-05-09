<?php
namespace View;

class HTMLView{

    //Skeleton to be shown on startpage
    public function echoHTML($body){
      $time = $this->getDateAndTime();
      echo '<!DOCTYPE html>
              <html>
              <head>
                <title>Svenskt Väder | Prognoser från YR och SMHI</title>
                <meta charset = "UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <!-- Bootstrap -->
                <link href="./Style/Bootstrap/css/bootstrap.min.css" rel="stylesheet">
                <!-- My style -->
                <link rel="stylesheet" type="text/css" href="./Style/Style.css">
              </head>
              <body>
              <div class="container">
                <header>
                  <div class="row">
                    <div class="col-md-8">                  
                    <a href="./">
                    <img src="/Style/sol.png" alt="logo för svenskt väder föreställande sol" />
                    </a>
                    </div>
                    <div class="col-md-4">     
                    <form class="form-inline" method="get" role="form" action="?'.NavigationView::$actionSearch.'">
                        <div class="form-group">
                          <input type="text" class="form-control" maxlength="255" name="search" id="search" placeholder="Sök väder via ort" autofocus="">
                        </div>
                        <div class="form-group">
                          <input type="submit" value="Sök" class="btn btn-default">
                        </div>
                    </form>
                    </div>
                  </div>  
                </header>
                <div id="content">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12">
                      '.$body.'
                    </div>
                  </div>
                </div>
                <footer>
                  <p class="tight">Denna sida är skapad av Marike Grinde</br>
                  i kursen 1DV42E, Självständigt arbete, Fakulteten för teknik, Linnéuniversitetet</p>
                </footer>
              </div>
              <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>   
              </body>
              </html>';
    }
    
    private function getDateAndTime(){
      setlocale (LC_ALL, "sv_SE");
      $date = date('d F');
      $year = date('Y');
      $day = ucfirst(strftime("%A"));
      $time = date('H:i:s');
      return utf8_encode($day) . ', den ' . $date . ' år ' . $year . '. Klockan är [' . $time . ']';
    }
}