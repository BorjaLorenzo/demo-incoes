@extends('template')
@section('content')
    <style></style>
    <div class="container">
        <div class="row row-cols-4 mt-5  justify-content-center">
            @if ($rol == 'root' || $rol=="ENCARGADO")
                <div class="col d-flex flex-column align-items-center dash-icon-hover " id="">
                    <div class="a-click" id="personal">{{ svg('healthicons-o-construction-worker') }}</div>
                    <span>Personal</span>
                </div>
            @endif
            <div class="col d-flex flex-column align-items-center dash-icon-hover " id="">
                <div class="a-click" id="vehiculos">{{ svg('fas-car') }}</div><span>Vehiculos</span>
            </div>
            <div class="col d-flex flex-column align-items-center dash-icon-hover " id="">
                <div class="a-click" id="tramos">{{ svg('akar-schedule') }}</div><span>Tramos Horarios</span>
            </div>
            <div class="col d-flex flex-column align-items-center dash-icon-hover " id="">
                <div class="a-click" id="dispositivos">{{ svg('tabler-device-desktop-analytics') }}</div>
                <span>Dispositivos</span>
            </div>
        </div>
    </div>
@endsection
