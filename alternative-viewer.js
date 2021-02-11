/*
 *  alternative-viewer
 *
 *  params : manifest
 *            - tileSources : array
 *            - sources : array
 *            - logo : string
 *            - title : string
 *            - home : string
 *            - current-index : int
 *            - initialZoom (optional) : {x, y, w, h}
 */

window.onload = function() {

const viewer = OpenSeadragon({
	id: "alternative-viewer",
	prefixUrl: "https://cdn.jsdelivr.net/npm/openseadragon@2.4/build/openseadragon/images/",
	sequenceMode: true,
	preserveViewport: true,
	showNavigator: true,
	navigatorSizeRatio: 0.15,
	showNavigationControl: false,
	showSequenceControl: false,
	maxZoomPixelRatio: 5,
	initialPage: manifest["current-index"],
	tileSources: manifest.tileSources
});

// Init logo
function init_logo() {
	var logo = document.getElementById("logo");

	var img = document.createElement( 'img' );
	img.src = manifest.logo;

	var a = document.createElement( 'a' );
	a.href = manifest.home;
	a.setAttribute( "title", manifest.title );
	a.appendChild( img );

	logo.appendChild( a );

	var span = document.createElement( 'span' );
	span.setAttribute( "title", manifest.desc );
	span.appendChild( document.createTextNode( manifest.desc ) );
	logo.appendChild( span );
}
init_logo();

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
document.getElementById("total").textContent = manifest.tileSources.length;

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

// Toggle ReferenceStrip and more
document.getElementById("nav-list-remove").onclick = function( e ) {
	viewer.removeReferenceStrip();
	this.classList.toggle( "inactive" );
	document.getElementById("nav-list-add").classList.toggle( "inactive" );
	if( true == e.shiftKey ) {
		document.getElementById("logo").classList.toggle( "inactive" );
		document.getElementById("navigation").classList.toggle( "inactive" );
		document.getElementById("l-bar").classList.toggle( "inactive" );
		document.getElementById("r-bar").classList.toggle( "inactive" );
		viewer.navigator.element.classList.toggle( "inactive" );
	}
};
document.getElementById("nav-list-add").onclick = function( e ) {
	viewer.addReferenceStrip();
	init_add_page();
	this.classList.toggle( "inactive" );
	document.getElementById("nav-list-remove").classList.toggle( "inactive" );
	if( true == e.shiftKey ) {
		document.getElementById("logo").classList.toggle( "inactive" );
		document.getElementById("navigation").classList.toggle( "inactive" );
		document.getElementById("l-bar").classList.toggle( "inactive" );
		document.getElementById("r-bar").classList.toggle( "inactive" );
		viewer.navigator.element.classList.toggle( "inactive" );
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

// Substitute params
function substitute( s, data ) {
	const vars = [...s.matchAll( /{([^}]*)}/g )];
	vars.forEach( e => s = s.replace( e[0], data[e[1]] ) );
	return s;
}

// Manage download link and permalink
document.getElementById("nav-permalink")["_url"] =  "" ;
var status_permalink = { 'i': -1, 'xhr': new XMLHttpRequest() };
viewer.addHandler( 'tile-loaded', function( e ) {
	//console.log( e, manifest );

	var index = e.eventSource._sequenceIndex;
	var data = manifest.sources[index];

	var src = e.eventSource.source ;
	if( src.hasOwnProperty('@context') ) { // IIIF
		document.getElementById("nav-download").href =  src['@id'] + "/full/full/0/default." + src.tileFormat ;
	} else if( src.url ) {
		document.getElementById("nav-download").href =  src.url ;
	} else if( data.download ) {
		document.getElementById("nav-download").href =  data.download ;
	} else if( manifest.download ) {
		var url = manifest.download;
		document.getElementById("nav-download").href = substitute( url, data ) ;
	} else {
		document.getElementById("nav-download").href =  'TODO:';
	}

	// Permalink
	if( data.permalink ) {
		document.getElementById("nav-permalink").href = data.permalink;
	} else if( manifest.permalink ) {
		var url = manifest.permalink;
		document.getElementById("nav-permalink").href = substitute( url, data );
	} else if( index != status_permalink.i ) {
		var url = manifest.ajax_pl;
		if( url ) {
			url = substitute( url, data );

			xhr = status_permalink.xhr;
			xhr.onreadystatechange = function() {
				if( xhr.readyState == 4 ) {
					if( xhr.status == 200 ) {
						if( index == status_permalink.i ) {
							document.getElementById("nav-permalink").href = xhr.responseText ;
							data.permalink = xhr.responseText;
						}
					} else {
						console.log( 'fail' );
						status_permalink.i = -1;
					}
				}
			};
			xhr.open( 'GET', url, true );
			xhr.send( null );
			status_permalink.i = index;
			document.getElementById("nav-permalink").href =  "loading:" ;
		} else {
			document.getElementById("nav-permalink").href =  "TODO:" ;
		}
	}
});

// Manage initial zoom
if( manifest.initialZoom ) {
	viewer.world.addOnceHandler( 'add-item', function(addItemEvent ) {
		var tiledImage = addItemEvent.item;
		tiledImage.addOnceHandler('fully-loaded-change', function(fullyLoadedChangeEvent) {
			var zone = document.createElement( 'div' );
			viewer.addOverlay( zone, new OpenSeadragon.Rect( manifest.initialZoom.x, manifest.initialZoom.y, manifest.initialZoom.w, manifest.initialZoom.h ) );
			viewer.viewport.fitBoundsWithConstraints( viewer.getOverlayById( zone ).getBounds( viewer.viewport ) );
		});
	});
}

// Manage initial highlight
/*
if( param_initialHighlight ) {
	viewer.world.addOnceHandler( 'add-item', function(addItemEvent ) {
		var tiledImage = addItemEvent.item;
		tiledImage.addOnceHandler('fully-loaded-change', function(fullyLoadedChangeEvent) {
			var zone = document.createElement( 'div' );
			zone.className = "highlight";
			zone.setAttribute( "title", "Message" );
			viewer.addOverlay( zone, new OpenSeadragon.Rect( param_initialHighlight.x, param_initialHighlight.y, param_initialHighlight.w, param_initialHighlight.h ) );
		});
	});
}
*/

// Needed for auto fade
viewer.addControl( "navigation", { anchor: "NONE" } );
viewer.addControl( "l-bar", { anchor: "NONE" } );
viewer.addControl( "r-bar", { anchor: "NONE" } );
viewer.addControl( "nav-list-remove", { anchor: "NONE" } );
viewer.addControl( "nav-list-add", { anchor: "NONE" } );

// Add page number
function v_add_page( id, v ) {
	var pagenum = 1 + parseInt( id.replace( /^.*-/, '' ) );
	var page_id = id + "-page";
	if( !v.getOverlayById( page_id ) ) {
		var div = document.createElement( 'div' );
		div.id = page_id;
		div.className = "pagenum";
		div.appendChild( document.createTextNode( pagenum ) );
		v.addOverlay( div, new OpenSeadragon.Point( 0, 0) );
	}
}
function init_add_page () {
	if( viewer.referenceStrip ) {
		var proxy = new Proxy( viewer.referenceStrip.miniViewers, {
			set: function( target, id, v ) {
				v_add_page( id, v );
				target[ id ] = v;
				return true;
			}
		});
		viewer.referenceStrip.miniViewers = proxy;
		Object.entries( viewer.referenceStrip.miniViewers ).forEach( ([id, v]) => v_add_page( id, v ) );
	}
}

}; //onload
