(function() {
    tinymce.PluginManager.add('easy_affiliate_links_shortcode', function( editor, url ) {
        function replaceShortcodes( content ) {
            return content.replace( /\[eafl([^\]]*)\]/g, function( match ) {
                return html( match );
            });
        }

        function html( data ) {
            var id = data.match(/id="?'?(\d+)/i);
            var text = data.match(/text="([^"]+)/i);

            text = text == null ? 'affiliate link' : text[1];

            data = window.encodeURIComponent( data );
            return '<span style="border-bottom: 1px dashed #2980b9;" ' +
                'data-eafl-id="' + id[1] + '" data-eafl-shortcode="' + data + '">' + text + '</span>';
        }

        function restoreShortcodes( content ) {
            function getAttr( str, name ) {
                name = new RegExp( name + '=\"([^\"]+)\"' ).exec( str );
                return name ? window.decodeURIComponent( name[1] ) : '';
            }

            return content.replace( /(<span [^>]+>[^<]*<\/span>)/g, function( match, elem ) {
                var data = getAttr( elem, 'data-eafl-shortcode' );

                if ( data ) {
                    return data;
                }

                return match;
            });
        }

        editor.on( 'mouseup', function( event ) {
            var dom = editor.dom,
                node = event.target;

            if ( node.nodeName === 'SPAN' && dom.getAttrib( node, 'data-eafl-shortcode' ) ) {
                // Don't trigger on right-click
                if ( event.button !== 2 ) {
                    var id = dom.getAttrib( node, 'data-eafl-id' );
                    // TODO Edit this affiliate link
                }
            }
        });

        editor.on( 'BeforeSetContent', function( event ) {
            event.content = replaceShortcodes( event.content );
        });

        editor.on( 'PostProcess', function( event ) {
            if ( event.get ) {
                event.content = restoreShortcodes( event.content );
            }
        });
    });
})();