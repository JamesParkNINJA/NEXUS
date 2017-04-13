<script>
    jQuery(document).ready(function ($) {
    // Datepicker options
        var date = new Date();
        date.setDate(date.getDate() + 1);

        $('.datepicker.anyDate').pikaday({ 
            format: 'DD-MM-YYYY'
        });

        $('.datepicker.minToday').pikaday({ 
            disableWeekends:true, 
            minDate:date,
            format: 'DD-MM-YYYY'
        });
    });
</script>