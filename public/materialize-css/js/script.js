$(document).ready(function(){
    $(".dropdown-button").dropdown();
    $(".button-collapse").sideNav();
    $('select').material_select();
    $('.task_date').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd',
        onSet: function (ele) {
            if(ele.select){
                this.close();
            }
        }
    });

    $('.report_dates').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd',
        onSet: function (ele) {
            if(ele.select){
                this.close();
            }
        }
    });

    $('#export').draggable();

});