<!DOCTYPE HTML>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <br>

    <?php
        $characters = array(
            "Topaz and Numby" => array("imagePath" => asset('images/topaz.webp'), "path" => "Hunt | Fire"),
            "Asta" => array("imagePath" => asset('images/asta.png'), "path" => "Harmony | Fire"),
            "March 7th" => array("imagePath" => asset("images/march.webp"), "path" => "Preservation | Ice"),
            "Seele" => array("imagePath" => asset("images/seele.png"), "path" => "Hunt | Quantum"),
            "Ruan Mei" => array("imagePath" => asset("images/ruanmei.png"), "path" => "Harmony | Ice"),
            "Guinaifen" => array("imagePath" => asset("images/guinaifen.webp"), "path" => "Nihility | Fire")
        )
    ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php foreach ($characters as $character => $details) { ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="card">
                        <img src="<?=$details["imagePath"];?>" class="card-img-top img-fluid" alt="#">
                        <div class="card-body">
                            <h5 class="card-title"><?=$character;?></h5>
                            <h6 id="custom-card" class="card-subtitle text-body-secondary">
                                <?=$details["path"];?>
                            </h6>
                            <p class="card-text my-4">Text goes here</p>
                            <a href="#" class="card-link btn btn-primary d-block mx-auto">More</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>