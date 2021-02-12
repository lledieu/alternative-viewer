/*
 *  mnesys
 */

(function($) {

$.MnesysTileSource = function( options ) {

	OpenSeadragon.TileSource.apply( this, [options] );

};

$.extend($.MnesysTileSource.prototype, $.TileSource.prototype, {

	supports: function( data, url ) {
		var test = url.match( /\/p\.xml$/ ) != null;
        	return( test );
	},

	configure: function( data, url ) {

		if( !data || !data.documentElement ) {
			throw new Error( $.getString( "Errors.Xml" ) );
		}

		var root = data.documentElement;
		var rootName = root.localName || root.tagName;

		if( rootName == "nao_jpeg_server" ) {
			var options = {};
			var layers = [];
	
			options.tilesUrl = url.replace( 'p.xml', '' );
			options.tilesUrl = options.tilesUrl.replace( 'CORS/mnesys-proxy.php?url=', '' );

			root.childNodes.forEach( function( c ) {
				if( c.nodeName == "layer" ) {
					var layer = {};

					for( i = 0; i < c.attributes.length; i++ ) {
						var name = c.attributes[i].name;
						if( name == "z" ) {
							layer[name] = parseFloat( c.attributes[i].value );
						} else {
							layer[name] = parseInt( c.attributes[i].value, 10 );
						}
					}

					if( layer.z == 1 ) {
						options.width = layer.w;
						options.height = layer.h;
					}

					if( layer.t ) {
						layer.cols = Math.floor(1 + layer.w / layer.t);
					} else {
						layer.cols = 1;
					}

					layers.push( layer );
				}
			});

			options.layers = layers;
			options.minLevel = 0;
			options.maxLevel = layers.length - 1;

			return options;
		}

		throw new Error( $.getString( "Errors.Xml" ) );
	},
	getTileUrl: function( level, x, y ) {
		var layer = this.layers[ level ];
		var tile = y * layer.cols + x;
		return( this.tilesUrl + level + "_" + tile + ".jpg" );
	},
	getTileWidth: function( level ) {
		var t = this.layers[level].t;
		if( !t ) {
			t = Math.max( this.layers[level].w, this.layers[level].h );
		}
		return t;
	},
	getTileHeight: function( level ) {
		var t = this.layers[level].t;
		if( !t ) {
			t = Math.max( this.layers[level].w, this.layers[level].h );
		}
		return t;
	},
	getLevelScale: function( level ) {
		return this.layers[level].z;
	}

});

}(OpenSeadragon));
