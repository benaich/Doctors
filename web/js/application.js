/* helper functions */
function validateEmail(email){
    var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return emailReg.test(email);
}
function validateCin(cin){
    var cinReg = new RegExp(/^[a-zA-Z]{1,2}[0-9]{1,7}$/);
    return cinReg.test(cin);
}
function validateCne(cne){
    var cneReg = new RegExp(/^[0-9]{10}$/);
    return cneReg.test(cne);
}
function scrollTo(cible) {
    if ($(cible).length >= 1) {
        hauteur = $(cible).offset().top - ($(window).height() - $(cible).height()) / 2;
    } else {
        return false;
    }
    $('html,body').animate({
        scrollTop: hauteur
    }, 1000);
    return false;
}
function validateFloat(number){
    var numberReg = new RegExp(/^[0-9]{1,10}\.?[0-9]{0,2}$/);
    return numberReg.test(number);
}
function confirmation() {
    var msg='voullez-vous vraiment effectué cette action';
    return window.confirm(msg, 'Alert');
}

(function($) {
    /* menu config */
    var li=$('.menu li span:last-child'),
        shelfBtn = $('#trigger-shelf');
    shelfBtn.on('click', function() {
        $(document.body).toggleClass('shelf');
        if($(document.body).hasClass('shelf')) 
            $.cookie('shelf_class', 'shelf', { expires: 7, path: '/' });
        else $.cookie('shelf_class', '', { expires: 7, path: '/' });

        shelfBtn.find('.glyphicon').toggleClass('glyphicon-chevron-right');
    });
    if($.cookie('shelf_class') === 'shelf'){
        shelfBtn.find('.glyphicon').toggleClass('glyphicon-chevron-right');
        $(document.body).addClass($.cookie('shelf_class'));
    }

    /* print button */
    $('#btnPrint').on('click', function () {
        $('#mycontainer').removeClass('hidden-print');
        
    	window.print();
    });

    /* check all check buttons*/
    $("#checkall").click(function(){
        if($("#checkall").prop("checked")) $("input:checkbox").prop("checked",true);
        else $("input:checkbox").prop("checked",false);
    });

    /* tooltip */
    $('a[data-toggle="tooltip"]').tooltip();

    /* select 2 */
    $('.select2.search').select2();
    $('.select2.no-search').select2({minimumResultsForSearch: -1});

})(jQuery);