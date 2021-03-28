<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <title>Weather Forecast</title>
</head>
<body class="bg-secondary">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#"><i class="fas fa-feather-alt fa-lg"></i>&nbsp;&nbsp;Weather 24/7</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
<div class="container">
    
    <div class="row">
        <div class="col-6">
            <h2></h2>
            <div class="searchBar">
                <input type="text" id="searchInput" class="searchInput" placeholder="city..." autocomplete="off" value="">
                <div class="search"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="widget col-12">
        <div class="modal"><!-- Place at bottom of page --></div>
            <div class="main container">
                <div class="row">
                    <div class="col-12">
                        <div class="col-12 col-sm-6 offset-sm-3 col-lg-4 offset-lg-4 row weather-panel">
                            <div class="col-6 pt-3">
                                <h2><?php echo strtoupper($location['name']) ?><br><small><?php echo date("M d, Y", strtotime($location['localtime'])); ?></small></h2>
                                <p class="h3" style="font-size: 25px!important;"><img src="<?php echo $forecast['forecastday'][0]['day']['condition']['icon']?>"> <?php echo $forecast['forecastday'][0]['day']['condition']['text'] ?></p>
                            </div>
                            <div class="col-6 text-center">
                                <div class="h1 temperature pt-5">
                                    <span><?php echo $forecast['forecastday'][0]['day']['avgtemp_c'].'&deg;'; ?></span>
                                    <br>
                                    <small><?php echo $forecast['forecastday'][0]['day']['mintemp_c'].'&deg; / '.$forecast['forecastday'][0]['day']['maxtemp_c'].'&deg;'; ?></small>
                                </div>
                            </div>
                            <div class="col-12">
                                <ul class="list-inline row justify-content-center forecast">
                                    <?php foreach($forecast['forecastday'] as $x): ?>
                                    <li class="col-4 col-sm-4 pl-1 text-center">
                                        <h3 class="h5"><?php echo date("D", strtotime($x['date'])); ?></h3>
                                        <p style="font-size: 13px;"><img src="<?php echo $x['day']['condition']['icon'] ?>" alt=""><br><?php echo $x['day']['mintemp_c'].'&deg; /'.$x['day']['maxtemp_c'].'&deg;'; ?></p>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    



    <!-- scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
    $(document).ready(function(){
        $(".searchInput").keyup( function postinput(){
            var city = $(this).val(); // this.value
            $.ajax({ 
                url: '<?php echo site_url('welcome/getWeather') ?>',
                data: { city: city },
                type: 'post'
            }).done(function(responseData) {
                console.log('Done: ', responseData);
                $(".widget").html(responseData);
            }).fail(function() {
                console.log('Failed');
            });
        });
    }); 
    $body = $(".widget");

    $(document).on({
        ajaxStart: function() { $body.addClass("loading");    },
        ajaxStop: function() { $body.removeClass("loading"); }    
    });
</script>
</body>
</html>