<template>
    <main class="app-content">
        <div class="app-title">
              <h1><i class="fa fa-th-list"></i> Bajas</h1>
        </div>
        <div class="form-group row p-3 mb-2 bg-primary text-white">
            <div class="col-md-6">
                <div class="input-group">
                    <select class="form-select col-md-3" v-model="criterio">
                        <option value="codigo">Código</option>
                        <option value="descrip">Descripción</option>
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
                        <th scope="col">UNIDAD</th>
                        <th scope="col">CÓDIGO</th>
                        <th scope="col">GRUPO CONTABLE</th>
                        <th scope="col">AUXLIAR</th>
                        <th scope="col">VIDA ÚTIL</th>
                        <th scope="col">OFICINA</th>
                        <th scope="col">RESPONSABLE</th>
                        <th scope="col">DESCRIPCIÓN</th>
                        <th scope="col">MOTIVO</th>
                        <th scope="col">FECHA DE INCORPORACIÓN</th>
                        <th scope="col">FECHA DE BAJA</th>
                        <th scope="col">RESOLUCIÓN</th>
                      </tr>
                    </thead>
                    <tbody v-if="arrayBajas !== 0">
                        <tr v-for="baja in arrayBajas" :key="baja.id">
                            <td v-text="baja.unidad"></td>
                            <td v-text="baja.codigo"></td>
                            <td v-text="baja.nombre"></td>
                            <td v-text="baja.nomaux"></td>
                            <td v-text="baja.vidautil"></td>
                            <td v-text="baja.nomofic"></td>
                            <td v-text="baja.nomresp"></td>
                            <td v-text="baja.descrip"></td>
                            <td v-text="baja.motivo"></td>
                            <td>{{ baja.dia + '/' + baja.mes + '/' + baja.año }}</td>
                            <td>{{ baja.d_baja + '/' + baja.m_baja + '/' + baja.a_baja }}</td>
                            <td v-text="baja.resolucion"></td>
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
        </div> <!-- Fin ejemplo de tabla Listado -->
        <div class="form-group row p-3 mb-2 bg-primary text-white text-end">
            <h4><b>Total Activos: </b>{{ total }}</h4>
        </div>
    </main>
</template>
    
    <script>
        import axios from 'axios';
        export default {
            data (){
                return {
                    arrayBajas : [],
                    pagination : {
                        'total' : 0,
                        'current_page' : 0,
                        'per_page' : 0,
                        'last_page' : 0,
                        'from' : 0,
                        'to' : 0,
                    },
                    offset : 3,
                    criterio : 'descrip',
                    buscar : '',
                    total:0
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
                    
                    var url= '/bajas?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                    axios.get(url).then((response)=> {
                        var respuesta= response.data;
                        me.arrayBajas = respuesta.bajas.data;
                        me.pagination= respuesta.pagination;
                        me.total = respuesta.total;
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
                
            },

            components: {
                   
                },
            mounted() {
                this.listarArticulo(1,this.buscar,this.criterio);
            }
        }
    </script>