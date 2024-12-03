<template>
    <main class="app-content">
      <div class="app-title">
          <h1><i class="fa fa-th-list"></i> Reporte de Devoluciones</h1>
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
                    <button class="btn btn-info form-control btnagregar" type="button" @click="buscarResponsable()"><i class="bi bi-search"></i> Buscar</button>
                  </div>
                  <div class="mb-3 col-md-3 form-group">
                    <button class="btn btn-success form-control btnagregar" type="button" @click="abrirModal()"><i class="bi bi-plus-lg" ></i> Agregar</button>
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
                <div class="col-md-4"><h5 class="text-center font-weight-light my-4"> Activos: </h5></div>
                <div class="mb-3 col-md-4">
                  <br>
                  <button class="btn btn-info form-control" type="button" @click="buscarActivo()"><i class="bi bi-search"></i> Buscar</button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="form-group tile">
                      <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                          <thead>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Oficina</th>
                            <th>Estado</th>
                          </thead>
                          <tbody v-if="actuales.length">
                              <tr v-for="(detalle,index) in actuales" :key="detalle.id">
                                  <td v-text="detalle.codigo"></td>
                                  <td v-text="detalle.descripcion"></td>
                                  <td v-text="detalle.nomofic"></td>
                                  <td>
                                <div v-if="detalle.codestado === 1">
                                    <span class="me-1 badge badge-pill bg-success">Bueno</span>
                                </div>
                                <div v-else-if="detalle.codestado === 2">
                                    <span class="me-1 badge badge-pill bg-warning">Regular</span>
                                </div>
                                <div v-else>
                                    <span class="me-1 badge badge-pill bg-danger">Malo</span>
                                </div>
                            </td>
                              </tr>
                          </tbody>
                          <tbody v-else>
                              <tr>
                                  <td colspan="5">
                                      NO hay Activos asignados
                                  </td>
                              </tr>
                          </tbody>        
                        </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                  <button class="btn btn-primary form-control" type="button" @click="registrarDevolucion()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
  <path d="M11 2H9v3h2z"/>
  <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
</svg> Generar Reporte</button>
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
                                    <input type="text" v-model="buscar" @keyup.enter="listarResponsable(buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarResponsable(buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
      cod_resp:0,
      cod_ofi:0,
      ci:'',
      codigo:'',
      codigoTable:'',
      descripcionTable:'',
      arrayResponsable:[],
      arrayResponsableTodos:[],
      arrayActivo:[],
      arrayActivosTodos:[],
      actuales:[],
      errorResponsable:0,
      errorMostrarMsjResponsable:[],
      nomresp:'',
      cargo:'',
      oficina:'',
      modal : 0,
      criterio:'nomresp',
      buscar: '',
    }
  },
  methods: {
    buscarResponsable(){
        let me=this;
        var url= '/responsable/buscarResponsable?filtro=' + me.ci;

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
    },
    listarResponsable(buscar,criterio){
        let me=this;
        var url= '/responsable/?buscar='+ buscar + '&criterio='+ criterio;
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayResponsableTodos = respuesta.responsables.data;
        })
        .catch( (error) =>{
            console.log(error);
        });
    },

    buscarActivo(){
      let me=this;
      var url = '/actuales/buscarActivoResp?codofic=' + me.cod_ofi + '&codresp='+ me.cod_resp;
      axios.get(url).then((res)=>{
        me.actuales= res.data.actuales;
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
        this.arrayResponsableTodos=[];
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
    registrarDevolucion(){
      if(this.cod_resp == 0){
        swal.fire('Seleccione un Responsable','','error')
      }else if(this.actuales.length == 0){
        swal.fire('el Responsable no tiene activos','','error')
      }
      else{
        let me = this;
        window.open('http://192.168.28.219/actual/repDevoluciones?codofic=' + me.cod_ofi + '&codresp='+ me.cod_resp +  '','_blank');
      }
    }
  },

  mounted() {
   
  }
}
</script>