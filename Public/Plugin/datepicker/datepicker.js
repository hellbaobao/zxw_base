$(function () {
    $.datepicker.regional["zh-CN"] = {
        monthNames: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
        monthNamesShort: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
        dateFormat: "yy-mm-dd",
        firstDay: 1,
        isRTL: !1,
        showMonthAfterYear: !0,
        yearSuffix: "年"
    };
    $.datepicker.setDefaults($.datepicker.regional["zh-CN"]);
//    $('#Datepicker').datepicker({
//        changeMonth: true,
//        changeYear: true,
//        dateFormat: 'yy-MM-dd',
//        //showButtonPanel: true,
//        onClose: function(dateText, inst) {
//            var month = $("#ui-datepicker-div .ui-datepicker-month option:selected").val();//得到选中的月份值
//            var year = $("#ui-datepicker-div .ui-datepicker-year option:selected").val();//得到选中的年份值
//            $('#Datepicker').val(year+'-'+(parseInt(month)+1));//给input赋值，其中要对月值加1才是实际的月份
//        }
//    });
});