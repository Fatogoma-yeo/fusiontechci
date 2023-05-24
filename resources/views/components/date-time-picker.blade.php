<div class="picker mb-2">
    <div class="ns-button">
        <button class="border shadow rounded cursor-pointer w-full px-1 py-1 flex items-center text-primary bg-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ $slot }}
        </button>
    </div>
</div>

<script>
  $( function() {
        var dateFormat = "yy-mm-dd",
        startDate = $( "#startDate" )
            .datepicker({
            defaultDate: "+1w",
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1
            })
            .on( "change", function() {
                startDate.datepicker( "option", "minDate", getDate( this ) );
            }),
        endDate = $( "#endDate" ).datepicker({
            defaultDate: "+1w",
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1
        })
        .on( "change", function() {
            endDate.datepicker( "option", "maxDate", getDate( this ) );
        });
    
        function getDate( element ) {
        var date;
        try {
            date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
            date = null;
        }
    
        return date;
        }
    } );
</script>