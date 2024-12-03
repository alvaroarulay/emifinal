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
        <div>
            <h1><i class="bi bi-people-fill"></i> Usuarios</h1>
         </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                                    <th>Email</th>
                                    <th>Usuario</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                    <td>
                                        <button type="button" @click="abrirModal(persona)" class="btn btn-warning btn-sm">
                                          <i class="fa fa-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="persona.condicion">
                                            <button type="button" class="btn btn-success btn-sm" @click="desactivarUsuario(persona.id)">
                                               <i class="fa fa-check"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-danger btn-sm" @click="activarUsuario(persona.id)">
                                                 <i class="fa fa-trash"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="persona.name"></td>
                                    <td v-text="persona.email"></td>
                                    <td v-text="persona.username"></td>
                                    <td v-text="persona.rol"></td>
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
    </div> <!-- Fin ejemplo de tabla Listado -->
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" > Actualizar Usuario</h4>
                            <button type="button" class="close btn btn-danger" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre(*)</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="name" class="form-control" placeholder="Nombre de la persona">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Role</label>
                                    <div class="col-md-9">
                                        <select name="" id="" class="form-select" v-model="rol"  @change="onChange($event)">
                                        <option v-for="rol in arrayRoles" :key="rol.id" :value="rol.id" v-text="rol.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Usuario</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="username" class="form-control" placeholder="Nombre del usuario">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">password</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="password del usuario" autocomplete="on">
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
                            <button type="button" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
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
    export default {
        data (){
            return {
                idunidad:'',
                unidad:'',
                idrol:0,
                titulo:'',
                arrayUnidad:[],
                persona_id: 0,
                name : '',
                email : '',
                username: '',
                password:'',
                rol: '',
                arrayPersona : [],
                arrayRoles : [],
                modal : 0,
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
                criterio : 'name',
                buscar : ''
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
        methods : {
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
                    //console.log(respuesta);
                    //me.listarPersona(1,this.buscar,this.criterio);
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
                var url= '/users?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio + '&unidad='+ me.idunidad;
                axios.get(url).then(function (response) {
                    //console.log(response.data);
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.personas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectRol(){
                let me=this;
                axios.get('/rol/').then( (response) =>{
                    var respuesta= response.data;
                    me.arrayRoles = respuesta.roles.data;
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
                me.listarPersona(page,buscar,criterio);
            },
           
            actualizarPersona(){
               if (this.validarPersona()){
                    return;
                }
                let me = this;
                axios.put('/user/actualizar',{
                    'name': this.name,
                    'email' : this.email,
                    'idrol' : this.rol,
                    'username': this.username,
                    'password': this.password,
                    'id': this.persona_id

                }).then(function (response) {
                    Swal.fire(response.data.message, "", "success");
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarPersona(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona =[];

                if (!this.name) this.errorMostrarMsjPersona.push("El nombre de la pesona no puede estar vacío.");
                if (!this.username) this.errorMostrarMsjPersona.push("El nombre de usuario no puede estar vacío.");
                if (!this.password) this.errorMostrarMsjPersona.push("La password del usuario no puede estar vacía.");
                if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

                return this.errorPersona;
            },
            cerrarModal(){
                this.modal=0;
                this.name='';
                this.email='';
                this.username='';
                this.password='';
                this.idrol=0;
                this.errorPersona=0;
            },
            abrirModal(data = []){
                this.selectRol();
                this.modal=1;
                this.persona_id=data['id'];
                this.name = data['name'];
                this.email = data['email'];
                this.username = data['username'];
                this.password=data['password'];
                this.rol=data['idrol'];
            },
            onChange(event) {
                this.rol=event.target.value;
            },
            desactivarUsuario(id){
                 const swal = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })
                    Swal.fire({
                        title: "Esta seguro de desactivar este usuario?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, Desactivar!",
                        cancelButtonText: "Cancelar",
                        }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/user/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPersona(1,'','nombre');
                        Swal.fire({
                            title: "Borrado!",
                            text: "El Usuario fue Desactivado.",
                            icon: "success"
                            });
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarUsuario(id){
                 const swal = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })
                swal.fire({
                title: 'Esta seguro de activar este usuario?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar!!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/user/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPersona(1,'','nombre');
                        swal.fire(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
        },
        mounted() {
            this.listarUnidad();
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
