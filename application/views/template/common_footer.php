<footer class="main-footer">
        <div class="footer-left">
          <a href="templateshub.net">Templateshub</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="assets/bundles/datatables/datatables.min.js"></script>
  <script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/bundles/jquery-ui/jquery-ui.min.js"></script>
  <!-- Page Specific JS File -->
   <script src="assets/js/page/datatables.js"></script>
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
  <script src="breadcrumb_assets/script.js"></script>
</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>

<script>
   function onlyCNIC(obj, evt) {
    
    obj.on('paste', function(e){
        /// v variable have paste value
        //var v = e.originalEvent.clipboardData.getData('Text');
        return false;
        obj.val('');       
    });
    
    var charCode = (evt.which) ? evt.which : event.keyCode;
    
    if(obj.val().length < 15)
    {
        if(onlyDigits(charCode))
        {
            if(obj.val().length == 5 || obj.val().length == 13)
                obj.val(obj.val()+'-');
        }
        else
            return false;
    }
    else
        return false;
}



//// only digits function
function onlyDigits(charCode)
{
    
    if(charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }    
    else
    {
        return true;
    }
}

 function onlyNumber(obj, evt) {
   
    obj.on('paste', function(e){
        /// v variable have paste value
        //var v = e.originalEvent.clipboardData.getData('Text');
        return false;
        obj.val('');       
    });
    
    var charCode = (evt.which) ? evt.which : event.keyCode;
    
   
     return  onlyDigits(charCode);
      
    }
    
//// only digits function
function onlyDigits(charCode)
{
    
    if(charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }    
    else
    {
        return true;
    }
}


</script>