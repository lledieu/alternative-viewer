/*
 *  alternative-viewer
 *
 *  params :
 *   param_initialPage : initial page index
 *   param_tileSources : tileSources array
 *   param_InitialZoom : null / {x, y, w, h}
 */

window.onload = function() {

var stateReferenceTrip = true;

const viewer = OpenSeadragon({
	id: "alternative-viewer",
	prefixUrl: "https://cdn.jsdelivr.net/npm/openseadragon@2.4/build/openseadragon/images/",
	sequenceMode: true,
	preserveViewport: true,
	showNavigator: true,
	showNavigationControl: false,
	showSequenceControl: false,
	showReferenceStrip: stateReferenceTrip,
	initialPage: param_initialPage,
	tileSources: param_tileSources
});

// Toggle shadowing
document.getElementById("navigation").onmouseover = function() {
	this.classList.remove( "nav-shadow" );
};
document.getElementById("navigation").onmouseleave = function() {
	this.classList.add( "nav-shadow" );
};

document.getElementById("l-bar").onmouseover = function() {
	this.classList.remove( "nav-shadow" );
};
document.getElementById("l-bar").onmouseleave = function() {
	this.classList.add( "nav-shadow" );
};

document.getElementById("r-bar").onmouseover = function() {
	this.classList.remove( "nav-shadow" );
};
document.getElementById("r-bar").onmouseleave = function() {
	this.classList.add( "nav-shadow" );
};

// Page control
document.getElementById("total").textContent = param_tileSources.length;

document.getElementById("inputvue").value = viewer.currentPage() + 1;
viewer.addHandler( 'page', function( e ) {
	document.getElementById("inputvue").value = e.page + 1;
});

function goToPage( isDelta, n ) {
	var max = viewer.tileSources.length - 1;
	var current = viewer.currentPage();
	if( isDelta ) {
		n = current + n;
	} else if ( -1 == n ) { // Last
		n = max;
	}
	if( n < 0 ) {
		n = 0;
	}
	if( n > max ) {
		n = max;
	}
	if( n != current ) {
		viewer.goToPage( n );
	}
	return n;
}

document.getElementById("nav-first").onclick = function() {
	goToPage( false, 0 );
};
document.getElementById("nav-ten-back").onclick = function() {
	goToPage( true, -10 );
};
document.getElementById("nav-one-back").onclick = function() {
	goToPage( true, -1 );
};
document.getElementById("inputvue").onchange = function() {
	this.value = 1 + goToPage( false, this.value - 1 );
};
document.getElementById("nav-one").onclick = function() {
	goToPage( true, +1 );
};
document.getElementById("nav-ten").onclick = function() {
	goToPage( true, +10 );
};
document.getElementById("nav-last").onclick = function() {
	goToPage( false, -1 );
};

document.getElementById("l-bar-nav-first").onclick = function() {
	goToPage( false, 0 );
};
document.getElementById("l-bar-nav-ten-back").onclick = function() {
	goToPage( true, -10 );
};
document.getElementById("l-bar-nav-one-back").onclick = function() {
	goToPage( true, -1 );
};

document.getElementById("r-bar-nav-one").onclick = function() {
	goToPage( true, +1 );
};
document.getElementById("r-bar-nav-ten").onclick = function() {
	goToPage( true, +10 );
};
document.getElementById("r-bar-nav-last").onclick = function() {
	goToPage( false, -1 );
};

// Change page on wheel
document.getElementById("inputvue").addEventListener( 'wheel', function( e ) {
	e.preventDefault();

	goToPage( true, (event.deltaY > 0) ? -1 : +1 );
});
document.getElementById("nav-one-back").addEventListener( 'wheel', function( e ) {
	e.preventDefault();

	goToPage( true, (event.deltaY > 0) ? -1 : +1 );
});
document.getElementById("nav-ten-back").addEventListener( 'wheel', function( e ) {
	e.preventDefault();

	goToPage( true, (event.deltaY > 0) ? -10 : +10 );
});
document.getElementById("nav-one").addEventListener( 'wheel', function( e ) {
	e.preventDefault();

	goToPage( true, (event.deltaY > 0) ? -1 : +1 );
});
document.getElementById("nav-ten").addEventListener( 'wheel', function( e ) {
	e.preventDefault();

	goToPage( true, (event.deltaY > 0) ? -10 : +10 );
});
document.getElementById("l-bar-nav-one-back").addEventListener( 'wheel', function( e ) {
	e.preventDefault();

	goToPage( true, (event.deltaY > 0) ? -1 : +1 );
});
document.getElementById("l-bar-nav-ten-back").addEventListener( 'wheel', function( e ) {
	e.preventDefault();

	goToPage( true, (event.deltaY > 0) ? -10 : +10 );
});
document.getElementById("r-bar-nav-one").addEventListener( 'wheel', function( e ) {
	e.preventDefault();

	goToPage( true, (event.deltaY > 0) ? -1 : +1 );
});
document.getElementById("r-bar-nav-ten").addEventListener( 'wheel', function( e ) {
	e.preventDefault();

	goToPage( true, (event.deltaY > 0) ? -10 : +10 );
});

// Manage rotation
function setRotation( angle ) {
	viewer.viewport.setRotation( viewer.viewport.getRotation() + angle );
}
document.getElementById("nav-rotate-left").onclick = function( e ) {
	if( true == e.shiftKey ) {
		setRotation( -45 );
	} else {
		setRotation( -90 );
	}
};
document.getElementById("nav-rotate-right").onclick = function( e ) {
	if( true == e.shiftKey ) {
		setRotation( +45 );
	} else {
		setRotation( +90 );
	}
};
function setRotationOnWheel( e ) {
	e.preventDefault();

	var step = 90;
	if( e.shiftKey ) {
		step = 45;
	} else if( e.ctrlKey ) {
		step = 1;
	}

	var current = viewer.viewport.getRotation();
	if( step != 1 ) {
		current = Math.round( current / step ) * step;
	}
	var direction = event.deltaY > 0 ? +1 : -1 ;

	viewer.viewport.setRotation( current + direction * step );
}
document.getElementById("nav-rotate-right").addEventListener( 'wheel', setRotationOnWheel );
document.getElementById("nav-rotate-left").addEventListener( 'wheel', setRotationOnWheel );

// Manage horizontal and vertical fit
document.getElementById("nav-fit-v").onclick = function() {
	viewer.viewport.fitVertically();
};
document.getElementById("nav-fit-h").onclick = function() {
	viewer.viewport.fitHorizontally();
};

// Manage zone zooming
var drag;
var selectionMode = false;
new OpenSeadragon.MouseTracker({
	element: viewer.element,
	pressHandler: function( event ) {
		if( !selectionMode ) {
			return;
		}

		var overlayElement = document.createElement( 'div' );
		overlayElement.classList.add( "zone" );
		var viewportPos = viewer.viewport.pointFromPixel( event.position );
		viewer.addOverlay( overlayElement, new OpenSeadragon.Rect( viewportPos.x, viewportPos.y, 0, 0) );

		drag = {
			overlayElement: overlayElement, 
			startPos: viewportPos
		};
	},
	dragHandler: function(event) {
		if( !drag ) {
			return;
		}

		var viewportPos = viewer.viewport.pointFromPixel( event.position );
		var diffX = viewportPos.x - drag.startPos.x;
		var diffY = viewportPos.y - drag.startPos.y;

		var location = new OpenSeadragon.Rect(
			Math.min( drag.startPos.x, drag.startPos.x + diffX ), 
			Math.min( drag.startPos.y, drag.startPos.y + diffY ), 
			Math.abs( diffX ), 
			Math.abs( diffY )
		);

		viewer.updateOverlay( drag.overlayElement, location );
	},
	releaseHandler: function( event ) {
		var rect = viewer.getOverlayById( drag.overlayElement ).getBounds( viewer.viewport );

		document.getElementById("nav-zone")._last =
			Math.round(100*rect.x) + ',' +
			Math.round(100*rect.y) + ',' +
			Math.round(100*rect.width) + ',' +
			Math.round(100*rect.height);

		viewer.viewport.fitBoundsWithConstraints( rect );

		viewer.removeOverlay( drag.overlayElement );
		drag = null;
		selectionMode = false;
		viewer.setMouseNavEnabled( true );
		document.body.style.cursor = "default";
		document.getElementById("nav-zone").classList.remove( "fa" );
		document.getElementById("nav-zone").classList.add( "far" );
	}
});
document.getElementById("nav-zone").onclick = function( e ) {
	if( true == e.shiftKey ) {
		alert( "Dernière zone : " + this._last );
	} else {
		selectionMode = true;
		viewer.setMouseNavEnabled( false );
		document.body.style.cursor = "crosshair";
		this.classList.remove( "far" );
		this.classList.add( "fa" );
	}
}
document.addEventListener( "keydown", function( e ) {
	if( e.key == "Escape" ) {
		if( true == selectionMode ) {
			if( drag != null ) {
				viewer.removeOverlay( drag.overlayElement );
				drag = null;
			}
			selectionMode = false;
			viewer.setMouseNavEnabled( true );
			document.body.style.cursor = "default";
			document.getElementById("nav-zone").classList.remove( "fa" );
			document.getElementById("nav-zone").classList.add( "far" );
		}
	}
});

// Toggle preserve viewport
document.getElementById("nav-lock").onclick = function() {
	viewer.preserveViewport = !viewer.preserveViewport;
	if( viewer.preserveViewport ) {
		this.classList.remove( 'fa-unlock' );
		this.classList.add( 'fa-lock' );
	} else {
		this.classList.remove( 'fa-lock' );
		this.classList.add( 'fa-unlock' );
	}
};

// Manage full screen
document.addEventListener( "fullscreenchange", function() {
	if( document.fullscreenElement ) {
		document.getElementById("nav-screen").classList.remove( 'fa-expand' );
		document.getElementById("nav-screen").classList.add( 'fa-compress' );
	} else {
		document.getElementById("nav-screen").classList.remove( 'fa-compress' );
		document.getElementById("nav-screen").classList.add( 'fa-expand' );
	}
});
document.getElementById("nav-screen").onclick = function() {
	if( this.classList.contains( 'fa-expand' ) ) {
		document.getElementById("alternative-viewer-container").requestFullscreen();
	} else {
		document.exitFullscreen();
	}
};

// Manage loader for main image
viewer.world.addHandler( 'add-item', function(addItemEvent ) {
	var tiledImage = addItemEvent.item;
	document.getElementById("loader").classList.remove( 'hidden' );
	document.getElementById("loader").classList.add( 'loader' );
	tiledImage.addHandler('fully-loaded-change', function(fullyLoadedChangeEvent) {
		document.getElementById("loader").classList.add( 'hidden' );
		document.getElementById("loader").classList.remove( 'loader' );
	});
});

// Manage download link
viewer.addHandler( 'tile-loaded', function( e ) {
	//console.log( e );
	var src = e.eventSource.source ;
	if( src.hasOwnProperty('@context') ) {
		document.getElementById("nav-download").href =  src['@id'] + "/full/full/0/native." + src.tileFormat ;
	} else if( src.url ) {
		document.getElementById("nav-download").href =  src.url ;
	} else {
/* Pour AD02		
https://archives.aisne.fr/archive/download?file=https://hatch.vtech.fr/cgi-bin/iipsrv.fcgi?FPY=1%26CSV=JPG%26FIF=
/home/httpd/ad02/data/files/images/FRAD002_EC/FRAD002_5Mi0288/FRAD002_5Mi0288_1480.jpg
*/
		document.getElementById("nav-download").href =  "TODO:" ;
	}
});

// Manage initial zoom
if( param_initialZoom ) {
	viewer.world.addOnceHandler( 'add-item', function(addItemEvent ) {
		var tiledImage = addItemEvent.item;
		tiledImage.addOnceHandler('fully-loaded-change', function(fullyLoadedChangeEvent) {
			var zone = document.createElement( 'div' );
			viewer.addOverlay( zone, new OpenSeadragon.Rect( param_initialZoom.x, param_initialZoom.y, param_initialZoom.w, param_initialZoom.h ) );
			viewer.viewport.fitBoundsWithConstraints( viewer.getOverlayById( zone ).getBounds( viewer.viewport ) );
		});
	});
}

// Needed for auto fade
viewer.addControl( "navigation", { anchor: "NONE" } );
viewer.addControl( "l-bar", { anchor: "NONE" } );
viewer.addControl( "r-bar", { anchor: "NONE" } );

}; //onload
