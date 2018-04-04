(function ($, root, undefined) {

	$(function () {

		'use strict';

		// DOM ready, take it away
		$(".hamburger_wrapper").click(function(){
			$(".mobile_nav").toggle();
			$(".hamburger").toggleClass("fa-bars");
			$(".hamburger").toggleClass("fa-times");
			$('.nav').fadeToggle( "slow", "linear" );
         $('.search-wrapper').css('height','0px');
		});

      var getUrlParameter = function getUrlParameter(sParam) {
         var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

         for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
               return sParameterName[1] === undefined ? true : sParameterName[1];
            }
         }
      };

      var status = getUrlParameter('status');
      if(status == 'awesome')
         document.cookie = "subbed=yes; expires=Thu, 28 Dec 2026 12:00:00 UTC; path=/";

      function getCookie(cname) {
         var name = cname + "=";
         var decodedCookie = decodeURIComponent(document.cookie);
         var ca = decodedCookie.split(';');
         for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
               c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
               return c.substring(name.length, c.length);
            }
         }
         return "";
      }

      if(getCookie('subbed') === 'yes') {
         console.log('already a subscriber');
         $('.footer .subscribe-wrapper').hide();
         $('.footer .subscribe-wrapper').prev().hide();
         $('.awesome').show();
         $('.mockup-content').hide();
         $('.morph-clone').hide();
         $('#ouibounce-modal').attr("id","nope");
      }



   $('a').click(function(event) {
      // Remember the link href
      var href = this.href;

      // Don't follow the link
      event.preventDefault();

      if (href.indexOf(location.host) == -1) {

         console.log('external link click');
         // Do the async thing

            ga('send', 'event', 'Outgoing Links', 'Click', href, '1');
            window.open(href, '_blank');

      }
      else {
         window.location.href = href;
      }
   });




      jQuery('.subscribe-me').click(function (event) {
         if(jQuery(this).parent().find('.my-email').val() != '') {
            console.log("submitting...");
            toastr.info('Please wait...');
         }

         event.preventDefault();

         var data = {
            'action': 'subscribe_wplcc',
            'email': jQuery(this).parent().find('.my-email').val()
         };

         console.log(data);

         if(jQuery(this).parent().find('.my-email').val() != '') {
            jQuery.post(the_ajax_script.ajaxurl, data, function (response) {
               //jQuery('.messages').empty();
               //console.log(response);
               toastr.clear();


               //jQuery('.messages').append(response);
               var obj = String(response);
               console.log(obj);

               if(obj == '') {
                  toastr.success('Thank you for subscribing to our email list.');
                  document.cookie = "subbed=yes; expires=28 Dec 2026 12:00:00 UTC; path=/";
                  $('.footer .subscribe-wrapper').hide();
                  $('.footer .subscribe-wrapper').prev().hide();
                  $('.awesome').show();
                  ga('send', 'event', 'Email List', 'Subscribe', 'after launch', '10');
                  $('.mockup-content').hide();
                  //$('<script>')
                  //    .attr('type', 'text/javascript')
                  //    .text("ga('send', 'event', 'Email List', 'Subscribe', 'Coming Soon', '10');")
                   //   .appendTo('head');

               }
               else {
                  $('.modal-body').empty();
                  if(obj.indexOf('email_address') !== -1)
                     $('.modal-body').append('Please enter a valid email address');
                  else {
                     if(response == 'You are already subscribed to our list.') {
                        document.cookie = "subbed=yes; expires=Thu, 28 Dec 2026 12:00:00 UTC; path=/";
                     }
                     $('.modal-body').append(response);
                  }

                  $("#myModal").modal('show');
               }



               toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "1500",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
               }
            });
         }

      });

		//show search box
      $( ".search-icon" ).click(function() {

         if($(window).width() < 768) {
            $('.nav').hide();
         }

         $(".hamburger").addClass("fa-bars");
         $(".hamburger").removeClass("fa-times");

         if($('.search-wrapper').height()== 0) {
            $('.search-wrapper').css('height','50px');
            $('.search-wrapper').css('margin-bottom','15px');
            $('#searchbox').addClass('show').removeClass('hide');
			}
			else {
            $('.search-wrapper').css('height','0px');
            $('#searchbox').addClass('hide').removeClass('show');
            $('.search-wrapper').css('margin-bottom','0');
			}

      });

      $('#searchbox-close').click(function() {
         $('.search-wrapper').css('height','0px');
         $('.search-wrapper').css('margin-bottom','0');
         $('#searchbox').addClass('hide').removeClass('show');
      });


      if($(window).width() < 450) {
         console.log('swap images');
         $(".single p img").each(function () {
            if(!$(this).hasClass('size-full')) {
               var smallsrc = $(this).attr("src");
               if(smallsrc.indexOf("jpeg") === -1 && smallsrc.indexOf("x") !== -1) {
                  var ext = smallsrc.slice(-4);
                  smallsrc = smallsrc.slice(0,-12);

                  $(this).attr('src',smallsrc+ext);
                  $(this).attr('srcset','');
                  $(this).attr('sizes','');
               }
            }
         });
      }

      if($(window).width() < 450) {
         console.log('swap images');
         $(".single p img").each(function () {
      $(this).attr('srcset','');
      $(this).attr('sizes','');
         });
      }




	});

   $(document).ready(function(){(function(){$("html").on("mouseout.ouibounce",function(){function e(){$("#ouibounce-modal").modal()}return function(t){if(!(t.clientY<20))return;e();$("html").off("mouseout.ouibounce")}}())})();$("head").prepend('<style type="text/css">.modal-open{overflow:hidden}.modal{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1040;display:none;overflow:auto;overflow-y:scroll}.modal.fade .modal-dialog{-webkit-transform:translate(0,-25%);-ms-transform:translate(0,-25%);transform:translate(0,-25%);-webkit-transition:-webkit-transform .3s ease-out;-moz-transition:-moz-transform .3s ease-out;-o-transition:-o-transform .3s ease-out;transition:transform .3s ease-out}.modal.in .modal-dialog{-webkit-transform:translate(0,0);-ms-transform:translate(0,0);transform:translate(0,0)}.modal-dialog{position:relative;z-index:1050;width:auto;margin:10px}.modal-content{position:relative;background-color:#fff;border:1px solid #999;border:1px solid rgba(0,0,0,0.2);border-radius:6px;outline:0;-webkit-box-shadow:0 3px 9px rgba(0,0,0,0.5);box-shadow:0 3px 9px rgba(0,0,0,0.5);background-clip:padding-box}.modal-backdrop{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1030;background-color:#000}.modal-backdrop.fade{opacity:0;filter:alpha(opacity=0)}.modal-backdrop.in{opacity:.5;filter:alpha(opacity=50)}.modal-header{min-height:16.428571429px;padding:15px;border-bottom:1px solid #e5e5e5}.modal-header .close{margin-top:-2px}.modal-title{margin:0;line-height:1.428571429}.modal-body{position:relative;padding:20px;min-height:300px}.modal-footer{padding:19px 20px 20px;margin-top:15px;text-align:right;border-top:1px solid #e5e5e5}.modal-footer:before,.modal-footer:after{display:table;content:" "}.modal-footer:after{clear:both}.modal-footer:before,.modal-footer:after{display:table;content:" "}.modal-footer:after{clear:both}.modal-footer .btn+.btn{margin-bottom:0;margin-left:5px}.modal-footer .btn-group .btn+.btn{margin-left:-1px}.modal-footer .btn-block+.btn-block{margin-left:0}@media screen and (min-width:768px){.modal-dialog{width:600px;margin:30px auto}.modal-content{-webkit-box-shadow:0 5px 15px rgba(0,0,0,0.5);box-shadow:0 5px 15px rgba(0,0,0,0.5)}}.btn{display:inline-block;padding:6px 12px;margin-bottom:0;font-size:14px;font-weight:normal;line-height:1.428571429;text-align:center;white-space:nowrap;vertical-align:middle;cursor:pointer;background-image:none;border:1px solid transparent;border-radius:4px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;-o-user-select:none;user-select:none}.btn-primary{color:#fff;background-color:#428bca;border-color:#357ebd}.btn-primary:hover,.btn-primary:focus,.btn-primary:active,.btn-primary.active,.open .dropdown-toggle.btn-primary{color:#fff;background-color:#3276b1;border-color:#285e8e}</style>');+function(e){"use strict";var t=function(t,n){this.options=n;this.$element=e(t);this.$backdrop=this.isShown=null;if(this.options.remote)this.$element.load(this.options.remote)};t.DEFAULTS={backdrop:true,keyboard:true,show:true};t.prototype.toggle=function(e){return this[!this.isShown?"show":"hide"](e)};t.prototype.show=function(t){var n=this;var r=e.Event("show.bs.modal",{relatedTarget:t});this.$element.trigger(r);if(this.isShown||r.isDefaultPrevented())return;this.isShown=true;this.escape();this.$element.on("click.dismiss.modal",'[data-dismiss="modal"]',e.proxy(this.hide,this));this.backdrop(function(){var r=e.support.transition&&n.$element.hasClass("fade");if(!n.$element.parent().length){n.$element.appendTo(document.body)}n.$element.show();if(r){n.$element[0].offsetWidth}n.$element.addClass("in").attr("aria-hidden",false);n.enforceFocus();var i=e.Event("shown.bs.modal",{relatedTarget:t});r?n.$element.find(".modal-dialog").one(e.support.transition.end,function(){n.$element.focus().trigger(i)}).emulateTransitionEnd(300):n.$element.focus().trigger(i)})};t.prototype.hide=function(t){if(t)t.preventDefault();t=e.Event("hide.bs.modal");this.$element.trigger(t);if(!this.isShown||t.isDefaultPrevented())return;this.isShown=false;this.escape();e(document).off("focusin.bs.modal");this.$element.removeClass("in").attr("aria-hidden",true).off("click.dismiss.modal");e.support.transition&&this.$element.hasClass("fade")?this.$element.one(e.support.transition.end,e.proxy(this.hideModal,this)).emulateTransitionEnd(300):this.hideModal()};t.prototype.enforceFocus=function(){e(document).off("focusin.bs.modal").on("focusin.bs.modal",e.proxy(function(e){if(this.$element[0]!==e.target&&!this.$element.has(e.target).length){this.$element.focus()}},this))};t.prototype.escape=function(){if(this.isShown&&this.options.keyboard){this.$element.on("keyup.dismiss.bs.modal",e.proxy(function(e){e.which==27&&this.hide()},this))}else if(!this.isShown){this.$element.off("keyup.dismiss.bs.modal")}};t.prototype.hideModal=function(){var e=this;this.$element.hide();this.backdrop(function(){e.removeBackdrop();e.$element.trigger("hidden.bs.modal")})};t.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove();this.$backdrop=null};t.prototype.backdrop=function(t){var n=this;var r=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var i=e.support.transition&&r;this.$backdrop=e('<div class="modal-backdrop '+r+'" />').appendTo(document.body);this.$element.on("click.dismiss.modal",e.proxy(function(e){if(e.target!==e.currentTarget)return;this.options.backdrop=="static"?this.$element[0].focus.call(this.$element[0]):this.hide.call(this)},this));if(i)this.$backdrop[0].offsetWidth;this.$backdrop.addClass("in");if(!t)return;i?this.$backdrop.one(e.support.transition.end,t).emulateTransitionEnd(150):t()}else if(!this.isShown&&this.$backdrop){this.$backdrop.removeClass("in");e.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one(e.support.transition.end,t).emulateTransitionEnd(150):t()}else if(t){t()}};var n=e.fn.modal;e.fn.modal=function(n,r){return this.each(function(){var i=e(this);var s=i.data("bs.modal");var o=e.extend({},t.DEFAULTS,i.data(),typeof n=="object"&&n);if(!s)i.data("bs.modal",s=new t(this,o));if(typeof n=="string")s[n](r);else if(o.show)s.show(r)})};e.fn.modal.Constructor=t;e.fn.modal.noConflict=function(){e.fn.modal=n;return this};e(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(t){var n=e(this);var r=n.attr("href");var i=e(n.attr("data-target")||r&&r.replace(/.*(?=#[^\s]+$)/,""));var s=i.data("modal")?"toggle":e.extend({remote:!/#/.test(r)&&r},i.data(),n.data());t.preventDefault();i.modal(s,this).one("hide",function(){n.is(":visible")&&n.focus()})});e(document).on("show.bs.modal",".modal",function(){e(document.body).addClass("modal-open")}).on("hidden.bs.modal",".modal",function(){e(document.body).removeClass("modal-open")})}(jQuery)});


})(jQuery, this);

/* TOAST JS */
!function(e){e(["jquery"],function(e){return function(){function t(e,t,n){return g({type:O.error,iconClass:m().iconClasses.error,message:e,optionsOverride:n,title:t})}function n(t,n){return t||(t=m()),v=e("#"+t.containerId),v.length?v:(n&&(v=d(t)),v)}function o(e,t,n){return g({type:O.info,iconClass:m().iconClasses.info,message:e,optionsOverride:n,title:t})}function s(e){C=e}function i(e,t,n){return g({type:O.success,iconClass:m().iconClasses.success,message:e,optionsOverride:n,title:t})}function a(e,t,n){return g({type:O.warning,iconClass:m().iconClasses.warning,message:e,optionsOverride:n,title:t})}function r(e,t){var o=m();v||n(o),u(e,o,t)||l(o)}function c(t){var o=m();return v||n(o),t&&0===e(":focus",t).length?void h(t):void(v.children().length&&v.remove())}function l(t){for(var n=v.children(),o=n.length-1;o>=0;o--)u(e(n[o]),t)}function u(t,n,o){var s=!(!o||!o.force)&&o.force;return!(!t||!s&&0!==e(":focus",t).length)&&(t[n.hideMethod]({duration:n.hideDuration,easing:n.hideEasing,complete:function(){h(t)}}),!0)}function d(t){return v=e("<div/>").attr("id",t.containerId).addClass(t.positionClass),v.appendTo(e(t.target)),v}function p(){return{tapToDismiss:!0,toastClass:"toast",containerId:"toast-container",debug:!1,showMethod:"fadeIn",showDuration:300,showEasing:"swing",onShown:void 0,hideMethod:"fadeOut",hideDuration:1e3,hideEasing:"swing",onHidden:void 0,closeMethod:!1,closeDuration:!1,closeEasing:!1,closeOnHover:!0,extendedTimeOut:1e3,iconClasses:{error:"toast-error",info:"toast-info",success:"toast-success",warning:"toast-warning"},iconClass:"toast-info",positionClass:"toast-top-right",timeOut:5e3,titleClass:"toast-title",messageClass:"toast-message",escapeHtml:!1,target:"body",closeHtml:'<button type="button">&times;</button>',closeClass:"toast-close-button",newestOnTop:!0,preventDuplicates:!1,progressBar:!1,progressClass:"toast-progress",rtl:!1}}function f(e){C&&C(e)}function g(t){function o(e){return null==e&&(e=""),e.replace(/&/g,"&amp;").replace(/"/g,"&quot;").replace(/'/g,"&#39;").replace(/</g,"&lt;").replace(/>/g,"&gt;")}function s(){c(),u(),d(),p(),g(),C(),l(),i()}function i(){var e="";switch(t.iconClass){case"toast-success":case"toast-info":e="polite";break;default:e="assertive"}I.attr("aria-live",e)}function a(){E.closeOnHover&&I.hover(H,D),!E.onclick&&E.tapToDismiss&&I.click(b),E.closeButton&&j&&j.click(function(e){e.stopPropagation?e.stopPropagation():void 0!==e.cancelBubble&&e.cancelBubble!==!0&&(e.cancelBubble=!0),E.onCloseClick&&E.onCloseClick(e),b(!0)}),E.onclick&&I.click(function(e){E.onclick(e),b()})}function r(){I.hide(),I[E.showMethod]({duration:E.showDuration,easing:E.showEasing,complete:E.onShown}),E.timeOut>0&&(k=setTimeout(b,E.timeOut),F.maxHideTime=parseFloat(E.timeOut),F.hideEta=(new Date).getTime()+F.maxHideTime,E.progressBar&&(F.intervalId=setInterval(x,10)))}function c(){t.iconClass&&I.addClass(E.toastClass).addClass(y)}function l(){E.newestOnTop?v.prepend(I):v.append(I)}function u(){if(t.title){var e=t.title;E.escapeHtml&&(e=o(t.title)),M.append(e).addClass(E.titleClass),I.append(M)}}function d(){if(t.message){var e=t.message;E.escapeHtml&&(e=o(t.message)),B.append(e).addClass(E.messageClass),I.append(B)}}function p(){E.closeButton&&(j.addClass(E.closeClass).attr("role","button"),I.prepend(j))}function g(){E.progressBar&&(q.addClass(E.progressClass),I.prepend(q))}function C(){E.rtl&&I.addClass("rtl")}function O(e,t){if(e.preventDuplicates){if(t.message===w)return!0;w=t.message}return!1}function b(t){var n=t&&E.closeMethod!==!1?E.closeMethod:E.hideMethod,o=t&&E.closeDuration!==!1?E.closeDuration:E.hideDuration,s=t&&E.closeEasing!==!1?E.closeEasing:E.hideEasing;if(!e(":focus",I).length||t)return clearTimeout(F.intervalId),I[n]({duration:o,easing:s,complete:function(){h(I),clearTimeout(k),E.onHidden&&"hidden"!==P.state&&E.onHidden(),P.state="hidden",P.endTime=new Date,f(P)}})}function D(){(E.timeOut>0||E.extendedTimeOut>0)&&(k=setTimeout(b,E.extendedTimeOut),F.maxHideTime=parseFloat(E.extendedTimeOut),F.hideEta=(new Date).getTime()+F.maxHideTime)}function H(){clearTimeout(k),F.hideEta=0,I.stop(!0,!0)[E.showMethod]({duration:E.showDuration,easing:E.showEasing})}function x(){var e=(F.hideEta-(new Date).getTime())/F.maxHideTime*100;q.width(e+"%")}var E=m(),y=t.iconClass||E.iconClass;if("undefined"!=typeof t.optionsOverride&&(E=e.extend(E,t.optionsOverride),y=t.optionsOverride.iconClass||y),!O(E,t)){T++,v=n(E,!0);var k=null,I=e("<div/>"),M=e("<div/>"),B=e("<div/>"),q=e("<div/>"),j=e(E.closeHtml),F={intervalId:null,hideEta:null,maxHideTime:null},P={toastId:T,state:"visible",startTime:new Date,options:E,map:t};return s(),r(),a(),f(P),E.debug&&console&&console.log(P),I}}function m(){return e.extend({},p(),b.options)}function h(e){v||(v=n()),e.is(":visible")||(e.remove(),e=null,0===v.children().length&&(v.remove(),w=void 0))}var v,C,w,T=0,O={error:"error",info:"info",success:"success",warning:"warning"},b={clear:r,remove:c,error:t,getContainer:n,info:o,options:{},subscribe:s,success:i,version:"2.1.3",warning:a};return b}()})}("function"==typeof define&&define.amd?define:function(e,t){"undefined"!=typeof module&&module.exports?module.exports=t(require("jquery")):window.toastr=t(window.jQuery)});
//# sourceMappingURL=toastr.js.map


/*Classie*/
/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 *
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

( function( window ) {

   'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

   function classReg( className ) {
      return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
   }

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
   var hasClass, addClass, removeClass;

   if ( 'classList' in document.documentElement ) {
      hasClass = function( elem, c ) {
         return elem.classList.contains( c );
      };
      addClass = function( elem, c ) {
         elem.classList.add( c );
      };
      removeClass = function( elem, c ) {
         elem.classList.remove( c );
      };
   }
   else {
      hasClass = function( elem, c ) {
         return classReg( c ).test( elem.className );
      };
      addClass = function( elem, c ) {
         if ( !hasClass( elem, c ) ) {
            elem.className = elem.className + ' ' + c;
         }
      };
      removeClass = function( elem, c ) {
         elem.className = elem.className.replace( classReg( c ), ' ' );
      };
   }

   function toggleClass( elem, c ) {
      var fn = hasClass( elem, c ) ? removeClass : addClass;
      fn( elem, c );
   }

   var classie = {
      // full names
      hasClass: hasClass,
      addClass: addClass,
      removeClass: removeClass,
      toggleClass: toggleClass,
      // short names
      has: hasClass,
      add: addClass,
      remove: removeClass,
      toggle: toggleClass
   };

// transport
   if ( typeof define === 'function' && define.amd ) {
      // AMD
      define( classie );
   } else {
      // browser global
      window.classie = classie;
   }

})( window );

/* Modernizr 2.8.1 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-csstransitions-shiv-cssclasses-prefixed-testprop-testallprops-domprefixes-load
 */
;window.Modernizr=function(a,b,c){function x(a){j.cssText=a}function y(a,b){return x(prefixes.join(a+";")+(b||""))}function z(a,b){return typeof a===b}function A(a,b){return!!~(""+a).indexOf(b)}function B(a,b){for(var d in a){var e=a[d];if(!A(e,"-")&&j[e]!==c)return b=="pfx"?e:!0}return!1}function C(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:z(f,"function")?f.bind(d||b):f}return!1}function D(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+n.join(d+" ")+d).split(" ");return z(b,"string")||z(b,"undefined")?B(e,b):(e=(a+" "+o.join(d+" ")+d).split(" "),C(e,b,c))}var d="2.8.0",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m="Webkit Moz O ms",n=m.split(" "),o=m.toLowerCase().split(" "),p={},q={},r={},s=[],t=s.slice,u,v={}.hasOwnProperty,w;!z(v,"undefined")&&!z(v.call,"undefined")?w=function(a,b){return v.call(a,b)}:w=function(a,b){return b in a&&z(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=t.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(t.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(t.call(arguments)))};return e}),p.csstransitions=function(){return D("transition")};for(var E in p)w(p,E)&&(u=E.toLowerCase(),e[u]=p[E](),s.push((e[u]?"":"no-")+u));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)w(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" "+(b?"":"no-")+a),e[a]=b}return e},x(""),i=k=null,function(a,b){function l(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function m(){var a=s.elements;return typeof a=="string"?a.split(" "):a}function n(a){var b=j[a[h]];return b||(b={},i++,a[h]=i,j[i]=b),b}function o(a,c,d){c||(c=b);if(k)return c.createElement(a);d||(d=n(c));var g;return d.cache[a]?g=d.cache[a].cloneNode():f.test(a)?g=(d.cache[a]=d.createElem(a)).cloneNode():g=d.createElem(a),g.canHaveChildren&&!e.test(a)&&!g.tagUrn?d.frag.appendChild(g):g}function p(a,c){a||(a=b);if(k)return a.createDocumentFragment();c=c||n(a);var d=c.frag.cloneNode(),e=0,f=m(),g=f.length;for(;e<g;e++)d.createElement(f[e]);return d}function q(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return s.shivMethods?o(c,a,b):b.createElem(c)},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+m().join().replace(/[\w\-]+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c("'+a+'")'})+");return n}")(s,b.frag)}function r(a){a||(a=b);var c=n(a);return s.shivCSS&&!g&&!c.hasCSS&&(c.hasCSS=!!l(a,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),k||q(a,c),a}var c="3.7.0",d=a.html5||{},e=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,f=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,g,h="_html5shiv",i=0,j={},k;(function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>",g="hidden"in a,k=a.childNodes.length==1||function(){b.createElement("a");var a=b.createDocumentFragment();return typeof a.cloneNode=="undefined"||typeof a.createDocumentFragment=="undefined"||typeof a.createElement=="undefined"}()}catch(c){g=!0,k=!0}})();var s={elements:d.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video",version:c,shivCSS:d.shivCSS!==!1,supportsUnknownElements:k,shivMethods:d.shivMethods!==!1,type:"default",shivDocument:r,createElement:o,createDocumentFragment:p};a.html5=s,r(b)}(this,b),e._version=d,e._domPrefixes=o,e._cssomPrefixes=n,e.testProp=function(a){return B([a])},e.testAllProps=D,e.prefixed=function(a,b,c){return b?D(a,b,c):D(a,"pfx")},g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+s.join(" "):""),e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};


/**
 * uiMorphingButton_inflow.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
;( function( window ) {

   'use strict';

   var transEndEventNames = {
         'WebkitTransition': 'webkitTransitionEnd',
         'MozTransition': 'transitionend',
         'OTransition': 'oTransitionEnd',
         'msTransition': 'MSTransitionEnd',
         'transition': 'transitionend'
      },
      transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
      support = { transitions : Modernizr.csstransitions };

   function extend( a, b ) {
      for( var key in b ) {
         if( b.hasOwnProperty( key ) ) {
            a[key] = b[key];
         }
      }
      return a;
   }

   function UIMorphingButton( el, options ) {
      this.el = el;
      this.options = extend( {}, this.options );
      extend( this.options, options );
      this._init();
   }

   UIMorphingButton.prototype.options = {
      closeEl : '',
      onBeforeOpen : function() { return false; },
      onAfterOpen : function() { return false; },
      onBeforeClose : function() { return false; },
      onAfterClose : function() { return false; }
   }

   UIMorphingButton.prototype._init = function() {
      // save element height
      this.elH = this.el.offsetHeight;
      // the button
      this.button = this.el.querySelector( 'button' );
      // state
      this.expanded = false;
      // content el
      this.contentEl = this.el.querySelector( '.morph-content' );
      // init events
      this._initEvents();
   }

   UIMorphingButton.prototype._initEvents = function() {
      var self = this;
      // open
      this.button.addEventListener( 'click', function() { self.toggle(); } );
      // close
      if( this.options.closeEl !== '' ) {
         var closeEl = this.el.querySelector( this.options.closeEl );
         if( closeEl ) {
            closeEl.addEventListener( 'click', function() { self.toggle(); } );
         }
      }
   }

   UIMorphingButton.prototype.toggle = function() {
      if( this.isAnimating ) return false;

      // callback
      if( this.expanded ) {
         this.options.onBeforeClose();
      }
      else {
         // add class active (solves z-index problem when more than one button is in the page)
         classie.addClass( this.el, 'active' );
         this.options.onBeforeOpen();
      }

      this.isAnimating = true;

      var self = this,
         onEndTransitionFn = function( ev ) {
            if( ev.target !== this ) return false;

            if( support.transitions ) {
               this.removeEventListener( transEndEventName, onEndTransitionFn );
            }
            self.isAnimating = false;

            // callback
            if( self.expanded ) {
               // remove class active (after closing)
               classie.removeClass( self.el, 'active' );
               self.options.onAfterClose();
            }
            else {
               self.options.onAfterOpen();
            }

            self.expanded = !self.expanded;
         };

      if( support.transitions ) {
         this.el.addEventListener( transEndEventName, onEndTransitionFn );
      }
      else {
         onEndTransitionFn();
      }

      // add/remove class "open" to the button wraper
      this.el.style.height = this.expanded ? this.elH + 'px' : this.contentEl.offsetHeight + 'px';

      if( this.expanded ) {
         classie.removeClass( this.el, 'open' );
      }
      else {
         classie.addClass( this.el, 'open' );
      }
   }

   // add to global namespace
   window.UIMorphingButton = UIMorphingButton;

})( window );


