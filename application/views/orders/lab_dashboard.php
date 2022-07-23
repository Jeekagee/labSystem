<style>
.small-box {
    border-radius: 5px;
    box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
    display: block;
    margin-bottom: 20px;
    position: relative;
}

.small-box > .inner {
    padding: 10px;
}

.col-lg-3 .small-box h3, .col-md-3 .small-box h3, .col-xl-3 .small-box h3 {
    font-size: 25px;
}

.small-box h3 {
    font-size: 25px;
    font-weight: 700;
    margin: 0 0 10px;
    padding: 0;
    white-space: nowrap;
}


.small-box p {
    font-size: 18px;
}
p {
    margin-top: 0;
    margin-bottom: 10px;
}
*, ::after, ::before {
    box-sizing: border-box;
}
.small-box > .small-box-footer {
    background-color: rgba(0,0,0,.1);
    color: rgba(255,255,255,.8);
    display: block;
    padding: 3px 0;
    position: relative;
    text-align: center;
    text-decoration: none;
    z-index: 10;
}
.small-box .icon {
    color: rgba(0,0,0,.15);
    z-index: 0;
}

.bg-info, .bg-info > a {
    color: #fff !important;
}
.bg-info {
    background-color: #17a2b8 !important;
}

</style>
        
<?php $CI =& get_instance(); ?>
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12 main-chart">
            <div class="row">
            <?php
            foreach ($lab_services as $services) {
            ?>
              <div class="col-lg-2 col-sm-3 col-xs-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <p style="font-size:18px;"><?php echo $services->service; ?></p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="<?php echo base_url(); ?>Laboratory/View/<?php echo $services->service_id; ?>" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            <?php
            }
            ?>
            </div>
          </div>
        </div>
      </section>
    </section>