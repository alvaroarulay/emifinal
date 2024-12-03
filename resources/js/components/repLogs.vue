<template>
    <main class="app-content">
    <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Registro de Movimientos</h1> 
        </div>
    </div>
<div class="row justify-content-center">
<div class="col-lg-10">
    <div class="card shadow-lg border-0 rounded-lg mt-12">
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body table-responsive">
                <DataTable :data="Logs" :columns="columns" class="table table-striped table-bordered display"
                :options="{ autowidth:true, dom:'Bfrtip', language:{
                    search:'Buscar', zeroRecords:'No hay registros que Mostrar',
                    info: 'Mostrando del _START_ a _END_ de _TOTAL_ registros',
                    infoFiltered: '(Filtrados de _MAX_ registros.)',
                    paginate:{first:'Primero', previous:'Anterior', next:'Siguiente', last:'Ultimo'}},
                    buttons:botones
                    }" 
                    >
                <thead>
                    <tr>
                        <th>CÓDIGO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>USUARIO</th>
                        <th>FECHA</th>
                    </tr>
                </thead>
            </DataTable>
            </div>
          </div>
        </div>
    </div>
    </div>
    </div>
    </div> <!-- Fin ejemplo de tabla Listado -->
    
    </main>
</template>

<script>
import axios from 'axios';
import DataTable from 'datatables.net-vue3';
import DataTableLib from 'datatables.net-bs5';
import Buttons from 'datatables.net-buttons-bs5';
import ButtonsHtml5 from 'datatables.net-buttons/js/buttons.html5';
import print from 'datatables.net-buttons/js/buttons.print';
import pdfmake from 'pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
import 'datatables.net-responsive-bs5';
import JsZip from 'jszip';
pdfmake.vfs = pdfFonts.pdfMake.vfs;
window.JSZip = JsZip;
DataTable.use(DataTableLib);
DataTable.use(pdfmake);
DataTable.use(ButtonsHtml5);

export default {
    components: {DataTable},
    data (){
        return {
        Logs : null,
        arrayTitulos:[],
        columns : [
            {data:'codigo'},
            {data:'descripcion'},
            {data:'user'},
            {data:'created_at'},
            ],
        botones:[
            {
                title: 'Reporte de Movimientos',
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel',
                className: 'btn btn-success'
            },
            
            {
                title: 'Reporte de Movimientos',
                extend: 'print',
                text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                className: 'btn btn-dark'
            },
        ]
        }  
    },
    methods : {
        buscarLogs(){
            let me=this;
            var url = '/log/replogs';
            axios.get(url).then((res)=>{
                me.Logs= res.data.logs;
            }
            ).catch((e)=>{
            console.log(e);
            })
        },
    },
    mounted() {
        this.buscarLogs();
    }
}
</script>
<style>  
   @import 'datatables.net-bs5';
</style>
