</div>
       </div>
          

       <footer class="text-center" style="margin-top: 200px;">&copy; Copyright 2018-2019,Geboct Technologies Ltd.</footer>
        <script>
        jQuery(window).scroll(function(){
          var vscroll = jQuery(this).scrollTop();
          jQuery('#header-Logo').css({
            "transform" : "translate(0px, "+vscroll/2+"px)"
          });
        });

        function detailsmodal(id){
          var data = {"id" : id};
          jQuery.ajax({
            url : '/GebOct Store/includes/detailsmodal.php',
            method : "post",
            data : data,
            success : function(data){
              jQuery('body').append(data);
              jQuery('#details-modal').modal('toggle');
            },
            error : function(){
              alert("Something went wrong!");
            }
          });
        }
        </script>
        <script src="jquery/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
</body>
</html>