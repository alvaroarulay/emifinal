require ('./bootstrap');
window.Vue = require('vue');
import { createApp, ref, h } from 'vue'
import { createVfm } from 'vue-final-modal'
import Actual from './components/Actual.vue'
import Articulo from './components/Articulo.vue'
import Asignaciones from './components/Asignaciones.vue'
import Auxiliares from './components/Auxiliares.vue'
import CodigoContable from './components/CodigoContable.vue'
import Devoluciones from './components/Devoluciones.vue'
import Escritorio from './components/Escritorio.vue'
import InventarioRapido from './components/InventarioRapido.vue'
import Oficinas from './components/Oficinas.vue'
import Responsables from './components/Responsables.vue'
import newResponsable from './components/newResponsable.vue'
import UnidadAdministrativa from './components/UnidadAdministrativa.vue'
import User from './components/User.vue'
import NewUser from './components/Newuser.vue'
import Rol from './components/Rol.vue'
import VueUploadComponent from 'vue-upload-component'
import RepResp from './components/repResponsables.vue'
import RepAsig from './components/RepAsignaciones.vue'
import RepLogs from './components/RepLogs.vue'
import HistorialAsig from './components/HistorialAsignaciones.vue'
import bbdd from './components/bbdd.vue'
import bajas from './components/Bajas.vue'
//import globalMixin from './components/globales.js';

const app = createApp({ 
  setup() {
  return {
    menu : ref(0)
  }}
});
if (process.env.NODE_ENV === 'production') {
    app.config.devtools = false;
    app.config.productionTip = false;
  }

app.component('file-upload', VueUploadComponent);
app.component("actuales", Actual);
app.component("articulos", Articulo);
app.component("asignaciones", Asignaciones);
app.component("auxiliares", Auxiliares);
app.component("codcont", CodigoContable);
app.component("devoluciones", Devoluciones);
app.component("escritorio", Escritorio);
app.component("inventrap", InventarioRapido);
app.component("oficinas", Oficinas);
app.component("responsables", Responsables);
app.component("unidadadmin",UnidadAdministrativa);
app.component('newuser',NewUser);
app.component("usuarios",User);
app.component("rol",Rol);
app.component("represponsables",RepResp);
app.component("newresponsable",newResponsable);
app.component("repasignaciones",RepAsig);
app.component("replogs",RepLogs);
app.component("historialasignaciones",HistorialAsig);
app.component("bbdd",bbdd);
app.component("bajas",bajas);
//app.mixin(globalMixin);
const vfm = createVfm()
app.use(vfm)
  .mount('#app')
  


