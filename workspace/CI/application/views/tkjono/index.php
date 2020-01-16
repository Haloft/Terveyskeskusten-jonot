
 <div class="row">
    <div class="col-12 btn-group nappi">
        <button type="button" class="btn btn-primary" id="sortButton">Järjestä</button>
        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="<?php echo base_url('tkjono/index/clinic'); ?>">Nimen mukaan</a>
        <a class="dropdown-item" href="<?php echo base_url('tkjono/index/doctor_queue'); ?>">Lääkärijonon mukaan</a>
        <a class="dropdown-item" href="<?php echo base_url('tkjono/index/nurse_queue'); ?>">Hoitajajonon mukaan</a>
    </div>
    </div>
</div>

       
  
        <ul class="row" id="kortit">
            <?php foreach ($clinicWaitingTimes as $clinicWaiting) : ?>
                <div class='col-sm-6 col-lg-4'>
                    <div class='card'>
                        <img class="card-img-top" src="<?php echo base_url("assets/" . $clinicWaiting['clinic']. ".jpg"); ?>" alt="">
                        <div class='card-body'>
                            <h5 class='card-title'><li><a href="<?php echo base_url("tkjono/view_clinic/" . $clinicWaiting['clinic']) ?>">
                                <?php echo  $clinicWaiting['clinic'] ?></a></li></h5>
                                    <p><?php $temp = strtotime($clinicWaiting['date']);
                                            $date = date('d.m.Y', $temp); 
                                            echo $date
                                        ?><br>
                                            Keskimääräiset odotusajat
                                    </p>
                            <p><i class="fas fa-user-md"></i> Lääkäri: <?php echo $clinicWaiting['doctor_queue'] ?> min<br>
                               <i class="fas fa-user-nurse"></i> Sairaanhoitaja: <?php echo $clinicWaiting['nurse_queue'] ?> min
                            </p>      
                                  
                        </div>
                    </div>
                    <p></p>
                </div>
            <?php endforeach ?>
        </ul>
  