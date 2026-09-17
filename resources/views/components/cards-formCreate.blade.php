<div class="col-md-6">

    <div class="card">
        @if(isset($titulo))
            <div class="card-header text-black">
                <h5 class="mb-0 mt-3">
                    {{ $titulo }}
                </h5>
            </div>
        @endif

        <div class="card-body {{ $bodyClass ?? '' }}">
            {{ $contenido }}
        </div>
    </div>
</div>