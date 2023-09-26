( function( $ ) {

	languageSelector();

	function languageSelector(){
		$('#menu-accessibility .current-lang').click(function(e){
			var currLang = $('#menu-accessibility .current-lang').detach();
			currLang.prependTo($('#menu-accessibility'));
			$('#menu-accessibility .lang-item:not(.current-lang)').toggle();
		});
		$('#menu-accessibility .current-lang a').click(function(e){
			e.preventDefault();
		});
	}

})( jQuery );