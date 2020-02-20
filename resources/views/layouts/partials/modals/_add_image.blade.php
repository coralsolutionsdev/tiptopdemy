<div class="image-preview d-flex align-items-center">

<img id="output" @yield('image_source')>
      <script>
        var loadFile = function(event) {
          var reader = new FileReader();
          reader.onload = function(){
            var output = document.getElementById('output');
            output.src = reader.result;
          };
          reader.readAsDataURL(event.target.files[0]);
        };
      </script>
</div>

<div class="form-group upload">
<br>

      <div id="uploud">
        <div class="btn-upload d-flex justify-content-center">
          <div class="btn btn-secondary" style="">
          {{--<i class="fa fa-camera" aria-hidden="true"></i> --}}
              Upload
          <input type="file" class="form-control-file" name="image" accept="image/*" onchange="loadFile(event)">
          </div>
        </div>   
      </div>

</div>