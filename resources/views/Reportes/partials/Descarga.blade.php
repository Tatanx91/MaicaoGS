
<h3>Reporte Convenio</h3>
<br>
{{-- <table  style="border-style: solid;border-color: red !important;">
        <tr  style="background: '#137194' !important;color:'#FFFFFF' !important;">
            <td width="5%" align="center">No</td>
            <td width="25%" align="center">Empresa</td>
            <td width="25%" align="center">Numero De identifiacion</td>
        </tr>
        @if(isset($lista) && $lista == null)
        <p>entra</p>
            <tr><td colspan="3"></td align="center"><b>Sin Registros....</b></td></tr>
        @else
            @foreach($lista as $val)
                <tr>
                    <td width="5%" align="center">{{ $val->ID}}</td>
                    <td width="25%" align="center">{{ $val->Nombre}}</td>
                    <td width="25%" align="center">{{ $val->NumeroDocumento}}</td>

                </tr>
            @endforeach
        @endif
        <tr  style="margin-top: -10px;margin-bottom: 10px;border-top: 2px solid #085D8E;">
            <td colspan="3" align="center">
                <b>TOTAL</b>
            </td>
            <td align="center">
                <b>$123</b>
            </td>
        </tr>
</table> --}}
<table>
    <thead>
        <tr class="text-center">
         {{--   <th  align="center">No. Convenio</th>
            <th  align="center">Empresa</th>
            <th  align="center">Juguete</th>
            <th  align="center">Cantidad</th>
            <th  align="center">Fecha Inicio</th>
            <th  align="center">Fecha Fin</th> --}}
            <th>No</th>
            <th>Empresa</th>
            <th>Nombre Empleado</th>
            <th>Apellido Empleado</th>
            <th>Documento Empleado</th>
            <th>Telefono/Celular</th>
            <th>Dirección Empleado</th>
            <th>Ciudad</th>
            @if( $tipoReporte == 1)
                <th>Nombre Hijo</th>
                <th>Apellido Hijo</th>
                <th>Fecha Nacimiento</th>
                <th>Nombre Juguete</th>
                <th>Fecha inicial</th>
                <th>Fecha Fin</th>
            @endif
            <th>Fecha Seleccion</th>
        </tr>
    </thead>
    <tbody>
        <tr> 
            @if(isset($lista) && $lista == null)
                <tr>
                    <td colspan="3"></td align="center"><b>Sin Registros....</b></td>
                </tr>
            @else
                @foreach($lista as $val)
                    <tr>
                         <td align="center">{{ $val->IdConvenio}}</td>
                         <td align="center">{{ $val->NombreEmpresa}}</td>
                         <td align="center">{{ $val->NombreEmpleado}}</td>
                         <td align="center">{{ $val->ApellidoEmpleado}}</td>
                         <td align="center">{{ $val->NumeroDocumento}}</td>
                         <td align="center">{{ $val->Telefono}}</td>
                         <td align="center">{{ $val->Direccion}}</td>
                         <td align="center">{{ $val->Ciudad}}</td>
                         @if( $tipoReporte == 1)
                             <td align ="center">{{ $val->NombreHijo}}</td>
                             <td align ="center">{{ $val->ApellidoHijo}}</td>
                             <td align ="center">{{ $val->FechaNacimiento}}</td>
                             <td align="center">{{ $val->NombreJuguete}}</td>
                             <td align="center">{{ $val->FechaInicio}}</td>
                             <td align="center">{{ $val->FechaFin}}</td>
                         @endif
                         <td align="center">{{ $val->FechaSeleccion}}</td>
                        {{-- <td align="center">{{ $val->IdConvenio}}</td>
                        <td align="center">{{ $val->NombreEmpresa}}</td>
                        <td align="center">{{ $val->NombreJuguete}}</td>
                        <td align="center">{{ $val->StockInicial}}</td>
                        <td align="center">{{ $val->FechaInicio}}</td>
                        <td align="center">{{ $val->FechaFin}}</td> --}}
                    </tr>
                @endforeach
            @endif
        </tr>
    </tbody>
</table>
<br>
