<template>
    <main class="app-content">
      <div class="app-title row">
                <div class="col-md-8">
                    <h1><i class="bi bi-collection"></i> Unidad: {{ titulo }}</h1> 
                </div>
                <div class="col-md-4">
                    <select class="form-select" @change="onChangeUnidad($event)" v-model="idunidad" v-if="idrol==1">
                        <option v-for="unidad in arrayUnidad" :value="unidad.unidad" v-text="unidad.descrip"></option>
                    </select>
                </div>
        </div>
      <div class="app-title row">
        <h1><i class="bi bi-collection"></i> Inventario Rápido</h1> 
      </div>
      <div class="row card shadow-lg border-0 rounded-lg mt-5">
        <h5 class="text-start font-weight-light my-4">Responsable</h5>
          <div class="row mb-3">
            <div class="col-md-6">
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
              <button class="btn btn-secondary form-control btnagregar" type="button" @click="buscarResponsable()"><i class="bi bi-plus-lg" ></i> Agregar</button>
            </div>
            <div class="mb-3 col-md-3 form-group">
              <button class="btn btn-info form-control btnagregar" type="button" @click="abrirModal()"><i class="bi bi-search"></i> Buscar</button>
            </div>
              </div>
            </div>
            
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <table>
                <tr>
                  <th scope="row">NOMBRE RESPONSABLE: </th>
                  <td>{{ nomresp }}</td>
                </tr>
                <tr>
                  <th scope="row">CARGO: </th>
                  <td>{{ cargo }}</td>
                </tr>
                <tr>
                  <th scope="row">OFICINA: </th>
                  <td>{{ oficina }}</td>
                </tr>
            </table>
            </div>
            
          </div>
      </div>
      <div class="row card shadow-lg border-0 rounded-lg mt-5">
        <div class="col-md-12">
           <h5 class="text-start font-weight-light my-4">Activos a Inventariar</h5>
        <div class="row p-3 mb-2 bg-primary text-white ">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                  <input type="text" class="form-control" placeholder="Ingrese un Código" v-model="codigo" @keyup.enter="buscarActivo()">
              </div>
              <div class="col-md-3">
                <button class="btn btn-secondary form-control btnagregar" type="button" @click="buscarActivo()"><i class="bi bi-plus-lg"></i> Agregar</button>
              </div>
              <div class="col-md-3"> 
                <button class="btn btn-info form-control btnagregar" type="button" @click="abrirModalActivos()"><i class="bi bi-search"></i> Buscar</button>
              </div>
            </div>
          </div>
        </div>

        <div style="height: 25rem;">
            <div class="table-responsive col-md-12 table-fixed">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Responsable</th>
                            <th>Oficina</th>
                        </tr>
                    </thead>
                    <tbody v-if="arrayActivo.length">
                        <tr v-for="(detalle,index) in arrayActivo" :key="detalle.id">
                            <td>
                                <button  @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                  <i class="bi bi-x-lg"></i></button>
                            </td>
                            <td v-text="detalle.codigo"></td>
                            <td v-text="detalle.descripcion"></td>
                            <td v-text="detalle.nomresp"></td>
                            <td v-text="detalle.nomofic"></td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="5">
                                NO hay Activos agregados
                            </td>
                        </tr>
                    </tbody>                                    
                </table>
            </div>
        </div>
        
       
        </div>
        
          <div class="p-3 mb-2 bg-primary text-white mb-3 text-end">
            <h4>Total: {{ cantidad }}</h4>
          </div>
          <div class="row" v-if="listado==0">
            <div class="mb-3 col-md-3 form-group text-end">
            <button class="btn btn-primary form-control btnagregar" type="button" @click="registrarInventario()"><i class="bi bi-floppy2-fill"></i> Registrar Inventario</button>
            </div>
          </div>
          <div class="row" v-if="listado==1">
            <div class="mb-3 col-md-3 form-group text-end">
              <button class="btn btn-warning form-control btnagregar" type="button" @click="devoluciones()"><i class="bi bi-floppy2-fill"></i> Ver Devolución</button>
            </div>
            <div class="mb-3 col-md-3 form-group text-end">
              <button class="btn btn-success form-control btnagregar" type="button" @click="asignaciones()"><i class="bi bi-floppy2-fill"></i> Ver Asignación</button>
            </div>
            <div class="mb-3 col-md-3 form-group text-end">
              <button class="btn btn-info form-control btnagregar" type="button" @click="finalizar()"><i class="bi bi-floppy2-fill"></i> Finalizar</button>
            </div>
          </div>
      </div>
      
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
                                        <div v-if="responsable.estado==1">
                                            <span class="me-1 badge badge-pill bg-success">Activo</span>
                                        </div>
                                        <div v-else-if="responsable.estado==3">
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
      <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalactivo}" role="dialog" aria-labelledby="myModalLabel" style="overflow-y: scroll;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Buscar Activo</h4>
                        <button type="button" class="close btn btn-danger" @click="cerramodalActivo()" aria-label="Close" >
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">                                
                      <div class="col-md-6">
                          <div class="input-group mb-3">
                          <select class="form-select col-md-3" v-model="criterio2">
                              <option value="codigo">Código</option>
                              <option value="codigosec">Código Secundario</option>
                              <option value="descripcion" selected>Descripción</option>
                          </select>
                          <input type="text" v-model="buscar" @keyup.enter="listarArticulo(1,buscar,criterio2)" class="form-control" placeholder="Texto a buscar">
                          <button type="submit" @click="listarArticulo(1,buscar,criterio2)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                          </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Codigo</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="activo in arrayActivos" :key="activo.id">
                                        <td>
                                            <button type="button" @click="agregarActivo(activo)" class="btn btn-success btn-sm">
                                            <i class="fa fa-check"></i>
                                            </button>
                                        </td>
                                        <td v-text="activo.codigo"></td>
                                        <td v-text="activo.descripcion"></td>
                                        <td>
                                        <div v-if="activo.codestado==1">
                                            <span class="me-1 badge badge-pill bg-success">Bueno</span>
                                        </div>
                                        <div v-else-if="activo.codestado==2">
                                            <span class="me-1 badge badge-pill bg-warning">Regular</span>
                                        </div>
                                        <div v-else-if="activo.codestado==3">
                                            <span class="me-1 badge badge-pill bg-danger">Malo</span>
                                        </div>
                                    </td>
                                    </tr>                                
                                </tbody>
                            </table>
                            <nav>
                              <ul class="pagination">
                                  <li class="page-item" v-if="pagination.current_page > 1">
                                      <a class="page-link" href="#" @click.prevent="cambiarPaginaArticulo(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                  </li>
                                  <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                      <a class="page-link" href="#" @click.prevent="cambiarPaginaArticulo(page,buscar,criterio)" v-text="page"></a>
                                  </li>
                                  <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                      <a class="page-link" href="#" @click.prevent="cambiarPaginaArticulo(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                  </li>
                              </ul>
                          </nav>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerramodalActivo()">Cerrar</button>
                    </div>
                </div>
            </div>
                <!-- /.modal-content -->
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
      arrayUnidad:[],
      idunidad:'',
      unidad:'',
      idrol:0,
      titulo:'',
      id_dev:0,
      id_asig:0,
      listado:0,
      pdf:'',
      modalpdf:0,
      ci:'',
      codigo:'',
      cantidad:0,
      arrayResponsable:[],
      arrayResponsableTodos:[],
      arrayResponsable_ant:[],
      codresp_ant:0,
      codofic_ant:0,
      arrayActivo:[],
      actuales:[],
      arrayActivos:[],
      oficina:'',
      codresp:0,
      codofic:0,
      nomresp:'',
      cargo:'',
      modal : 0,
      modalactivo:0,
      criterio:'nomresp',
      buscar: '', 
      criterio2 : 'descripcion',
      buscar : '',
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
    onChangeUnidad(event){
        this.arrayArticulo = [];
        this.idunidad=(event.target.value);
        const res = this.arrayUnidad.find((unidad) => unidad.unidad == this.idunidad);
        this.titulo= res.descrip;
    },
    buscarResponsable(){
        let me=this;
        var url= '/responsable/buscarResponsable?filtro=' + me.ci + '&unidad='+ this.idunidad;

        axios.get(url).then((response)=>{
            me.arrayResponsable = response.data.responsable;
            if (me.arrayResponsable.estado==1 || data.estado==null) {
              me.codresp=me.arrayResponsable.codresp;
              me.codofic=me.arrayResponsable.codofic;
              me.nomresp=me.arrayResponsable.nomresp;
              me.cargo=me.arrayResponsable.cargo;
              me.oficina=me.arrayResponsable.nomofic;
            }else{
              Swal.fire('El Responsable no se encuentra activo!!','','error');
            }
        })
        .catch(function (error) {
            console.log(error);
            Swal.fire('No se Encontro Responsable','','error')
        });
    },
    listarResponsable(page,buscar,criterio){
        let me=this;
        var url= '/responsable/?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio + '&unidad='+ this.idunidad;
        axios.get(url).then( (response) =>{
            var respuesta = response.data;
            me.arrayResponsableTodos = respuesta.responsables.data;
            me.idrol = respuesta.idrol;
            me.pagination= respuesta.pagination;
            me.unidad = respuesta.titulo;
        })
        .catch( (error) =>{
            console.log(error);
        });
    },
    cambiarPagina(page,buscar,criterio){
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.listarResponsable(page,buscar,criterio);
    },
    cambiarPaginaArticulo(page,buscar,criterio2){
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.listarArticulo(page,buscar,criterio2);
    },
    listarArticulo (page,buscar,criterio2){
        let me = this;
        var url = '/actuales/inventario?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio2 + '&unidad=' + me.idunidad;
        axios.get(url).then( (response) =>{
          var respuesta= response.data;
          console.log(response.data);
          me.arrayActivos = respuesta.actuales.data;
          me.pagination= respuesta.pagination;
        })
        .catch( (error) =>{
            console.log(error);
        });
    },
    buscarActivo(){
      let me=this;
      if(this.codigo.length==0){
        swal.fire('Ingrese un Código!!!','','info')
      }else{
        this.codigo = this.codigo.slice(0, 8);
        var url = '/actuales/buscarActivos?filtro=' + me.codigo + '&unidad=' + me.idunidad;
        axios.get(url).then((res)=>{
         
          if (res.data.actuales.length === 0) {Swal.fire('No se encontro Activo!','','error') }
          else{
              me.actuales= res.data.actuales;
            if(me.encuentra(res.data.actuales[0].codigo)){Swal.fire('Ese Activo ya se encuentra agregado!','','error')}
            else{
                me.arrayActivo.push(...res.data.actuales);
                me.cantidad= me.arrayActivo.length;
                me.codigo = '';
                me.codigo.value.focus();
              }
            }
          }
      ).catch((error)=> {
          console.log(error);
        }); 
      }
    },
    encuentra(cod){
        var sw=false;
        if(this.arrayActivo.find((element) => element.codigo == cod)){
            sw=true;
        }
        return sw;
    },
    encuentraResp(codresp,codofic,unidad){
        var sw=true;
        if(this.arrayResponsable_ant.find((element) => element.codresp == codresp && element.codofic == codofic && element.unidad == unidad)){
            sw=false;
        }
        return sw;
    },
    eliminarDetalle(index){
        let me = this;
        me.arrayActivo.splice(index, 1);
        me.cantidad -=1;
    },
    cerrarModal(){
        this.modal=0;
        this.arrayResponsableTodos=[];
        this.arrayArticulos=[];
        this.buscar='';
        this.criterio='descripcion';
    }, 
    cerramodalActivo(){
        this.modalactivo=0;
        this.arrayActivos=[];
        this.buscar='';
        this.criterio='descripcion';
    }, 
    abrirModal(){  
      this.criterio="nomresp";
        this.modal = 1;
        this.listarResponsable(1,this.buscar,this.criterio);
        
    },
    abrirModalActivos(){
      this.modalactivo=1;
      this.listarArticulo (1,this.buscar,this.criterio2);
    },
    agregarDetalleModal(data){
      if(data.estado==1 || data.estado==null){
        this.ci=data.ci;
        this.nomresp=data.nomresp;
        this.cargo=data.cargo;
        this.oficina=data.nomofic;
        this.modal=0;
        this.codresp = data.codresp;
        this.codofic = data.codofic;
      }
      else{
        Swal.fire('El Responsable no se encuentra activo!!','','error');
      }
      
    },
    agregarActivo(data){
      let me = this;
      if(me.encuentra(data.codigo)){
          Swal.fire('Ese Activo ya se encuentra agregado!','','error')
          }
          else{
             me.arrayActivo.push({
              id:data.id,
              codigo: data.codigo,
              descripcion: data.descripcion,
              nomresp : data.nomresp,
              nomofic : data.nomofic,
            });
            if(me.encuentraResp(data.codresp,data.codofic,data.unidad)){
              me.arrayResponsable_ant.push({
                id:data.id,
                codresp:data.codresp,
                codofic:data.codofic,
                unidad:data.unidad,
              });
            }
            
            me.cantidad= me.arrayActivo.length;
          }
     
    },
    registrarInventario(){
      let me = this;
      if(me.arrayActivo.length==0){swal.fire('Ingrese un Activo','','info');}
      else
      {
        if(me.codresp==0){swal.fire('Selecciona un Responsable','','info');}
        else{
          let me = this;
          me.listado=1;
          axios.put('/actual/actualizarasingacion',{
              'data' : me.arrayActivo,
              'codresp2' : me.codresp,
              'codofic2' : me.codofic,
              'unidad' : me.idunidad,
          }).then((response)=>{
            let me = this;
            me.id_dev=response.data.id_dev;
            me.id_asig=response.data.id_asig;
            swal.fire('Datos Guardados',response.data.message,'success');
          }).catch((error)=>{
              console.log(error);
          });
            
        }
      }
    },
    asignaciones(){
      let me = this;
        me.pdf =('http://192.168.28.219/asignaciones/actaAsignaciones?codofic=' + me.codofic + '&codresp='+ me.codresp +  '&unidad=' + me.idunidad + '&id_asig=' + me.id_asig);
        me.modalpdf = 1;
    },
    devoluciones(){
      let me = this;
      this.arrayResponsable_ant.forEach(function(item) {
          console.log(item.codofic);
          window.open('http://192.168.28.219/devoluciones/actaDevoluciones?codofic=' + item.codofic + '&codresp='+ item.codresp + '&unidad=' + me.idunidad + '&id_dev=' + me.id_dev +'','_blank');
      });
    },
    finalizar(){
      this.listado=0;
      this.arrayResponsable_ant=[];
      this.reset();
    },
    cerrarModalpdf(){
      this.modalpdf = 0;
      this.pdf = '';
    },
    reset(){
      let me =this;
      me.ci='';
      me.codigo='';
      me.cantidad=0;
      me.arrayResponsable=[];
      me.arrayResponsableTodos=[];
      me.arrayActivo=[];
      me.actuales=[];
      me.arrayActivos=[];
      me.oficina='';
      me.codresp=0;
      me.codofic=0;
      me.nomresp='';
      me.cargo='';
      me.modal = 0;
      me.modalactivo=0;
      me.criterio='nomresp';
      me.buscar= ''; 
      me.criterio2 = 'descripcion';
      me.buscar = '';
    },
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
  },
  mounted() {
    this.listarUnidad();
    
  }
}
</script>
<style>
.table-fixed {
  max-height: 150px;
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