@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($cliente->idcliente) && $cliente->idcliente > 0 ? $cliente->idcliente : 0; ?>';
    <?php $globalId = isset($cliente->idcliente) ? $cliente->idcliente : "0"; ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/clientes">Clientes</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/cliente/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fas fa-save" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if ($globalId > 0)
    <li class="btn-item"><a title="Eliminar" href="#" class="fas fa-trash-alt" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fas fa-reply" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
    function fsalir() {
        location.href = "/admin/clientes";
    }
</script>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="panel-body">
    <div id="msg"></div>
    <?php
    if (isset($msg)) {
        echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
    }
    ?>
    <form id="form1" method="POST">
        <div class="row">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
            <div class="form-group col-lg-6">
                <label>Nombre: *</label>
                <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{ $cliente->nombre or '' }}" required>
            </div>
            <div class="form-group col-lg-6">
                <label>Apellido: *</label>
                <input type="text" id="txtApellido" name="txtApellido" class="form-control" value="{{ $cliente->apellido or '' }}" required>
            </div>
            <div class="form-group col-lg-6">
                <label>DNI:</label>
                <input type="text" id="txtDni" name="txtDni" class="form-control" value="{{ $cliente->dni or '' }}" required>
            </div>
            <div class="form-group col-lg-6">
                <label>Telefono:</label>
                <input type="text" id="txtTelefono" name="txtTelefono" class="form-control" value="{{ $cliente->telefono or ''}}">
            </div>
            <div class="form-group col-lg-6">
                <label>Direccion</label>
                <input type="text" id="txtDireccion" name="txtDireccion" class="form-control" value="{{ $cliente->direccion or ''}}">
            </div>
            <div class="form-group col-lg-6">
                <label>Codigo Postal:</label>
                <input type="text" id="txtCodigo_postal" name="txtCodigo_postal" class="form-control" value="{{ $cliente->codigo_postal or ''}}">
            </div>
            <div class="form-group col-lg-6">
                <label>Fecha Nacimiento:</label>
                <input type="date" id="txtFechaNac" name="txtFechaNac" class="form-control" value="{{ $cliente->fecha_nac or ''}}">
            </div>
            <div class="form-group col-lg-6">
                <label>Correo electrónico:</label>
                <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" value="{{ $cliente->correo or '' }}">
            </div>
            <div class="form-group col-lg-6">
                <label for="lstUsuario">Usuario *</label>
                <select name="lstUsuario" id="lstUsuario" class="form-control selectpicker" data-live-search="true" required>
                <option value="" disabled>Seleccionar usuario</option>
                    @for($i = 0; $i < count($array_usuarios); $i++) @if(isset($cliente) && $cliente->fk_idusuario == $array_usuarios[$i]->idusuario)
                        <option selected value="{{ $array_usuarios[$i]->idusuario }}">{{ $array_usuarios[$i]->usuario }}</option>
                        @else
                        <option value="{{ $array_usuarios[$i]->idusuario }}">{{ $array_usuarios[$i]->usuario }}</option>
                        @endif
                        @endfor
                </select>
            </div>
        </div>
</div>
</form>
</div>
<div class="modal fade" id="mdlEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar registro?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">¿Deseas eliminar el registro actual?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="eliminar();">Sí</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#form1").validate();
    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit();
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }
    function eliminar() {
        $.ajax({
            type: "GET",
            url: "{{ asset('/admin/cliente/eliminar') }}",
            data: {
                id: globalId
            },
            async: true,
            dataType: "json",
            success: function(data) {
                if (data.err = "0") {
                    msgShow("Registro eliminado exitosamente.", "success");
                    $("#btnEnviar").hide();
                    $("#btnEliminar").hide();
                    $('#mdlEliminar').modal('toggle');
                    $("form").hide();
                } else {
                    msgShow("Error al eliminar", "success");
                }
            }
        });
    }
</script>
@endsection