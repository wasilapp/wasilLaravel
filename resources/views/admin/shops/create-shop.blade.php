@extends('admin.layouts.app', ['title' => 'Create Shop'])

@section('css')
    <link href="{{asset('assets/libs/summernote/summernote.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{env('APP_NAME')}}</a>
                            </li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('admin.shops.index')}}">{{__('admin.shop')}}</a></li>
                            <li class="breadcrumb-item active">{{__('admin.create')}}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{__('admin.create_shop')}}</h4>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                <form action="{{route('admin.shops.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <h4 class="card-title">{{__('admin.general')}}</h4>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <label for="image">{{__('admin.image')}}</label>
                                            <input type="file" name="image" id="image" data-plugins="dropify"
                                                   data-default-file=""
                                                   class="form-control"/>
                                            <p class="text-muted text-center mt-2 mb-0">{{__('admin.upload_image')}}</p>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mt-0">
                                                        <label for="name">{{__('admin.name')}}</label>
                                                        <input type="text"
                                                               class="form-control @if($errors->has('name')) is-invalid @endif"
                                                               id="name" placeholder="Name" name="name"
                                                               value="{{old('name')}}">
                                                        @if($errors->has('name'))
                                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="col-12">
                                                    <div class="form-group mt-0">
                                                        <label for="email">{{__('admin.email')}}</label>
                                                        <input type="text"
                                                               class="form-control @if($errors->has('email')) is-invalid @endif"
                                                               id="email" placeholder="Email" name="email"
                                                               value="{{old('email')}}">
                                                        @if($errors->has('email'))
                                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group mt-0">
                                                        <label for="mobile">{{__('admin.mobile')}}</label>
                                                        <input type="tel"
                                                               class="form-control @if($errors->has('mobile')) is-invalid @endif"
                                                               id="mobile" placeholder="0795826120" name="mobile"
                                                               value="{{old('mobile')}}">
                                                        @if($errors->has('mobile'))
                                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="category">{{__('manager.category')}} <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="category" id="category">
                                                        <option disabled>Select Category</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <h4 class="card-title">{{__('admin.location')}}</h4>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <input type="text" placeholder="Search here for place in map.." name="search" id="search-box" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                <div id="map" style="height: 200px; width:500px;">

                                </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mt-0">
                                        <label for="address">{{__('admin.address')}}</label>
                                        <input type="text"
                                               class="form-control @if($errors->has('address')) is-invalid @endif"
                                               id="address" placeholder="Address" name="address"
                                               value="{{old('address')}}">
                                        @if($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mt-0">
                                        <label for="latitude">{{__('admin.latitude')}}</label>
                                        <input type="text"
                                               class="form-control @if($errors->has('latitude')) is-invalid @endif"
                                               id="latitude" placeholder="Latitude" name="latitude"
                                               value="{{old('latitude')}}">
                                        @if($errors->has('latitude'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('latitude') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mt-0">
                                        <label for="longitude">{{__('admin.longitude')}}</label>
                                        <input type="text"
                                               class="form-control @if($errors->has('longitude')) is-invalid @endif"
                                               id="longitude" placeholder="Longitude" name="longitude"
                                               value="{{old('longitude')}}">
                                        @if($errors->has('longitude'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('longitude') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="card" hidden>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <h4 class="card-title">{{__('manager.delivery_boy')}}</h4>
                                </div>


                                <div class="col-12 col-md-6" hidden>
                                    <div class="custom-checkbox custom-control">
                                        <input class="custom-control-input" type="checkbox" id="available_for_delivery"
                                               name="available_for_delivery" value="true">
                                        <label class="custom-control-label"
                                               for="available_for_delivery">{{__('manager.available_for_delivery')}}</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6" hidden>
                                    <div class="form-group mt-0">
                                        <label for="delivery_range">{{__('manager.delivery_range')}}</label>
                                        <div class="input-group">

                                            <input type="number" step="1" min="0"
                                                   class="form-control @if($errors->has('delivery_range')) is-invalid @endif"
                                                   id="delivery_range" placeholder="Delivery Range" name="delivery_range" value="99999">
                                            @if($errors->has('delivery_range'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('delivery_range') }}</strong>
                                        </span>
                                            @endif

                                            <div class="input-group-append">
                                                <span class="input-group-text"
                                                      id="basic-addon1">Meter</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>






                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <h4 class="card-title">{{__('manager.other')}}</h4>
                                </div>

                                <div class="col-12 col-md-12 mb-3">
                                    <div class="custom-checkbox custom-control">
                                        <input class="custom-control-input" type="checkbox" name="open" id="open">
                                        <label class="custom-control-label" for="open">{{__('manager.open')}}</label>
                                    </div>
                                </div>

                                {{-- <div class="col-12 col-md-6">
                                    <div class="form-group mt-0">
                                        <label for="default_tax">{{__('manager.default_tax')}}</label>
                                        <div class="input-group">
                                            <input type="number" step="1" min="0"
                                                   class="form-control @if($errors->has('default_tax')) is-invalid @endif"
                                                   id="default_tax" placeholder="Default Tax" name="default_tax">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon1">%</span>
                                            </div>
                                            @if($errors->has('default_tax'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('default_tax') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                </div> --}}






                            </div>
                        </div>
                    </div>


                    <div class="col mt-3 mb-3">
                        <div class="text-right">
                            <button type="submit"
                                    class="btn btn-success waves-effect waves-light mr-1">{{__('admin.create')}}
                            </button>
                            <a type="button" href="{{route('admin.shops.index')}}"
                               class="btn btn-danger waves-effect waves-light m-l-10">{{__('admin.cancel')}}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <!------ Summer note -------->
    <script>



var map;
var marker;
var lat = document.getElementById("latitude");
var lng = document.getElementById("longitude");
var placeName = document.getElementById("address");
var geocoder = new google.maps.Geocoder();

$(document).ready(function(){
  initMap();
});

function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 8
  });

  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      map.setCenter(pos);
      marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: pos
      });
    }, function() {
      handleLocationError(true, map.getCenter());
    });
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, map.getCenter());
  }

  google.maps.event.addListener(map, "click", function(event) {
    marker.setPosition(event.latLng);
    lat.value = event.latLng.lat();
    lng.value = event.latLng.lng();

    geocoder.geocode({'location': event.latLng}, function(results, status) {
      if (status === 'OK') {
        if (results[0]) {
          placeName.value = results[0].formatted_address;
        } else {
          window.alert('No results found');
        }
      } else {
        window.alert('Geocoder failed due to: ' + status);
      }
    });

    var infoWindow = new google.maps.InfoWindow({
      content: 'Latitude: ' + lat.value + '<br>' + 'Longitude: ' + lng.value
    });
    infoWindow.open(map, marker);
  });

  // Create the search box input field
  var input = document.getElementById('search-box');
  var searchBox = new google.maps.places.Autocomplete(input);

  // Add listener for the place changed event
  searchBox.addListener('place_changed', function() {
    var place = searchBox.getPlace();
    if (place.geometry) {
      // Set the position of the marker to the selected place
      marker.setPosition(place.geometry.location);
      map.setCenter(place.geometry.location);
      // Update the latitude and longitude input fields
      lat.value = place.geometry.location.lat();
      lng.value = place.geometry.location.lng();
      // Update the place name input field
      placeName.value = place.formatted_address;

      var infoWindow = new google.maps.InfoWindow({
        content: 'Latitude: ' + lat.value + '<br>' + 'Longitude: ' + lng.value
      });
      infoWindow.open(map, marker);
    }
  });
}
function handleLocationError(browserHasGeolocation, pos) {
    window.alert(browserHasGeolocation ?
                  'Error: The Geolocation service failed.' :
                  'Error: Your browser doesn\'t support geolocation.');
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('MAP_KEY')}}&callback=initMap&libraries=places"></script>


    <script src="{{asset('assets/libs/summernote/summernote.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/form-summernote.init.js')}}"></script>

    <!------ Dropify -------->

    <script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('assets/libs/dropify/dropify.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
@endsection
