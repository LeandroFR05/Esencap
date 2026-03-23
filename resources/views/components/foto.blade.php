@props(['foto'])

@if($foto)
    <img src="{{ asset('storage/' . $foto) }}" 
         class="card-img-top img-fluid"
         style="height: 160px; object-fit: cover; object-position: center;">
@else
    <img src="https://www.solumex.com/wp-content/uploads/2013/11/dummy-image-square.jpg"
         class="card-img-top img-fluid"
         style="height: 160px; object-fit: cover;">
@endif