var Activity = (function() {
  var count = 0;

  var show, hide;

  var initialize = function() {
    show = function(){
    	jQuery('#dealer_map').append('<div id="activity"></div>');
    };

    hide = function() {
    	jQuery("#activity").remove();
    };
  };

  var start = function() {
    ++count;
    show();
  };

  var stop = function() {
    if (--count < 1) {
      count = 0;
      hide();
    }
  };

  return { initialize: initialize, start: start, stop: stop };
}());



/*
 * Dealers class is a basic model for dealer data.
 */
var Dealers = (function(GLatLng) {
  var dealers = {};

  var Dealer = function(data) {
//    var fields = data.custom_fields;
//    _.extend(this, {
//      id: data.id,
//      title: data.title,
//      phone_number: fields.phone_number,
//      website: fields.website,
//      address: fields.address.address
//    });
    
    var fields = data.custom_fields;
    _.extend(this, {
      id: data.id,
      title: data.title,
      phone_number: fields.phone_number,
      website: fields.website,
      address: fields.address.address,
      lat: fields.lat,
      lng: fields.lng
    });
    
    console.log(fields);

    // This is a little fragile
    // TODO: figure out what to do about it
    //var ll = fields.address.coordinates.split(',');
    //this.location = new GLatLng(ll[0], ll[1]);
    var latt = fields.address.lat;
    var lngg = fields.address.lng;
    
    this.location = new GLatLng(latt, lngg);
    console.log( this.location);
  };

  dealers.initialize = function(datas) {
    dealers.all = _.map(datas, function(data) { return new Dealer(data); });
  };

  return dealers;
})(google.maps.LatLng);


/*
 * DealerView is a basic viewmodel for displaying a dealer.
 */
var DealerView = (function() {
  var view = function(attributes) {
    _.extend(this, attributes);
    var t = this;
    t.name = t.dealer.title;

    _.each([
        'id', 'title', 'location', 'address', 'phone_number', 'website'
        ], function(attr) {
      t[attr] = t.dealer[attr];
    });
  };

  view.prototype.directions_url = function() {
    var base = "http://maps.google.com/maps?";
    var params = {
      f: 'd', hl: 'en',
      daddr: this.address
    };

    return base + jQuery.param(params);
  };

  return view;
})();

/*
 * Geolocator, abstract HTML5 geolocation api.
 */
var Geolocator = (function(GLatLng) {
  var geolocation_options = { enableHighAccuracy: true, timeout: 10 * 1000 * 1000, maximumAge: 0 };

  var self = function(callback) {
    this.callback = callback;
  };

  self.prototype.locate = function() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        _.bind(this.success, this), _.bind(this.error, this), geolocation_options
      );
    }
  };

  self.prototype.success = function(position) {
    // console.log(position);
    if (this.callback) {
      var latlng = new GLatLng(position.coords.latitude, position.coords.longitude);
      this.callback(latlng);
    }
  };

  self.prototype.error = function() { };

  return self;
})(google.maps.LatLng);


/*
 * DealerMap, all the google maps / dealer specific code.
 */
var DealerMap = (function() {
  var m = {};
  var MILES_TO_METERS = 1609.34;
  var dealer_views = [];
  var max_zoom = 12;

  var init_map = function(selector) {
    var mapOptions = {
      // Lebanon, Kansas - Geographic center of the continuous 48 states.
      // center: new google.maps.LatLng(39.828175, -98.5795),
      // Coffeyville, Kansas - Google maps default center
      center: new google.maps.LatLng(37.037778, -95.626389),
      // Northwestern Washington
      // center: new google.maps.LatLng(48.3, -122.2),
      zoom: 4, // - see the whole USA
      // zoom: 8, // - localized testing
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    m.map = new google.maps.Map(jQuery(selector)[0], mapOptions);
    google.maps.event.addListener(m.map, 'click', m.close_infowindow);
  };

  m.close_infowindow = function() {
    if (m.infowindow) {
      m.infowindow.close();
      m.infowindow = undefined;
      m.results.find('li[data-id]').removeClass('selected');
    }
  };

  m.open_infowindow = function(infowindow, marker) {
    m.close_infowindow();
    m.infowindow = infowindow;
    infowindow.open(m.map, marker);
  };

  m.select_dealer = function(dealer) {
    m.open_infowindow(dealer.infowindow, dealer.marker);
    m.results.find('li[data-id='+dealer.id+']').addClass('selected');
  };

  m.add_marker_for_dealer = function(dealer_view) {
    dealer_view.marker = new google.maps.Marker({
      position: dealer_view.location,
      map: m.map,
      title: dealer_view.name
    });

    dealer_view.infowindow = new google.maps.InfoWindow({
      content: m.infowindow_template(dealer_view)
    });

    dealer_view.select = _.bind(function() { m.select_dealer(this); }, dealer_view);
    google.maps.event.addListener(dealer_view.marker, 'click', dealer_view.select);
    dealer_views.push(dealer_view);
  };

  var sort_by_distance = function(a, b) {
    return a.distance_in_meters - b.distance_in_meters;
  };

  m.render_results = function() {
    m.results.html(m.results_template({
      dealers: dealer_views.sort(sort_by_distance)
    }));

    m.results.on('click', 'li', function() {
      var target_id = jQuery(this).data('id');
      var view = _.find(dealer_views, function(view) {
        return view.id == target_id;
      });

      if (view) view.select();
    });
  };

  m.remove_markers = function() {
    var view;
    while ((view = dealer_views.pop())) {
      view.marker.setMap(null);
    }
    m.results.empty();
  };

  m.geocode = function(place_name, callback) {
    if (m.geocode.cache[place_name]) return callback(m.geocode.cache[place_name]);

    Activity.start();
    m.geocoder.geocode({ 'address': place_name }, function(results, status) {
      Activity.stop();
      if (status == google.maps.GeocoderStatus.OK) {
        m.geocode.cache[place_name] = results[0].geometry;
        callback(results[0].geometry);
      } else {
        alert('Geocode for "' + place_name + '" was not successful for the following reason: ' + status);
      }
    });
  };
  m.geocode.cache = {};


  var dup_bounds = function(bounds) {
    return new google.maps.LatLngBounds(bounds.getSouthWest(), bounds.getNorthEast());
  };

  m.fit_bounds = function(viewport) {
    var bounds = dup_bounds(viewport);
    _.each(dealer_views, function(view) {
      bounds.extend(view.marker.getPosition());
    });

    m.map.fitBounds(bounds);
    if (m.map.getZoom() > max_zoom)
      m.map.setZoom(max_zoom);
  };



  m.show_dealers_within_of = function(dealers, miles, place_name) {
    m.remove_markers();

    if (jQuery.trim(place_name) === '') return;

    var meters = miles * MILES_TO_METERS;
    m.geocode(place_name, function(geometry) {
      // console.log('geocode result for ', place_name, geometry);
      _.each(dealers, function(dealer) {
        var distance = m.compute_distance_between(dealer.location, geometry.location);

        if (distance < meters) {
          var dealer_view = new DealerView({
            dealer: dealer,
            distance_in_meters: distance,
            distance_in_miles: distance / MILES_TO_METERS
          });

          m.add_marker_for_dealer(dealer_view);
        }
      });

      m.fit_bounds(geometry.viewport);
      m.render_results();
    });
  };

  m.initialize = function(selector) {
    m.geocoder = new google.maps.Geocoder();
    m.compute_distance_between = google.maps.geometry.spherical.computeDistanceBetween;
    init_map(selector);

    m.geolocator = new Geolocator(function(latlng) {
      // console.log(latlng);
      // HACK: Inject our geolocated value into the geocode cache,
      //  so that geocoding 'Your Location' returns your "location"
      m.geocode.cache['Your Location'] = {
        location: latlng, viewport: new google.maps.LatLngBounds(latlng, latlng)
      };
      jQuery('#location').val('Your Location').change();
    });


    // Only geolocate if the location field is empty
    if (jQuery.trim(jQuery('#location').val()) === '') {
      m.geolocator.locate();
    }

    m.results = jQuery('#results');
    m.results_template = _.template(jQuery('#results_template').html());
    m.infowindow_template = _.template(jQuery('#dealer_infowindow').html());
  };

  return m;
})();





/*
 * Ok, we haz all our support code, initialize already
 */
jQuery(document).ready(function() {

  DealerMap.initialize('#map_wrapper');
  Activity.initialize();


  var filter_map = function() {
    var distance = jQuery('#distance').val();
    var location = jQuery('#location').val();
    var dealers = Dealers.all;
    DealerMap.show_dealers_within_of(dealers, distance, location);
  };

  jQuery('form[action="#"]').submit(false);

  var api_url = jQuery('#map_wrapper').data('api-url');

  Activity.start();
  jQuery.getJSON(api_url, function(data) {
    Activity.stop();
    Dealers.initialize(data.posts);
    filter_map();

    // This happens so late because we can't wire up functionality until we have data.
    jQuery('#location, #distance').change(filter_map);
  });

});
