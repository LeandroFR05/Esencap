<div class="row justify-content-center">
    <div class="col-md-10">

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

            @if(isset($footer))
                <div class="card-footer bg-body-tertiary">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
