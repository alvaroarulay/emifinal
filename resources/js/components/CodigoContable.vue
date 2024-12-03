<template>
    <main class="app-content">
      <div class="app-title">
            <h1><i class="bi bi-collection"></i> Grupos Contables</h1>
            <br>
            <button type="submit" @click="revisarNuevos()" class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i> Actualizar Datos</button>
        </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body table-responsive">
                 <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Código</th>
                            <th>Grupo Contable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="contable in arrayContable" :key="contable.id">
                            <td>
                                <button type="button" @click="abrirModal(contable)" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar">
                                  <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                            <td v-text="contable.codcont"></td>
                            <td v-text="contable.nombre"></td>
                        </tr>                                
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div> <!-- Fin ejemplo de tabla Listado -->
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"> Actualizar Grupo Contable</h4>
                            <button type="button" class="close btn btn-danger btn-sm" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row mb-3">
                                    <label class="col-md-3" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control">                                        
                                    </div>
                                </div>
                                <div v-show="errorContable" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjContable" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="actualizarContable()">Actualizar</button>
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
      arrayContable:[],
      nombre:'',
      id:0,
      codcont:0,
      modal : 0,
      errorContable : 0,
      errorMostrarMsjContable : [],
    
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
    listarContables (){
        let me=this;
        var url= '/contable';
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayContable = respuesta.codigos;
        })
        .catch( (error)=> {
            console.log(error);
        });
    },
    abrirModal(data = []){
      this.modal=1;
      this.id = data['id'];
      this.nombre=data['nombre'];
      this.codcont=data['codcont'];
    },
    cerrarModal(){
      this.modal=0;
      this.nombre='';
    },
    actualizarContable(){
        let me = this;
          axios.put('/contable/actualizar',{
            'id':this.id,
            'nombre':this.nombre,
            'codcont':this.codcont,
          }).then((response)=>{
              me.cerrarModal();
              Swal.fire(response.data.message,"","info");
              me.listarContables(1,'','nombre');
          }).catch((error)=>{
            Swal.error('Hubo un Error');
              console.log(error);
          }); 
    },
    revisarNuevos(){
        let me = this;
        axios.get('/contable/datos').then((response) =>{
            Swal.fire(response.data.message, "", "info");
            me.listarContables(1,'','nombre');
        }).catch((error)=> {
        Swal.fire("Cierre la tabla CODCONT.DBF " + error, "", "error");
    }); 
    },
  },
  mounted() {
    this.listarContables();
  }
}
</script>