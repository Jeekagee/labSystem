<!-- js placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url(); ?>assets/admin/lib/jquery/jquery.min.js"></script>
  <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/admin/lib/advanced-datatable/js/jquery.js"></script>
  <script src="<?php echo base_url(); ?>assets/admin/lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="<?php echo base_url(); ?>assets/admin/lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="<?php echo base_url(); ?>assets/admin/lib/jquery.scrollTo.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/admin/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/admin/lib/advanced-datatable/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/lib/advanced-datatable/js/DT_bootstrap.js"></script>
  <!--common script for all pages-->
  <script src="<?php echo base_url(); ?>assets/admin/lib/common-scripts.js"></script>

  <script src="<?php echo base_url(); ?>assets/admin/lib/jquery-ui-1.9.2.custom.min.js"></script>
  <!--custom switch-->
  <script src="<?php echo base_url(); ?>assets/admin/lib/bootstrap-switch.js"></script>
  <!--custom tagsinput-->
  <script src="<?php echo base_url(); ?>assets/admin/lib/jquery.tagsinput.js"></script>
  <!--custom checkbox & radio-->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/lib/bootstrap-daterangepicker/date.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/lib/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/admin/lib/form-component.js"></script>
  <!--script for this page-->

  
  <script type="text/javascript">
    /* Formating function for row details */
    function fnFormatDetails(oTable, nTr) {
      var aData = oTable.fnGetData(nTr);
      var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
      sOut += '<tr><td>Rendering engine:</td><td>' + aData[1] + ' ' + aData[4] + '</td></tr>';
      sOut += '<tr><td>Link to source:</td><td>Could provide a link here</td></tr>';
      sOut += '<tr><td>Extra info:</td><td>And any further details here (images etc)</td></tr>';
      sOut += '</table>';

      return sOut;
    }

    $(document).ready(function() {
      var oTable = $('#hidden-table-info').dataTable({
        "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [0]
        }],
      });


    });
  </script>

<script type="text/javascript">
  $(document).ready(function(){
      $("#nic").on("keyup", function(){

        $("#pname").val("");
        $("#mobile").val("");
        $("#date").val("");
        $("#pyear").val("");
        $("#pmonth").val("");

        var nic = $(this).val();
        if (nic !== "") {
          $.ajax({
            url:"<?php echo base_url(); ?>Appoint/nic_search",
            type:"POST",
            cache:false,
            data:{nic:nic},
            success:function(data){
              //alert(data);
              $("#nic_list").html(data);
              $("#nic_list").fadeIn();
            }
          });
        }else{
          $("#nic_list").html("");
          $("#nic_list").fadeOut();
        }
      });


      // Mobile number search  function
      /*$("#mobile").on("keyup", function(){
        $("#pname").val("");
        $("#nic").val("");
        $("#address").val("");

        var mobile = $(this).val();
        if (mobile !== "") {
          $.ajax({
            url:"<?php echo base_url(); ?>Laboratory/mobile_search",
            type:"POST",
            cache:false,
            data:{mobile:mobile},
            success:function(data){
              //alert(data);
                $("#mobile_list").html(data);
                $("#mobile_list").fadeIn();
            }
          });
        }else{
          $("#mobile_list").html("");
          $("#mobile_list").fadeOut();
        }
      });*/
      //End Mobile search

      // Data for mobile 
      /*$(document).on("click","#mobile_list li", function(){

        $('#mobile').val($(this).text());
        $('#mobile_list').fadeOut("fast");
        var mobile = $('#mobile').val();


        $.ajax({
          url:"<?php echo base_url(); ?>Laboratory/patient_name",
          type:"POST",
          cache:false,
          data:{mobile:mobile},
          success:function(data){
            $("#pname").val(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Laboratory/patient_address",
          type:"POST",
          cache:false,
          data:{mobile:mobile},
          success:function(data){
            $("#address").val(data);
            //alert(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Laboratory/patient_nic",
          type:"POST",
          cache:false,
          data:{mobile:mobile},
          success:function(data){
            $("#nic").val(data);
            //alert(data);
          }
        });
      });*/
        //End

      // click one particular city name it's fill in textbox
      $(document).on("click","#nic_list li", function(){

        $('#nic').val($(this).text());
        $('#nic_list').fadeOut("fast");
        var nic = $('#nic').val();

        //$('#c_no').fadeOut("fast");

         $.ajax({
          url:"<?php echo base_url(); ?>Appoint/patient_name",
          type:"POST",
          cache:false,
          data:{nic:nic},
          success:function(data){
            $("#pname").val(data);
            //alert(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Appoint/patient_mobile",
          type:"POST",
          cache:false,
          data:{nic:nic},
          success:function(data){
            $("#mobile").val(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Appoint/patient_gender",
          type:"POST",
          cache:false,
          data:{nic:nic},
          success:function(data){
            $('#' + data).prop('checked',true);
          }
        });
        
        $.ajax({
          url:"<?php echo base_url(); ?>Appoint/patient_dob",
          type:"POST",
          cache:false,
          data:{nic:nic},
          success:function(data){
            $("#date").val(data);

            var dob = new Date(data);
            var dob_year = dob.getFullYear();
            var dob_month = dob.getMonth()+1;

            var today = new Date();
            var today_year = today.getFullYear();
            var today_month = today.getMonth()+1;

            var age_year = 0;
            var age_month = 0;

            if(dob_month > today_month)
            {
              age_year = today_year - dob_year - 1;
              age_month = 12 - dob_month + today_month;
            }
            else
            {
              age_year = today_year - dob_year;
              age_month = today_month - dob_month;
            }
            
            $('#pyear').val(age_year);
            $('#pmonth').val(age_month);
          }
        });
      });
  });
</script>

<script type="text/javascript">
// Load doctors  and brand for special
    $(document).ready(function(){
      $("#service").change(function(){
        var service = $(this).val();
        //var location = $("#location").val();
        $.ajax({
          url:"<?php echo base_url(); ?>Laboratory/Service_charge",
          type:"POST",
          cache:false,
          data:{service:service},
          success:function(data){
            $("#charge").val(data);
            $("#add_btn").attr("enabled","enabled");
            $("#save_btn").attr("disabled","disabled");
          }
        });
      });

      //When Change location service charge 
      $("#location").change(function(){
        var service = $('#service').val();
        var location = $("#location").val();
        $.ajax({
          url:"<?php echo base_url(); ?>Laboratory/Service_charge",
          type:"POST",
          cache:false,
          data:{service:service, location:location},
          success:function(data){
            //alert(data);
            $("#charge").val(data);
          }
        });
      });

      $('.del_service').click(function() {
        var id = $(this).attr("id");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>Laboratory/delete_service", //178
                data: ({
                    id: id
                }),
                cache: false,
                success: function(data) {
                  //alert(data);
                  $("#service" + id).fadeOut('slow');
                }
          });
      });
    });

    // Add Service for lap test
    function addService(){
        var nic = $("#nic").val();
        var name = $("#pname").val();
        var dob = $("#date").val();
        var gender = $('input[name=pgender]:checked').val();
        var mobile = $("#mobile").val();

        var year = $("#pyear").val();
        var month = $("#pmonth").val();
        var invoice_no = $("#invoice_no").val();
        var service_id = $("#service").val();
        var test_date = '';
        var source = $("#source").val();
        var requested = $("#requested").val();
        var dr = $("#doctor").val();
        var charge = $("#charge").val();
        var center = $("#center").val();


        //alert(ref_no);
        if (service_id == "") {
          $("#service_error").html("Please Select Service");
        }
        else if (center == "") {
          $("#center_error").html("Please Select Center");
        }
        else{
          $("#service_error").html("");
          $("#center_error").html("");
          $.ajax({
            url:'<?php echo base_url(); ?>Laboratory/insert_service',
            type:'post',
            data:{nic:nic,name:name,dob:dob,gender:gender,mobile:mobile,year:year,month:month,invoice_no:invoice_no,service_id:service_id,year:year,month:month,test_date:test_date,source:source,requested:requested,dr:dr,charge:charge,center:center
            },
            success:function(data){
              //alert(data);
              $("#services").html(data);
              //$("#add_btn").attr("disabled","disabled");
               $('#service').val("");
               $("#charge").val("");
               $(':input[type="submit"]').prop('disabled', false);
              
            }
          });
        }
    }

    // Price for Service
    $(document).ready(function(){
      $("#add_other").click(function(){
        var other = $("#other").val();
        var amount = $("#amount").val();
        var invoice_no = $("#invoice_no").val();

        if (other == "" || amount == "") {
          $("#other_error").html("Please fill both");
        }
        else{
          $("#other_error").html("");
          $.ajax({
            url:"<?php echo base_url(); ?>Appoint/Add_Other",
            type:"POST",
            cache:false,
            data:{other:other,amount:amount,invoice_no:invoice_no},
            success:function(data){
              //alert(data);
              $("#other_tbl").html(data);
              $('#other').val("");
              $('#amount').val("");
            }
          });
        }
        
      }); 
    });

    /*
    $(document).ready(function(){
          var invoice_no = $("#invoice_no").val();
          $.ajax({
            url:"<?php echo base_url(); ?>Appoint/view_other",
            type:"POST",
            cache:false,
            data:{invoice_no:invoice_no},
            success:function(data){
              //alert(data);
              $("#other_tbl").html(data);
              $('#other').val("");
              $('#amount').val("");
            }
          });
    }); */

  </script>

<script>
    $(document).ready(function () {
        $(".openDialog").click(function () {
          $.ajax({
            url:'<?php echo base_url(); ?>Laboratory/load_data',
            type:'post',
            data:{invoice:$(this).data('invoice')},
            success:function(data){
              $("#load_data_table").html(data);
            }
          });
          $('#exampleModal').modal('show');
        });

        $("#date").change(function(){
          var dob = new Date($("#date").val());
          var dob_year = dob.getFullYear();
          var dob_month = dob.getMonth()+1;

          var today = new Date();
          var today_year = today.getFullYear();
          var today_month = today.getMonth()+1;

          var age_year = 0;
          var age_month = 0;

          if(dob_month > today_month)
          {
            age_year = today_year - dob_year - 1;
            age_month = 12 - dob_month + today_month;
          }
          else
          {
            age_year = today_year - dob_year;
            age_month = today_month - dob_month;
          }
          
          $('#pyear').val(age_year);
          $('#pmonth').val(age_month);

        });
    });
  </script>

</body>

</html>
