(function($, Drupal, drupalSettings) {
    $(document).ready(function () {
        //alert('Hello');
        $("a[href^='http']").attr('target', '_blank');
        var $host = window.location.origin;
        $(".node a[href^='http']")
            .css('background-image', 'url("' + $host + '/dev/web//themes/custom/ive/images/external-link.gif")')
            .css('background-repeat', 'no-repeat')
            .css('padding-left', '30px')
            .css('background-size', '25px')
            .css('background-position', 'left center')
    });

  $( ".block h2" ).click(function() {
        $( this).parent().find('.content').slideToggle( "slow", function() {
            // Animation complete.
        });
    });


}) (jQuery, Drupal, drupalSettings);

