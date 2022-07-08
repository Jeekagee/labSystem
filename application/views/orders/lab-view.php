
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <style>
.dropbtn {
  background-color: #1fbb60;
  color: white;
  padding: 13px;
  padding-top: 8px;
  padding-bottom: 5px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #2980B9;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
</style>
    <section id="main-content">
    <section class="wrapper site-min-height">
        <h3></i>View List</h3>
        <div class="row mt">
            <div class="col-lg-8">
            <div class="dropdown">
                    <button onclick="myFunction()" class="dropbtn"><i class="fa fa-plus"></i></button>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="<?php echo base_url(); ?>Laboratory/View">Lab Testing</a>
                        <a href="">Orders</a>
                        <a href="">New Bill</a>
                        <a href="">OPD Invoice</a>
                        <a href="">Channeling Invoice</a>
                        <a href="">Service order Invoice</a>
                    </div>
                    </div>

                    <script>
                    /* When the user clicks on the button, 
                    toggle between hiding and showing the dropdown content */
                    function myFunction() {
                    document.getElementById("myDropdown").classList.toggle("show");
                    }

                    // Close the dropdown if the user clicks outside of it
                    window.onclick = function(event) {
                    if (!event.target.matches('.dropbtn')) {
                        var dropdowns = document.getElementsByClassName("dropdown-content");
                        var i;
                        for (i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                        }
                    }
                    }
                    </script>
            <!-- <div style="margin-bottom: 10px;" >
                <a href="" class="btn btn-success"><i class="fa fa-plus"></i></a>
            </div> -->
           
            </div>
          </div>
        </div>
      </section>
    </section>
  