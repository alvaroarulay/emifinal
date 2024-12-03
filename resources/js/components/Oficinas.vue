<template>
      <main class="app-content">
        <div class="app-title">
            <h1><i class="bi bi-building"></i> Oficinas</h1>
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
                            <th>Oficina</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="oficina in arrayOficina" :key="oficina.codofic">
                            <td>
                                <button type="button" @click="abrirModal(oficina)" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar">
                                  <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                            <td v-text="oficina.nomofic"></td>
                        </tr>                                
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
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
                            <h4 class="modal-title"> Actualizar Oficina</h4>
                            <button type="button" class="close btn btn-danger btn-sm" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row mb-3">
                                    <label class="col-md-3" for="text-input">Nombre Oficina</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nomofic" class="form-control">                                        
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
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="actualizarOficina()">Actualizar</button>
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
      id:0,
      codofic:0,
      nomofic:'',
      arrayOficina : [],
      modal : 0,
      errorAuxiliar : 0,
      errorMostrarMsjAuxiliar : [],
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
    listarOficina (page){
        let me=this;
        var url= '/oficinas?page=' + page;
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayOficina = respuesta.oficinas.data;
            me.pagination= respuesta.pagination;
        })
        .catch( (error)=> {
            console.log(error);
        });
    },
    abrirModal(data = []){
      this.modal=1;
      this.nomofic=data['nomofic'];
      this.id=data['id'];
      this.codofic=data['codofic'];
    },
    cerrarModal(){
      this.modal=0;
      this.id=0;
      this.codofic=0;
      this.nomofic='';
    },
    cambiarPagina(page){
        let me = this;
        me.pagination.current_page = page;
        me.listarOficina(page);
    },
    actualizarOficina(){
        let me = this;
        axios.put('/oficinas/actualizar',{
            'id': this.id,
            'codofic':this.codofic,
            'nomofic': this.nomofic,
        }).then( (response) =>{
            me.cerrarModal();
            me.listarOficina(1);
            Swal.fire(response.data.message, "", "success");
        }).catch(function (error) {
            Swal.fire("Cierre la tabla Oficina.DBF ", "", "error");
        });
    }
  },
  mounted() {
   this.listarOficina();
  }
}
</script>