/*!
 * remark v1.0.7 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
(function(document, window, $) {
  'use strict';

  var Site = window.Site;

  $(document).ready(function($) {
    Site.run();
  });
	
  window.edit = function() {
    $('.click2edit').summernote({
      focus: true
    });
  };
  window.save = function() {
    $('.click2edit').destroy();
  };
  $('[data-plugin=summernote]').summernote({
		onpaste: function (e) {
			var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');

			e.preventDefault();

			document.execCommand('insertText', false, bufferText);
		}
	});
	$('.note-editable').css('height', '200px');
})(document, window, jQuery);
