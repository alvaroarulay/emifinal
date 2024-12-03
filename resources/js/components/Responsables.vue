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
            <h1><i class="bi bi-person-fill"></i> Responsables</h1>
            <br>
            <button type="submit" @click="revisarNuevos()" class="btn btn-primary" v-if="idrol==1"><i class="bi bi-arrow-clockwise"></i> Actualizar Datos</button>
        </div>
        <div class="form-group row p-3 mb-2 bg-primary text-white">
            <div class="col-md-6">
                <div class="input-group">
                    <select class="form-select col-md-3" v-model="criterio">
                        <option value="nomresp">Nombre</option>
                        <option value="ci">Documento</option>
                    </select>
                    <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                    <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-info"><i class="fa fa-search"></i> Buscar</button>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body table-responsive">
                 <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Carnet</th>
                                    <th>Expedido</th>
                                    <th>Cargo</th>
                                    <th>Oficina</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                    <td>
                                        <button type="button" @click="abrirModal('persona','actualizar',persona)" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar">
                                          <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" @click="eliminarResponsable(persona)" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                    <td v-text="persona.nomresp"></td>
                                    <td v-text="persona.ci"></td>
                                    <td v-text="persona.sigla"></td>
                                    <td v-text="persona.cargo"></td>
                                    <td v-text="persona.nomofic"></td>
                                    <td>
                                        <div v-if="persona.api_estado==1">
                                            <span class="me-1 badge badge-pill bg-success">Activo</span>
                                        </div>
                                        <div v-else-if="persona.api_estado==3">
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
        </div>
    </div> 
    <div class="row p-3 mb-2 bg-primary text-white text-end">
            <h4><b>Total Activos: </b>{{ total }}</h4>
        </div>
    <!-- Fin ejemplo de tabla Listado -->
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
             
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close btn btn-danger btn-sm" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row mb-3">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control">                                        
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-3 form-control-label" for="text-input">Cargo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="cargo" class="form-control">                                        
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-3 form-control-label" for="text-input">Carnet</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="ci" class="form-control">                                        
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-3 form-control-label" for="text-input">Expedido</label>
                                    <div class="col-md-9">
                                      <select v-model="expedido" class="form-select" @change="onChangeCodEstado($event)">
                                        <option value='1'>CHUQUISACA</option>
                                        <option value='2'>LA PAZ</option>
                                        <option value='3'>COCHABAMBA</option>
                                        <option value='4'>ORURO</option>
                                        <option value='5'>POTOSI</option>
                                        <option value='6'>TARIJA</option>
                                        <option value='7'>SANTA CRUZ</option>
                                        <option value='8'>BENI</option>
                                        <option value='9'>PANDO</option>
                                        <option value='10'>OTRO</option>
                                      </select>                                 
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-3 form-control-label" for="text-input">Estado</label>
                                    <div class="col-md-9">
                                        <div class="form-check">
                                          <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="estado" value="1" v-model="estado">Activo
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="estado" value="3" v-model="estado">Inactivo
                                          </label>
                                        </div>
                                      </div>
                                </div>
                                <div v-show="errorPersona" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
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
import { setTransitionHooks } from 'vue';
export default {
  data() {
    return {
        idunidad:'',
        unidad:'',
        titulo:'',
        idrol:0,
        arrayUnidad:[],

      id:0,
      codresp: 0,
      codofic:0,
      nombre : '',
      ci : '',
      cargo:'',
      expedido:0,
      estado:0,
      arrayPersona : [],
      modal : 0,
      tituloModal : '',
      tipoAccion : 0,
      errorPersona : 0,
      errorMostrarMsjPersona : [],
      pagination : {
          'total' : 0,
          'current_page' : 0,
          'per_page' : 0,
          'last_page' : 0,
          'from' : 0,
          'to' : 0,
      },
      offset : 3,
      criterio : 'nomresp',
      buscar : '',
      total:0,
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
        this.listarPersona(1,this.buscar,this.criterio);
    },
    listarPersona (page,buscar,criterio){
        let me=this;
        var url= '/responsable?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio + '&unidad=' + me.idunidad;
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayPersona = respuesta.responsables.data;
            me.pagination= respuesta.pagination;
            me.total = respuesta.total;
        })
        .catch( (error)=> {
            console.log(error);
        });
    },
    actualizarPersona(){
          let me = this;

          axios.put('/responsable/actualizar',{
            'id':this.id,
            'codresp':this.codresp,
              'codofic':this.codofic,
              'nomresp': this.nombre,
              'cargo':this.cargo,
              'ci':this.ci,
              'cod_exp':this.expedido,
              'api_estado':this.estado,
          }).then(function (response) {
              me.cerrarModal();
              Swal.fire(response.data.message,"","info");
              me.listarPersona(1,'','nombre');
          }).catch(function (error) {
            Swal.error('Hubo un Error');
              console.log(error);
          }); 
      }, 
      eliminarResponsable(data){
          let me = this;
          axios.put('/responsable/eliminar',{
            'id':data['id'],
            'codresp':data['codresp'],
            'codofic':data['codofic'],
          }).then((response)=>{
              Swal.fire(response.data.message,"","info");
              me.listarPersona(1,'','nombre');
          }).catch((error)=>{
            Swal.fire('Hubo un Error',"","error");
              console.log(error);
          }); 
      },    
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarPersona(page,buscar,criterio);
            },
            cerrarModal(){
              this.modal=0;
              this.tipoAccion=0;
              this.nombre = "";
              this.cargo ="";
              this.ci="";
              this.expedido=0;
              this.estado=0;
            },
            
            onChangeCodEstado(event) {
                this.expedido = (event.target.value);
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Responsable';
                                this.tipoAccion=1;
                                this.id = 0;
                                this.codresp="";
                                this.codofic="";
                                this.nombre ="";
                                this.cargo ="";
                                this.ci="";
                                this.expedido="";
                                this.estado="";
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tipoAccion=2;
                                this.tituloModal="Actualizar Responsable";
                                this.id = data['id'];
                                this.codresp=data['codresp'];
                                this.codofic=data['codofic'];
                                this.nombre = data['nomresp'];
                                this.cargo =data['cargo'];
                                this.ci=data['ci'];
                                this.expedido=data['cod_exp'];
                                this.estado=data['api_estado'];
                                break;
                            }
                        }
                    }
                }
            },
            revisarNuevos(){
                    let me = this;
                    axios.get('/responsable/datos').then((response) =>{
                        Swal.fire(response.data.message, "", "info");
                        me.listarPersona(1,'','nomresp');
                    }).catch((error)=> {
                    Swal.fire("Cierre la tabla RESP.DBF ", "", "error");
                }); 
                },
  },
  mounted() {
    this.listarUnidad();
    this.listarPersona(1,this.buscar,this.criterio);
  }
}
</script>