</div>   
    <footer class="col-md-12 text-center" style="margin-top:5%;">&copy; Copyright 2018-2019 Geboct Technologies Ltd.</footer>

    <script>
       function updateModels(){
         var modelString = '';
         for(var i = 1; i <= 12; i++){
             if(jQuery('#model'+i).val() != ''){
                 modelString += jQuery('#model'+i).val()+':'+jQuery('#qty'+i).val()+',';
               }
            }
         jQuery('#models').val(modelString);
       }

        function get_child_options(selected){
            if (typeof selected === 'undefined') {
                var selected = '';
            }
        var parentID = jQuery('#parent').val();
        jQuery.ajax({
            url: '/GebOct Store/admin/parsers/child_categories.php',
            type: 'POST',
            data: {parentID : parentID, selected: selected  },
            success: function(data){
                jQuery('#child').html(data);
            },
            erro: function(){alert("Something went wrong with the chlid options!")},
        });
        }
        jQuery('select[name="parent"]').change(function(){
            get_child_options();
        });
    </script>  
</body>
</html>