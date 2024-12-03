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
      <div class="app-title">
          <h1><i class="fa fa-th-list"></i> Reporte de Asignaciones</h1>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-lg mt-12">
              <div class="card-header"><h3 class="text-center font-weight-light my-4"> Responsable: </h3></div>
              <div class="card-body">
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <div class="mb-3 input-group" >
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="bi bi-person-vcard-fill"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control"  placeholder="Ingrese un Carnet de Identidad" v-model="ci" @keyup.enter="buscarResponsable()" >
                    </div>
                  </div>
                  <div class="mb-3 col-md-3 form-group">
                    <button class="btn btn-info form-control btnagregar" type="button" @click="buscarResponsable()"><i class="bi bi-plus-lg" ></i> Agregar</button>
                  </div>
                  <div class="mb-3 col-md-3 form-group">
                    <button class="btn btn-success form-control btnagregar" type="button" @click="abrirModal()"><i class="bi bi-search"></i> Buscar</button>
                  </div>
                </div>
                <div class="mb-3 input-group" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="bi bi-person-square"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" disabled v-model="nomresp">
                </div>
                <div class="mb-3 input-group" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="bi bi-stickies"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" disabled v-model="cargo">
                </div>
                <div class="mb-3 input-group" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="bi bi-building"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" disabled v-model="oficina">
                </div>
              </div>
            </div>
        </div>
      </div>
      <br>
      <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-lg mt-12">
              <div class="card-header row justify-content-center">
                <div class="col-md-4"><h3 class="text-center font-weight-light my-4"> Activos Asignados: </h3></div>
                
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-check">
                      <label class="form-check-label mb-2">
                        <input  class="form-check-input" type="checkbox" v-model="todos">  TODOS
                      </label>
                    </div>
                    <div class="form-check" v-for="gcont in arrayContables" :key="gcont.codcont">
                      <label class="form-check-label mb-2" v-if="todos==true">
                        <input  class="form-check-input" type="checkbox" :value="gcont.codcont" v-model="checkContables" disabled>  {{ gcont.nombre }}
                      </label>
                      <label class="form-check-label mb-2" v-if="todos==false">
                        <input  class="form-check-input" type="checkbox" :value="gcont.codcont" v-model="checkContables">  {{ gcont.nombre }}
                      </label>
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6"><label for="start">Fecha:</label></div>
                      <div class="col-md-6"><input class="form-control" type="date" v-model="fecha"/></div>
                    </div>
                  </div>            
                </div>
                
              </div>
              <div class="card-footer">
                <div class="row">
                <div class="mb-3 col-md-3 form-group">
                  <button class="btn btn-success form-control" type="button" @click="registrarAsignacion()"><i class="bi bi-file-earmark-pdf-fill"></i> Generar Asignación</button>
                </div>
                <div class="mb-3 col-md-3 form-group">
                  <button class="btn btn-warning form-control" type="button" @click="registrarDevolucion()"><i class="bi bi-file-earmark-pdf-fill"></i> Generar Devolución</button>
                </div>
                </div>
              </div>
            </div>
        </div>
      </div>
      <!----inicio modal-->
      <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Buscar Responsable</h4>
                        <button type="button" class="close btn btn-sm btn-danger" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <select class="form-select col-md-3" v-model="criterio">
                                    <option value="nomresp">Nombre</option>
                                    <option value="ci">Carnet</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarResponsable(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarResponsable(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Carnet</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="responsable in arrayResponsableTodos" :key="responsable.id">
                                        <td>
                                            <button type="button" @click="agregarDetalleModal(responsable)" class="btn btn-success btn-sm">
                                            <i class="fa fa-check"></i>
                                            </button>
                                        </td>
                                        <td v-text="responsable.nomresp"></td>
                                        <td v-text="responsable.ci"></td>
                                        <td>
                                        <div v-if="responsable.api_estado==1">
                                            <span class="me-1 badge badge-pill bg-success">Activo</span>
                                        </div>
                                        <div v-else-if="responsable.api_estado==3">
                                            <span class="me-1 badge badge-pill bg-danger">Inactivo</span>
                                        </div>
                                        
                                    </td>
                                    </tr>                                
                                </tbody>
                            </table>
                            <nav>
                              <ul class="pagination">
                                  <li class="page-item" v-if="pagination.current_page > 1">
                                      <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                  </li>
                                  <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                      <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                  </li>
                                  <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                      <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                  </li>
                              </ul>
                          </nav>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
      </div>
      <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalpdf}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true" data-target=".bd-example-modal-lg">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Documento Preliminar</h4>
                        <button type="button" class="close btn btn-sm btn-danger" @click="cerrarModalpdf()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                          <iframe
                            :src="pdf"
                            frameBorder="0"
                            scrolling="auto"
                            height="768"
                            width="1024"
                        ></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModalpdf()">Cerrar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
      </div>
    </main>
</template>
<script>
import axios from 'axios';
export default {
  data() {
    return {
      idunidad:'',
        unidad:'',
        idrol:0,
        titulo:'',
        arrayUnidad:[],
        fecha:'',
      pdf:'',
      modalpdf:0,
      checkContables:[],
      todos:true,
      cod_resp:0,
      cod_ofi:0,
      ci:'',
      codigo:'',
      codigoTable:'',
      codcont:0,
      descripcionTable:'',
      value: [],
      arrayResponsable:[],
      arrayResponsableTodos:[],
      arrayActivo:[],
      arrayActivosTodos:[],
      actuales:[],
      arrayContables : [],
      errorResponsable:0,
      errorMostrarMsjResponsable:[],
      nomresp:'',
      cargo:'',
      oficina:'',
      modal : 0,
      criterio:'nomresp',
      buscar: '',
      pagination : {
            'total' : 0,
            'current_page' : 0,
            'per_page' : 0,
            'last_page' : 0,
            'from' : 0,
            'to' : 0,
        },
      offset : 3,
    }
  },
  computed:{
        isActived: function(){
            return this.pagination.current_page;
        },
        //Calcula los elementos de la paginación
        pagesNumber: function() {
            if(!this.pagination.to) {
                return [];
            }
            
            var from = this.pagination.current_page - this.offset; 
            if(from < 1) {
                from = 1;
            }

            var to = from + (this.offset * 2); 
            if(to >= this.pagination.last_page){
                to = this.pagination.last_page;
            }  

            var pagesArray = [];
            while(from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;             

        }
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
    onChangeUnidad(event){
        this.idunidad=(event.target.value);
        const res = this.arrayUnidad.find((unidad) => unidad.unidad == this.idunidad);
        this.titulo= res.descrip;
    },
    buscarResponsable(){
        let me=this;
        var url= '/responsable/buscarResponsable?filtro=' + me.ci + '&unidad=' + me.idunidad;

        axios.get(url).then((response)=>{
            me.arrayResponsable = response.data.responsable;
            me.nomresp=me.arrayResponsable.nomresp;
            me.cargo=me.arrayResponsable.cargo;
            me.oficina=me.arrayResponsable.nomofic;
            me.cod_ofi=me.arrayResponsable.codofic;
            me.cod_resp=me.arrayResponsable.codresp;
            me.buscarActivo();
            me.listarGrupoContable(me.arrayResponsable.codresp,me.arrayResponsable.codofic);
        })
        .catch(function (error) {
            console.log(error);
            Swal.fire('No se Encontro Responsable','','error')
        });
    },
    listarResponsable(page, buscar,criterio){
        let me=this;
        var url= '/responsable/?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio + '&unidad=' + this.idunidad;
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.pagination = respuesta.pagination;
            me.arrayResponsableTodos = respuesta.responsables.data;
        })
        .catch( (error) =>{
            console.log(error);
        });
    },

    buscarActivo(){
      let me=this;
      var url = '/actuales/buscarActivoResp?codofic=' + me.cod_ofi + '&codresp='+ me.cod_resp + '&unidad=' + me.idunidad;
      axios.get(url).then((res)=>{
        me.actuales= res.data.actuales;
        console.log(res.data);
        }
      ).catch((e)=>{
        console.log(e);
      })
    },
   
    cerrarModal(){
        this.modal=0;
        this.actuales = [];
        this.ci='';
        this.nomresp='';
        this.cargo='';
        this.oficina='';
        this.modal=0;
        this.cod_ofi=0;
        this.cod_resp=0;
    }, 
    abrirModal(){  
        this.modal = 1;
        this.listarResponsable(1,this.buscar,this.criterio);
    },
    agregarDetalleModal(data){
        this.ci=data.ci;
        this.nomresp=data.nomresp;
        this.cargo=data.cargo;
        this.oficina=data.nomofic;
        this.modal=0;
        this.cod_ofi=data.codofic;
        this.cod_resp=data.codresp;
        this.buscarActivo();
        this.listarGrupoContable(data.codresp,data.codofic);
    },
    cambiarPagina(page,buscar,criterio){
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.listarResponsable(page,buscar,criterio);
    },
    listarGrupoContable (codresp,codofic){
        let me=this;
        var url= '/actuales/gcontable?codresp='+ codresp + '&codofic=' + codofic + '&unidad=' + me.idunidad;
        axios.get(url).then(function (response) {
            var respuesta= response.data;
            me.arrayContables = respuesta.gcontables;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
     onChange(event) {
        this.codcont=event.target.value;
    },
    registrarAsignacion(){
      console.log(this.fecha);
      if(this.cod_resp == 0){
        swal.fire('Seleccione un Responsable','','error')
      }else if(this.actuales.length == 0){
        swal.fire('el Responsable no tiene activos','','error')
      }
      else if(this.checkContables.length == 0){

        let me = this;
        me.pdf ='http://192.168.28.219/actual/repAsignaciones?codofic=' + me.cod_ofi + '&codresp='+ me.cod_resp + '&codcont='+ me.codcont + '&unidad='+me.idunidad + '&fecha=' + me.fecha;
        me.modalpdf = 1;
      }
      else{
        let me = this;
        me.pdf ='http://192.168.28.219/actual/repAsignaciones?codofic=' + me.cod_ofi + '&codresp='+ me.cod_resp + '&data='+ me.checkContables + '&unidad='+me.idunidad + '&fecha=' + me.fecha;
        me.modalpdf = 1;
      }
    },
    cerrarModalpdf(){
      this.modalpdf = 0;
      this.pdf = '';
    },
    registrarDevolucion(){
      if(this.cod_resp == 0){
        swal.fire('Seleccione un Responsable','','error')
      }
      else if(this.checkContables.length == 0){
        let me = this;
        me.pdf='http://192.168.28.219/actual/repDevoluciones?codofic=' + me.cod_ofi + '&codresp='+ me.cod_resp + '&codcont='+ me.codcont  + '&unidad=' + me.idunidad + '&fecha=' + me.fecha;
        me.modalpdf = 1;
      }
      else{
        let me = this;
        me.pdf='http://192.168.28.219/actual/repDevoluciones?codofic=' + me.cod_ofi + '&codresp='+ me.cod_resp + '&data='+ me.checkContables  + '&unidad=' + me.idunidad;
        me.modalpdf = 1;
      }
    },
    
   
  },

  mounted() {
    this.listarUnidad();
  }
}
</script>
