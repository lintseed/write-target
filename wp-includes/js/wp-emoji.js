
( function( window, settings ) {
	function wpEmoji() {
		var MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver,

		/**
<<<<<<< HEAD
=======
		 * Flag to determine if the browser and the OS support emoji.
		 *
		 * @since 4.2.0
		 *
		 * @var Boolean
		 */
		supportsEmoji = false,

		/**
		 * Flag to determine if the browser and the OS support flag (two character) emoji.
		 *
		 * @since 4.2.0
		 *
		 * @var Boolean
		 */
		supportsFlagEmoji = false,

		/**
>>>>>>> 3c97a521e358651cb1c2084e5ff494b19c026ba9
		 * Flag to determine if we should replace emoji characters with images.
		 *
		 * @since 4.2.0
		 *
		 * @var Boolean
		 */
		replaceEmoji = false,

<<<<<<< HEAD
		// Private
		twemoji, timer,
		loaded = false,
=======
		isIE8 = window.navigator.userAgent.indexOf( 'IE 8' ) !== -1,

		// Private
		twemoji, timer,
>>>>>>> 3c97a521e358651cb1c2084e5ff494b19c026ba9
		count = 0;

		/**
		 * Runs when the document load event is fired, so we can do our first parse of the page.
		 *
		 * @since 4.2.0
		 */
		function load() {
<<<<<<< HEAD
			if ( loaded ) {
				return;
			}

=======
>>>>>>> 3c97a521e358651cb1c2084e5ff494b19c026ba9
			if ( typeof window.twemoji === 'undefined' ) {
				// Break if waiting for longer than 30 sec.
				if ( count > 600 ) {
					return;
				}

				// Still waiting.
				window.clearTimeout( timer );
				timer = window.setTimeout( load, 50 );
				count++;

				return;
			}

			twemoji = window.twemoji;
<<<<<<< HEAD
			loaded = true;
=======
>>>>>>> 3c97a521e358651cb1c2084e5ff494b19c026ba9

			if ( MutationObserver ) {
				new MutationObserver( function( mutationRecords ) {
					var i = mutationRecords.length,
<<<<<<< HEAD
						addedNodes, removedNodes, ii, node;

					while ( i-- ) {
						addedNodes = mutationRecords[ i ].addedNodes;
						removedNodes = mutationRecords[ i ].removedNodes;
						ii = addedNodes.length;

						if (
							ii === 1 && removedNodes.length === 1 &&
							addedNodes[0].nodeType === 3 &&
							removedNodes[0].nodeName === 'IMG' &&
							addedNodes[0].data === removedNodes[0].alt
						) {
							return;
						}

						while ( ii-- ) {
							node = addedNodes[ ii ];
=======
						ii, node;

					while ( i-- ) {
						ii = mutationRecords[ i ].addedNodes.length;

						while ( ii-- ) {
							node = mutationRecords[ i ].addedNodes[ ii ];
>>>>>>> 3c97a521e358651cb1c2084e5ff494b19c026ba9

							if ( node.nodeType === 3 ) {
								node = node.parentNode;
							}

<<<<<<< HEAD
							if ( ! node || ( node.className && node.className.indexOf( 'wp-exclude-emoji' ) !== -1 ) ) {
								continue;
							}

=======
>>>>>>> 3c97a521e358651cb1c2084e5ff494b19c026ba9
							if ( node && node.nodeType === 1 ) {
								parse( node );
							}
						}
					}
				} ).observe( document.body, {
					childList: true,
					subtree: true
				} );
			}

			parse( document.body );
		}

		/**
		 * Given an element or string, parse any emoji characters into Twemoji images.
		 *
		 * @since 4.2.0
		 *
		 * @param {HTMLElement|String} object The element or string to parse.
		 * @param {Object} args Additional options for Twemoji.
		 */
		function parse( object, args ) {
<<<<<<< HEAD
			if ( ! replaceEmoji || ! twemoji ) {
=======
			if ( ! replaceEmoji ) {
>>>>>>> 3c97a521e358651cb1c2084e5ff494b19c026ba9
				return object;
			}

			args = args || {};

			return twemoji.parse( object, {
				base: settings.baseUrl,
				ext: settings.ext,
				className: args.className || 'emoji',
				imgAttr: args.imgAttr,
				callback: function( icon, options ) {
					// Ignore some standard characters that TinyMCE recommends in its character map.
					switch ( icon ) {
						case 'a9':
						case 'ae':
						case '2122':
						case '2194':
						case '2660':
						case '2663':
						case '2665':
						case '2666':
							return false;
					}

<<<<<<< HEAD
					if ( ! settings.supports.flag && settings.supports.simple &&
=======
					if ( ! supportsFlagEmoji && supportsEmoji &&
>>>>>>> 3c97a521e358651cb1c2084e5ff494b19c026ba9
						! /^1f1(?:e[6-9a-f]|f[0-9a-f])-1f1(?:e[6-9a-f]|f[0-9a-f])$/.test( icon ) ) {

						return false;
					}

					return ''.concat( options.base, icon, options.ext );
				}
			} );
		}

<<<<<<< HEAD
=======
		// Load when the readyState changes to 'interactive', not 'complete'.
		function onLoad() {
			if ( ( ! isIE8 && 'interactive' === document.readyState ) || ( isIE8 && 'complete' === document.readyState ) ) {
				load();
			}
		}

>>>>>>> 3c97a521e358651cb1c2084e5ff494b19c026ba9
		/**
		 * Initialize our emoji support, and set up listeners.
		 */
		if ( settings ) {
<<<<<<< HEAD
			replaceEmoji = ! settings.supports.simple || ! settings.supports.flag;

			if ( settings.DOMReady ) {
				load();
			} else {
				settings.readyCallback = load;
=======
			supportsEmoji = window._wpemojiSettings.supports.simple;
			supportsFlagEmoji = window._wpemojiSettings.supports.flag;
			replaceEmoji = ! supportsEmoji || ! supportsFlagEmoji;

			if ( ( ! isIE8 && 'loading' === document.readyState ) || ( isIE8 && 'complete' !== document.readyState ) ) {
				if ( document.addEventListener ) {
					document.addEventListener( 'readystatechange', onLoad, false );
				} else if ( document.attachEvent ) {
					document.attachEvent( 'onreadystatechange', onLoad );
				}
			} else {
				load();
>>>>>>> 3c97a521e358651cb1c2084e5ff494b19c026ba9
			}
		}

		return {
			replaceEmoji: replaceEmoji,
			parse: parse
		};
	}

	window.wp = window.wp || {};
	window.wp.emoji = new wpEmoji();

} )( window, window._wpemojiSettings );
