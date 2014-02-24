$(document).ready(function() {
    var checkedin = false;
    var checkedout = false;
    var days = $('#days').val();
    var pad = function(val) {
        var str = val.toString();
        return (str.length < 2) ? "0" + str : str
    };

    $('#checkin.datepicker').Zebra_DatePicker({
        direction: 1,
        format: 'd-m-Y',
        onSelect: function(date) {
            checkedin = true;
            var checkout = $('#checkout.datepicker').data('Zebra_DatePicker');
            checkout.update({
                direction: [date, false]
            });
            if (days != '') {
                checkedout=true;
                var pieces = date.split('-').reverse();
                var dateString = pieces.join('-');
                var myDate = new Date(dateString);
                myDate.setDate(myDate.getDate() + parseInt(days));
                var y = myDate.getFullYear(),
                        m = myDate.getMonth() + 1, // january is month 0 in javascript
                        d = myDate.getDate()
                var fecha = [pad(d), pad(m), y].join("-");
                $('#checkout.datepicker').val(fecha);
                checkout.update({
                    direction: [fecha, fecha]
                });
            }
        }
    });
    $('#checkout.datepicker').Zebra_DatePicker({
        direction: 1,
        format: 'd-m-Y',
        onSelect: function(date) {
            checkedout = true;
            var checkin = $('#checkin.datepicker').data('Zebra_DatePicker');
            checkin.update({
                direction: [1, date]
            });
        }
    });
    $('#booking').submit(function(event) {
        var isEmpty = true;
        $(this).find('#adults').each(function() {
            if ($(this).val() !== '0')
                isEmpty = false;
        });
        $(this).find('#children').each(function() {
            if ($(this).val() !== '0')
                isEmpty = false;
        });
        if (isEmpty)
            $('#errorMsg').html(lang['sel_people']);
        if (!checkedout || !checkedin) {
            isEmpty = true;
            $('#errorMsg').html(lang['sel_dates']);
        }
        if (isEmpty)
            return false;
    });
});

