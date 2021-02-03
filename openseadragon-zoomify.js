/*
 *  Zoomify with ImageProperties.xml
 */

(function($) {

$.MyZoomifyTileSource = function( options ) {
	var currentImageSize = {
		x: options.width,
		y: options.height
	};
	options.imageSizes = [{
		x: options.width,
		y: options.height
	}];
	options.gridSize = [this._getGridSize( options.width, options.height, options.tileSize )];

	while( parseInt(currentImageSize.x, 10) > options.tileSize ||
               parseInt(currentImageSize.y, 10) > options.tileSize ) {
		currentImageSize.x = Math.floor( currentImageSize.x / 2 );
		currentImageSize.y = Math.floor( currentImageSize.y / 2 );
		options.imageSizes.push({
			x: currentImageSize.x,
			y: currentImageSize.y
		});
		options.gridSize.push( this._getGridSize( currentImageSize.x, currentImageSize.y, options.tileSize ) );
	}
	options.imageSizes.reverse();
	options.gridSize.reverse();

	options.minLevel = 0;
	options.maxLevel = options.gridSize.length - 1;

	OpenSeadragon.TileSource.apply(this, [options]);
};

$.extend($.MyZoomifyTileSource.prototype, $.TileSource.prototype, {

	// Private
	_getGridSize: function ( width, height, tileSize ) {
		return {
			x: Math.ceil( width / tileSize ),
			y: Math.ceil( height / tileSize )
		};
	},

	// Private
	_calculateAbsoluteTileNumber: function ( level, x, y ) {
		var num = 0;
		var size = {};

		//Sum up all tiles below the level we want the number of tiles
		for( var z = 0; z < level; z++ ) {
			size = this.gridSize[z];
			num += size.x * size.y;
		}
		//Add the tiles of the level
		size = this.gridSize[level];
		num += size.x * y + x;

		return num;
	},

	supports: function( data, url ) {
		var test = url.match( /\/ImageProperties\.xml$/ ) != null;
        	return( test );
	},
	configure: function( data, url ) {

		if( !data || !data.documentElement ) {
			throw new Error( $.getString( "Errors.Xml" ) );
		}

		var root = data.documentElement;
		var rootName = root.localName || root.tagName;

		if( rootName = "IMAGE_PROPERTIES" ) {
			var options = {};

			options.tilesUrl = url.replace( 'ImageProperties.xml', '' );

			// From XML
			try {
				options.width = parseFloat( root.attributes["WIDTH"].nodeValue );
				options.height = parseFloat( root.attributes["HEIGHT"].nodeValue );
				// NUMTILES
				// NUMIMAGES
				// VERSION
				options.tileSize = parseFloat( root.attributes["TILESIZE"].nodeValue );
			} catch( e ) {
				throw (e instanceof Error) ? e : new Error( $.getString("Errors.Xml") );
			}

			return options;
		}

		throw new Error( $.getString( "Errors.Xml" ) );
	},
	getTileUrl: function( level, x, y ) {
		var result = 0;
		var num = this._calculateAbsoluteTileNumber( level, x, y );
		result = Math.floor( num / 256 );
		return this.tilesUrl + 'TileGroup' + result + '/' + level + '-' + x + '-' + y + '.jpg';
	}
});

}(OpenSeadragon));
