<template>
    <main class="app-content">
         <div class="app-title row">
             <div class="col-md-8">
                <h1><i class="bi bi-collection"></i> Unidad: <p v-text="titulo"></p></h1> 
             </div>
             <div class="col-md-4">
                 <select class="form-select" @change="onChangeUnidad($event)" v-model="idunidad" v-if="idrol==1">
                     <option v-for="unidad in arrayUnidad" :value="unidad.unidad" v-text="unidad.descrip"></option>
                 </select>
             </div>
        </div>
     <div class="tile">
         <h3 class="tile-title">Detalles del Grupo Contable</h3>
         <div class="tile-body">
             <div class="row">
                 <div class="col-md-4">
                     <div class="mb-3 row">
                     <label class="form-label col-md-3">Grupo</label>
                     <div class="col-md-8">
                         <input class="form-control" type="text" v-model="codcont" disabled>
                     </div>
                     </div>
                     <div class="mb-3 row">
                     <label class="form-label col-md-3">Vida Útil</label>
                     <div class="col-md-8">
                         <input class="form-control col-md-8" v-model="vidautil" disabled>
                     </div>
                     </div>
                 </div>
                 <div class="col-md-8">
                     <div class="mb-3 row">
                     <label class="form-label col-md-3">Grupo Contable</label>
                     <div class="col-md-8">
                         <select class="form-select" @change="onChangeCodigo($event)">
                            <option value="0" selected> Seleccione...</option>
                             <option v-for="gcont in arrayContables" :value="gcont.codcont" v-text="gcont.nombre"></option>
                         </select>
                     </div>
                     </div>
                     <div class="mb-3 row">
                     <label class="form-label col-md-3">Observaciones</label>
                     <div class="col-md-8">
                         <textarea name="" id="" cols="30" rows="2" class="form-control col-md-8" v-model="observaciones" disabled></textarea>
                     </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <template v-if="listado==1">
          <div class="row mb-3">
         <div class="col-md-12">
           <div class="tile">
             <div class="row">
                <div class="col-md-10">
                    <h3><i class="bi bi-calculator"></i> Auxiliares</h3>
                </div>
                <div class="col-md-2">
                    <button type="submit" @click="revisarNuevos()" class="btn btn-primary" v-if="idrol==1"><i class="bi bi-arrow-clockwise"></i> Actualizar Datos</button>
                </div>
             </div>
                <div class="row mb-3">
                     <div class="col-md-6">
                    <div class="input-group">
                        <select class="form-select col-md-3" v-model="criterio">
                            <option value="codaux">Código</option>
                            <option value="nomaux" selected>Nombre</option>
                        </select>
                        <input type="text" v-model="buscar" @keyup.enter="listarAuxiliar(1,buscar,criterio,codcont)" class="form-control" placeholder="Texto a buscar">
                        <button type="submit" @click="listarAuxiliar(1,buscar,criterio,codcont)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
               
                 
             </div>
             
             <div class="tile-body table-responsive table-fixed">
                  <table class="table table-bordered table-striped table-sm">
                     <thead>
                         <tr>
                             <th>Opciones</th>
                             <th>Código</th>
                             <th>Nombre Auxiliar</th>
                         </tr>
                     </thead>
                     <tbody v-if="arrayAuxiliar.length">
                         <tr v-for="auxiliar in arrayAuxiliar" :key="auxiliar.id">
                             <td>
                                 <button type="button" @click="abrirModal(auxiliar)" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar">
                                   <i class="bi bi-pencil-square"></i>
                                 </button>
                                 <button type="button" @click="abrirlistado(auxiliar)" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Activos">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-suitcase-lg-fill" viewBox="0 0 16 16">
                                        <path d="M7 0a2 2 0 0 0-2 2H1.5A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14H2a.5.5 0 0 0 1 0h10a.5.5 0 0 0 1 0h.5a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2H11a2 2 0 0 0-2-2zM6 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1zM3 13V3h1v10zm9 0V3h1v10z"/>
                                    </svg>
                                 </button>
                             </td>
                             <td v-text="auxiliar.codaux"></td>
                             <td v-text="auxiliar.nomaux"></td>
                         </tr>                                
                     </tbody>
                     <tbody v-else>
                         <tr>
                             <td colspan="3">
                                 NO hay Auxiliares en este Grupo
                             </td>
                         </tr>
                     </tbody>
                     <tfoot>
                        <tr>
                            <th>Cantidad:</th>
                            <th v-text="totalAuxiliares" colspan="2"></th>
                        </tr>
                        
                     </tfoot>  
                 </table>
             </div>
           </div>
         </div>
     </div>
     </template>
     <template v-if="listado==2">
        <div class="row">
            <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Activos Fijos del Auxiliar: {{ nombre_auxiliar }}</h3>
            <div class="row mb-3">
                     <div class="col-md-6">
                    <div class="input-group">
                        <select class="form-select col-md-3" v-model="criterio1">
                            <option value="codigo">Código</option>
                            <option value="descrip" selected>Descripcion</option>
                        </select>
                        <input type="text" v-model="buscar1" @keyup.enter="listarActivos(codcont, codaux, criterio1, buscar1)" class="form-control" placeholder="Texto a buscar">
                        <button type="submit" @click="listarActivos(codcont, codaux, criterio1, buscar1)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
               </div>
            <div class="tile-body table-responsive table-fixed">
                <table class="table table-hover">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Descripción</th>
                </tr>
              </thead>
              <tbody v-if="arrayActivos.length">
                <tr v-for="activo in arrayActivos" :key="activo.id">
                  <td>{{ activo.codigo }}</td>
                  <td>{{ activo.descrip }}</td>
                </tr>
              </tbody>
              <tbody v-else>
                    <tr>
                        <td colspan="3">
                            NO hay Activo en este Auxiliar
                        </td>
                    </tr>
                </tbody>
              <tfoot>
                <th>Cantidad</th>
                <th>{{ totalActivos }}</th>
              </tfoot>
            </table>
            </div>
            <div class="tile-footer">
                <button class="btn btn-danger" @click="cerrarlistado()">Cerrar</button>
            </div>
          </div>
        </div>
        </div>

     </template>
   
      <!-- Fin ejemplo de tabla Listado -->
             <!--Inicio del modal agregar/actualizar-->
             <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h4 class="modal-title" >Actualizar Auxiliar</h4>
                             <button type="button" class="close btn btn-danger btn-sm" @click="cerrarModal()" aria-label="Close">
                               <span aria-hidden="true">×</span>
                             </button>
                         </div>
                         <div class="modal-body">
                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                 <div class="form-group row mb-3">
                                     <label class="col-md-3" for="text-input">Grupo Contable:</label>
                                     <div class="col-md-9">
                                         <input type="text" v-model="grupocontable" class="form-control" disabled>                       
                                     </div>
                                 </div>
                                 <div class="form-group row mb-3">
                                     <label class="col-md-3" for="text-input">Nombre Auxiliar:</label>
                                     <div class="col-md-9">
                                         <input type="text" v-model="nomaux" class="form-control">                                        
                                     </div>
                                 </div>
                                 <div class="form-group row mb-3">
                                     <label class="col-md-3" for="text-input">Observaciones:</label>
                                     <div class="col-md-9">
                                         <input type="text" v-model="observ" class="form-control">                                        
                                     </div>
                                 </div>
                                 <div v-show="errorAuxiliar" class="form-group row div-error">
                                     <div class="text-center text-error">
                                         <div v-for="error in errorMostrarMsjAuxiliar" :key="error" v-text="error">
 
                                         </div>
                                     </div>
                                 </div>
 
                             </form>
                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-danger" @click="cerrarModal()"><i class="bi bi-x-square"></i>Cerrar</button>
                             <button type="button" class="btn btn-warning" @click="actualizarAuxiliar()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                 <path d="M11 2H9v3h2z"/>
                                 <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                                 </svg>Actualizar
                             </button>
                           </div>
                     </div>
                     <!-- /.modal-content -->
                 </div>
                 <!-- /.modal-dialog -->
             </div>
             <!--Fin del modal-->
     </main>
 </template>
<script>
import axios from 'axios';
export default {
  data() {
    return {
        nombre_auxiliar:'',
        listado:1,
        criterio:'nomaux',
        buscar:'',
        vidautil:0,
        observaciones:'',
        observ:'',
        tipoAccion:0,
        grupocontable:'',
        totalAuxiliares:0,
        id:0,
        nomaux:'',
        codcont:0,
        codaux:0,
        arrayAuxiliar : [],
        arrayContables : [],
        arrayActivos : [],
        totalActivos : 0,
        idunidad:'',
        unidad:'',
        idrol:0,
        titulo:'',
        arrayUnidad:[],
        modal : 0,
        errorAuxiliar : 0,
        errorMostrarMsjAuxiliar : [],
        
        criterio : 'nomaux',
        buscar : '',
        criterio1 : 'descrip',
        buscar1 : ''
    }
  },
  computed:{
            
        },
  methods: {
    listarUnidad (){
            let me=this;
            var url= '/unidad/select';
            axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayUnidad = respuesta.unidad;
            me.unidad = respuesta.descripcion;
            me.idunidad = respuesta.idunidad;
            me.idrol = respuesta.idrol;
            me.titulo = respuesta.titulo;
        })
        .catch( (error)=> {
            console.log(error);
        });
    },
    listarAuxiliar (page,buscar,criterio,cod_cont){
        let me=this;
        var url= '/auxiliar?codcont='+ cod_cont +'&page=' + page + '&buscar='+ buscar + '&criterio='+ criterio + '&unidad='+ this.idunidad;
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayAuxiliar = respuesta.auxiliares;
            me.totalAuxiliares = respuesta.totalaux;
        })
        .catch( (error)=> {
            console.log(error);
        });
    },
    listarContables (id){
        let me=this;
        var url= '/contable?id='+ id;
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayContables = respuesta.codigos;
            me.idunidad=respuesta.unidad;
            //me.detalleContable(this.codcont);
        })
        .catch( (error)=> {
            console.log(error);
        });
    },
    onChangeCodigo(event) {
        this.listado=1;
        this.codcont=(event.target.value);
        this.detalleContable(this.codcont);
        this.listarAuxiliar(1,'','',this.codcont);
    },
    detalleContable(idcont){
        const resultado = this.arrayContables.find((grupo) => grupo.codcont == idcont);
        this.vidautil= resultado.vidautil;
        this.observaciones= resultado.observ;
        this.grupocontable=resultado.nombre;
    },
    abrirModal(data = []){
      this.modal=1;
      this.id = data['id'];
      this.nomaux=data['nomaux'];
      this.codcont=data['codcont'];
      this.codaux=data['codaux'];
    },
    cerrarModal(){
      this.modal=0;
    },
    actualizarAuxiliar(){
          let me = this;
          axios.put('/auxiliar/update',{
            'id':this.id,
            'nomaux':this.nomaux,
            'codcont':this.codcont,
            'codaux':this.codaux,
          }).then((response)=>{
              me.cerrarModal();
              Swal.fire(response.data.message,"","info");
              me.listarAuxiliar(1,'','',this.codcont);
          }).catch((error)=>{
            Swal.fire('Hubo un Error','','error');
              console.log(error);
          }); 
    },  
    onChangeUnidad(event){
        this.arrayContables=[];
        this.arrayAuxiliar=[];
        this.listado=1;
        this.buscar='';
        this.vidautil=0;
        this.totalAuxiliares=0;
        this.codcont=0;
        this.idunidad=(event.target.value);
        const res = this.arrayUnidad.find((unidad) => unidad.unidad == this.idunidad);
        this.titulo= res.descrip;
        this.listarContables(this.idunidad);
    },
    abrirlistado(data){
        this.listado=2;
        this.nombre_auxiliar = data['nomaux'];
        this.codaux = data['codaux'];
        this.listarActivos(data['codcont'],data['codaux'],'','');
    },
    listarActivos(cod_cont, cod_aux, criterio, buscar){
        let me=this;
        var url= '/actuales/auxiliar?codcont='+ cod_cont +'&codaux=' + cod_aux +'&buscar='+ buscar + '&criterio='+ criterio + '&unidad=' + me.idunidad;
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayActivos = respuesta.actuales;
            me.totalActivos = respuesta.totalactuales;
        })
        .catch( (error)=> {
            console.log(error);
        });
    },
    cerrarlistado(){
        this.listado=1;
        this.arrayActivos = [];
        this.totalActivos = 0;
        this.criterio1='descrip';
        this.buscar1='';
    }
  },

  mounted() {
    this.listarUnidad();
    this.listarContables('');
  }
}
</script>
<style>
.table-fixed {
  max-height: 400px;
  overflow-y: auto;
  position: relative;
}

.table-fixed thead th,
.table-fixed tfoot th {
    position: sticky;
    top: 0;
    background: #fff; /* Fondo blanco para los encabezados */
    z-index: 1; /* Asegura que los encabezados estén por encima del contenido */
    align-items: center;
}
.table-fixed thead th {
    top: 0; /* Encabezado fijo en la parte superior */
}

.table-fixed tfoot th {
    bottom: 0; /* Pie fijo en la parte inferior */
}
</style>  