@props(['foto'])

@if($foto)
    <img src="{{ asset('storage/' . $foto) }}" 
         class="card-img-top img-fluid"
         style="height: 160px; object-fit: cover; object-position: center;">
@else
    <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg"
         class="card-img-top img-fluid"
         style="height: 160px; object-fit: cover;">
@endif