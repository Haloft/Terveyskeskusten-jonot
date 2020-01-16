<div class="row">
    <div class="col-12 btn-group">
        <a class="btn btn-primary" href="<?php echo base_url('tkjono/index'); ?>"role="button">Etusivu</a>
    </div>
</div>
            
<div class="row">
    <div class="col-12 center">
        <p></p>
        <img class="img-fluid" src="<?php echo base_url("assets/" . $clinic . ".jpg"); ?>" alt="">
        <p></p>
        <h3><?php echo $clinic ;?></h3>
    </div>
</div>
<div class="row">
    <div class="col-12 center">
        <div class="card-deck">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Uusimmat keskimääräiset odotusajat</h5>
                    <p class="card-text"><i class="fas fa-user-md"></i> Lääkäri: <?php echo $latest['doctor_queue']?> min<br>
                        <i class="fas fa-user-nurse"></i> Sairaanhoitaja: <?php echo $latest['nurse_queue']?> min</p>
                </div>
                <div class="card-footer">
                    <p class="card-text"><?php echo date('d.m.Y', strtotime($latest['date'])) ?></p>
                </div>                    
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Edelliset keskimääräiset odotusajat</h5>
                    <p class="card-text"><i class="fas fa-user-md"></i> Lääkäri: <?php echo $lastMonth['doctor_queue']?> min<br>
                       <i class="fas fa-user-nurse"></i> Sairaanhoitaja: <?php echo $lastMonth['nurse_queue']?> min</p>
                </div>
                <div class="card-footer">
                    <p class="card-text"><?php echo date('d.m.Y', strtotime($lastMonth['date'])) ?></p>
                </div>                    
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">6 Kuukauden keskiarvo</h5>
                    <p class="card-text"><i class="fas fa-user-md"></i> Lääkäri: <?php echo $averages['doctorAverage']?> min<br>
                       <i class="fas fa-user-nurse"></i> Sairaanhoitaja: <?php echo $averages['nurseAverage']?> min</p>
                </div>
                <div class="card-footer">
                    <p class="card-text"><?php echo date('d.m.Y', strtotime($averageDates['startingPoint'])) . "-" . date('d.m.Y', strtotime($averageDates['endingPoint'])) ?></p>
                </div>                    
            </div>               
        </div>
    </div>
</div>