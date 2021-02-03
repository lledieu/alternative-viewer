/*
 *  Topview
 */

(function($) {

$.TopviewTileSource = function( options ) {

	OpenSeadragon.TileSource.apply( this, [options] );

};

$.extend($.TopviewTileSource.prototype, $.TileSource.prototype, {

	supports: function( data, url ) {
		var test = url.match( /topview.json/ ) != null;
        	return( test );
	},

	configure: function( data, url ) {
		var options = {};
	
		var topview = data.topviews[0];

		options.tilesUrl = "https://search.arch.be" + data.config.tileurl_v2.replace( '{file}', topview.filepath );

		options.width = topview.width;
		options.height = topview.height;
		options.tileWidth = topview.tileWidth;
		options.tileHeight = topview.tileHeight;
		options.minLevel = 0;
		options.maxLevel = topview.layers.length - 1;
		options.layers = topview.layers;

		return options;
	},

	getTileUrl: function( level, x, y ) {
		var layer = this.layers[ level ];
		var tile = layer.starttile + y * layer.cols + x;
		return( this.tilesUrl.replace( '{tile}', tile ) );
	}

});

}(OpenSeadragon));
