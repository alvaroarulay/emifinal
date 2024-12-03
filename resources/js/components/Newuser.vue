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
          <h1><i class="bi bi-person-add"></i> Nuevo Usuario</h1>
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

                <div class="mb-3 row">
                  <label class="form-label col-md-4">Nombre:</label>
                  <div class="col-md-8 input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="bi bi-person-square"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text"  disabled v-model="nomresp">
                  </div>
                </div>

                <div class="mb-3 row">
                  <label class="form-label col-md-4">Correo Electronico:</label>
                  <div class="col-md-8 input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="bi bi-envelope"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" v-model="email">
                  </div>
                </div>

                <div class="mb-3 row">
                  <label class="form-label col-md-4">Nombre de Usuario:</label>
                  <div class="col-md-8 input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="bi bi-person-fill-check"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text"  v-model="username">
                  </div>
                </div>

                <div class="mb-3 row">
                  <label class="form-label col-md-4">Contraseña:</label>
                  <div class="col-md-8 input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="bi bi-key"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" v-model="ci">
                  </div>
                </div>


                <div class="mb-3 row">
                  <label class="form-label col-md-4">Roles:</label>
                  <div class="col-md-8 input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="bi bi-list-check"></i>
                        </span>
                    </div>
                    <select name="" id="" class="form-select" v-model="rol"  @change="onChange($event)">
                      <option v-for="rol in arrayRoles" :key="rol.id" :value="rol.id" v-text="rol.nombre"></option>
                    </select>
                  </div>
                </div>

              </div>
              <div class="card-footer">
                <div v-show="errorUser" class="form-group row div-error">
                    <div class="text-center text-error">
                        <div v-for="error in errorMostrarMsjUser" :key="error" v-text="error">

                        </div>
                    </div>
                </div>
                <div class="mb-3 col-md-3 form-group">
                    <button class="btn btn-primary form-control" type="button" @click="registrarPersona()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16" >
                      <path d="M11 2H9v3h2z"/>
                      <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                    </svg> Guardar</button>
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
      cod_resp:0,
      cod_ofi:0,
      ci:'',
      email:'',
      username:'',
      rol:1,
      codigo:'',
      codigoTable:'',
      descripcionTable:'',
      arrayResponsable:[],
      arrayResponsableTodos:[],
      arrayRoles:[],
      errorUser:0,
      errorMostrarMsjUser:[],
      nomresp:'',
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
        if(me.idunidad==''){
          swal.fire('seleccione unidad','','error')
        }
        else{
        var url= '/responsable/buscarResponsable?filtro=' + me.ci + '&unidad=' + this.idunidad;

        axios.get(url).then((response)=>{
            me.arrayResponsable = response.data.responsable;
              me.nomresp=me.arrayResponsable.nomresp;
              me.cargo=me.arrayResponsable.cargo;
              me.oficina=me.arrayResponsable.nomofic;
              me.cod_ofi=me.arrayResponsable.codofic;
              me.cod_resp=me.arrayResponsable.codresp;
        })
        .catch(function (error) {
            console.log(error);
            Swal.fire('No se Encontro Responsable','','error')
        });
      }
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
    listarRoles(){
      let me=this;
        axios.get('/rol/').then( (response) =>{
            var respuesta= response.data;
            me.arrayRoles = respuesta.roles.data;
        })
        .catch( (error) =>{
            console.log(error);
        });
    },
    cerrarModal(){
        this.modal=0;
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
    },
    onChange(event) {
        this.rol=event.target.value;
    },
    cambiarPagina(page,buscar,criterio){
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.listarResponsable(page,buscar,criterio);
    },
    registrarPersona(){
      let me = this;
      if (this.validarPersona()){ return;}
        axios.post('/user/registrar',{
            'name': me.nomresp,
            'email': me.email,
            'username' : me.username,
            'password' : me.ci,
            'codresp' : me.cod_resp,
            'codofic' : me.cod_ofi,
            'idrol' : me.rol,
            'unidad' : me.idunidad,
        }).then((response)=>{
          Swal.fire(response.data.message, "", "success");
          me.nomresp="";
          me.email = "";
          me.username = "";
          me.ci=0;
          me.cod_resp=0;
          me.cod_ofi =0;
          me.rol = 0;
          me.idunidad="";
          me.unidad="";
        }).catch((error)=>{
            console.log(error);
        });
    },
    validarPersona(){
        this.errorUser=0;
        this.errorMostrarMsjUser =[];

        if (!this.nomresp) this.errorMostrarMsjUser.push("El nombre de la persona no puede estar vacío.");
        if (!this.username) this.errorMostrarMsjUser.push("El nombre de usuario no puede estar vacío.");
        if (!this.ci) this.errorMostrarMsjUser.push("La password del usuario no puede estar vacío.");
        if (this.idrol==0) this.errorMostrarMsjUser.push("Seleccione una Role.");
        if (this.errorMostrarMsjUser.length) this.errorUser = 1;

        return this.errorUser;
    },
  },
  mounted() {
    this.listarUnidad();
   this.listarRoles();
  }
}
</script>