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
        <div class="app-title">
            <h1><i class="fa fa-th-list"></i> Articulos</h1>
            <button type="submit" @click="revisarNuevos()" class="btn btn-primary" v-if="idrol==1"><i class="fa fa-list-alt"></i> Actualizar Datos</button>
        </div>
        <div class="form-group row p-3 mb-2 bg-primary text-white">
            <div class="col-md-6">
                <div class="input-group">
                    <select class="form-select col-md-3" v-model="criterio">
                        <option value="codigo">Código</option>
                        <option value="codigosec">Código Secundario</option>
                        <option value="descripcion" selected>Descripción</option>
                    </select>
                    <input type="text" v-model="buscar" @keyup.enter="listarbusqueda(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                    <button type="submit" @click="listarbusqueda(1,buscar,criterio)" class="btn btn-info"><i class="fa fa-search"></i> Buscar</button>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body table-responsive">
                  <table class="table table-hover table-sm  table-striped table-bordered" >
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">&nbsp;ACCIONES&nbsp;</th>
                        <th scope="col">UNIDAD</th>
                        <th scope="col">CÓDIGO</th>
                        <th scope="col">GRUPO CONTABLE</th>
                        <th scope="col">AUXLIAR</th>
                        <th scope="col">VIDA ÚTIL</th>
                        <th scope="col">OFICINA</th>
                        <th scope="col">RESPONSABLE</th>
                        <th scope="col">DESCRIPCIÓN</th>
                        <th scope="col">FECHA DE INCORPORACIÓN</th>
                        <th scope="col">ID BIEN</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col">ASIGNACIÓN</th>
                      </tr>
                    </thead>
                    <tbody v-if="arrayArticulo !== 0">
                        <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                            <th scope="row">
                                <button type="button" @click="mostrarEditar(articulo.id)" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></button> 
                                <button type="button" @click="abrirModal('articulo','actualizar',articulo)" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
                            </th>
                            <td v-text="articulo.unidad"></td>
                            <td v-text="articulo.codigo"></td>
                            <td v-text="articulo.nombre"></td>
                            <td v-text="articulo.nomaux"></td>
                            <td v-text="articulo.vidautil"></td>
                            <td v-text="articulo.nomofic"></td>
                            <td v-text="articulo.nomresp"></td>
                            <td v-text="articulo.descripcion"></td>
                            <td>{{ articulo.dia + '/' + articulo.mes + '/' + articulo.año }}</td>
                            <td v-text="articulo.cod_rube"></td>
                            <td>
                                <div v-if="articulo.codestado === 1">
                                    <span class="me-1 badge badge-pill bg-success">Bueno</span>
                                </div>
                                <div v-else-if="articulo.codestado === 2">
                                    <span class="me-1 badge badge-pill bg-warning">Regular</span>
                                </div>
                                <div v-else>
                                    <span class="me-1 badge badge-pill bg-danger">Malo</span>
                                </div>
                            </td>
                            <td>
                                <div v-if="articulo.estadoasignacion === 1">
                                    <span class="me-1 badge badge-pill bg-success">Asignado</span>
                                </div>
                                <div v-else>
                                    <span class="me-1 badge badge-pill bg-warning">No Asignado</span>
                                </div>
                            </td>
                            
                        </tr>                 
                    </tbody>
                    <tbody v-else>
                        <th colspan="11">Sesión Expirada, vuelva a iniciar sesión</th>
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
                                <button type="button" class="close btn btn-danger" @click="cerrarModal()" aria-label="Close" >
                                  <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="form-group row mb-3" v-if="idrol==1">
                                        <label class="col-md-3 form-control-label" for="text-input">Grupo Contable</label>
                                        <div class="col-md-9">
                                            <select class="form-select" v-model="codcont" @change="onChange($event)">
                                                <option value="0" disabled selected>Seleccione</option>
                                                <option v-for="gcont in arrayContables" :key="gcont.codcont" :value="gcont.codcont" v-text="gcont.nombre"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                   
                                    <div class="form-group row mb-3" v-if="idrol==1">
                                        <label class="col-md-3 form-control-label" for="text-input">Auxiliar</label>
                                        <div class="col-md-9">
                                            <select class="form-select" v-model="codaux">
                                                <option v-for="aux in arrayAuxiliares" :key="aux.codaux" :value="aux.codaux" v-text="aux.nomaux"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3" v-if="idrol==1">
                                        <label class="col-md-3 form-control-label" for="text-input">Descripción: </label>
                                        <div class="col-md-9">
                                            <textarea class="form-control"  v-model="descripcion" ></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-md-3 form-control-label" for="text-input">Observaciones: </label>
                                        <div class="col-md-9">
                                            <textarea class="form-control"  v-model="observaciones" ></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-md-3 form-control-label" for="text-input">Estado: </label>
                                        <div class="col-md-9">
                                            <select class="form-select" v-model="codestado" @change="onChangeCodEstado($event)">
                                                <option value='1'>BUENO</option>
                                                <option value='2'>REGULAR</option>
                                                <option value='3'>MALO</option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3" v-if="idrol==1">
                                        <label class="col-md-3 form-control-label" for="text-input">Código Secundario: </label>
                                        <div class="col-md-9">
                                            <input type="text"  class="form-control" placeholder="" v-model="codigosec">                                        
                                        </div>
                                    </div>
                                    <div v-show="errorArticulo" class="form-group row div-error mb-3">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">
    
                                            </div>
                                        </div>
                                    </div>
                                    <form @submit.prevent="subirImagenes">
                                    <div class="mb-3">
                                        <input class="form-control"  type="file" @change="uploadImage" accept="image/*">
                                        </div>
                                        <div class="row">
                                        <div v-for="image in selectedImages" :key="image.id" class="thumbnails float-left mr-1 col-sm-12 col-md-3">
                                                <img :src="image.url" alt="Miniatura" class="img-responsive" style="width: 100px; height: auto;">
                                        </div>
                                         <button type="submit" class="btn btn-primary">Subir Imagenes</button>
                                    </div>
                                    </form>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarArticulo()">Actualizar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalver}" role="dialog" aria-labelledby="myModalLabel" style="overflow-y: scroll;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Detalle</h4>
                        <button type="button" class="close btn btn-danger" @click="cerrarModalImage()" aria-label="Close" >
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">                                
                        <div class="row">
                            <div class="col-md-4" v-for="image in imagenes" :key="image.id">
                                <img :src="getImageUrl(image)" :alt="image.nombre"  class="img-thumbnail img-fluid"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModalImage()">Cerrar</button>
                    </div>
                </div>
            </div>
                <!-- /.modal-content -->
        </div>
                    <!-- /.modal-dialog -->
    </main>
</template>
    
    <script>
        import axios from 'axios';
        export default {
            data (){
                return {
                    codigo : '',
                    codcont:0,
                    codaux:0,
                    descripcion : '',  
                    observaciones : '',      
                    codestado : 0,
                    estadoasignacion :0,
                    codigosec:0,
                    articulo_id: 0,
                    popUp: false,
                    idArticulo:0,
                    total:0,

                    arrayUnidad:[],
                    unidad:'',
                    idunidad:'',
                    idrol:0,
                    titulo:'',

                    arrayContables : [],
                    arrayAuxiliares : [],
                    selectedImages: [],
                    imagenes: [],
                    
                    nombre : '',
                    
                    arrayArticulo : [],
                    modal : 0,
                    modalver : 0,
                    tituloModal : '',
                    tipoAccion : 0,
                    errorArticulo : 0,
                    errorMostrarMsjArticulo : [],
                    pagination : {
                        'total' : 0,
                        'current_page' : 0,
                        'per_page' : 0,
                        'last_page' : 0,
                        'from' : 0,
                        'to' : 0,
                    },
                    offset : 3,
                    criterio : 'descripcion',
                    buscar : '',
                    mostrandoEditar: false,
                }
            },
            components: {
            
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
                
                listarbusqueda(page,buscar,criterio){
                    if (this.buscar=='') {
                        Swal.fire('Escriba un texto','','error');
                    };
                    this.listarArticulo (page,buscar,criterio);
                },
                listarArticulo (page,buscar,criterio){
                    let me=this;
                    
                    var url= '/actuales?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio + '&unidad=' + me.idunidad;
                    axios.get(url).then( (response) => {
                        var respuesta= response.data;
                        me.arrayArticulo = respuesta.actuales.data;
                        me.pagination= respuesta.pagination;
                        me.idrol = respuesta.idrol;
                        me.total = respuesta.total;
                        me.titulo = respuesta.titulo;
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
                },
                listarGrupoContable (){
                    let me=this;
                    var url= '/contable?id='+ me.idunidad;
                    axios.get(url).then(function (response) {
                        var respuesta= response.data;
                        me.arrayContables = respuesta.codigos;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                },
                listarAuxiliar (id){
                    var url= '/auxiliar/' + id;
                    axios.get(url).then((response)=> {

                        this.arrayAuxiliares= response.data.auxiliares;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                },
                cambiarPagina(page,buscar,criterio){
                    let me = this;
                    //Actualiza la página actual
                    me.pagination.current_page = page;
                    //Envia la petición para visualizar la data de esa página
                    me.listarArticulo(page,buscar,criterio);
                },
                abrirModal(modelo, accion, data = []){
                    switch(modelo){
                    case "articulo":
                    {
                        switch(accion){
                            case 'actualizar':
                            {
                                this.listarGrupoContable ();
                                this.listarAuxiliar(data['codcont']);
                                this.modal=1;
                                this.tituloModal='Actualizar Artículo: '+ data['codigo'];
                                this.idArticulo =data['id'];
                                this.codigo = data['codigo'];
                                this.codcont= data['codcont'];
                                this.codaux = data['codaux']
                                this.descripcion = data['descripcion'];
                                this.observaciones = data['observ'];
                                this.codestado =data['codestado'];
                                this.codigosec=data['codigosec'];
                                this.tipoAccion=2;
                                break;
                            }
                        }
                    }
                    
                    }
                },
                onChange(event) {
                    this.listarAuxiliar(event.target.value);
                },
                onChangeCodEstado(event) {
                    this.codestado = (event.target.value);
                },
                onChangeUnidad(event){
                    this.arrayArticulo = [];
                    this.idunidad=(event.target.value);
                    const res = this.arrayUnidad.find((unidad) => unidad.unidad == this.idunidad);
                    this.unidad= res.descrip;
                    this.listarArticulo(1,this.buscar,this.criterio);
                },
                uploadImage(event) {
                    const files = event.target.files;
                    for (let i = 0; i < files.length; i++) {
                        this.previewImage(files[i]);
                    }
                    },
                previewImage(file) {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        this.selectedImages.push({
                        id: this.selectedImages.length + 1, // Puedes usar un identificador único
                        url: e.target.result,
                        file: file,
                        });
                    };

                    reader.readAsDataURL(file);
                },
                subirImagenes() {
                    this.selectedImages.forEach((file) => {
                    const formData = new FormData();
                    
                    formData.append('codactual', this.idArticulo);
                    formData.append('image', file.file);
                    axios
                        .post('/image/crear', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                        })
                        .then((response) => {
                        Swal.fire(response.data.message,"","info");
                        this.selectedImages = [];
                        })
                        .catch((error) => {
                            Swal.error('Error al subir la imagen'+ error);
                        });
                    });
                    
                },
                
                actualizarArticulo(){
                    if (this.validarArticulo()){
                    return;
                    }
                    let me = this;
                    axios.put('/actual/actualizar',{
                        'id': this.idArticulo,
                        'codigo':this.codigo,
                        'codcont': this.codcont,
                        'codaux': this.codaux,
                        'descripcion' : this.descripcion,
                        'observacion' : this.observaciones,
                        'estado' : this.codestado,
                        'codsec' : this.codigosec
                    }).then(function (response) {
                        me.cerrarModal();
                        me.listarArticulo(1,'','descripcion');
                        Swal.fire(response.data.message, "", "success");
                    }).catch(function (error) {
                        Swal.fire(error.response.data, "", "error");
                    }); 
                },
                cerrarModal(){
                    this.modal=0;
                    this.codigo = '';
                    this.descripcion = '';
                    this.codcont=0;
                    this.codaux=0;    
                    this.codestado =0;
                    this.estadoasignacion =0;
                    this.codigosec=0;
                    this.errorArticulo=0;
                    this.selectedImages= [];
                },
                cerrarModalImage(){
                    this.modalver=0;
                    this.imagenes= [];
                },
                validarArticulo(){
                    this.errorArticulo=0;
                    this.errorMostrarMsjArticulo =[];
                    if (this.descripcion.length >= 151) this.errorMostrarMsjArticulo.push("La descripción no puede ser mas de 150 caracteres.");

                    if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;

                    return this.errorArticulo;
                },
                revisarNuevos(){
                    let me = this;
                    axios.get('/actuales/datos').then((response) =>{
                        Swal.fire(response.data.message, "", "info");
                        me.listarArticulo(1,'','descripcion');
                    }).catch((error)=> {
                    Swal.fire("Cierre la tabla ACTUAL.DBF ", "", "error");
                }); 
                },
                mostrarEditar(id){
                    let me = this;
                    
                    axios.get('/image/ver/' + id).then((response) =>{
                        if(response.data.imagenes.length > 0){
                            me.modalver=1;
                        }else{
                            Swal.fire("No hay Imagenes 😔","","info");
                        }
                        me.imagenes = response.data.imagenes;
                    }).catch((error)=> {
                    Swal.fire("Existe un Problema ", "", "error");
                    }); 
                },
                getImageUrl(image) {
                    return `/images/${image.nombre}`;
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
                this.listarArticulo(1,this.buscar,this.criterio);
            }
        }
    </script>
    <style> 
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
        .thumbnails {
        display: flex;
        flex-wrap: wrap;
        }

        .thumbnail {
        margin: 10px;
        }

    </style>