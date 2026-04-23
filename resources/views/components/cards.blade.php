<div class="row justify-content-center">
    <div class="col-xl-10">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                {{ $titulo }}
                </h5>
            </div>

            <div class="card-body">
                {{ $contenido }}
            </div>

            @if(isset($footer))
                <div class="card-footer bg-body-tertiary">
                {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
