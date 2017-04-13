<?php include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details ?>
<?php 
    $startYear = nexus_firstPostYear().'-01-01';
    $endYear = '2099-12-31';
    $sY = '01-01-'.nexus_firstPostYear();
    $eY = '31-12-2099';
?>

<ul class="navigationMenu">
    <li>
        <label for="startDate" style="font-size:14px;">Start Date</label><input id="startDate" style="font-size:14px;" class="startDate required" type="text" name="startDate" value="<?php echo ($sY ? $sY : ''); ?>" />
    </li>
    <li>
        <label for="endDate" style="font-size:14px;">End Date</label><input id="endDate" style="font-size:14px;" class="endDate required" type="text" name="endDate" value="<?php echo ($eY ? $eY : ''); ?>" />
    </li>
    <li>
        <a class="nexus_ajaxFunction" data-query="statistics" href="#">Apply Filter</a> 
    </li>
</ul>

<script>
        
    jQuery(document).ready(function ($) {

        function destroyFuture() { //destroy to field and init with new param
            var $from = $('.startDate').pikaday({ 
                disableWeekends:true, 
                minDate:new Date(<?php echo $fdTS * 1000; ?>),
                format: 'DD-MM-YYYY'
            });

            if($from.val()) {
                $('.endDate').pikaday('destroy');
                $('.endDate').remove();
                $('.endDateBox').html('<input class="endDate required" type="text" name="endDate" /><label for="endDate">End Date</label>');


                $('.endDate').pikaday({ 
                    disableWeekends:true, 
                    format: 'DD-MM-YYYY',
                    minDate: moment($from.val(), 'DD-MM-YYYY').toDate()
                });
            }
        }

        $('.startDate').pikaday({ 
            disableWeekends:true, 
            minDate:new Date(<?php echo $fdTS * 1000; ?>),
            format: 'DD-MM-YYYY',
            onSelect: function() {
                destroyFuture();
            }
        });

        $('.endDate').pikaday({ 
            disableWeekends:true, 
            minDate:new Date(<?php echo $fdTS * 1000; ?>),
            format: 'DD-MM-YYYY'
        });

    });          

</script>