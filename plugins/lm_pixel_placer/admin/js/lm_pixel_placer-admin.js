(function( $ ) {
	'use strict';


   $(function() {

      $( window ).load(function() {
         if ($("#lm_pixel_placer-google_analytics").is(':checked')) {
            $('.ga_id').show();
         }
         if ($("#lm_pixel_placer-gtm_datalayer").is(':checked')) {
            $('.gtm_id').show();
         }
         if ($("#lm_pixel_placer-google_conversion").is(':checked')) {
            $('.adwords_ecomm').show();
         }
         if ($("#lm_pixel_placer-google_remarketing").is(':checked')) {
            $('.remarketing_id').show();
         }
         if ($("#lm_pixel_placer-facebook_pixel").is(':checked')) {
            $('.facebook_id').show();
         }
         if ($("#lm_pixel_placer-bing_pixel").is(':checked')) {
            $('.bing_id').show();
         }
         if($("#lm_pixel_placer-specific_pixels_for_page1").val() != "") {
            $(".specific1").show();
            $("#click2").show();
            $("#click1").hide();
			}
         if($("#lm_pixel_placer-specific_pixels_for_page2").val() != "") {
            $(".specific2").show();
            $("#click3").show();
            $("#click2").hide();
         }
         if($("#lm_pixel_placer-specific_pixels_for_page3").val() != "") {
            $(".specific3").show();
            $("#click4").show();
            $("#click3").hide();
         }
         if($("#lm_pixel_placer-specific_pixels_for_page4").val() != "") {
            $(".specific4").show();
         }



      });

		$( "#lm_pixel_placer-google_analytics" ).click(function() {
			if ($("#lm_pixel_placer-google_analytics").is(':checked')) {
				$('.ga_id').show();
			}
			else {
				$('.ga_id').hide();
			}
		});
      $( "#lm_pixel_placer-gtm_datalayer" ).click(function() {
         if ($("#lm_pixel_placer-gtm_datalayer").is(':checked')) {
            $('.gtm_id').show();
         }
         else {
            $('.gtm_id').hide();
         }
      });
      $( "#lm_pixel_placer-google_conversion" ).click(function() {
         if ($("#lm_pixel_placer-google_conversion").is(':checked')) {
            $('.adwords_ecomm').show();
         }
         else {
            $('.adwords_ecomm').hide();
         }
      });

      $( "#lm_pixel_placer-google_remarketing" ).click(function() {
         if ($("#lm_pixel_placer-google_remarketing").is(':checked')) {
            $('.remarketing_id').show();
         }
         else {
            $('.remarketing_id').hide();
         }
      });

      $( "#lm_pixel_placer-adwords_conversion_id" ).change(function() {
         $("#lm_pixel_placer-remarketing_conversion_id").val($( "#lm_pixel_placer-adwords_conversion_id" ).val());
      });

      $( "#lm_pixel_placer-facebook_pixel" ).click(function() {
         if ($("#lm_pixel_placer-facebook_pixel").is(':checked')) {
            $('.facebook_id').show();
         }
         else {
            $('.facebook_id').hide();
         }
      });

      $( "#lm_pixel_placer-bing_pixel" ).click(function() {
         if ($("#lm_pixel_placer-bing_pixel").is(':checked')) {
            $('.bing_id').show();
         }
         else {
            $('.bing_id').hide();
         }
      });

      $( "#click1" ).click(function(e) {
         e.preventDefault();
         $(".specific1").toggle();
         $("#click2").show();
      });
      $( "#click2" ).click(function(e) {
         e.preventDefault();
         $(".specific2").toggle();
         $("#click3").show();
      });
      $( "#click3" ).click(function(e) {
         e.preventDefault();
         $(".specific3").toggle();
         $("#click4").show();
      });
      $( "#click4" ).click(function(e) {
         e.preventDefault();
         $(".specific4").toggle();
      });

   });



})( jQuery );
