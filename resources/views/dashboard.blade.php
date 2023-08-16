@extends('template')
@section('content')
    <style></style>
    <div class="container">
        <div class="row row-cols-4 mt-5  justify-content-center">
            @if ($rol == 'root' || $rol=="ENCARGADO")
                <div class="col d-flex flex-column align-items-center dash-icon-hover " id="">
                    <div class="a-click" id="personal">{{ svg('ri-folder-user-line') }}</div>
                    <span>Personal</span>
                </div>
            @endif
            <div class="col d-flex flex-column align-items-center dash-icon-hover " id="">
                <div class="a-click" id="vehiculos">{{ svg('ri-roadster-fill') }}</div><span>Vehiculos</span>
            </div>
            <div class="col d-flex flex-column align-items-center dash-icon-hover " id="">
                <div class="a-click" id="tramos">{{ svg('ri-calendar-event-fill') }}</div><span>Tramos Horarios</span>
            </div>
            <div class="col d-flex flex-column align-items-center dash-icon-hover " id="">
                <div class="a-click" id="dispositivos">{{ svg('ri-traffic-light-line') }}</div>
                <span>Dispositivos</span>
            </div>
        </div>
    </div>
@endsection
