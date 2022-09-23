@extends('layout.main');
@section('container')

{{-- <a href="/logout" class="btn btn-info">Logout</a> --}}
<div class="container">
  <div id="info"></div>
  @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success')}}
    </div>
  @endif

  @if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error')}}
    </div>
  @endif

  <div class="card">
    <div class="card-body"><div class="col-md-12 ">
        <div style="display: flex">
          <a href="/logout" class="btn btn-info">Logout</a>
          <h2 style="padding-left:10px; text-transform:uppercase">Jelajai Lokasi dan Beri Ulasan</h2>
        </div>
      </div></div> 
  </div>


  <div class="row">
    <div class="col-md-8 mb-3">
      <div class="card">
        <div class="card-header bg-dark text-white">
          MapBox
        </div>
        <div class="card-body">
          <div id="map"></div>
        </div>
      </div>
    </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-header bg-dark text-white">
            Beri Ulasan Lokasi
          </div>
          <div class="card-body">
            <form action="/dashboard" method="POST">
              @csrf
              <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="title" id="title" placeholder="Nama Tempat">
                  <label for="title">Judul</label>
                </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="address" id="address" placeholder="Alamat">
                <label for="address">Alamat</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="coordinate" id="coordinate" value="" placeholder="Titik Koordinat" readonly>
                <label for="coordinate">Titik Koordinat</label>
              </div>
              <select class="form-select mb-3" name="rating">
                  <option value="-">Beri Penilaian</option>
                  <option value="Luar Biasa">Luar Biasa</option>
                  <option value="Bagus">Bagus</option>
                  <option value="Cukup Bagus">Cukup Bagus</option>
                  <option value="Tidak Bagus">Tidak Bagus</option>
                </select>
                <div class="form-floating mb-3">
                  <textarea class="form-control" name="description" style="height: 100px"></textarea>
                  <label for="floatingTextarea2">Tambah Keterangan</label>
                </div>
              <button type="submit" class="btn btn-primary" style="width:100%">Simpan Lokasi</button>
            </form>
          </div>
        </div>
      </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-dark text-white">
        Ulasan Anda
      </div>
      <div class="card-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Tempat</th>
                <th scope="col">Alamat Lokasi</th>
                <th scope="col">Titik Koordinat</th>
                <th scope="col">Penilaian</th>
                <th scope="col">Keterangan</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($posts as $post)
              <tr id="coords">
                <th scope="row">{{ $no++ }}</th>
                <td>{{ $post->title }}</td>
                <td>{{ $post->address }}</td>
                <td id="coord" value="{{ $post->coordinate }}">{{ $post->coordinate }}</td>
                <td>{{ $post->rating }}</td>
                <td>{{ $post->description }}</td>
              </tr>
              @endforeach
            </tbody>
      </div>
    </div>
  </div>
</div>
  </div>
</div>



  <script>
      mapboxgl.accessToken = "{{ env('MAPBOX_KEY') }}";
      const map = new mapboxgl.Map({
      container: 'map', // container id
      // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [106.87, -6.25], // starting position
      zoom: 9 // starting zoom
      });

      const coordinatesGeocoder = function (query) {
      const matches = query.match(
      /^[ ]*(?:Lat: )?(-?\d+\.?\d*)[, ]+(?:Lng: )?(-?\d+\.?\d*)[ ]*$/i
      );
      if (!matches) {
      return null;
      }
      
      function coordinateFeature(lng, lat) {
      return {
      center: [lng, lat],
      geometry: {
      type: 'Point',
      coordinates: [lng, lat]
      },
      place_name: 'Lat: ' + lat + ' Lng: ' + lng,
      place_type: ['coordinate'],
      properties: {},
      type: 'Feature'
      };
      }
      
      const coord1 = Number(matches[1]);
      const coord2 = Number(matches[2]);
      const geocodes = [];
      
      if (coord1 < -90 || coord1 > 90) {
      // must be lng, lat
      geocodes.push(coordinateFeature(coord1, coord2));
      }
      
      if (coord2 < -90 || coord2 > 90) {
      // must be lat, lng
      geocodes.push(coordinateFeature(coord2, coord1));
      }
      
      if (geocodes.length === 0) {
      // else could be either lng, lat or lat, lng
      geocodes.push(coordinateFeature(coord1, coord2));
      geocodes.push(coordinateFeature(coord2, coord1));
      }
      
      return geocodes;
      };
      
      // Add the control to the map.
      map.addControl(
        new MapboxGeocoder({
          accessToken: mapboxgl.accessToken,
          localGeocoder: coordinatesGeocoder,
          zoom: 9,
          placeholder: 'Cari Lokasi',
          mapboxgl: mapboxgl,
          reverseGeocode: true
        })
      );

      map.addControl(new mapboxgl.NavigationControl)

      map.addControl(new mapboxgl.GeolocateControl({
      positionOptions: {
      enableHighAccuracy: true
      },
      trackUserLocation: true,
      showUserHeading: true
      }));

      map.on("click", (e) => {
          mapClickFn(e.lngLat);
      });

      function mapClickFn(coordinates) {
      const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${coordinates.lng},${coordinates.lat}.json?access_token=pk.eyJ1IjoiYXJrYW5mYXV6YW45MyIsImEiOiJja3U2djJtYjcycm00Mm5vcTh0bHJxMmh6In0.8p3Sy60ztY0-uY-UTZSFHQ`;
        $.get(url, function(data) {
          if (data.features.length>false) {
            let address = data.features[0].place_name;
            let text = data.features[0].text;
            // console.log(JSON.stringify(data));
            document.getElementById('coordinate').value =  `${coordinates.lat}, ${coordinates.lng}`;
            document.getElementById('address').value =  `${address}`;
            document.getElementById('title').value =  `${text}`;
          } else {
            console.log("No address found");
          }
        });
      }

      let coords = document.getElementById('coords');
      let coord = document.getElementById('coord');
      coords.addEventListener('click', ()=>{
        console.log(coord.innerHTML)
      })

</script>
@endsection